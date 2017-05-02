<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ManufacturerSearch represents the model behind the search form about `common\models\Manufacturer`.
 */
class ManufacturerSearch extends Manufacturer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'image', 'created_at', 'updated_at'], 'safe'],
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
        $query = Manufacturer::find();

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
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->created_at != '') {
            list($created_start, $created_end) = explode(' - ', $this->created_at);

            $query->andFilterWhere(['>=', 'created_at', $created_start . ' 00:00:00'])
                ->andFilterWhere(['<=', 'created_at', $created_end . ' 23:59:59']);
        }

        if ($this->updated_at != '') {
            list($updated_start, $updated_end) = explode(' - ', $this->updated_at);

            $query->andFilterWhere(['>=', 'updated_at', $updated_start . ' 00:00:00'])
                ->andFilterWhere(['<=', 'updated_at', $updated_end . ' 23:59:59']);
        }


        return $dataProvider;
    }
}
