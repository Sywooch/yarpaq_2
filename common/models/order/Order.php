<?php

namespace common\models\order;

use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\OrderOption;
use common\models\Product;
use Yii;
use common\models\Currency;
use common\models\Language;
use common\models\User;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone1
 * @property string $phone2
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
            [['firstname', 'lastname', 'email', 'phone1', 'payment_firstname', 'payment_lastname', 'payment_address', 'payment_city', 'payment_country', 'payment_country_id', 'payment_zone', 'payment_zone_id', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_country_id', 'shipping_zone', 'shipping_zone_id', 'shipping_method', 'shipping_code', 'language_id', 'currency_id', 'currency_code', 'ip', 'user_agent', 'accept_language', 'created_at', 'modified_at'], 'required'],
            [['comment'], 'string'],
            [['total', 'currency_value'], 'number'],
            [['created_at', 'modified_at'], 'safe'],
            [['firstname', 'lastname', 'phone1', 'payment_firstname', 'payment_lastname', 'shipping_firstname', 'shipping_lastname'], 'string', 'max' => 32],
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
            'id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'phone1' => Yii::t('app', 'Phone1'),
            'phone2' => Yii::t('app', 'Phone2'),
            'payment_firstname' => Yii::t('app', 'Firstname'),
            'payment_lastname' => Yii::t('app', 'Lastname'),
            'payment_company' => Yii::t('app', 'Company'),
            'payment_address' => Yii::t('app', 'Address'),
            'payment_city' => Yii::t('app', 'City'),
            'payment_postcode' => Yii::t('app', 'Postcode'),
            'payment_country' => Yii::t('app', 'Country'),
            'payment_country_id' => Yii::t('app', 'Country'),
            'payment_zone' => Yii::t('app', 'Zone'),
            'payment_zone_id' => Yii::t('app', 'Zone'),
            'payment_method' => Yii::t('app', 'Payment method'),
            'payment_code' => Yii::t('app', 'Code'),
            'shipping_firstname' => Yii::t('app', 'Firstname'),
            'shipping_lastname' => Yii::t('app', 'Lastname'),
            'shipping_company' => Yii::t('app', 'Company'),
            'shipping_address' => Yii::t('app', 'Address'),
            'shipping_city' => Yii::t('app', 'City'),
            'shipping_postcode' => Yii::t('app', 'Postcode'),
            'shipping_country' => Yii::t('app', 'Country'),
            'shipping_country_id' => Yii::t('app', 'Country'),
            'shipping_zone' => Yii::t('app', 'Region'),
            'shipping_zone_id' => Yii::t('app', 'Region'),
            'shipping_method' => Yii::t('app', 'Shipping method'),
            'shipping_code' => Yii::t('app', 'Code'),
            'comment' => Yii::t('app', 'Comment'),
            'total' => Yii::t('app', 'Total'),
            'order_status_id' => Yii::t('app', 'Status'),
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

    public function getStatus() {
        return $this->hasOne(OrderStatus::className(), ['order_status_id' => 'order_status_id'])
            ->andWhere(['language_id' => Language::getCurrent()]);
    }

    public function getOrderProducts() {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    public function addProduct(Product $product, array $options) {
        $orderProduct               = new OrderProduct();
        $orderProduct->order_id     = $this->id;
        $orderProduct->product_id   = $product->id;
        $orderProduct->save();

        if ( !empty($options) ) { // если переданы опции

            foreach ($options as $product_option_id => $product_option_value_id) {

                $productOption      = ProductOption::findOne($product_option_id);
                $productOptionValue = ProductOptionValue::findOne($product_option_value_id);

                $orderOption                            = new OrderOption();
                $orderOption->order_id                  = $this->id;
                $orderOption->order_product_id          = $orderProduct->id;
                $orderOption->product_option_id         = $product_option_id;
                $orderOption->product_option_value_id   = $product_option_value_id;

                $orderOption->name                      = $productOption->option->content->name;
                $orderOption->value                     = $productOptionValue->value;
                $orderOption->type                      = $productOption->option->type;

                $orderOption->save();
            }

        }

        return true;
    }
}
