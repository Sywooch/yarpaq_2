<?php

namespace frontend\components;


use yii\base\Widget;
use frontend\models\appearance\HomeCategoryRepository;

/**
 * Class HomeCategoryGroup
 *
 * Виджет. Выводит промо категории на главную страницу.
 * @package frontend\components
 */
class HomeCategoryGroup extends  Widget
{
    public function run() {

        $categories = (new HomeCategoryRepository())
            ->visibleOnTheSite()
            ->all();

        return $this->render('home_category_group', [
            'home_categories'     => $categories
        ]);
    }
}