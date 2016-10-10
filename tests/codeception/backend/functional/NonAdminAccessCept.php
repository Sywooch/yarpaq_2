<?php
namespace tests\codeception\backend\functional;

use tests\codeception\backend\FunctionalTester;
use common\models\User;

/* @var $scenario \Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure non-admin roles don\'t have access to admin pages');


// User object is passed as parameter
$admin = User::findByUsername('zaur');

$I->amLoggedInAs($admin);
$I->amOnPage(['user-management/index']);
//$I->see('Logout');