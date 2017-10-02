<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "{{%discount}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property double $value
 * @property integer $period
 * @property string $start_date
 * @property string $end_date
 */
class Discount extends \yii\db\ActiveRecord
{

    const PERIOD_CONSTANT   = 0;
    const PERIOD_RANGE      = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'value', 'period'], 'required'],
            [['id', 'product_id', 'period'], 'integer'],
            [['value'], 'number'],
            [['start_date', 'end_date'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['start_date', 'end_date'], 'required', 'when' => function ($discount) {
                return $discount->period === 1;
            }, 'whenClient' => "

                function (attribute, value) {
                    return $('#discount-period').val() == '1';
                }"
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'value' => Yii::t('app', 'Price'),
            'period' => Yii::t('app', 'Period'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }

    public function beforeValidate() {
        if(parent::beforeValidate()) {

            echo $this->period;

            if ($this->period == 0) {
                $this->start_date = NULL;
                $this->end_date = NULL;
            } else {
                if ($this->start_date >= $this->end_date) {
                    $this->addError('start_date', Yii::t('app', 'Start Date must be earlier than End Date'));
                    $this->addError('end_date', Yii::t('app', 'End Date must be later than Start Date'));

                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
