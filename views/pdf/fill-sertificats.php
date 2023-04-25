<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

/** @var \app\models\FillSertificatsForm $fillSertificatsForm */
/** @var string[] $excelFiles */
/** @var string[] $pdfFiles */
?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($fillSertificatsForm, 'excelFileName')->dropDownList($excelFiles) ?>
<?= $form->field($fillSertificatsForm, 'pdfTemplateFileName')->dropDownList($pdfFiles) ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>