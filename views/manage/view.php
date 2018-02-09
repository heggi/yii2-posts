<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model heggi\yii2pages\models\Page */

$module = Yii::$app->controller->module;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $module->nameMultiple, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
        </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'slug',
                'visible' => $module->showSlug,
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'excerpt',
                'visible' => $module->showExcerpt,
            ],
            
            'content:html',
        ],
    ]) ?>

</div>
