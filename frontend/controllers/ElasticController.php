<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use Elasticsearch\ClientBuilder;

class ElasticController extends BasicController
{
    private $index = 'yarpaq';
    private $type = 'product';
    private $endPoint = 'https://elastic:1O9dV3nKiGkhtBdbGgU80tXX@7b51591276427595ffadb0b88481a0a5.us-east-1.aws.found.io:9243';

    public $freeAccessActions = ['index', 'one', 'create', 'delete'];

    function actionIndex() {

        $client = ClientBuilder::create()
            ->setHosts([$this->endPoint])
            ->build();

        //ini_set('memory_limit', '512M');
        //ini_set('max_execution_time', 3000); // 3000 seconds = 50 minutes

        $products = Product::find()
            ->offset(0)
            ->limit(1000)
            ->all();
        $currency = Yii::$app->currency;
        $aznCurrency = $currency->getCurrencyByCode('AZN');

        foreach ($products as $product) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->index,
                    '_type' => $this->type,
                    '_id' => $product->id
                ]
            ];

            $params['body'][] = [
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
                'price'         => $currency->convert($product->price, $product->currency, $aznCurrency)
            ];

        }

        //var_dump($params);


        $response = $client->bulk($params);

        var_dump($response);

    }

    public function actionOne($id) {

        $client = ClientBuilder::create()
            ->setHosts([$this->endPoint])
            ->build();

        $params = [
            'index' => $this->index,
            'type'  => $this->type,

            'body'  => [
                'query' => [
                    'term' => [
                        'id' => $id
                    ]
                ]
            ]
        ];

        try {
            $response = $client->search($params);
            var_dump( $response );

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    public function actionCreate() {
        $client = ClientBuilder::create()
            ->setHosts([$this->endPoint])
            ->build();

        $params = [
            'index' => $this->index,
            'body' => [
                'settings' => [
                    'number_of_shards' => 4,
                    'number_of_replicas' => 1
                ],
                "mappings" => [
                    $this->type => [
                        "properties" => [
                            "moderated_at" => [
                                "type" => "date"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $client->indices()->create($params);
        print_r($response);
    }

    public function actionDelete() {
        $client = ClientBuilder::create()
            ->setHosts([$this->endPoint])
            ->build();

        $deleteParams = [
            'index' => $this->index
        ];
        $response = $client->indices()->delete($deleteParams);

        print_r($response);
    }
}