<?php

namespace app\models;

use app\helpers\FilePathHelper;
use yii\base\Model;
use yii\web\UploadedFile;

class ExcelUploadForm extends Model
{
    /** @var UploadedFile */
    public $excelFile;

    /**
     * @return void
     */
    public function setExcelFile()
    {
        $this->excelFile = UploadedFile::getInstance($this, 'excelFile');
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }
        return $this->excelFile->saveAs($this->getExcelFileName());
    }

    /**
     * @return string
     */
    public function getExcelFileName()
    {
        return FilePathHelper::getStoragePath() . "{$this->excelFile->baseName}.{$this->excelFile->extension}";
    }
}
