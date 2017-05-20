<?php

namespace common\models;


use webvimark\modules\UserManagement\models\User as BaseUser;

class User extends BaseUser {

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();

        $rules[] = ['salt', 'string'];

        return $rules;
    }

    /**
     * Возвращает профиль пользователя, если есть.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }


    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => User::STATUS_ACTIVE]);
    }


    /**
     * Validates password
     * Реализуем способ проверки пароля со старого движка
     * Участвует текущий хэш и соль
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password_hash === $this->generateHash($password, $this->salt);
    }

    /**
     * Generates password hash from password with salt and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->salt = $this->generateSalt();
        $this->password_hash = $this->generateHash($password, $this->salt);
    }

    private function generateHash($password, $salt) {
        return sha1( $salt . sha1( $salt . sha1( $password ) ) );
    }

    private function generateSalt() {
        return substr(md5(uniqid(rand(), true)), 0, 9);
    }

    public function getFullname() {
        return $this->profile->firstname . ' ' . $this->profile->lastname;
    }
}