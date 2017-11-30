<?php

namespace frontend\actions;

use Yii;

class ErrorAction extends \yii\web\ErrorAction
{
    /**
     * Runs the action.
     *
     * @return string result content
     */
    public function run()
    {
        Yii::$app->getResponse()->setStatusCodeByException($this->exception);

        if (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjaxResponse();
        }

        if (Yii::$app->request->get('sort') ||
            Yii::$app->request->get('filter') ||
            Yii::$app->request->get('order') ||
            Yii::$app->request->get('path') ||
            Yii::$app->request->get('route') ||
            Yii::$app->request->get('product_id') ||
            Yii::$app->request->get('seller_id') ||
            Yii::$app->request->get('url') ||
            Yii::$app->request->hostName == 'admin.yarpaq.az'
        ) {

            Yii::$app->getResponse()->setStatusCode(410);

            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex'
            ]);

        }


        if (Yii::$app->request->get('page')) {

            Yii::$app->getResponse()->setStatusCode(200);

            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex'
            ]);

        }


        return $this->renderHtmlResponse();
    }
}