<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Yarpaq.az - Sifariş <?= $order->id; ?></title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div style="width: 680px;  background-color: #F7F7F7; padding-bottom: 100px;">
    <div style="position: relative; background-color: #fff;">
        <table style="background-color: #79B237; width: 680px;">
            <tr>
                <td style="padding-left: 30px; padding-top: 27px; padding-bottom: 15px;">
                    <a href="https://www.yarpaq.az/" title="Yarpaq.az" style="display: block; width: 160px;">
                        <img src="https://www.yarpaq.az/img/logo.png" alt="Yarpaq.az" style="width:158px;" />
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

        <div style="padding: 40px; color: #545454; background-color: #fff;">
            <p style="margin-top: 0px; margin-bottom: 20px;">Sifarişiniz qəbul olundu.</p>
            <p style="margin-top: 0px; margin-bottom: 20px;"></p>
            <p style="margin-top: 0px; margin-bottom: 20px;"><a href=""></a></p>

            <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
                <thead>
                <tr>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">Sifariş haqqında məlumatlar</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b>Sifarişin nömrəsi:</b> <?= $order->id; ?><br />
                        <b>Tarix əlavə olundu:</b> <?= $order->created_at; ?><br />
                        <b>Ödəmə üsulu:</b> <?= $order->payment_method; ?><br />
                        <b>Çatdırılma üsulu:</b> <?= $order->shipping_method; ?></td>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                    </td>
                </tr>
                </tbody>
            </table>

            <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
                <thead>
                <tr>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Məhsul</td>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Model</td>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Miqdar</td>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Qiymət</td>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Cəmi</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order->orderProducts as $orderProduct) { ?>
                    <tr>
                        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $orderProduct->name; ?><br> Kod: <?= $orderProduct->product_id; ?></td>
                        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?= $orderProduct->model; ?></td>
                        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $orderProduct->quantity; ?></td>
                        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $orderProduct->price; ?> AZN</td>
                        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $orderProduct->total; ?> AZN</td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>

                <tr>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Cəmi:</b></td>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $order->total; ?> AZN</td>
                </tr>
                <tr>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Yekun məbləğ:</b></td>
                    <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?= $order->total; ?> AZN</td>
                </tr>

                </tfoot>
            </table>
        </div>


    </div>

</div>
<div style="width: 680px; background-color: #79B237; height: 6px;"></div>
</body>
</html>
