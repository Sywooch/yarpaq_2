<?php

use webvimark\modules\UserManagement\UserManagementModule;

/**
 * @var yii\web\View $this
 */

$this->title = UserManagementModule::t('back', 'Change own password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account_edit">
	<div>
		<h2><?= $this->title ?></h2>

		<?= UserManagementModule::t('back', 'Password has been changed') ?>
	</div>
</div>
