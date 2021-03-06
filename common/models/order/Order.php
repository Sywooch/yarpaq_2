<?php

namespace common\models\order;

use common\models\Country;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use common\models\OrderOption;
use common\models\Product;
use common\models\shipping\Shipping;
use common\models\Zone;
use Yii;
use common\models\Currency;
use frontend\components\Currency as CurrencyComponent;
use common\models\Language;
use common\models\User;
use yii\base\Model;
use yii\db\Exception;
use common\models\notification\OrderStatusChangedAdminNotification;
use common\models\notification\OrderStatusChangedUserNotification;
use common\models\notification\OrderStatusChangedSellerNotification;

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
 * @property string $shipping_price
 * @property string $comment
 * @property float $subtotal
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
    public $payment_method_id;
    public $shipping_method_id;

    const SCENARIO_OWN = 'own';

    const STATUS_CHANGED = 'Status changed';

    public $seller_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    public function init() {
        $this->on(self::STATUS_CHANGED, function ($event) {
            $order = $event->sender;

            try {
                $userNotification = new OrderStatusChangedUserNotification($order);
                $userNotification->send();

                $adminNotification = new OrderStatusChangedAdminNotification($order);
                $adminNotification->send();

                $sellerNotification = new OrderStatusChangedSellerNotification($order);
                $sellerNotification->send();
            } catch (Exception $e) {
                Yii::error($e->getMessage());
            }

        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'language_id', 'currency_id', 'payment_method_id', 'shipping_method_id'], 'integer'],
            [['firstname', 'lastname', 'email', 'phone1', 'payment_firstname', 'payment_lastname', 'payment_address', 'payment_city', 'payment_country', 'payment_country_id', 'payment_zone', 'payment_zone_id', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_country_id', 'shipping_zone', 'shipping_zone_id', 'shipping_method', 'shipping_code', 'language_id', 'currency_id', 'currency_code'], 'required'],
            [['comment'], 'string'],
            ['order_status_id', 'default', 'value' => 0],
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
            [['created_at', 'modified_at'], 'default', 'value' => function ($model, $attribute) {
                $now = new \DateTime();
                return $now->format('Y-m-d H:i:s');
            }],
            ['ip', 'default', 'value' => function ($model, $attribute) {
                return Yii::$app->request->userIP;
            }],
            ['user_agent', 'default', 'value' => function ($model, $attribute) {
                return Yii::$app->request->userAgent;
            }],
            ['accept_language', 'default', 'value' => function ($model, $attribute) {
                return implode(';', Yii::$app->request->acceptableLanguages);
            }]
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
            'shipping_zone_id' => Yii::t('app', 'Zone'),
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
            ->andWhere(['language_id' => Language::getCurrent()->id]);
    }

    public function getOrderProducts() {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    /**
     * Прикрепляет товар к заказу в определенном количестве с учетом опций
     *
     * @param Product $product
     * @param $quantity
     * @param array $options
     * @return bool
     */
    public function addProduct(Product $product, $quantity, array $options) {
        $currency = new CurrencyComponent();

        $tr = $this->getDb()->beginTransaction();

        // создаем связь заказа и товара
        $orderProduct               = new OrderProduct();
        $orderProduct->order_id     = $this->id;
        $orderProduct->product_id   = $product->id;
        $orderProduct->name         = $product->title;
        $orderProduct->model        = $product->model;
        $orderProduct->quantity     = $quantity;

        // если переданы опции, применяем их
        if ( !empty($options) ) {
            foreach ($options as $product_option_id => $product_option_value_id) {
                $productOption      = ProductOption::findOne($product_option_id);
                $productOptionValue = ProductOptionValue::findOne($product_option_value_id);

                $product->applyOption($productOption, $productOptionValue);
            }
        }


        $orderProduct->price        = $currency->convert($product->getRealPrice(true), $product->currency, $currency->getCurrencyByCode($this->currency_code));
        $orderProduct->total        = $quantity * $orderProduct->price;
        $isValid = $orderProduct->save();

        if ($isValid) {
            $this->total += $orderProduct->total;
            $this->save();
        }

        // создаем опции товара в заказе
        foreach ($product->appliedOptions as $appliedOption) {

            $product_option         = $appliedOption['product_option'];
            $product_option_value   = $appliedOption['product_option_value'];

            $orderOption                            = new OrderOption();
            $orderOption->order_id                  = $this->id;
            $orderOption->order_product_id          = $orderProduct->id;
            $orderOption->product_option_id         = $product_option->id;
            $orderOption->product_option_value_id   = $product_option_value->id;

            $orderOption->name                      = $product_option->option->content->name;
            $orderOption->value                     = $product_option_value->optionValue->name;
            $orderOption->type                      = $product_option->option->type;

            $isValid = $orderOption->save() && $isValid;
        }

        if ($isValid) {
            $tr->commit();
        }

        return $isValid;
    }


    public function beforeSave($insert) {

        if (parent::beforeSave($insert))
        {
            $now = new \DateTime();

            // set Created At
            if (!$this->isNewRecord) {
                $this->modified_at = $now->format('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }

    public function scenarios()
    {
        $scenarios = Model::scenarios();
        $scenarios[self::SCENARIO_OWN] = $scenarios['default'];

        return $scenarios;
    }

    public function setAsPaid() {
        // TODO
    }

    public function getPaymentCountry() {
        return $this->hasOne(Country::className(), ['id' => 'payment_country_id']);
    }

    public function getPaymentZone() {
        return $this->hasOne(Zone::className(), ['id' => 'payment_zone_id']);
    }

    public function getShippingCountry() {
        return $this->hasOne(Country::className(), ['id' => 'shipping_country_id']);
    }

    public function getShippingZone() {
        return $this->hasOne(Zone::className(), ['id' => 'shipping_zone_id']);
    }


    /**
     * Пересчитывает общую сумму с учетом стоимости товаров,
     * доставки и наценки на оплату
     */
    public function recalculate() {
        $subtotal = 0;

        foreach ($this->getOrderProducts()->all() as $orderProduct) {
            // прибавляем стоимость товара
            $subtotal += $orderProduct->total;
        }

        $this->subtotal = $subtotal;

        $this->recalculateShippingPrice();

        $this->total = $this->subtotal + $this->shipping_price;

        $this->save();
    }

    public function recalculateShippingPrice() {
        $shipping_price = 0;
        $weight = 0;
        $shipping_method = Shipping::create($this->shipping_method);

        foreach ($this->getOrderProducts()->all() as $orderProduct) {
            // определяем вес товара
            $weight = $orderProduct->product->weight;
        }

        // прибавляем стоимость доставки товара в соответствии
        // с его весом и пунктом назначения
        $shipping_price += $shipping_method->calculateCostByZone($weight, $this->shippingZone);

        $currency = new CurrencyComponent();
        $shipping_price = $currency->convert($shipping_price, $currency->getCurrencyByCode('AZN'), $currency->getCurrencyByCode($this->currency_code));

        $this->shipping_price = $shipping_price;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if (isset($changedAttributes['order_status_id'])) {
            $this->trigger(Order::STATUS_CHANGED);
        }
    }
}
