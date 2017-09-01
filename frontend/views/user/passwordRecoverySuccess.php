<?php

use webvimark\modules\UserManagement\UserManagementModule;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\PasswordRecoveryForm $model
 */

$this->title = UserManagementModule::t('front', 'Password recovery');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account_edit">
	<div>
		<h2><?= $this->title ?></h2>

		<?= UserManagementModule::t('front', 'Check your E-mail for further instructions') ?>
	</div>
</div>