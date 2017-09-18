<?php

namespace backend\controllers;


use yii\web\Controller;
use ElasticSearch\Client;

class ElasticController extends Controller
{
    function actionIndex() {
        // The recommended way to go about things is to use an environment variable called ELASTICSEARCH_URL
        // $es = Client::connection();

        // Alternatively you can use dsn string
        $es = Client::connection('https://3d2ffe75fd58df49bf393b33d089f355.us-east-1.aws.found.io:9243/');

        $es->index(array('title' => 'My cool document'));

        //$es->search('title:cool');
    }
}