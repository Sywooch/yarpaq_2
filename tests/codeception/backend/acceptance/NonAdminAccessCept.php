<?php

namespace tests\codeception\backend\acceptance;

use tests\codeception\backend\AcceptanceTester;
/* @var $scenario \Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure non-admin roles don\'t have access to admin pages');

$I->am('admin');
$I->amOnPage('/user-management');
$I->see('Logout');