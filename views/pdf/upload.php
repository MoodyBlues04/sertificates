<?php

use yii\widgets\ActiveForm;

/** @var \app\models\PdfUploadForm $pdfUploadForm */
?>

<p> Выберите шаблон документа </p>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($pdfUploadForm, 'pdfFile')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>