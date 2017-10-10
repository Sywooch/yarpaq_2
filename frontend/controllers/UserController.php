<?php

namespace frontend\controllers;

use common\models\address\Address;
use common\models\Country;
use common\models\Language;
use common\models\order\Order;
use common\models\Profile;
use common\models\Zone;
use frontend\models\LoginForm;
use frontend\models\ChangeOwnPasswordForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\models\PasswordRecoveryForm;
use webvimark\modules\UserManagement\components\UserAuthEvent;
use webvimark\modules\UserManagement\UserManagementModule;


class UserController extends BasicController
{

    public $freeAccessActions = ['registration', 'login', 'orders', 'profile', 'recovery-password', 'password-recovery-receive', 'success'];

    public function actionRegistration()
    {

        if (!Yii::$app->user->isGuest) {
            $this->redirect(Url::home());
        }


        $customer   = new User(['scenario'=>'newUser']);
        $profile    = new Profile();
        $address    = new Address();
        $agree      = null;

        if ( Yii::$app->request->post() ) {

            $agree                      = (bool)Yii::$app->request->post('agree');

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
            $isValid = $customer->validate() && $agree;
            // проверяем все поля профиля, кроме user_id
            $isValid = $profile->validate(['firstname', 'lastname', 'org', 'phone1', 'phone2', 'fax']) && $isValid;
            // проверяем все поля адреса, кроме user_id
            $isValid = $address->validate(['firstname', 'lastname', 'company', 'address_1', 'city', 'postcode', 'country_id', 'zone_id']) && $isValid;

            if ($isValid && $customer->save()) {
                User::assignRole($customer->id, 'seller');

                $profile->user_id = $customer->id;
                $address->user_id = $customer->id;

                if ($profile->save() && $address->save()) {
                    $trans->commit();
                    return $this->redirect(Url::to(['user/success']));
                } else {
                    $trans->rollBack();
                }
            }

        }

        $countries  = Country::find()->all();
        $zones      = Zone::find()->all();

        $this->seo(Yii::t('app', 'Registration'));

        return $this->render('registration', [
            'customer' => $customer,
            'profile'  => $profile,
            'address'  => $address,
            'agree'    => $agree,

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
        if (!$user) {
            return $this->render('forbidden');
        }


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

        $this->seo(Yii::t('app', 'Personal information'));

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

        return Json::encode(['status' => 0, 'message' => array_values($model->getErrors())]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->homeUrl);
    }

    public function actionOrders() {
        $user = User::getCurrentUser();

        if (!$user) {
            return $this->render('orders_forbidden');
        }

        $this->seo(Yii::t('app', 'Orders history'));

        return $this->render('orders', [
            'orders' => Order::find()->andWhere(['user_id' => $user->id])->all()
        ]);
    }

    public function actionRecoveryPassword() {
        $this->seo(UserManagementModule::t('front', 'Password recovery'));

        if ( !Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $model = new PasswordRecoveryForm();

        if ( Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post()) )
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            // Ajax validation breaks captcha. See https://github.com/yiisoft/yii2/issues/6115
            // Thanks to TomskDiver
            $validateAttributes = $model->attributes;
            unset($validateAttributes['captcha']);

            return ActiveForm::validate($model, $validateAttributes);
        }

        if ( $model->load(Yii::$app->request->post()) AND $model->validate() )
        {
            if ( $this->triggerModuleEvent(UserAuthEvent::BEFORE_PASSWORD_RECOVERY_REQUEST, ['model'=>$model]) )
            {
                if ( $model->sendEmail(false) )
                {
                    if ( $this->triggerModuleEvent(UserAuthEvent::AFTER_PASSWORD_RECOVERY_REQUEST, ['model'=>$model]) )
                    {
                        return $this->renderIsAjax('passwordRecoverySuccess');
                    }
                }
                else
                {
                    Yii::$app->session->setFlash('error', UserManagementModule::t('front', "Unable to send message for email provided"));
                }
            }
        }

        return $this->renderIsAjax('passwordRecovery', compact('model'));
    }

    public function actionSuccess() {
        return $this->render('success_registration');
    }

    /**
     * Universal method for triggering events like "before registration", "after registration" and so on
     *
     * @param string $eventName
     * @param array  $data
     *
     * @return bool
     */
    protected function triggerModuleEvent($eventName, $data = [])
    {
        $event = new UserAuthEvent($data);

        $this->module->trigger($eventName, $event);

        return $event->isValid;
    }


    public function actionPasswordRecoveryReceive($token)
    {
        $this->seo(UserManagementModule::t('front', 'Change own password'));

        if ( !Yii::$app->user->isGuest )
        {
            return $this->goHome();
        }

        $user = User::findByConfirmationToken($token);

        if ( !$user )
        {
            throw new NotFoundHttpException(UserManagementModule::t('front', 'Token not found. It may be expired. Try reset password once more'));
        }

        $model = new ChangeOwnPasswordForm([
            'scenario'=>'restoreViaEmail',
            'user'=>$user,
        ]);

        if ( $model->load(Yii::$app->request->post()) AND $model->validate() )
        {
            if ( $this->triggerModuleEvent(UserAuthEvent::BEFORE_PASSWORD_RECOVERY_COMPLETE, ['model'=>$model]) )
            {
                $model->changePassword(false);

                if ( $this->triggerModuleEvent(UserAuthEvent::AFTER_PASSWORD_RECOVERY_COMPLETE, ['model'=>$model]) )
                {
                    return $this->renderIsAjax('changeOwnPasswordSuccess');
                }
            }
        }

        return $this->renderIsAjax('changeOwnPassword', compact('model'));
    }
}