<?php

namespace frontend\models\appearance;

use common\models\appearance\HomeCategory;
use common\models\category\Category;
use yii\db\ActiveQuery;

class HomeCategoryRepository extends ActiveQuery
{

    public function __construct() {
        parent::__construct(HomeCategory::className());

        $this->alias('hc');
    }

    /**
     * Добавляет условие:
     * Добашняя категория должна быть активна, также должна быть связанная с ней реальная категория
     */
    public function visibleOnTheSite() {
        $this->andWhere(['hc.status' => HomeCategory::STATUS_ACTIVE]);

        $this->joinWith('relatedCat rc');
        $this->andWhere(['rc.status' => Category::STATUS_ACTIVE]);

        return $this;
    }
}