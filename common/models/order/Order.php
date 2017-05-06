<?php

namespace common\models\order;

use Yii;
use common\models\Currency;
use common\models\Language;
use common\models\User;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 * @property string $custom_field
 * @property string $payment_firstname
 * @property string $payment_lastname
 * @property string $payment_company
 * @property string $payment_address
 * @property string $payment_city
 * @property string $payment_postcode
 * @property string $payment_country
 * @property integer $payment_country_id
 * @property string $payment_zone
 * @property integer $payment_zone_id
 * @property string $payment_address_format
 * @property string $payment_custom_field
 * @property string $payment_method
 * @property string $payment_code
 * @property string $shipping_firstname
 * @property string $shipping_lastname
 * @property string $shipping_company
 * @property string $shipping_address
 * @property string $shipping_city
 * @property string $shipping_postcode
 * @property string $shipping_country
 * @property integer $shipping_country_id
 * @property string $shipping_zone
 * @property integer $shipping_zone_id
 * @property string $shipping_address_format
 * @property string $shipping_custom_field
 * @property string $shipping_method
 * @property string $shipping_code
 * @property string $comment
 * @property string $total
 * @property integer $order_status_id
 * @property integer $language_id
 * @property integer $currency_id
 * @property string $currency_code
 * @property string $currency_value
 * @property string $ip
 * @property string $forwarded_ip
 * @property string $user_agent
 * @property string $accept_language
 * @property string $created_at
 * @property string $modified_at
 *
 * @property Currency $currency
 * @property Language $language
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'language_id', 'currency_id'], 'integer'],
            [['firstname', 'lastname', 'email', 'phone1', 'fax', 'custom_field', 'payment_firstname', 'payment_lastname', 'payment_company', 'payment_address', 'payment_city', 'payment_postcode', 'payment_country', 'payment_country_id', 'payment_zone', 'payment_zone_id', 'payment_address_format', 'payment_custom_field', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address', 'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_country_id', 'shipping_zone', 'shipping_zone_id', 'shipping_address_format', 'shipping_custom_field', 'shipping_method', 'shipping_code', 'comment', 'language_id', 'currency_id', 'currency_code', 'ip', 'forwarded_ip', 'user_agent', 'accept_language', 'created_at', 'modified_at'], 'required'],
            [['custom_field', 'payment_address_format', 'payment_custom_field', 'shipping_address_format', 'shipping_custom_field', 'comment'], 'string'],
            [['total', 'currency_value'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['firstname', 'lastname', 'phone1', 'fax', 'payment_firstname', 'payment_lastname', 'shipping_firstname', 'shipping_lastname'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 96],
            [['phone2', 'user_agent', 'accept_language'], 'string', 'max' => 255],
            [['payment_company', 'shipping_company', 'ip', 'forwarded_ip'], 'string', 'max' => 40],
            [['payment_address', 'payment_city', 'payment_country', 'payment_zone', 'payment_method', 'payment_code', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_zone', 'shipping_method', 'shipping_code'], 'string', 'max' => 128],
            [['payment_postcode', 'shipping_postcode'], 'string', 'max' => 10],
            [['currency_code'], 'string', 'max' => 3],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'phone1' => Yii::t('app', 'Phone1'),
            'phone2' => Yii::t('app', 'Phone2'),
            'fax' => Yii::t('app', 'Fax'),
            'custom_field' => Yii::t('app', 'Custom Field'),
            'payment_firstname' => Yii::t('app', 'Payment Firstname'),
            'payment_lastname' => Yii::t('app', 'Payment Lastname'),
            'payment_company' => Yii::t('app', 'Payment Company'),
            'payment_address' => Yii::t('app', 'Payment Address'),
            'payment_city' => Yii::t('app', 'Payment City'),
            'payment_postcode' => Yii::t('app', 'Payment Postcode'),
            'payment_country' => Yii::t('app', 'Payment Country'),
            'payment_country_id' => Yii::t('app', 'Payment Country ID'),
            'payment_zone' => Yii::t('app', 'Payment Zone'),
            'payment_zone_id' => Yii::t('app', 'Payment Zone ID'),
            'payment_address_format' => Yii::t('app', 'Payment Address Format'),
            'payment_custom_field' => Yii::t('app', 'Payment Custom Field'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'payment_code' => Yii::t('app', 'Payment Code'),
            'shipping_firstname' => Yii::t('app', 'Shipping Firstname'),
            'shipping_lastname' => Yii::t('app', 'Shipping Lastname'),
            'shipping_company' => Yii::t('app', 'Shipping Company'),
            'shipping_address' => Yii::t('app', 'Shipping Address'),
            'shipping_city' => Yii::t('app', 'Shipping City'),
            'shipping_postcode' => Yii::t('app', 'Shipping Postcode'),
            'shipping_country' => Yii::t('app', 'Shipping Country'),
            'shipping_country_id' => Yii::t('app', 'Shipping Country ID'),
            'shipping_zone' => Yii::t('app', 'Shipping Zone'),
            'shipping_zone_id' => Yii::t('app', 'Shipping Zone ID'),
            'shipping_address_format' => Yii::t('app', 'Shipping Address Format'),
            'shipping_custom_field' => Yii::t('app', 'Shipping Custom Field'),
            'shipping_method' => Yii::t('app', 'Shipping Method'),
            'shipping_code' => Yii::t('app', 'Shipping Code'),
            'comment' => Yii::t('app', 'Comment'),
            'total' => Yii::t('app', 'Total'),
            'order_status_id' => Yii::t('app', 'Order Status ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'currency_code' => Yii::t('app', 'Currency Code'),
            'currency_value' => Yii::t('app', 'Currency Value'),
            'ip' => Yii::t('app', 'Ip'),
            'forwarded_ip' => Yii::t('app', 'Forwarded Ip'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'accept_language' => Yii::t('app', 'Accept Language'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
