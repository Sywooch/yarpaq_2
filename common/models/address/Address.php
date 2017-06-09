<?php

namespace common\models\address;

use common\models\Zone;
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
            [['user_id', 'firstname', 'lastname', 'address_1', 'country_id', 'zone_id', 'city', 'postcode'], 'required'],
            [['user_id', 'country_id', 'zone_id'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 32],
            [['company'], 'string', 'max' => 40],
            [['address_1', 'address_2', 'city'], 'string', 'max' => 128],
            [['postcode'], 'string', 'max' => 10],
            ['zone_id', 'validateZone']
        ];
    }

    public function validateZone($attribute, $params, $validator) {
        $zone = Zone::findOne($this->zone_id);

        if ($zone->country_id != $this->country_id) {
            $this->addError($attribute, 'Invalid zone for this country');
        }
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
        ];
    }
}
