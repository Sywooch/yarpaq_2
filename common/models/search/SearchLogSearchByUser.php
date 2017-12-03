<?php

namespace common\models\search;


use yii\data\ActiveDataProvider;

class SearchLogSearchByUser extends SearchLog
{
    public $count;

    public function rules() {
        return [
            ['text', 'string'],
            ['user_id', 'integer'],
        ];
    }

    public function search() {
        $query = SearchLogSearchByUser::find()
            ->select(['text', 'user_id', 'created_at'])
            ->with('user')
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['user_id'   => $this->user_id])
            ->andWhere(['not', ['user_id' => null]])
            ->orderBy(['created_at' => SORT_DESC]);

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