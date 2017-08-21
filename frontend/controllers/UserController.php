<?php

namespace frontend\controllers;

use common\models\address\Address;
use common\models\Country;
use common\models\Language;
use common\models\order\Order;
use common\models\Profile;
use common\models\Zone;
use frontend\models\LoginForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use common\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;


class UserController extends BasicController
{

    public $freeAccessActions = ['registration', 'login', 'orders', 'profile'];

    public function actionRegistration()
    {

        if (!Yii::$app->user->isGuest) {
            $this->redirect(Url::home());
        }


        $customer   = new User(['scenario'=>'newUser']);
        $profile    = new Profile();
        $address    = new Address();

        if ( Yii::$app->request->post() ) {

            $customer->password         = Yii::$app->request->post('password');
            $customer->repeat_password  = Yii::$app->request->post('confirm_password');
            $customer->email            = Yii::$app->request->post('email');
            $customer->username         = Yii::$app->request->post('email');
            $customer->email_confirmed  = 1;

            $profile->firstname         = Yii::$app->request->post('firstname');
            $profile->lastname          = Yii::$app->request->post('lastname');
            $profile->org               = Yii::$app->request->post('org');
            $profile->phone1            = Yii::$app->request->post('phone1');
            $profile->phone2            = Yii::$app->request->post('phone2');
            $profile->fax               = Yii::$app->request->post('fax');

            $address->firstname         = Yii::$app->request->post('firstname');
            $address->lastname          = Yii::$app->request->post('lastname');
            $address->company           = Yii::$app->request->post('org');
            $address->address_1         = Yii::$app->request->post('address');
            $address->city              = Yii::$app->request->post('city');
            $address->postcode          = Yii::$app->request->post('postal_code');
            $address->country_id        = Yii::$app->request->post('country_id');
            $address->zone_id           = Yii::$app->request->post('zone_id');


            $db = $customer->getDb();

            $trans = $db->beginTransaction();

            // проверяем пользователя
            $isValid = $customer->validate();
            // проверяем все поля профиля, кроме user_id
            $isValid = $profile->validate(['firstname', 'lastname', 'org', 'phone1', 'phone2', 'fax']) && $isValid;
            // проверяем все поля адреса, кроме user_id
            $isValid = $address->validate(['firstname', 'lastname', 'company', 'address_1', 'city', 'postcode', 'country_id', 'zone_id']) && $isValid;

            if ($isValid && $customer->save()) {
                $profile->user_id = $customer->id;
                $address->user_id = $customer->id;

                if ($profile->save() && $address->save()) {
                    $trans->commit();
                    return $this->redirect(Url::to(Language::getCurrent()->urlPrefix.'/'));
                } else {
                    $trans->rollBack();
                }
            }

        }

        $countries  = Country::find()->all();
        $zones      = Zone::find()->all();

        return $this->render('registration', [
            'customer' => $customer,
            'profile'  => $profile,
            'address'  => $address,

            'customerErrors'    => $customer->getErrors(),
            'profileErrors'     => $profile->getErrors(),
            'addressErrors'     => $address->getErrors(),

            'countries'     => ArrayHelper::map($countries, 'id', 'name'),
            'zones'         => ArrayHelper::map($zones,     'id', 'name', 'country_id')
        ]);
    }

    public function actionProfile()
    {

        $user = User::getCurrentUser();
        if (!$user) { throw new ForbiddenHttpException(); }


        $customer   = $user;
        $profile    = $user->profile;
        $addresses  = $user->addresses;
        if (count($addresses)) {
            $address = $user->addresses[0];
        } else {
            $address = new Address();
        }

        if ( Yii::$app->request->post() ) {

            $customer->password         = Yii::$app->request->post('password');
            $customer->repeat_password  = Yii::$app->request->post('confirm_password');
            $customer->email            = Yii::$app->request->post('email');
            $customer->username         = Yii::$app->request->post('email');
            $customer->email_confirmed  = 1;

            $profile->firstname         = Yii::$app->request->post('firstname');
            $profile->lastname          = Yii::$app->request->post('lastname');
            $profile->org               = Yii::$app->request->post('org');
            $profile->phone1            = Yii::$app->request->post('phone1');
            $profile->phone2            = Yii::$app->request->post('phone2');
            $profile->fax               = Yii::$app->request->post('fax');

            $address->firstname         = Yii::$app->request->post('firstname');
            $address->lastname          = Yii::$app->request->post('lastname');
            $address->company           = Yii::$app->request->post('org');
            $address->address_1         = Yii::$app->request->post('address');
            $address->city              = Yii::$app->request->post('city');
            $address->postcode          = Yii::$app->request->post('postal_code');
            $address->country_id        = Yii::$app->request->post('country_id');
            $address->zone_id           = Yii::$app->request->post('zone_id');


            $db = $customer->getDb();

            $trans = $db->beginTransaction();

            // проверяем пользователя
            $isValid = $customer->validate();
            // проверяем все поля профиля, кроме user_id
            $isValid = $profile->validate(['firstname', 'lastname', 'org', 'phone1', 'phone2', 'fax']) && $isValid;
            // проверяем все поля адреса, кроме user_id
            $isValid = $address->validate(['firstname', 'lastname', 'company', 'address_1', 'city', 'postcode', 'country_id', 'zone_id']) && $isValid;

            if ($isValid && $customer->save()) {
                $profile->user_id = $customer->id;
                $address->user_id = $customer->id;

                if ($profile->save() && $address->save()) {
                    $trans->commit();
                } else {
                    $trans->rollBack();
                }
            }

        }

        $countries  = Country::find()->all();
        $zones      = Zone::find()->all();

        return $this->render('profile', [
            'customer' => $customer,
            'profile'  => $profile,
            'address'  => $address,

            'customerErrors'    => $customer->getErrors(),
            'profileErrors'     => $profile->getErrors(),
            'addressErrors'     => $address->getErrors(),

            'countries'     => ArrayHelper::map($countries, 'id', 'name'),
            'zones'         => ArrayHelper::map($zones,     'id', 'name', 'country_id')
        ]);
    }

    public function actionLogin() {

        $model = new LoginForm();

        if ( $model->load(Yii::$app->request->get()) AND $model->login() )
        {
            return Json::encode(['status' => 1]);
        }

        return Json::encode(['status' => 0]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->homeUrl);
    }

    public function actionOrders() {
        $user = User::getCurrentUser();
        if (!$user) { throw new ForbiddenHttpException(); }


        return $this->render('orders', [
            'orders' => Order::find()->andWhere(['user_id' => $user->id])->all()
        ]);
    }
}