<?php
namespace common\mail;

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
        <table style="background-color: #79B237; width: 680px;">
            <tr>
                <td style="padding-left: 30px; padding-top: 27px; padding-bottom: 15px;">
                    <a href="https://www.yarpaq.az/" title="Yarpaq.az" style="display: block; width: 160px;">
                        <img src="https://www.yarpaq.az/img/logo2.png" alt="Yarpaq.az" style="width:158px;" />
                    </a>
                </td>


                <td align="right">
                    <span style="
                        color: #fff;
                        font-size: 12px;
                        font-weight: bold;
                        padding-right: 30px;
                        right: 30px;
                        display: inline-block;
                        width: 185px;
                        text-align: right;
                        font-family: Arial, Helvetica, sans-serif;
                    ">
                        <?= Yii::t('mail', 'Azerbaijan\'s Fastest Online Shopping Destination'); ?>
                    </span>
                </td>
            </tr>
        </table>

        <div style="padding: 40px 100px; width: 440px; color: #545454; background-color: #fff;">
            <h1 style="font-size: 24px; font-weight: normal; margin-bottom: 50px; font-family: Arial, Helvetica, sans-serif;">
                <?= Yii::t('mail', '{fullname}, welcome to Yarpaq.az website', [
                    'fullname' => $user->fullName
                ]); ?>
            </h1>

            <p style="font-size: 15px; font-family: Arial, Helvetica, sans-serif;">
                <?= Yii::t('mail', 'Dear {fullname}', [
                    'fullname' => '<strong>'.$user->fullName.'</strong>'
                ]); ?>
            </p>

            <p style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;"><?= Yii::t('mail', 'In order to complete the registration you should click on the link below.'); ?></p>

            <p style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                <strong><?= Yii::t('mail', 'Confirmation link'); ?>:</strong><br>
                <a href="<?= $link ?>"
                   style="color: #79B237; text-decoration: none; font-family: Arial, Helvetica, sans-serif;">
                    <?= $link; ?>
                </a>
            </p>
        </div>


    </div>

</div>
<div style="width: 680px; background-color: #79B237; height: 6px;"></div>
</body>
</html>
