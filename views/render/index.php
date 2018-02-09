<?php

use yii\helpers\Html;

$module = Yii::$app->controller->module;
$this->title = $module->nameMultiple;
$this->params['breadcrumbs'][] = $this->title;

$models = $dataProvider->getModels();
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="page-index">

<?php foreach($models as $model) : ?>

<div class="post">
    <h2><?= Html::encode($model->title) ?></h2>
    <p><?= Html::encode($model->excerpt) ?></p>
    <p><?= Html::a('Дальше...', ['render/single-id', 'id' => $model->id]) ?></p>
</div>

<?php endforeach ?>

</div>