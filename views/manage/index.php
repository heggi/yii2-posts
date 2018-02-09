<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = Yii::$app->controller->module;
$this->title = $module->nameMultiple;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a($module->nameNew, ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'content' => function($data) {
                    return Html::a($data->title, ['view', 'id' => $data->id]);
                },
            ],
            [
                'attribute' => 'slug',
                'visible' => $module->showSlug,
            ],
            [
                'attribute' => 'excerpt',
                'visible' => $module->showExcerpt,
            ],
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => false,
                    'update' => true,
                    'delete' => true,
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
