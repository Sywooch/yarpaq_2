<?php
namespace frontend\models;

use common\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\base\Model;
use Yii;

class LoginForm extends Model
{
	public $email;
	public $password;
	public $rememberMe = false;

	private $_user = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			['password', 'validatePassword'],
		];
	}

	public function attributeLabels()
	{
		return [
			'email'   => UserManagementModule::t('front', 'Email'),
			'password'   => UserManagementModule::t('front', 'Password'),
		];
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		if ( !Yii::$app->getModule('user-management')->checkAttempts() )
		{
			$this->addError('password', UserManagementModule::t('front', 'Too many attempts'));

			return false;
		}

		if ( !$this->hasErrors() )
		{
			$user = $this->getUser();
			if ( !$user || !$user->validatePassword($this->password) )
			{
				$this->addError('password', UserManagementModule::t('front', 'Incorrect email or password.'));
			}
		}
	}

	/**
	 * Logs in a user using the provided email and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ( $this->validate() )
		{
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->user->cookieLifetime : 0);
		}
		else
		{
			return false;
		}
	}

	/**
	 * Finds user by [[email]]
	 * @return User|null
	 */
	public function getUser()
	{
		if ( $this->_user === false )
		{
			$u = new \Yii::$app->user->identityClass;
			$this->_user = ($u instanceof User ? $u->findByEmail($this->email) : User::findByEmail($this->email));
		}

		return $this->_user;
	}
}
