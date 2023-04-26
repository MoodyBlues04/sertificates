<?php

namespace app\modules\SertificateFill;

use app\helpers\ExcelHelper;
use app\helpers\FilePathHelper;
use setasign\Fpdi\Fpdi;

class SertificatesFiller
{
    /** @var string */
    private $excelFileName;

    /** @var string */
    private $pdfTemplateFileName;

    /**
     * @param string $excelFileName
     * @param string $pdfTemplateFileName
     */
    public function __construct($excelFileName, $pdfTemplateFileName)
    {
        $this->excelFileName = $excelFileName;
        $this->pdfTemplateFileName = $pdfTemplateFileName;
    }

    /**
     * Fills sertificates data by template and excel
     * Loads them to /storage/buffer
     * 
     * @return void
     */
    public function fillSertificates()
    {
        $rows = ExcelHelper::getExcelDataWithoutHeaders($this->excelFileName);
        foreach ($rows as $idx => $row) {
            $excelRow = new SertificateFillExcelRow($row);

            $pdf = $this->getPdfTemplate();
            $this->setRecipientName($pdf, $excelRow->getFullName());
            $this->setSertificateNumber($pdf, $idx + 1);
            $this->loadToBuffer($pdf, $idx + 1);
        }
    }

    /**
     * @return Fpdi
     */
    private function getPdfTemplate()
    {
        $pdf = new Fpdi();

        $pdf->setSourceFile($this->pdfTemplateFileName);

        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        $pdf->useTemplate($tpl);

        $pdf->AddFont('DejaVu', '', 'DejaVuSerif-Italic.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);

        $pdf->SetFontSize('30');
        $pdf->SetTextColor(27, 59, 110);

        return $pdf;
    }

    /**
     * @param Fpdi $pdf
     * @param string $recipientName
     */
    private function setRecipientName(Fpdi $pdf, $recipientName)
    {
        $pdf->SetXY(20, 158);
        $pdf->Cell(0, 10, $recipientName, 0, 0, 'C');
    }

    /**
     * @param Fpdi $pdf
     * @param int $sertificateNumber
     */
    private function setSertificateNumber(Fpdi $pdf, $sertificateNumber)
    {
        $pdf->SetXY(40 + $this->getSertificateNumberIndention($sertificateNumber), 123);
        $pdf->Cell(0, 10, (string)$sertificateNumber, 0, 0, 'C');
    }

    /**
     * @param $sertificateNumber
     * 
     * @return int
     */
    private function getSertificateNumberIndention($sertificateNumber)
    {
        // return strlen((string)$sertificateNumber);
        if (100 <= $sertificateNumber) {
            return 17;
        }
        if (10 < $sertificateNumber && $sertificateNumber < 100) {
            return 10;
        }
        return 0;
    }

    /**
     * @param Fpdi $pdf
     * @param int $sertificateNumber
     */
    private function loadToBuffer(Fpdi $pdf, $sertificateNumber)
    {
        $pdf->Output('F', $this->getSertificateName($sertificateNumber));
    }

    /**
     * @param int $sertificateNumber
     * 
     * @return string
     */
    private function getSertificateName($sertificateNumber)
    {
        return FilePathHelper::getBufferPath() . "{$this->getTemplateFileName()}_{$sertificateNumber}.pdf";
    }

    /**
     * @return string
     */
    private function getTemplateFileName()
    {
        return pathinfo($this->pdfTemplateFileName, PATHINFO_FILENAME);
    }
}
