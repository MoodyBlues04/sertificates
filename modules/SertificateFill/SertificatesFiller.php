<?php

namespace app\modules\SertificateFill;

use app\helpers\ExcelHelper;
use app\helpers\FilePathHelper;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfReader\PdfReaderException;

class SertificatesFiller
{
    const OUTPUT_BROWSER = 'I';
    const OUTPUT_FILE = 'F';
    const NORMAL_ORIENTATION = '';
    const HORIZONTAL_ORIENTATION = 'L';

    /** @var string */
    private $excelFileName;

    /** @var string */
    private $pdfTemplateFileName;

    private $fontSize = 22;
    private $recipientNameXY = [13, 135];
    private $numberXY = [20, 102];
    private $outputType = self::OUTPUT_FILE;
    private $orientation = self::NORMAL_ORIENTATION;

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
     * @param int $fontSize
     * @return self
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
        return $this;
    }

    /**
     * @param int $x
     * @param int $y
     * @return self
     */
    public function setRecipientNameXY($x, $y)
    {
        $this->recipientNameXY = [$x, $y];
        return $this;
    }

    /**
     * @param int $x
     * @param int $y
     * @return self
     */
    public function setNumberXY($x, $y)
    {
        $this->numberXY = [$x, $y];
        return $this;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setOutputType($type)
    {
        $this->outputType = $type;
        return $this;
    }

    /**
     * @param string $orientation
     * @return self
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
        return $this;
    }

    /**
     * Fills sertificates data by template and excel
     * Loads them to /storage/buffer
     * 
     * @return void
     */
    public function fillSertificates()
    {
//        todo split into facade (fillTemplate) and builder (with all settings & PDF build)

        ini_set('memory_limit', -1);

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
     * @throws PdfParserException
     * @throws PdfReaderException
     */
    private function getPdfTemplate()
    {
        $pdf = new Fpdi();

        $pdf->setSourceFile($this->pdfTemplateFileName);

        // Import the first page from the PDF and add to dynamic PDF
        $tpl = $pdf->importPage(1);
        $pdf->AddPage($this->orientation);

        $pdf->useTemplate($tpl);

        $pdf->AddFont('DejaVu', '', 'DejaVuSerif-Italic.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);

        $pdf->SetFontSize((string) $this->fontSize);
        $pdf->SetTextColor(27, 59, 110);

        return $pdf;
    }

    /**
     * @param Fpdi $pdf
     * @param string $recipientName
     */
    private function setRecipientName(Fpdi $pdf, $recipientName)
    {
        $pdf->SetXY($this->recipientNameXY[0], $this->recipientNameXY[1]);
        $pdf->Cell(0, 10, $recipientName, 0, 0, 'C');
    }

    /**
     * @param Fpdi $pdf
     * @param int $sertificateNumber
     */
    private function setSertificateNumber(Fpdi $pdf, $sertificateNumber)
    {
        $pdf->SetXY($this->numberXY[0] + $this->getSertificateNumberIndention($sertificateNumber), $this->numberXY[1]);
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
            return 12;
        }
        if (10 < $sertificateNumber && $sertificateNumber < 100) {
            return 6;
        }
        return 0;
    }

    /**
     * @param Fpdi $pdf
     * @param int $sertificateNumber
     */
    private function loadToBuffer(Fpdi $pdf, $sertificateNumber)
    {
        $pdf->Output($this->outputType, $this->getSertificateName($sertificateNumber));
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
