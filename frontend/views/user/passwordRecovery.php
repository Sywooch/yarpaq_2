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

		<?php if ( Yii::$app->session->hasFlash('error') ): ?>
			<div class="alert-alert-warning text-center">
				<?= Yii::$app->session->getFlash('error') ?>
			</div>
		<?php endif; ?>

		<div class="form">
			<form action="" method="post" id="regForm">

				<ul>

					<li <?= isset($model->getErrors()['email']) ? 'class="error"' : ''; ?>>
						<span><?= Yii::t('app', 'Email'); ?></span>
						<div>
							<input type="text" name="PasswordRecoveryForm[email]" value="<?= $model->email; ?>">
							<?php if (isset($model->getErrors()['email'])) { ?>
								<strong><?= $model->getErrors()['email'][0]; ?></strong>
							<?php } ?>
						</div>
					</li>

				</ul>

				<div class="submit">
					<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken()?>">
					<button type="submit"><?= UserManagementModule::t('front', 'Recover'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>