<?php

namespace backend\controllers;

use common\models\Profile;
use Yii;
use common\models\User;
use webvimark\modules\UserManagement\models\search\UserSearch;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \webvimark\modules\UserManagement\controllers\UserController
{
	/**
	 * @var User
	 */
	public $modelClass = 'common\models\User';

	/**
	 * @var UserSearch
	 */
	public $modelSearchClass = 'common\models\UserSearch';

	/**
	 * @return mixed|string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new User(['scenario'=>'newUser']);
		$profile = new Profile();

		if ( $model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post()) )
		{

			$tr = Yii::$app->db->beginTransaction();

			try {
				$model->validate();
				$profile->validate();

				if (!$model->save()) {
					throw new Exception('model errors');
				}

				$profile->user_id = $model->id;

				if (!$profile->save()) {
					throw new Exception('profile errors');
				}

				$tr->commit();

				return $this->redirect(['view',	'id' => $model->id]);
			} catch (Exception $e) {
				$tr->rollBack();
			}

		}

		return $this->renderIsAjax('create', compact('model', 'profile'));
	}

	/**
	 * @param int $id User ID
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionChangePassword($id)
	{
		$model = User::findOne($id);

		if ( !$model )
		{
			throw new NotFoundHttpException('User not found');
		}

		$model->scenario = 'changePassword';

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('changePassword', compact('model'));
	}

	/**
	 * Lists all models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel  = $this->modelSearchClass ? new $this->modelSearchClass : null;

		if ( $searchModel )
		{
			$dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		}
		else
		{
			$modelClass = $this->modelClass;
			$dataProvider = new ActiveDataProvider([
				'query' => $modelClass::find(),
			]);
		}

		return $this->renderIsAjax('index', compact('dataProvider', 'searchModel'));
	}

	/**
	 * Updates an existing model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$profile = $model->profile;

		if ( $this->scenarioOnUpdate )
		{
			$model->scenario = $this->scenarioOnUpdate;
		}

		if ( $model->load(Yii::$app->request->post()) AND $model->save()
			AND $profile->load(Yii::$app->request->post()) AND $profile->save())
		{
			$redirect = $this->getRedirectPage('update', $model);

			return $redirect === false ? '' : $this->redirect($redirect);
		}

		return $this->renderIsAjax('update', compact('model', 'profile'));
	}

	/**
	 * Updates an existing User model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionProfile()
	{
		$model = $this->findModel(Yii::$app->user->id);
		$profile = $model->profile;

		if ( $this->scenarioOnUpdate )
		{
			$model->scenario = $this->scenarioOnUpdate;
		}

		if ( $model->load(Yii::$app->request->post()) AND $model->save()
			AND $profile->load(Yii::$app->request->post()) AND $profile->save())
		{
			$redirect = $this->getRedirectPage('update', $model);

			return $redirect === false ? '' : $this->redirect(['profile']);
		}

		$profile = $model->profile;

		return $this->renderIsAjax('update', compact('model', 'profile'));
	}

}
