<?php

namespace frontend\components;

use common\models\Language;
use common\models\Product;
use Yii;
use yii\base\Component;

class Cart extends Component
{
    private $config;
    private $data = [];
    private $currency;

    public function __construct($config = array()) {
//        $this->config = $registry->get('config');
//        $this->customer = $registry->get('customer');
//        $this->session = $registry->get('session');
//        $this->db = $registry->get('db');
//        $this->tax = $registry->get('tax');
//        $this->weight = $registry->get('weight');

//        if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
//            $this->session->data['cart'] = array();
//        }


        // надо учесть что если чел не авторизован, то данные просто хранятся в сессии
        // а если авторизован, то данные выгружаются из базы и сохраняются опять же в сессию
        // данее работа ведется именно с данными из сессии

        $this->currency = Yii::$app->currency;

        $session = Yii::$app->session;

        $user = Yii::$app->user->identity;

        // if user cart has value
        if ($user && $user->cart != '') {
            $cart_data = unserialize($user->cart);
            $session->set('cart', $cart_data);
        }

        parent::__construct($config);
    }

    public function getNewID($old_id) {
        $sql = "SELECT new_id FROM `product_assoc` WHERE old_id = ".(int)$old_id."  LIMIT 1";


        $result = Yii::$app->db->createCommand($sql)->queryAll();

        if (count($result)) {
            return $result[0]['new_id'];
        } else {
            return null;
        }
    }

