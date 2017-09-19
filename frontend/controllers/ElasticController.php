<?php

namespace frontend\controllers;

use Elasticsearch\ClientBuilder;

class ElasticController extends BasicController
{
    public $freeAccessActions = ['index'];

    function actionIndex() {
        phpinfo();
        return;

        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'yarpaq',
            'type' => 'product',
            //'id' => 'my_id',
            'body' => [
                'title' => 'Бритва'
            ]
        ];

        $response = $client->index($params);
        print_r($response);
    }
}