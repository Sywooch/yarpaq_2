<?php

namespace common\components;

use frontend\models\ProductFilter;
use Yii;
use common\models\Product;
use Elasticsearch\ClientBuilder;
use frontend\components\Currency;

class ProductSearch
{

    private $endPoint   = 'https://elastic:13FBz5ryol4NH7WBupFLQl7h@3d2ffe75fd58df49bf393b33d089f355.us-east-1.aws.found.io:9243';
    private $index      = 'yarpaq';
    private $type       = 'product';
    private $currency;
    private $client;

    public function __construct() {
        $this->currency = new Currency();

        // подключаемся
        $this->client = ClientBuilder::create()
            ->setHosts([$this->endPoint])
            ->build();
    }

    /**
     * Добавляем либо обновляем индекс товара
     *
     * @param Product $product
     */
    public function index(Product $product) {

        // базовая валюта
        $aznCurrency = $this->currency->getCurrencyByCode('AZN');


        // параметры
        $params = [
            'index' => $this->index,
            'type'  => $this->type,
            'id'    => $product->id,
            'body'  => [
                'id'            => $product->id,
                'title'         => strip_tags($product->title),
                'description'   => strip_tags($product->description),
                'model'         => strip_tags($product->model),
                'brand'         => $product->manufacturer_id,

                'moderated_at'  => (new \DateTime($product->moderated_at))->format('Y-m-d\TH:i:sO'),

                // виден ли товар на сайте
                'visible'       => (int)$product->isVisible(),

                // состояние товара: Новый => 1, Старый => 0
                'condition'     => $product->condition_id,

                // цена добавляется в базовой валюте, чтобы затем осуществлять поиск также по цене в базовой валюте
                'price'         => $this->currency->convert($product->price, $product->currency, $aznCurrency)
            ]
        ];


        // делаем запрос
        $this->client->index($params);
    }

    /**
     * Удаляет товар из индекса
     *
     * @param Product $product
     * @return array
     */
    public function delete(Product $product) {

        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $product->id
        ];

        return $this->client->delete($params);
    }

    public function total($query, $filter) {
        $queryFilter = $this->buildFilter($filter);


        $params = [
            'index' => $this->index,
            'type'  => $this->type,

            'body'  => [
                'query' => $this->getDefaultQuery($query, $queryFilter)
            ]
        ];

        try {
            $response = $this->client->count($params);
            return $response['count'];
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }
    }

    public function search($query, $filter, $page = 1, $limit = 2) {

        switch ($filter->sort) {
            case ProductFilter::SORT_PRICE_HIGHEST:
                $sort_query = ["price" => ["order" => "desc"]];
                break;
            case ProductFilter::SORT_PRICE_LOWEST:
                $sort_query = ["price" => ["order" => "asc"]];
                break;
            case ProductFilter::SORT_NEWLY_LISTED:
                $sort_query = ["moderated_at" => ["order" => "desc"]];
                break;
            default:
                $sort_query = "_score";
        }

        $queryFilter = $this->buildFilter($filter);

        $params = [
            'index' => $this->index,
            'type'  => $this->type,

            'body'  => [
                "sort" => [$sort_query],
                'query' => $this->getDefaultQuery($query, $queryFilter),
                "from" => ($page - 1) * $limit,
                "size" => $limit
            ]
        ];


        try {

            $response = $this->client->search($params);

            if (isset($response['error'])) {
                throw new \ElasticSearch\Exception();
            } else {
                return $response;
            }

        } catch (\Exception $e) {
            Yii::error($e->getMessage());

            return ['hits' => ['hits' => []]];
        }
    }

    public function minMaxPrice($query, $filter) {
        $queryFilter = $this->buildFilter($filter);
        $defaultQuery = $this->getDefaultQuery($query, $queryFilter);

        $params = [
            'index' => $this->index,
            'type'  => $this->type,

            'body'  => [
                'query' => $defaultQuery,
                "aggs" => [
                    "min_price" => [
                        "min" => [
                            "field" => "price"
                        ]
                    ],
                    "max_price" => [
                        "max" => [
                            "field" => "price"
                        ]
                    ]
                ],
                'size' => 0

            ]
        ];

        try {
            $response = $this->client->search($params);
            return $response;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }
    }

    public function getBrands($query) {
        $defaultQuery = $this->getDefaultQuery($query);

        $params = [
            'index' => $this->index,
            'type'  => $this->type,

            'body'  => [
                'query' => $defaultQuery,
                "aggs" => [
                    "brands" => [
                        "terms" => [
                            "field" => "brand"
                        ]
                    ]
                ],
                'size' => 0

            ]
        ];

        try {
            $response = $this->client->search($params);

            $result = [];

            if (isset($response['aggregations']['brands']['buckets'])) {
                $buckets = $response['aggregations']['brands']['buckets'];

                foreach ($buckets as $bucket) {
                    $result[] = $bucket['key'];
                }
            }

            return $result;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
        }
    }

    /**
     * Дополнительная часть массива must, в которой содержаться условия
     * из фильтра (цена, состояние, производитель)
     *
     * @param $filter
     * @return array
     */
    public function buildFilter($filter) {
        $must = [
            [
                "term"    => [
                    "condition" => $filter->condition,
                ]
            ],
            [
                "term"    => [
                    "visible" => 1,
                ]
            ]
        ];

        if ($filter->price_from != null && $filter->price_to != null ) {
            $must[] = [
                "range" => [
                    "price" => [
                        "gte" => $filter->price_from,
                        "lte" => $filter->price_to
                    ]
                ]
            ];
        }

        if ($filter->brand != null) {
            $must[] = [
                "terms" => [
                    "brand" => $filter->brand
                ]
            ];
        }

        return $must;
    }

    /**
     * Базовый запрос который ищет по title и только видные товары
     *
     * @param $query
     * @param array $mustFilter
     * @return array
     */
    private function getDefaultQuery($query, array $mustFilter = []) {
        $must = [
            [ "match"   => [ "title" => $query ] ],
        ];
        if (count($mustFilter)) {
            $must = array_merge($must, $mustFilter);
        }

        return [
            "bool" => [
                'should' => [
                    [
                        'bool' => [
                            "must" => $must,
                        ]

                    ],
                    [ "term"    => [ "id" => (int)$query, ] ]
                ],
            ]
        ];
    }
}