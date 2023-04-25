<?php

namespace app\models;

use app\helpers\FilePathHelper;
use yii\base\Model;

class FillSertificatsForm extends Model
{
    /** @var string */
    public $excelFileName;

    /** @var string */
    public $pdfTemplateFileName;

    public function rules()
    {
        return [
            [['excelFileName', 'pdfTemplateFileName'], 'string'],
            [['excelFileName', 'pdfTemplateFileName'], 'required'],
        ];
    }

    /**
     * @return string
     */
    public function getExcelFullPath()
    {
        return FilePathHelper::getStoragePath() . $this->excelFileName;
    }

    /**
     * @return string
     */
    public function getPdfFullPath()
    {
        return FilePathHelper::getStoragePath() . $this->pdfTemplateFileName;
    }
}
