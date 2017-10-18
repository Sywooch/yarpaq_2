<?php

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\PasswordRecoveryForm $model
 */

$this->title = Yii::t('app', 'Email Confirmation Successful');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account_edit">
	<div>
		<h2><?= $this->title ?></h2>

		<?= Yii::t('app', 'Your email was successfully confirmed') ?>
	</div>
</div>