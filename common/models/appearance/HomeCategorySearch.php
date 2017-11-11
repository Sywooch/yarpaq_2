<?php

namespace common\models\appearance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\appearance\HomeCategory;

/**
 * HomeCategorySearch represents the model behind the search form about `common\models\appearance\HomeCategory`.
 */
class HomeCategorySearch extends HomeCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'related_cat_id', 'product_id_1', 'product_id_2', 'product_id_3'], 'integer'],
            [['web_name_1', 'src_name_1', 'web_name_2', 'src_name_2', 'web_name_3', 'src_name_3'], 'safe'],
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
        $query = HomeCategory::find();

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
            'related_cat_id' => $this->related_cat_id,
            'product_id_1' => $this->product_id_1,
            'product_id_2' => $this->product_id_2,
            'product_id_3' => $this->product_id_3,
        ]);

        $query->andFilterWhere(['like', 'web_name_1', $this->web_name_1])
            ->andFilterWhere(['like', 'src_name_1', $this->src_name_1])
            ->andFilterWhere(['like', 'web_name_2', $this->web_name_2])
            ->andFilterWhere(['like', 'src_name_2', $this->src_name_2])
            ->andFilterWhere(['like', 'web_name_3', $this->web_name_3])
            ->andFilterWhere(['like', 'src_name_3', $this->src_name_3]);

        return $dataProvider;
    }
}