    public function getProducts() {
        if (!$this->data) {
            $session = Yii::$app->session;

            if (!$session->get('cart')) {
                return [];
            }

            foreach ($session->get('cart') as $key => $quantity) {
                $product = unserialize(base64_decode($key));

                $product_id = (int)$product['product_id'];

                $stock = true;

                // Options
                if (!empty($product['option'])) {
                    $options = $product['option'];
                } else {
                    $options = array();
                }

                $product_model = Product::find()
                    ->where(['id' => $product_id])
                    ->andWhere(['status_id' => Product::STATUS_ACTIVE])
                    ->one();

                if ($product_model) {
                    $option_price = 0;
                    $option_weight = 0;

                    $option_data = array();

                    foreach ($options as $product_option_id => $value) {
                        $sql = "
                            SELECT po.id as product_option_id, po.id as option_id, od.name, o.type
                            FROM y2_product_option po
                            LEFT JOIN `y2_option` o ON (po.option_id = o.id)
                            LEFT JOIN y2_option_description od ON (o.id = od.option_id)
                            WHERE po.id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . Language::getCurrent()->id . "'";
                        $option_query = Product::getDb()->createCommand($sql)->queryAll();


                        if (count($option_query)) {
                            $row = $option_query[0];
                            if ($row['type'] == 'select' || $row['type'] == 'radio' || $row['type'] == 'image') {

                                // временно убрал pov.subtract, из запроса
                                $sql = "
                                    SELECT pov.option_value_id, ovd.name, pov.quantity, pov.price, pov.price_prefix
                                    FROM y2_product_option_value pov
                                    LEFT JOIN y2_option_value ov ON (pov.option_value_id = ov.id)
                                    LEFT JOIN y2_option_value_description ovd ON (ov.id = ovd.option_value_id)
                                    WHERE pov.id = '" . (int)$value . "' AND
                                    pov.product_option_id = '" . (int)$product_option_id . "' AND
                                    ovd.language_id = '" . Language::getCurrent()->id . "'";

                                $option_value_query = Product::getDb()->createCommand($sql)->queryAll();

                                if (count($option_value_query)) {
                                    $ovq_row = $option_value_query[0];
                                    if ($ovq_row['price_prefix'] == '+') {
                                        $option_price += $ovq_row['price'];
                                    } elseif ($ovq_row['price_prefix'] == '-') {
                                        $option_price -= $ovq_row['price'];
                                    }

                                    //if ($ovq_row['subtract'] && (!$ovq_row['quantity'] || ($ovq_row['quantity'] < $quantity))) {
                                    if (!$ovq_row['quantity'] || ($ovq_row['quantity'] < $quantity)) {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'product_option_id'       => $product_option_id,
                                        'product_option_value_id' => $value,
                                        'option_id'               => $row['option_id'],
                                        'option_value_id'         => $ovq_row['option_value_id'],
                                        'name'                    => $row['name'],
                                        'value'                   => $ovq_row['name'],
                                        'type'                    => $row['type'],
                                        'quantity'                => $ovq_row['quantity'],
                                        //'subtract'                => $ovq_row['subtract'],
                                        'price'                   => $ovq_row['price'],
                                        'price_prefix'            => $ovq_row['price_prefix'],
                                    );
                                }
                            } elseif ($row['type'] == 'checkbox' && is_array($value)) {
//                                foreach ($value as $product_option_value_id) {
//                                    $option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
//
//                                    if ($option_value_query->num_rows) {
//                                        if ($option_value_query->row['price_prefix'] == '+') {
//                                            $option_price += $option_value_query->row['price'];
//                                        } elseif ($option_value_query->row['price_prefix'] == '-') {
//                                            $option_price -= $option_value_query->row['price'];
//                                        }
//
//                                        if ($option_value_query->row['points_prefix'] == '+') {
//                                            $option_points += $option_value_query->row['points'];
//                                        } elseif ($option_value_query->row['points_prefix'] == '-') {
//                                            $option_points -= $option_value_query->row['points'];
//                                        }
//
//                                        if ($option_value_query->row['weight_prefix'] == '+') {
//                                            $option_weight += $option_value_query->row['weight'];
//                                        } elseif ($option_value_query->row['weight_prefix'] == '-') {
//                                            $option_weight -= $option_value_query->row['weight'];
//                                        }
//
//                                        if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
//                                            $stock = false;
//                                        }
//
//                                        $option_data[] = array(
//                                            'product_option_id'       => $product_option_id,
//                                            'product_option_value_id' => $product_option_value_id,
//                                            'option_id'               => $option_query->row['option_id'],
//                                            'option_value_id'         => $option_value_query->row['option_value_id'],
//                                            'name'                    => $option_query->row['name'],
//                                            'value'                   => $option_value_query->row['name'],
//                                            'type'                    => $option_query->row['type'],
//                                            'quantity'                => $option_value_query->row['quantity'],
//                                            'subtract'                => $option_value_query->row['subtract'],
//                                            'price'                   => $option_value_query->row['price'],
//                                            'price_prefix'            => $option_value_query->row['price_prefix'],
//                                            'points'                  => $option_value_query->row['points'],
//                                            'points_prefix'           => $option_value_query->row['points_prefix'],
//                                            'weight'                  => $option_value_query->row['weight'],
//                                            'weight_prefix'           => $option_value_query->row['weight_prefix']
//                                        );
//                                    }
//                                }
                            } elseif ($row['type'] == 'text' || $row['type'] == 'textarea' || $row['type'] == 'file' || $row['type'] == 'date' || $row['type'] == 'datetime' || $row['type'] == 'time') {
//                                $option_data[] = array(
//                                    'product_option_id'       => $product_option_id,
//                                    'product_option_value_id' => '',
//                                    'option_id'               => $option_query->row['option_id'],
//                                    'option_value_id'         => '',
//                                    'name'                    => $option_query->row['name'],
//                                    'value'                   => $value,
//                                    'type'                    => $option_query->row['type'],
//                                    'quantity'                => '',
//                                    'subtract'                => '',
//                                    'price'                   => '',
//                                    'price_prefix'            => '',
//                                    'points'                  => '',
//                                    'points_prefix'           => '',
//                                    'weight'                  => '',
//                                    'weight_prefix'           => ''
//                                );
                            }
                        }

                    }

                    $price = $product_model->realPrice;

                    // Stock
                    if (!$product_model->quantity || ($product_model->quantity < $quantity)) {
                        $stock = false;
                    }

                    $this->data[$key] = array(
                        'key'             => $key,
                        'product_id'      => $product_model->id,
                        'title'           => $product_model->title,
                        'model'           => $product_model->model,
                        'image'           => $product_model->gallery[0]->url,
                        'option'          => $option_data,
                        'quantity'        => $quantity,
                        'stock'           => $stock,
                        'price'           => ($price + $option_price),
                        'total'           => ($price + $option_price) * $quantity,
                        'currency_code'   => $product_model->currency->code,
                        'weight'          => ($product_model->weight + $option_weight) * $quantity,
                        'weight_class_id' => $product_model->weight_class_id,
                        'length'          => $product_model->length,
                        'width'           => $product_model->width,
                        'height'          => $product_model->height,
                        'length_class_id' => $product_model->length_class_id,
                    );
                } else {
                    $this->remove($key);
                }
            }
        }

        return $this->data;
    }


