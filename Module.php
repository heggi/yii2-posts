<?php

namespace heggi\yii2posts;

class Module extends \yii\base\Module {
    
    public $nameSingle = 'Запись';
    public $nameMultiple = 'Записи';
    public $nameNew = 'Новая запись';

    public $showSlug = true;
    public $showExcerpt = true;

    public $ckeditor = false;
    public $elfinder = false;

    public $rules;
    public $files;

    public $views;
}
