<?php

namespace frontend\components;

use common\models\Language;
use common\models\Product;
use common\models\User;
use Yii;
use yii\base\Component;
use yii\db\ActiveQuery;

class Cart extends Component
{
    private $config;
    private $data = [];
    private $cart_data = [];

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

        $session = Yii::$app->session;

        $user = Yii::$app->user->identity;

        // init
        $cart_data = [];

        // if user cart has value
        if ($user && $user->cart != '') {
            $cart_data = unserialize($user->cart);
        }

        // set to session
        //if (!$session->has('cart')) {
            $session->set('cart', $cart_data);
        //}

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

            foreach ($session->get('cart') as $key => $quantity) {
                $product = unserialize(base64_decode($key));

                $product_id = $this->getNewID($product['product_id']);

                $stock = true;

                // Options
                if (!empty($product['option'])) {
                    $options = $product['option'];
                } else {
                    $options = array();
                }

                $product_model = Product::find()
                    ->where(['status_id' => Product::STATUS_ACTIVE])->one();

                if ($product_model) {
                    $option_price = 0;
                    $option_points = 0;
                    $option_weight = 0;

                    $option_data = array();

                    foreach ($options as $product_option_id => $value) {
                        $sql = "
                            SELECT po.id as product_option_id, po.id as option_id, od.name, o.type
                            FROM y2_product_option po
                            LEFT JOIN `y2_option` o ON (po.option_id = o.id)
                            LEFT JOIN y2_option_description od ON (o.id = od.option_id)
                            WHERE po.id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . Language::getCurrent()->id . "'";

                        echo $sql;
                        die;
                        $option_query = Product::getDb()->createCommand($sql)->queryAll();

                        if ($option_query->num_rows) {
                            if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
                                $option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                                if ($option_value_query->num_rows) {
                                    if ($option_value_query->row['price_prefix'] == '+') {
                                        $option_price += $option_value_query->row['price'];
                                    } elseif ($option_value_query->row['price_prefix'] == '-') {
                                        $option_price -= $option_value_query->row['price'];
                                    }

                                    if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
                                        $stock = false;
                                    }

                                    $option_data[] = array(
                                        'product_option_id'       => $product_option_id,
                                        'product_option_value_id' => $value,
                                        'option_id'               => $option_query->row['option_id'],
                                        'option_value_id'         => $option_value_query->row['option_value_id'],
                                        'name'                    => $option_query->row['name'],
                                        'value'                   => $option_value_query->row['name'],
                                        'type'                    => $option_query->row['type'],
                                        'quantity'                => $option_value_query->row['quantity'],
                                        'subtract'                => $option_value_query->row['subtract'],
                                        'price'                   => $option_value_query->row['price'],
                                        'price_prefix'            => $option_value_query->row['price_prefix'],
                                        'points'                  => $option_value_query->row['points'],
                                        'points_prefix'           => $option_value_query->row['points_prefix'],
                                        'weight'                  => $option_value_query->row['weight'],
                                        'weight_prefix'           => $option_value_query->row['weight_prefix']
                                    );
                                }
                            } elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
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
                            } elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
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

                    $price = $product_model->price;

                    // Product Discounts
//                    $discount_quantity = 0;
//
//                    foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
//                        $product_2 = (array)unserialize(base64_decode($key_2));
//
//                        if ($product_2['product_id'] == $product_id) {
//                            $discount_quantity += $quantity_2;
//                        }
//                    }
//
//                    $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
//
//                    if ($product_discount_query->num_rows) {
//                        $price = $product_discount_query->row['price'];
//                    }

                    // Product Specials
//                    $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
//
//                    if ($product_special_query->num_rows) {
//                        $price = $product_special_query->row['price'];
//                    }

                    // Reward Points
//                    $product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
//
//                    if ($product_reward_query->num_rows) {
//                        $reward = $product_reward_query->row['points'];
//                    } else {
//                        $reward = 0;
//                    }

                    // Stock
                    if (!$product_model->quantity || ($product_model->quantity < $quantity)) {
                        $stock = false;
                    }

                    $this->data[$key] = array(
                        'key'             => $key,
                        'product_id'      => $product_model->id,
                        'title'           => $product_model->title,
                        'model'           => $product_model->model,
                        //'shipping'        => $product_model->shipping,
                        'image'           => $product_model->gallery[0]->url,
                        'option'          => $option_data,
                        'quantity'        => $quantity,

                        'stock'           => $stock,
                        'price'           => ($price + $option_price),
                        'total'           => ($price + $option_price) * $quantity,
                        //'reward'          => $reward * $quantity,
                        //'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
                        //'tax_class_id'    => $product_query->row['tax_class_id'],
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

    public function add($product_id, $qty = 1, $option = array()) {
        $this->data = array();

        $product['product_id'] = (int)$product_id;

        if ($option) {
            $product['option'] = $option;
        }

        $key = base64_encode(serialize($product));

        if ((int)$qty && ((int)$qty > 0)) {
            if (!isset($this->session->data['cart'][$key])) {
                $this->session->data['cart'][$key] = (int)$qty;
            } else {
                $this->session->data['cart'][$key] += (int)$qty;
            }
        }
    }

    public function update($key, $qty) {
        $this->data = array();

        if ((int)$qty && ((int)$qty > 0) && isset($this->session->data['cart'][$key])) {
            $this->session->data['cart'][$key] = (int)$qty;
        } else {
            $this->remove($key);
        }
    }

    public function remove($key) {
        $this->data = array();

        unset($this->session->data['cart'][$key]);
    }

    public function clear() {
        $this->data = array();

        $this->session->data['cart'] = array();
    }

    public function getWeight() {
        $weight = 0;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
            }
        }

        return $weight;
    }

    public function getSubTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $product['total'];
        }

        return $total;
    }

    public function getTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
        }

        return $total;
    }

    public function countProducts() {
        $product_total = 0;

        $products = $this->getProducts();

        foreach ($products as $product) {
            $product_total += $product['quantity'];
        }

        return $product_total;
    }

    public function hasProducts() {
        return count($this->cart_data);
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
}