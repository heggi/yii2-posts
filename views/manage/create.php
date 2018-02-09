<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model heggi\yii2pages\models\Page */

$module = Yii::$app->controller->module;
$this->title = $module->nameNew;

$this->params['breadcrumbs'][] = ['label' => $module->nameMultiple, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
