<?php

namespace app\controllers;

use app\models\ExcelUploadForm;

class ExcelController extends \yii\web\Controller
{
    public function actionUpload()
    {
        $excelUploadForm = new ExcelUploadForm();

        if (\Yii::$app->request->isPost) {
            $excelUploadForm->setExcelFile();
            if ($excelUploadForm->upload()) {
                \Yii::$app->session->setFlash('success', 'Excel file successfully uploaded');
            }
        }

        return $this->render('upload', compact('excelUploadForm'));
    }
}
