Post Editor Extension
============================

Расширение для создания произвольных записей на сайте: новости, посты блога и т.д.

Installation
------------

Добавить в composer.json строки. Иначе будут проблемы с установкой виджета CKEditor правильной версии

```json
"minimum-stability": "dev",
"prefer-stable": true,
```

Далее в примерах конфигурации имя модуля можно использовать любое. news приведено лишь для примера. Так же возможно одновременное использование нескольких модулей под разными названиями

## Backend

Добавить в конфигурацию бекенда:
```php
'modules' => [
    'news' => [
        'class' => 'heggi\yii2posts\Module',
        'controllerNamespace' => 'heggi\yii2posts\controllers\backend',
        //Если нужен CKEditor
        'ckeditor' => [
            'preset' => 'full',
        ],
        //Если нужен ElFinder
        'elfinder' => true,
        //Нужно ли отображать поле slug в админке
        'showSlug' => false,
        //Нужно ли отображать поле Отрывок в админке
        'showExcerpt' => false,
    ],
],
```

Если нужен elfinder, то в конфигурацию нужно добавить
```php
'controllerMap' => [
    'elfinder' => [
        'class' => 'mihaildev\elfinder\PathController',
        'access' => ['@'],
        'root' => [
            'baseUrl' => '',
            'basePath' => '@webroot/..',
            'path' => 'uploads',
            'name' => 'Загрузки'
        ],
    ],
],
```

## Frontend

В конфигурации фронтэнда:
```php
'modules' => [
    'news' => [
        'class' => 'heggi\yii2posts\Module',
        'controllerNamespace' => 'heggi\yii2posts\controllers\frontend',
        //Переопределяем шаблоны для рендеринга фронтэнда
        'views' => [
            //Главная
            'index' => '//news/index',
            //Отображение одной записи
            'single' => '//news/single',
        ]
    ],
],
```

Пример правил для PrettyUrl:
```php
'rules' => [
    //Главная страница со списком
    'news' => 'news/render/index',
    //Если адресация к записи по ID
    'news/<id:\d+> => 'news/render/single-id',
    //Если адресация к записи по SLUG
    'news/<slug:\w+> => 'news/render/single-slug',
],
```

## Common

В общей конфигурации настраиваются общие настройки (Этот участок конфигурации должен быть доступен как в бекенде, так и во фронтэнде)
```php
'modules' => [
    'news' => [
        //Название в единственном числе
        'nameSingle' => 'Новость',
        //Название во множественном числе
        'nameMultiple' => 'Новости',
        //Для кнопки Новая Запись
        'nameNew' => 'Новая новость',
        //Если нужна возможность прикрепления файлов и изображений к новости посредством модуля heggi/yii2-files
        'files' => [
            //Ключ - название элемента
            'preview' => [
                //Метка с названием для админки
                'label' => 'Главное изображение',
                //Множественная загрузка или 1 файл
                'multiple' => false,
                //Опции для элемента fileInput в админке
                'options' => ['accept' => 'image/*'],
                //Позиция в админке
                'position' => 'sidebar' //sidebar or main
            ],
        ],
    ],
]
```
