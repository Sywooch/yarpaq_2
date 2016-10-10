<?php

namespace tests\codeception\common\_pages;

use yii\codeception\BasePage;
use webvimark\modules\UserManagement\models\forms\LoginForm;


/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = '/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $loginForm = new LoginForm;

        $this->actor->fillField('input[name="' . $loginForm->formName() . '[username]"]', $username);
        $this->actor->fillField('input[name="' . $loginForm->formName() . '[password]"]', $password);
        $this->actor->click('Login', 'button');
    }
}
