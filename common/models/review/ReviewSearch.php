<?php

namespace common\models\review;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\review\Review;

/**
 * ReviewSearch represents the model behind the search form about `common\models\review\Review`.
 */
class ReviewSearch extends Review
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'seller_id', 'product_id', 'stars', 'status'], 'integer'],
            [['review', 'post_date'], 'safe'],
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
        $query = Review::find();

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
            'customer_id' => $this->customer_id,
            'seller_id' => $this->seller_id,
            'product_id' => $this->product_id,
            'post_date' => $this->post_date,
            'stars' => $this->stars,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'review', $this->review]);

        return $dataProvider;
    }
}
