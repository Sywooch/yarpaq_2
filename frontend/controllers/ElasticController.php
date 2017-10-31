<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use Elasticsearch\ClientBuilder;

class ElasticController extends BasicController
{
    public $freeAccessActions = ['index', 'one', 'create', 'delete'];

    function actionIndex() {
        // это если по кусочкам делать
        //$offset = Yii::$app->request->get('offset') ? (int) Yii::$app->request->get('offset') : 0;

        $client = ClientBuilder::create()
            ->setHosts([Yii::$app->params['elastic']['endPoint']])
            ->build();

        $totalProducts = Product::find()->count();
        $pagesCount = ceil($totalProducts / 1000);

        for ($i=0; $i<$pagesCount; $i++) {

            $offset = $i*1000;

            $products = Product::find()
                ->offset($offset)
                ->limit(1000)
                ->all();
            $currency = Yii::$app->currency;
            $aznCurrency = $currency->getCurrencyByCode('AZN');

            $params = [];

            foreach ($products as $product) {
                $params['body'][] = [
                    'index' => [
                        '_index' => Yii::$app->params['elastic']['index'],
                        '_type' => Yii::$app->params['elastic']['productType'],
                        '_id' => $product->id
                    ]
                ];

                $_product = [
                    'id' => $product->id,
                    'title' => strip_tags($product->title),
                    'description' => strip_tags($product->description),
                    'model' => strip_tags($product->model),
                    'brand' => $product->manufacturer_id,

                    'moderated_at' => (new \DateTime($product->moderated_at))->format('Y-m-d\TH:i:sO'),

                    // виден ли товар на сайте
                    'visible' => (int)$product->isVisible(),

                    // состояние товара: Новый => 1, Старый => 0
                    'condition' => $product->condition_id,

                    // цена добавляется в базовой валюте, чтобы затем осуществлять поиск также по цене в базовой валюте
                    'price' => $currency->convert($product->price, $product->currency, $aznCurrency)
                ];

                if ($product->hasDiscount()) {
                    $_product['discount_price'] = $product->discount->value;
                    $_product['discount_period'] = $product->discount->period;
                    $_product['discount_start_date'] = (new \DateTime($product->discount->start_date))->format('Y-m-d\TH:i:sO');
                    $_product['discount_end_date'] = (new \DateTime($product->discount->end_date))->format('Y-m-d\TH:i:sO');
                }

                $params['body'][] = $_product;

            }

            //var_dump($params);


            $response = $client->bulk($params);

            var_dump($response);
        }

    }

    public function actionOne($id) {

        $client = ClientBuilder::create()
            ->setHosts([Yii::$app->params['elastic']['endPoint']])
            ->build();

        $params = [
            'index' => Yii::$app->params['elastic']['index'],
            'type'  => Yii::$app->params['elastic']['productType'],

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
            ->setHosts([Yii::$app->params['elastic']['endPoint']])
            ->build();

        $params = [
            'index' => Yii::$app->params['elastic']['index'],
            'body' => [
                "mappings" => [
                    Yii::$app->params['elastic']['productType'] => [
                        "properties" => [
                            "title" => [
                                "type" => "string",
                                "analyzer" => "ngram_analyzer_with_filter"
                            ],
                            "moderated_at" => [
                                "type" => "date"
                            ],
                            "discount_start_date" => [
                                "type" => "date"
                            ],
                            "discount_end_date" => [
                                "type" => "date"
                            ],
                            "discount_period" => [
                                "type" => "integer"
                            ],
                            "discount_price" => [
                                "type" => "double"
                            ],
                        ]
                    ]
                ],
                "settings" => [

                    'number_of_shards' => 5,
                    'number_of_replicas' => 1,

                    'analysis' => [
                        'analyzer' => [
                            //'ngram_analyzer_number' => ['tokenizer' => 'ngram_tokenizer_number', 'filter' => 'lowercase'],
                            //'ngram_analyzer_serial' => ['tokenizer' => 'ngram_tokenizer_serial', 'filter' => 'lowercase'],
                            'ngram_analyzer_with_filter' => [
                                'tokenizer' => 'ngram_tokenizer',
                                'filter' => 'lowercase, snowball'
                            ],
                        ],
                        'tokenizer' => [
                            'ngram_tokenizer' => [
                                'type' => 'nGram',
                                'min_gram' => 3,
                                'max_gram' => 10,
                                'token_chars' => ['letter', 'digit', 'whitespace', 'punctuation', 'symbol']
                            ],
//                            'ngram_tokenizer_number' => [
//                                'type' => 'nGram',
//                                'min_gram' => 3,
//                                'max_gram' => 5,
//                                'token_chars' => ['letter', 'digit']
//                            ],
//                            'ngram_tokenizer_serial' => [
//                                'type' => 'nGram',
//                                'min_gram' => 4,
//                                'max_gram' => 10,
//                                'token_chars' => ['letter', 'whitespace', 'punctuation', 'symbol', 'digit']
//                            ]
                        ],
                    ]
                ]
            ]
        ];

        $response = $client->indices()->create($params);
        print_r($response);
    }

    public function actionDelete() {
        $client = ClientBuilder::create()
            ->setHosts([Yii::$app->params['elastic']['endPoint']])
            ->build();

        $deleteParams = [
            'index' => Yii::$app->params['elastic']['index']
        ];
        $response = $client->indices()->delete($deleteParams);

        print_r($response);
    }
}