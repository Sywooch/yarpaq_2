<?php

namespace frontend\controllers;

use common\models\Language;
use common\models\Manufacturer;
use common\models\option\OptionValue;
use common\models\option\ProductOption;
use common\models\option\ProductOptionValue;
use frontend\models\ProductFilter;
use frontend\models\ProductRepository;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use frontend\components\CustomLinkPager;
use common\models\category\Category;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class CategoryController extends BasicController
{

    public $freeAccessActions = ['index'];

    public function actionIndex() {

        $ajax = false;

        if (Yii::$app->request->isAjax) {
            $ajax = true;
        }

        $r = Yii::$app->request;

        $url = preg_match('/^[\w_\-\d\/]+$/', $r->get('url')) ? $r->get('url') : '';

        // Параметры фильтра
        $productFilter = new ProductFilter();
        $productFilter->load($r->get());

        if (!$productFilter->validate()) {
            throw new Exception('Wrong filter');
        }

        // Поиск среди категорий
        $category = Category::findByUrl($url);
        if (!$category) { throw new NotFoundHttpException(); }

        $this->pageSeo($category);



        // GET Brands
        $brands = Manufacturer::find()
            ->alias('m')
            ->leftJoin('{{%product}}', '{{%product}}.manufacturer_id = m.id')
            ->leftJoin('{{%product_category}} pc', 'pc.`product_id` = {{%product}}.id')
            ->groupBy('m.id');
        // GET Brands END

        if ($category->id == Yii::$app->params['sale_category_id']) { // если категория скидок
            $repo = new ProductRepository();
            $products = $repo
                ->visibleOnTheSite()
                ->hasDiscount();

            $distinctBrands = clone $products;
            $distinctBrands
                ->select('manufacturer_id')
                ->distinct();

            $repo->orderBy(['d.id' => SORT_DESC]);



            $brands = Manufacturer::find()
                ->andWhere(['in', 'id', $distinctBrands]);
        } else {
            $childrenCategoriesIDs = $this->getAllChildrenCategories($category);

            $brands->where(['category_id' => $childrenCategoriesIDs]);

            $repo = new ProductRepository();
            $products = $repo
                ->visibleOnTheSite()
                ->leftJoin('{{%product_category}} pc', 'pc.`product_id` = {{%product}}.`id`')
                ->andWhere(['pc.category_id' => $childrenCategoriesIDs])
                ->groupBy('{{%product}}.id');
                //->withinCategory($category); // TODO почему-то запрос зависает

            if ($productFilter->sort) {
                $products->orderBy( $productFilter->sortSetting );
            } else {
                $products->orderBy(['price' => SORT_ASC]);
            }
        }

        $possibleOptions = $this->getPossibleOptionsAndValues($products, $category);

        // get min price
        $minPriceProducts = clone $products;
        $productFilter->price_min = $minPriceProducts->min('price');
        // get max price
        $maxPriceProducts = clone $products;
        $productFilter->price_max = $maxPriceProducts->max('price');


        if ($productFilter->optionValues) {
            $products->withOptionValues($productFilter->optionValues);
        }

        if ($productFilter->condition) {
            $products->andWhere(['condition_id' => $productFilter->condition]);
        }

        if ($productFilter->brand) {
            $products->andWhere(['manufacturer_id' => $productFilter->brand]);
        }

        if ($productFilter->price_from && $productFilter->price_to) {
            $products->joinWith('discount d');
            $products->andWhere('
            (
                case

                when
                    d.value IS NOT NULL
                    AND ( (d.period = 1 AND d.start_date <= :now AND d.end_date >= :now OR d.period = 0)  ) then

                    case when d.`value` >= :price_from and d.`value` <= :price_to then 1 else 0 end
                else
                    case when `price` >= :price_from AND `price` <= :price_to then 1 else 0 end
                end

            ) = 1
            ', [
                'now'           => ( new \DateTime() )->format('Y-m-d H:i:s'),
                'price_from'    => $productFilter->price_from,
                'price_to'      => $productFilter->price_to
            ]);
        }

        // pagination
        $productsCount = clone $products;
        $pages = new Pagination([
            'totalCount' => $productsCount->count(),
            'defaultPageSize' => $productFilter->per_page ? $productFilter->per_page : 24
        ]);

        $models = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        // GET Products END


        if ($ajax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'markup' => $this->renderPartial('@app/views/blocks/product_list', ['products' => $models]),
                'next_page_url' => $this->getNextPageUrl($pages)
            ];
        } else {
            return $this->render('index', [
                'count'                 => $pages->totalCount,
                'category'              => $category,
                'products'              => $models,
                'pages'                 => $pages,
                'pagination'            => CustomLinkPager::widget([ 'pagination' => $pages ]),
                'filterBrands'          => $brands->all(),
                'productFilter'         => $productFilter,
                'next_page_url'         => $this->getNextPageUrl($pages),
                'possibleOptionValues'  => ArrayHelper::map($possibleOptions, 'option_value_id', function ($row) {
                    return ['name' => $row['value_name'], 'image' => $row['image']];
                }, 'option_id'),
                'possibleOptions'       => ArrayHelper::map($possibleOptions, 'option_id', 'option_name')
            ]);
        }
    }

    /**
     * Возвращает список опций и их значений, которые есть хотябы у одного товара данной категории
     * Главное условие, чтобы уровень категории был не меньше 3
     *
     * @param $products
     * @param $category
     * @return array
     */
    protected function getPossibleOptionsAndValues(ProductRepository $products, $category) {
        if ($category->depth < 3) {
            return [];
        }

        $pr = clone $products;
        $pr->select([
            '{{%product_option}}.`option_id`',
            '`od`.`name` AS `option_name`',
            '`pov`.`option_value_id`',
            '`ovd`.`name` AS `value_name`',
            '`ov`.`image`'
        ]);

        $pr->joinWith('productOptionValues pov');

        $pr->leftJoin('{{%option_value}} ov', 'ov.id = pov.option_value_id');
        $pr->leftJoin('{{%option_description}} od', 'od.option_id = {{%product_option}}.option_id AND od.language_id = '.Language::getCurrent()->id);
        $pr->leftJoin('{{%option_value_description}} ovd', 'ovd.option_value_id = pov.option_value_id AND ovd.language_id = '.Language::getCurrent()->id);

        $pr->andWhere('{{%product_option}}.option_id IS NOT NULL');
        $pr->andWhere('pov.option_value_id IS NOT NULL');

        $pr->groupBy('`pov`.`option_value_id`');


        $sql = $pr->createCommand()->getRawSql();

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    private function getAllChildrenCategories($category) {
        $childrenCategories = $category->children()->all();

        $childrenCategoriesIDs = [$category->id];
        foreach ($childrenCategories as $cat) {
            $childrenCategoriesIDs[] = $cat->id;
        }

        return $childrenCategoriesIDs;
    }

    /**
     * Возвращает URL следующей страницы, если она есть.
     * Иначе пустую строку
     *
     * @param $pages Pagination
     * @return string
     */
    protected function getNextPageUrl($pages) {
        $link = '';

        if (isset($pages->getLinks()[Pagination::LINK_NEXT])) {
            $link = $pages->getLinks()[Pagination::LINK_NEXT];
            $link = str_replace('%2F', '/', $link);
        }

        return $link;
    }
}