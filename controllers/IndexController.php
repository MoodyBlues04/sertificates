<?php

namespace app\controllers;

use app\helpers\FilePathHelper;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $fileNames = FilePathHelper::getStorageFiles();
        return $this->render('index', compact('fileNames'));
    }
}
