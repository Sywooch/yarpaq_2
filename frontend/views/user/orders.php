<div class="order_history">
    <div>
        <h2><?= Yii::t('app', 'Orders history'); ?></h2>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <td>#</td>
                        <td><?= Yii::t('app', 'Order date'); ?></td>
                        <td><?= Yii::t('app', 'Price'); ?></td>
                        <td><?= Yii::t('app', 'Status'); ?></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order->id?></td>
                        <td><?= ( new \DateTime($order->created_at))->format('d.m.Y H:i:s'); ?></td>
                        <td><?= Yii::$app->currency->format($order->total, Yii::$app->currency->getCurrencyByCode($order->currency_code)); ?></td>
                        <td><?= $order->status->name; ?></td>
                        <td><a href="<?= \yii\helpers\Url::to(['user/order', 'id' => $order->id]) ?>"><?= Yii::t('app', 'More info'); ?></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>