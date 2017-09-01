<?php
/**
 * @var $this yii\web\View
 * @var $user webvimark\modules\UserManagement\models\User
 */
use yii\helpers\Html;
use webvimark\modules\UserManagement\UserManagementModule;
use common\models\Language;

?>
<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl([Language::getCurrent()->urlPrefix.'/user/password-recovery-receive', 'token' => $user->confirmation_token]);
?>

<?= UserManagementModule::t('front', 'Hello {fullname}, follow this link to reset your password:', ['fullname' => Html::encode($user->username)]) ?>

<?= Html::a('Reset password', $resetLink) ?>