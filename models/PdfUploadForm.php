<?php

namespace app\models;

use app\helpers\FilePathHelper;
use yii\base\Model;
use yii\web\UploadedFile;

class PdfUploadForm extends Model // TODO rules for extensions
{
    /** @var UploadedFile */
    public $pdfFile;

    /**
     * @return void
     */
    public function setPdfFile()
    {
        $this->pdfFile = UploadedFile::getInstance($this, 'pdfFile');
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }
        return $this->pdfFile->saveAs($this->getPdfFileName());
    }

    /**
     * @return string
     */
    public function getPdfFileName()
    {
        return FilePathHelper::getStoragePath() . "{$this->pdfFile->baseName}.{$this->pdfFile->extension}";
    }
}
