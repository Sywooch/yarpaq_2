<?php

namespace common\models\wide_banner;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SlideSearch represents the model behind the search form about `common\models\slider\Slide`.
 */
class WideBannerSearch extends WideBanner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sort'], 'integer'],
            [['name', 'created_at', 'updated_at', 'settings'], 'safe'],
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
        $query = WideBanner::find();

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
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->orderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }
}
