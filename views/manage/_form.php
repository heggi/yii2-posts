<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use heggi\slugwidget\SlugWidget;
use heggi\yii2files\widgets\SingleFileWidget;
use heggi\yii2files\widgets\MultipleFilesWidget;

$module = Yii::$app->controller->module;
?>

<div class="row" style="padding-bottom: 50px;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-xs-9">

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?php if($module->showSlug) : ?>
                <?= $form->field($model, 'slug')->widget(SlugWidget::className(), ['title' => 'title']) ?>
            <?php endif; ?>

            <?php if($module->showExcerpt) : ?>
                <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>
            <?php endif; ?>

            <?php if($module->ckeditor === false) : ?>
                <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
            <?php else : ?>
                <?= $form->field($model, 'content')->widget(CKEditor::className(), ArrayHelper::merge([
                    'options' => ['rows' => 6],
                    'clientOptions' => $module->elfinder ? ElFinder::ckeditorOptions('elfinder', is_array($module->elfinder)?$module->elfinder:[]) : [],
                ], $module->ckeditor))->label(false) ?>
            <?php endif ?>

            <?php if(is_array($module->files)) : foreach($module->files as $key => $file): ?>
                <?php if(ArrayHelper::getValue($file, 'position', 'sidebar') !== 'main') continue ?>

                <?php if(ArrayHelper::getValue($file, 'multiple', false)) : ?>
                    <?= $form->field($model, "files[${key}]")->widget(MultipleFilesWidget::className(), [
                        'delete' => "deleteFiles[${key}]",
                        'key' => $key,
                        'options' => ArrayHelper::getValue($file, 'options', []),
                    ])->label($file['label']) ?>
                <?php else : ?>
                    <?= $form->field($model, "file[${key}]")->widget(SingleFileWidget::className(), [
                        'delete' => "deleteFile[${key}]",
                        'key' => $key,
                        'options' => ArrayHelper::getValue($file, 'options', []),
                    ])->label($file['label']) ?>
                <?php endif ?>
            <?php endforeach; endif ?>

        </div>
        <div class="col-xs-3">

            <?php if(is_array($module->files)) : foreach($module->files as $key => $file): ?>
                <?php if(ArrayHelper::getValue($file, 'position', 'sidebar') !== 'sidebar') continue ?>

                <?php if(ArrayHelper::getValue($file, 'multiple', false)) : ?>
                    <?= $form->field($model, "files[${key}]")->widget(MultipleFilesWidget::className(), [
                        'delete' => "deleteFiles[${key}]",
                        'key' => $key,
                        'options' => ArrayHelper::getValue($file, 'options', []),
                    ])->label($file['label']) ?>
                <?php else : ?>
                    <?= $form->field($model, "file[${key}]")->widget(SingleFileWidget::className(), [
                        'delete' => "deleteFile[${key}]",
                        'key' => $key,
                        'options' => ArrayHelper::getValue($file, 'options', []),
                    ])->label($file['label']) ?>
                <?php endif ?>
            <?php endforeach; endif ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>