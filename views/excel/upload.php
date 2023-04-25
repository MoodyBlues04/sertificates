<?php

use yii\widgets\ActiveForm;

/** @var \app\models\ExcelUploadForm $excelUploadForm */
?>

<p> Выберите таблицу данных </p>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($excelUploadForm, 'excelFile')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>