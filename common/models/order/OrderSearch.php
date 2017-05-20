<?php

namespace common\models\order;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `common\models\order\Order`.
 */
class OrderSearch extends Order
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'language_id', 'currency_id'], 'integer'],
            [['firstname', 'lastname', 'email', 'phone1', 'phone2', 'fax', 'payment_firstname', 'payment_lastname', 'payment_company', 'payment_address', 'payment_city', 'payment_postcode', 'payment_country', 'payment_zone', 'payment_address_format', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address', 'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_zone', 'shipping_address_format', 'shipping_method', 'shipping_code', 'comment', 'currency_code', 'ip', 'forwarded_ip', 'user_agent', 'accept_language', 'created_at', 'modified_at', 'status'], 'safe'],
            [['total', 'currency_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'payment_country_id' => $this->payment_country_id,
            'payment_zone_id' => $this->payment_zone_id,
            'shipping_country_id' => $this->shipping_country_id,
            'shipping_zone_id' => $this->shipping_zone_id,
            'total' => $this->total,
            'order_status_id' => $this->order_status_id,
            'language_id' => $this->language_id,
            'currency_id' => $this->currency_id,
            'currency_value' => $this->currency_value,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'payment_firstname', $this->payment_firstname])
            ->andFilterWhere(['like', 'payment_lastname', $this->payment_lastname])
            ->andFilterWhere(['like', 'payment_company', $this->payment_company])
            ->andFilterWhere(['like', 'payment_address', $this->payment_address])
            ->andFilterWhere(['like', 'payment_city', $this->payment_city])
            ->andFilterWhere(['like', 'payment_postcode', $this->payment_postcode])
            ->andFilterWhere(['like', 'payment_country', $this->payment_country])
            ->andFilterWhere(['like', 'payment_zone', $this->payment_zone])
            ->andFilterWhere(['like', 'payment_address_format', $this->payment_address_format])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'payment_code', $this->payment_code])
            ->andFilterWhere(['like', 'shipping_firstname', $this->shipping_firstname])
            ->andFilterWhere(['like', 'shipping_lastname', $this->shipping_lastname])
            ->andFilterWhere(['like', 'shipping_company', $this->shipping_company])
            ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
            ->andFilterWhere(['like', 'shipping_city', $this->shipping_city])
            ->andFilterWhere(['like', 'shipping_postcode', $this->shipping_postcode])
            ->andFilterWhere(['like', 'shipping_country', $this->shipping_country])
            ->andFilterWhere(['like', 'shipping_zone', $this->shipping_zone])
            ->andFilterWhere(['like', 'shipping_address_format', $this->shipping_address_format])
            ->andFilterWhere(['like', 'shipping_method', $this->shipping_method])
            ->andFilterWhere(['like', 'shipping_code', $this->shipping_code])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'forwarded_ip', $this->forwarded_ip])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'accept_language', $this->accept_language]);

        return $dataProvider;
    }
}
