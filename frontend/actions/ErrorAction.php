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
            Yii::$app->request->get('path')
        ) {

            Yii::$app->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex'
            ]);

        }




        return $this->renderHtmlResponse();
    }
}