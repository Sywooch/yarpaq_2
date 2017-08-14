<?php

namespace common\models\info;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\info\Info;

/**
 * InfoSearch represents the model behind the search form about `common\models\info\Info`.
 */
class InfoSearch extends Info
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'template_id', 'created_user_id', 'updated_user_id'], 'integer'],
            [['created_at', 'updated_at', 'settings'], 'safe'],
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
        $query = Info::find();

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
            'status' => $this->status,
            'template_id' => $this->template_id,
            'created_at' => $this->created_at,
            'created_user_id' => $this->created_user_id,
            'updated_at' => $this->updated_at,
            'updated_user_id' => $this->updated_user_id,
        ]);

        $query->andFilterWhere(['like', 'settings', $this->settings]);

        return $dataProvider;
    }
}
