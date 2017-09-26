<?php

namespace common\models;


use common\models\address\Address;
use webvimark\modules\UserManagement\models\User as BaseUser;

class User extends BaseUser {

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = parent::rules();

        $rules[] = [['salt', 'cart'], 'string'];

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
     * Возвращает все адреса пользователя, если есть.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses() {
        return $this->hasMany(Address::className(), ['user_id' => 'id']);
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

    public static function findByEmailAndUsername($username)
    {
        $result = static::find();
        $result->andWhere(['username' => $username ]);
        $result->orWhere(['email' => $username]);
        $result->andWhere(['status' => User::STATUS_ACTIVE]);

        $result = $result->one();

        return $result;
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

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        // деактивировать товары продавца,
        // если продавец деактивирован

        if (
            $this->hasRole('seller') && // если юзер продавец
            $this->status != 1 && // если статус не равен "Активен"
            $changedAttributes['status'] == 1
        ) {
            Product::deactivateProductsBySeller($this);
        }
    }

}