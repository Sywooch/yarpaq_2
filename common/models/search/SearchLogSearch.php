<?php

namespace common\models\search;


use yii\data\ActiveDataProvider;

class SearchLogSearch extends SearchLog
{
    public $count;

    public function rules() {
        return [
            ['text', 'string'],
            ['user_id', 'integer'],
        ];
    }

    public function search() {
        $query = SearchLogSearch::find()
            ->select(['text', 'user_id', 'count(text) as `count`'])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['user_id'   => $this->user_id])
            ->groupBy('text')
            ->orderBy(['count' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        return $dataProvider;
    }
}