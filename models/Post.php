<?php

namespace heggi\yii2posts\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Post extends ActiveRecord {

    public $file = [];
    public $deleteFile = [];
    public $files = [];
    public $deleteFiles = [];

    public static function tableName() {
        return '{{%post}}';
    }

    public function rules() {
        $module = Yii::$app->controller->module;
        $rules = [
            [['module'], 'required'],
            [['content'], 'string'],
            [['module', 'slug'], 'string', 'max' => 100],
            [['title', 'excerpt'], 'string', 'max' => 255],
            [['slug'], 'unique', 'targetAttribute' => ['module', 'slug']],
            [['file'], 'each', 'rule' => ['file']],
            [['deleteFile'], 'each', 'rule' => ['integer']],
            [['files'], 'each', 'rule' => ['file', 'maxFiles' => 20]],
            [['deleteFiles'], 'each', 'rule' => ['each', 'rule' => ['integer']]], //deleteFiles['key']['id']
        ];
        if(is_array($module->rules)) {
            return ArrayHelper::merge($rules, $module->rules);
        }

        return $rules;
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'title' => 'Заголовок',
            'slug' => 'Ссылка',
            'excerpt' => 'Отрывок',
            'content' => 'Содержание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
            \heggi\yii2files\behaviors\FilesBehave::className(),
        ];
    }

    public function uploadFiles() {
        $module = Yii::$app->controller->module;
        if(is_array($module->files)) {
            foreach($module->files as $key => $file) {
                if(ArrayHelper::getValue($file, 'multiple', false)) {

                    $dfls = ArrayHelper::getValue($this->deleteFiles, $key, []);
                    foreach($dfls as $id => $val) {
                        if($val) {
                            $this->removeFile($key, $id);
                        }
                    }
                    $upfs = UploadedFile::getInstances($this, "files[${key}]");
                    $this->setFiles($upfs, $key);
                } else {
                    if(ArrayHelper::getValue($this->deleteFile, $key, 0)) {
                        $this->removeFile($key);
                    }
                    $upf = UploadedFile::getInstance($this, "file[${key}]");
                    if($upf) {
                        $this->removeFile($key);
                        $this->setFile($upf, $key);
                    }
                }
            }
        } 
    }
}
