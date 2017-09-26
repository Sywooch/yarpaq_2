<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\LoginForm;


class AuthController extends \webvimark\modules\UserManagement\controllers\AuthController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            //'captcha' => $this->module->captchaOptions,
        ];
    }

    public function actionLogin() {
        if ( !Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ( Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post()) )
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ( $model->load(Yii::$app->request->post()) AND $model->login() )
        {
            return $this->goBack();
        }

        return $this->renderIsAjax('login', compact('model'));
    }
}