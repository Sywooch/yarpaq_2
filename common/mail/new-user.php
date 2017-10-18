<?php
namespace common\mail;

use common\models\Language;
use Yii;

/**
 * @var $user
 * @var $link
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Yarpaq.az</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div style="width: 680px;  background-color: #F7F7F7; padding-bottom: 100px;">
    <div style="position: relative; background-color: #fff;">
        <div style="background-color: #79B237; height: 75px;">
            <a href="https://www.yarpaq.az/" title="Yarpaq.az" style="position: relative; left: 30px; top: 27px">
                <img src="https://www.yarpaq.az/img/logo.svg" alt="Yarpaq.az" style="width:158px;" />
            </a>

                <span style="
                color: #fff; 
                font-size: 12px; 
                font-weight: bold; 
                position: absolute; 
                top: 24px;
                right: 30px;
                display: inline-block;
                width: 185px;
                text-align: right;
                ">
                    <?= Yii::t('mail', 'Azerbaijan\'s Fastest Online Shopping Destination'); ?>
                </span>
        </div>

        <div style="padding: 60px 100px; width: 440px; color: #545454; background-color: #fff;">
            <h1 style="font-size: 24px; font-weight: normal; margin-bottom: 50px;">
                <?= Yii::t('mail', '{fullname}, welcome to Yarpaq.az website', [
                    'fullname' => $user->fullName
                ]); ?>
            </h1>

            <p style="font-size: 15px;">
                <?= Yii::t('mail', 'Dear {fullname}', [
                    'fullname' => '<strong>'.$user->fullName.'</strong>'
                ]); ?>
            </p>

            <p style="font-size: 14px;"><?= Yii::t('mail', 'In order to complete the registration you should click on the link below.'); ?></p>

            <p style="font-size: 12px;">
                <strong><?= Yii::t('mail', 'Confirmation link'); ?>:</strong><br>
                <a href="<?= $link ?>"
                   style="color: #79B237; text-decoration: none;">
                    <?= $link; ?>
                </a>
            </p>
        </div>


    </div>

</div>
<div style="width: 680px; background-color: #79B237; height: 6px;"></div>
</body>
</html>
