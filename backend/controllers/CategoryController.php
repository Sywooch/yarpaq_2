<?php

namespace backend\controllers;

use common\models\category\Category;
use common\models\category\CategoryContent;
use common\models\category\CategoryImage;
use common\models\Language;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * PageController implements the CRUD actions for Page model.
 */
class CategoryController extends AdminDefaultController
{

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->session->set('redirect', Yii::$app->request->absoluteUrl);

        $root = Category::findOne(['parent_id' => 0]);

        if (!$root) {
            $this->redirect(['create', ''], 302);
            return;
        }

        return $this->render('index', [
            'root' => $root
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionCreate()
    {
        $parent_id = (int) Yii::$app->request->get('parent_id', 0);
        $parent = Category::findOne($parent_id);
        if (!$parent) { throw new BadRequestHttpException(); }

        $model = new Category();
        $contents = $this->generateEmptyContents();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->parent_id = $parent_id;

            // Начало транзакции
            $transaction = Category::getDb()->beginTransaction();
            $s = true; // content successful save status

            if ($model->prependTo($parent) ) {

                foreach ($contents as $content) {

                    $content->attributes = Yii::$app->request->post('CategoryContent_'.$content->lang_id);
                    $content->category_id = $model->id;

                    $content_saved = $content->save();
                    if (!$content_saved) $s = false;
                }
            }

            if (!$s) $transaction->rollBack();

            if ($transaction->isActive) {
                $transaction->commit();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'parent' => Category::findOne($parent_id),
            'languages' => Language::find()->all(),
            'contents' => $contents
        ]);
    }

    private function generateEmptyContents() {
        // создаем контент для всех языков
        $languages = Language::find()->all();

        $contents = [];

        foreach ($languages as $language) {

            /**
             * @var Language $language
             */
            $content = new CategoryContent();
            $content->lang_id = $language->id;

            $contents[] = $content;
        }

        return $contents;
    }


    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent_id = $model->parent_id;
        $contents = $model->contents;

        if ($model->load(Yii::$app->request->post())) {
            $this->uploadGalleryFiles($model);


            $transaction = Category::getDb()->beginTransaction();

            $s = true;

            if ($model->parent_id != $parent_id) {
                $model->appendTo($this->findModel($model->parent_id));
            } else {
                $model->save();
            }

            $this->saveGalleryFiles($model);
            $this->saveSort();

            foreach ($contents as $content) {
                /**
                 * @var $content CategoryContent
                 */
                $content->attributes = Yii::$app->request->post('CategoryContent_'.$content->lang_id);
                if (!$content->save()) { $s = false; }
            }

            if (!$s) $transaction->rollBack();

            if ($transaction->isActive) {
                $transaction->commit();

                if (Yii::$app->session->has('redirect')) {
                    $redirect = Yii::$app->session->get('redirect');
                    Yii::$app->session->remove('redirect');

                    return $this->redirect($redirect);
                } else {
                    return $this->redirect(['update', 'id' => $model->id]);
                }

            }
        }

        return $this->render('update', [
            'model' => $model,
            'languages' => Language::find()->all(),
            'parent' => $model->parent,
            'contents' => $contents
        ]);

    }

    private function saveSort() {
        $sort = Yii::$app->request->post()['gallery_sort'];

        if ($sort != '') {
            $sort = explode(',', $sort);
            $num = 1;
            foreach ($sort as $s) {
                $model = CategoryImage::findOne($s);

                if ($model) {
                    $model->sort = $num++;
                    $model->save();
                }
            }
        }
    }

    private function uploadGalleryFiles($model) {
        $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');
    }

    private function saveGalleryFiles($m) {
        $files = $m->galleryFiles;
        if (count($files)) {
            $sort = count($m->gallery);
            foreach ($files as $file) { $sort++;
                if (!is_null($file)) {
                    $model = new CategoryImage();
                    $model->model_id = $m->id;
                    $model->src_name = $file->name;
                    $model->sort = $sort;
                    $file_parts = explode(".", $file->name);
                    $ext = end($file_parts);
                    // generate a unique file name to prevent duplicate filenames
                    $model->web_name = Yii::$app->security->generateRandomString().".{$ext}";

                    $file->saveAs($model->path);

                    $model->save();
                }
            }
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->parent_id != 0) {
            $model->deleteWithChildren();
        }


        return $this->redirect(['index']);
    }


    public function actionImageDelete() {

        $key = (int) Yii::$app->request->post('key');

        $image = CategoryImage::findOne($key);
        if ($image) {
            $image->delete();
        }

        return json_encode(['success' => 1]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Возвращает JSON объект, описывающий свойства потомков
     *
     * @param $id Integer ID родительского элемента
     * @return String
     */
    public function actionGetChildrenData($id)
    {
        $tree = [];

        // получаем родительский элемент
        $node = Category::findOne(['id' => $id]);

        // если найден
        if ($node)
        {
            $children = $node->getChildren()->all();

            foreach ($children as $child) {

                /**
                 * @var Category $child
                 */
                $tree[] = [
                    'id'            => $child->id,
                    'header'        => $child->title,
                    'editUrl'       => Url::toRoute(['update', 'id' => $child->id]),
                    'moveUpUrl'     => Url::toRoute(['move-up', 'id' => $child->id]),
                    'moveDownUrl'   => Url::toRoute(['move-down', 'id' => $child->id]),
                    'addUrl'        => Url::toRoute(['create', 'parent_id' => $child->id]),
                    'viewUrl'       => $child->url,
                    'deleteUrl'     => Url::toRoute(['delete', 'id' => $child->id]),
                    'childrenUrl'   => Url::toRoute(['get-children-data', 'id' => $child->id]),
                    'childrenCount' => count( $child->children )
                ];
            }
        }
        // если не найден
        else
        {
            return \yii\helpers\Json::encode(['error' => 'Node not found']);
        }

        return \yii\helpers\Json::encode($tree);
    }

    public function actionMoveUp($id) {
        $current_node = Category::findOne($id);
        if (!$current_node->id) {
            throw new BadRequestHttpException();
        }

        $prev_node = $current_node->prev()->one();
        if (!$prev_node) { // нет предыдущего
            throw new BadRequestHttpException();
        }

        $result = $current_node->insertBefore($prev_node);

        echo json_encode(['result' => $result]);
    }

    public function actionMoveDown($id) {
        $current_node = Category::findOne($id);
        if (!$current_node->id) {
            throw new BadRequestHttpException();
        }

        $next_node = $current_node->next()->one();
        if (!$next_node) { // нет следующего
            throw new BadRequestHttpException();
        }

        $result = $current_node->insertAfter($next_node);

        echo json_encode(['result' => $result]);
    }
}
