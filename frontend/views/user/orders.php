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
                        <td><?= Yii::t('app', 'Delivered date'); ?></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order->id?></td>
                        <td><?= $order->created_at; ?></td>
                        <td><?= $order->total; ?></td>
                        <td><?= $order->status->name; ?></td>
                        <td><?= $order->modified_at; ?></td>
                        <td><a href="#"><?= Yii::t('app', 'More info'); ?></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>