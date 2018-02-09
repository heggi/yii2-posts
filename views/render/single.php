<?php

use yii\helpers\Html;

$module = Yii::$app->controller->module;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $module->nameMultiple, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="content"><?= $model->content ?></div>

</div>
