<?php

namespace app\controllers;

use app\helpers\FileBuffer;
use app\helpers\FilePathHelper;
use app\models\FillSertificatsForm;
use app\models\PdfUploadForm;
use app\modules\SertificateFill\SertificatesFiller;
use app\modules\Zip\Zip;

class PdfController extends \yii\web\Controller
{
    public function actionFillSertificats() // TODO to index controller
    {
        $fillSertificatsForm = new FillSertificatsForm();
        $excelFiles = $this->getKeyValExcelNames();
        $pdfFiles = $this->getKeyValPdfNames();

        if (!\Yii::$app->request->isPost) {
            return $this->render('fill-sertificats', compact('fillSertificatsForm', 'excelFiles', 'pdfFiles'));
        }

        if ($fillSertificatsForm->load(\Yii::$app->request->post())) {
            $sertificateFiller = new SertificatesFiller(
                $fillSertificatsForm->getExcelFullPath(),
                $fillSertificatsForm->getPdfFullPath()
            );
            $sertificateFiller->fillSertificates();

            $archiveName = $this->getZipPath('Sertificates');
            $this->createSertificatesZip($archiveName);

            FileBuffer::clear();

            $this->uploadZip($archiveName);
        }

        return $this->render('fill-sertificats', compact('fillSertificatsForm', 'excelFiles', 'pdfFiles'));
    }

    public function actionUpload()
    {
        $pdfUploadForm = new PdfUploadForm();

        if (\Yii::$app->request->isPost) {
            $pdfUploadForm->setPdfFile();
            if ($pdfUploadForm->upload()) {
                \Yii::$app->session->setFlash('success', 'Excel file successfully uploaded');
            }
        }

        return $this->render('upload', compact('pdfUploadForm'));
    }

    /**
     * @param string $archiveName
     */
    private function createSertificatesZip($archiveName)
    {
        $path = FilePathHelper::getBufferPath();
        $zip = new Zip($path);
        $zip->createArchive($archiveName);
    }

    /**
     * @param string $archiveName
     */
    private function uploadZip($archiveName)
    {
        $fileName = pathinfo($archiveName, PATHINFO_FILENAME);

        header('Content-Type:  multipart/form-data;');
        header("Content-Disposition: attachment; filename=\"{$fileName}.zip\"");
        echo file_get_contents($archiveName);
    }

    /**
     * @return array<string,string>
     */
    private function getKeyValExcelNames()
    {
        $excelFiles = FilePathHelper::getStorageExcelFileNames();
        return $this->getKeyValFileNames($excelFiles);
    }

    /**
     * @return array<string,string>
     */
    private function getKeyValPdfNames()
    {
        $pdfFiles = FilePathHelper::getStoragePdfFileNames();
        return $this->getKeyValFileNames($pdfFiles);
    }

    /**
     * @param string[]
     * 
     * @return array<string,string>
     */
    private function getKeyValFileNames($fileNames)
    {
        $res = [];
        foreach ($fileNames as $fileName) {
            $res[$fileName] = $fileName;
        }
        return $res;
    }

    /**
     * @param string $archiveName
     * 
     * @return string
     */
    private function getZipPath($archiveName)
    {
        return FilePathHelper::getStoragePath() . "{$archiveName}.zip";
    }
}
