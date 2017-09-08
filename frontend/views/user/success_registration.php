<?php

/**
 * @var yii\web\View $this
 */

$this->title = Yii::t('app', 'Congratulations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account_edit">
	<div>
		<h2><?= $this->title ?></h2>

		<?= Yii::t('app', 'You have successfully joined Yarpaq.az') ?>
	</div>
</div>
