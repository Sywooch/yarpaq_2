<?php
/**
 * @var $this yii\web\View
 * @var $user webvimark\modules\UserManagement\models\User
 */
use yii\helpers\Html;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\Url;

?>
<?php
$resetLink = Url::to(['user/password-recovery-receive', 'token' => $user->confirmation_token], true);
?>

<?= UserManagementModule::t('front', 'Hello {fullname}, follow this link to reset your password', ['fullname' => Html::encode($user->fullname)]) ?>:

<?= Html::a( UserManagementModule::t('back', 'Reset password'), $resetLink) ?>