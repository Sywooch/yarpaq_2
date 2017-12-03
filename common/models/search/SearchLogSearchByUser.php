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
            ['no_result', 'integer']
        ];
    }

    public function search() {
        $query = SearchLogSearchByUser::find()
            ->select(['text', 'user_id', 'created_at', 'no_result'])
            ->with('user')
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['user_id'   => $this->user_id])
            ->andFilterWhere(['no_result'   => $this->no_result])
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