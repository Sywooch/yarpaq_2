<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property integer $address_id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $company
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property string $postcode
 * @property integer $country_id
 * @property integer $zone_id
 * @property string $custom_field
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'firstname', 'lastname', 'company', 'address_1', 'address_2', 'city', 'postcode', 'custom_field'], 'required'],
            [['user_id', 'country_id', 'zone_id'], 'integer'],
            [['custom_field'], 'string'],
            [['firstname', 'lastname'], 'string', 'max' => 32],
            [['company'], 'string', 'max' => 40],
            [['address_1', 'address_2', 'city'], 'string', 'max' => 128],
            [['postcode'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_id' => Yii::t('app', 'Address ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'company' => Yii::t('app', 'Company'),
            'address_1' => Yii::t('app', 'Address 1'),
            'address_2' => Yii::t('app', 'Address 2'),
            'city' => Yii::t('app', 'City'),
            'postcode' => Yii::t('app', 'Postcode'),
            'country_id' => Yii::t('app', 'Country ID'),
            'zone_id' => Yii::t('app', 'Zone ID'),
            'custom_field' => Yii::t('app', 'Custom Field'),
        ];
    }
}
