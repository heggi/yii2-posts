<?php

namespace heggi\yii2posts\controllers\backend;

use Yii;
use heggi\yii2posts\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManageController implements the CRUD actions for Post model.
 */
class ManageController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
			    'class' => \yii\filters\AccessControl::className(),
			    'rules' => [
			        [
			            'allow' => true,
			            'roles' => ['@'],
			        ],
			    ],
			],
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where([
                'module' => $this->module->id
            ]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $model = new Post();
        $model->module = $this->module->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFiles();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFiles();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Post::findOne(['id' => $id, 'module' => $this->module->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
