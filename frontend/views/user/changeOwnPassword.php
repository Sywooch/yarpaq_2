<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm $model
 */

$this->title = UserManagementModule::t('back', 'Change own password');
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

					<?php if ( $model->scenario != 'restoreViaEmail' ): ?>

						<li <?= isset($model->getErrors()['current_password']) ? 'class="error"' : ''; ?>>
							<span><?= Yii::t('app', 'Current password'); ?></span>
							<div>
								<input type="password" name="ChangeOwnPasswordForm[current_password]" value="" autocomplete="off">
								<?php if (isset($model->getErrors()['current_password'])) { ?>
									<strong><?= $model->getErrors()['current_password'][0]; ?></strong>
								<?php } ?>
							</div>
						</li>

					<?php endif; ?>

					<li <?= isset($model->getErrors()['password']) ? 'class="error"' : ''; ?>>
						<span><?= Yii::t('app', 'Password'); ?></span>
						<div>
							<input type="password" name="ChangeOwnPasswordForm[password]" value="" autocomplete="off">
							<?php if (isset($model->getErrors()['password'])) { ?>
								<strong><?= $model->getErrors()['password'][0]; ?></strong>
							<?php } ?>
						</div>
					</li>

					<li <?= isset($model->getErrors()['repeat_password']) ? 'class="error"' : ''; ?>>
						<span><?= Yii::t('app', 'Repeat password'); ?></span>
						<div>
							<input type="password" name="ChangeOwnPasswordForm[repeat_password]" value="" autocomplete="off">
							<?php if (isset($model->getErrors()['repeat_password'])) { ?>
								<strong><?= $model->getErrors()['repeat_password'][0]; ?></strong>
							<?php } ?>
						</div>
					</li>

				</ul>

				<div class="submit">
					<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken()?>">
					<button type="submit"><?= UserManagementModule::t('front', 'Save'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>