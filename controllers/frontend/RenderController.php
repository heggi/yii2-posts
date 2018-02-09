<?php

namespace heggi\yii2posts\controllers\frontend;

use Yii;
use yii\web\Controller;
use heggi\yii2posts\models\Post;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class RenderController extends Controller {

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where([
                'module' => $this->module->id
            ]),
        ]);

        $view = ArrayHelper::getValue($this->module->views, 'index', 'index');
        return $this->render($view, [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSingleId($id) {
        if (($model = Post::findOne(['id' => $id, 'module' => $this->module->id])) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $view = ArrayHelper::getValue($this->module->views, 'single', 'single');
        return $this->render($view, [
            'model' => $model,
        ]);
    }

    public function actionSingleSlug($slug) {
        if (($model = Post::findOne(['slug' => $slug, 'module' => $this->module->id])) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $view = ArrayHelper::getValue($this->module->views, 'single', 'single');
        return $this->render($view, [
            'model' => $model,
        ]);
    }
}