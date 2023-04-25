<?php

namespace app\commands;

use yii\console\Controller;

class TestController extends Controller
{
    public function actionHi()
    {
        file_put_contents('C:\Users\ant\Desktop\\' . (string)time() . '.txt', 'hi');
        exit;
    }
}