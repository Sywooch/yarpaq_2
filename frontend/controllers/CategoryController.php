<?php

namespace frontend\controllers;

use common\models\Manufacturer;
use frontend\models\ProductFilter;
use Yii;
use yii\data\Pagination;
use frontend\components\CustomLinkPager;
use common\models\Product;
use common\models\category\Category;


class CategoryController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {
        $r = Yii::$app->request;

        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        // Параметры фильтра
        $productFilter = new ProductFilter();
        $productFilter->load($r->get());

        // Поиск среди категорий
        $category = Category::findByUrl($url);

        $childrenCategoriesIDs = $this->getAllChildrenCategories($category);


        // GET Products
        $products = Product::find()
            ->leftJoin('{{%product_category}}', '`product_id` = `id`')
            ->where(['category_id' => $childrenCategoriesIDs])
            ->orderBy(['price' => SORT_ASC]);

        $productsCount = clone $products;
        $pages = new Pagination([
            'totalCount' => $productsCount->count(),
            'defaultPageSize' => 16
        ]);
        $models = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        // GET Products END

        // GET Brands
        $brands = Manufacturer::find()
            ->leftJoin('{{%product}} p', '`manufacturer_id` = p.`id`')
            ->leftJoin('{{%product_category}} pc', 'pc.`product_id` = p.id')
            ->where(['category_id' => $childrenCategoriesIDs])->all();
        // GET Brands END



        return $this->render('index', [
            'category'          => $category,
            'products'          => $models,
            'pages'             => $pages,
            'pagination'        => CustomLinkPager::widget([ 'pagination' => $pages ]),
            'filterBrands'      => $brands,
            'productFilter'     => $productFilter
        ]);
    }

    private function getAllChildrenCategories($category) {
        $childrenCategories = $category->children()->all();

        $childrenCategoriesIDs = [];
        foreach ($childrenCategories as $cat) {
            $childrenCategoriesIDs[] = $cat->id;
        }

        return $childrenCategoriesIDs;
    }
}