    /**
     * Добавляет товар в корзину
     *
     * @param $product_id
     * @param int $qty
     * @param array $option
     */
    public function add($product_id, $qty = 1, $option = array()) {
        $this->data = array();

        $product['product_id'] = (int)$product_id;

        if ($option) {
            $product['option'] = $option;
        }

        $key = base64_encode(serialize($product));


        $cart = Yii::$app->session->get('cart');
        if ((int)$qty && ((int)$qty > 0)) {
            if (!isset($cart[$key])) {
                $cart[$key] = (int)$qty;
            } else {
                $cart[$key] += (int)$qty;
            }
        }
        Yii::$app->session->set('cart', $cart);
    }

    /**
     * Обновляет количество товара в корзине по ключу (base64)
     *
     * @param $key
     * @param $qty
     */
    public function update($key, $qty) {
        $this->data = [];

        $cart = Yii::$app->session->get('cart');

        if ((int)$qty && ((int)$qty > 0) && isset($cart[$key])) {
            $cart[$key] = (int)$qty;
        } else {
            $this->remove($key);
        }

        Yii::$app->session->set('cart', $cart);
    }

    /**
     * Удаляет товар из корзины по ключу (base64)
     *
     * @param $key
     */
    public function remove($key) {
        unset($this->data[$key]);

        $cart = Yii::$app->session->get('cart');
        unset($cart[$key]);

        Yii::$app->session->set('cart', $cart);
    }


    /**
     * Очищает корзину
     */
    public function clear() {
        $this->data = array();
        Yii::$app->session->set('cart', []);
    }


    public function getWeight() {
        $weight = 0;

        foreach ($this->getProducts() as $product) {
            $weight += $product['weight'];
        }

        return $weight;
    }

    /**
     * Возвращает сумму стоимостей всех товаров, без учета налогов, расходов на достувку и пр.
     *
     * @return int
     */
    public function getSubTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $product_currency = $this->currency->getCurrencyByCode($product['currency_code']);
            $total += $this->currency->convert($product['total'], $product_currency);
        }

        return $total;
    }


    /**
     * Возвращает общую (финальную) стоимость заказа
     *
     * @return int
     */
    public function getTotal() {

        $total = 0;

        foreach ($this->getProducts() as $product) {
            $product_currency = $this->currency->getCurrencyByCode($product['currency_code']);
            $total += $this->currency->convert($product['price'] * $product['quantity'], $product_currency);
        }

        return $total;
    }


    /**
     * Возвращает количество товаров в корзине
     *
     * @return int
     */

    public function countProducts() {
        $product_total = 0;

        $products = $this->getProducts();

        foreach ($products as $product) {
            $product_total += $product['quantity'];
        }

        return $product_total;
    }

    /**
     * Показывает есть ли товары в корзине
     *
     * @return int
     */
    public function hasProducts() {
        return count(Yii::$app->session->get('cart'));
    }

    public function hasStock() {
        $stock = true;

        foreach ($this->getProducts() as $product) {
            if (!$product['stock']) {
                $stock = false;
            }
        }

        return $stock;
    }

    public function hasShipping() {
        $shipping = false;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $shipping = true;

                break;
            }
        }

        return $shipping;
    }

    public function save() {
        $user = Yii::$app->user->identity;

        if ($user) {
            $user->cart = serialize(Yii::$app->session->get('cart'));
            return $user->save();
        }

        return false;
    }
}