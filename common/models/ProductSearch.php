<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    public $seller_email;
    public $category;

    const SCENARIO_OWN = 'own';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'condition_id', 'currency_id', 'quantity', 'stock_status_id', 'weight_class_id', 'length_class_id', 'status_id', 'user_id', 'manufacturer_id', 'viewed', 'moderated'], 'integer'],
            [['model', 'title',  'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location_id', 'moderated_at', 'created_at', 'updated_at', 'seller_email', 'category'], 'safe', 'on' => 'default'],
            [['model', 'title',  'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location_id', 'moderated_at', 'created_at', 'updated_at', 'category'], 'safe', 'on' => 'own'],
            [['price', 'weight', 'length', 'width', 'height'], 'number'],
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
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            $this->tableName().'.id' => $this->id,
            'condition_id' => $this->condition_id,
            'price' => $this->price,
            'currency_id' => $this->currency_id,
            'quantity' => $this->quantity,
            'stock_status_id' => $this->stock_status_id,
            'weight' => $this->weight,
            'weight_class_id' => $this->weight_class_id,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'length_class_id' => $this->length_class_id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'manufacturer_id' => $this->manufacturer_id,
            'viewed' => $this->viewed,
            'moderated' => $this->moderated,
            'moderated_at' => $this->moderated_at,
            //'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if ($this->created_at != '') {
            list($created_start, $created_end) = explode(' - ', $this->created_at);

            $query->andFilterWhere(['>=', 'created_at', $created_start . ' 00:00:00'])
                ->andFilterWhere(['<=', 'created_at', $created_end . ' 23:59:59']);
        }

        if ($this->seller_email != '') {
            $query->joinWith(['seller s']);
            $query->andFilterWhere(['like', 's.email', $this->seller_email]);
        }

        if ($this->category != '') {
            $query->joinWith(['categories c']);
            $query->andFilterWhere(['c.id' => $this->category]);
        }


        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'upc', $this->upc])
            ->andFilterWhere(['like', 'ean', $this->ean])
            ->andFilterWhere(['like', 'jan', $this->jan])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'mpn', $this->mpn])
            ->andFilterWhere(['location_id' => $this->location_id]);

        return $dataProvider;
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();

        $labels['seller_email'] = Yii::t('app', 'Seller email');
        $labels['category'] = Yii::t('app', 'Category');

        return $labels;
    }
}
