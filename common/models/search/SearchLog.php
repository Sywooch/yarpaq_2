<?php

namespace common\models\search;

use common\models\User;
use Yii;

class SearchLog extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%search_log}}';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // set Created At
            if ($this->isNewRecord) {
                $now = new \DateTime();
                $this->created_at = $now->format('Y-m-d H:i:s');
            }

            $this->ip = Yii::$app->request->userIP;
            $this->user_agent = Yii::$app->request->userAgent;

            return true;
        }

        return false;
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'user_id'   => Yii::t('app', 'User ID'),
            'text'      => Yii::t('app', 'Query'),
            'count'      => Yii::t('app', 'Quantity'),
        ];
    }

    public static function getNoResultQueriesCount() {
        return self::find()->where(['no_result' => 1])->count();
    }
}