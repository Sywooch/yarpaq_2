<?php
use common\models\category\Category;

foreach ($home_categories as $home_category) {
    $category = $home_category->relatedCat;
    $subcategories = $category
        ->children(1)
        ->limit(8)
        ->andWhere(['status' => Category::STATUS_ACTIVE])
        ->orderBy('lft')
        ->all(); ?>

    <div class="container container_home_category">
        <div class="home_category clearfix">
            <div class="pc_cell home_category_list"
                 style="background-color: <?= $home_category->bg_color ? $home_category->bg_color : '#4F6184'; ?>;">

                <a href="<?= $category->url; ?>" class="hc_link"><h3 class="h"><?= $category->title; ?></h3></a>

                <ul>
                    <?php foreach ($subcategories as $subcategory) { ?>
                    <li>
                        <a href="<?= $subcategory->url; ?>"><?= $subcategory->title; ?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>


            <div class="pc_cell home_category_main_cell">
                <a href="<?= $home_category->product1->url; ?>">
                    <img src="<?= $home_category->url1; ?>">
                </a>
            </div>

            <div class="pc_cell home_category_right_cell">
                <div class="home_category_sec_cell" style="margin-bottom: 14px;">
                    <a href="<?= $home_category->product2->url; ?>"
                       style="background: url('<?= $home_category->url2; ?>') no-repeat center; background-size: cover;">
                        <img class="hide_me" src="<?= $home_category->url2; ?>">
                    </a>
                </div>
                <div class="home_category_sec_cell">
                    <a href="<?= $home_category->product3->url; ?>"
                       style="background: url('<?= $home_category->url3; ?>') no-repeat center; background-size: cover;">
                        <img class="hide_me" src="<?= $home_category->url3; ?>">
                    </a>
                </div>
                <br style="clear: both">
            </div>

        </div>
    </div>

<?php }