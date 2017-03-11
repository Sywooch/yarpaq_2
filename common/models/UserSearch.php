<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `webvimark\modules\UserManagement\models\User`.
 */
class UserSearch extends \webvimark\modules\UserManagement\models\search\UserSearch
{
    public function rules()
    {
        return [
            [['id', 'superadmin', 'status', 'updated_at', 'email_confirmed'], 'integer'],
            ['created_at', 'string'],
            [['username', 'gridRoleSearch', 'registration_ip', 'email'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $query->with(['roles']);

        if ( !Yii::$app->user->isSuperadmin )
        {
            $query->where(['superadmin'=>0]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort'=>[
                'defaultOrder'=>[
                    'id'=>SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ( $this->gridRoleSearch )
        {
            $query->joinWith(['roles']);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'superadmin' => $this->superadmin,
            'status' => $this->status,
            Yii::$app->getModule('user-management')->auth_item_table . '.name' => $this->gridRoleSearch,
            'registration_ip' => $this->registration_ip,
            'updated_at' => $this->updated_at,
            'email_confirmed' => $this->email_confirmed,
        ]);

        if ($this->created_at != '') {
            list($created_start, $created_end) = explode(' - ', $this->created_at);

            $query->andFilterWhere(['>=', 'created_at', strtotime($created_start . ' 00:00:00')])
                ->andFilterWhere(['<=', 'created_at', strtotime($created_end . ' 23:59:59')]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
