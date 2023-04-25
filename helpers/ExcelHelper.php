<?php

namespace app\helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelHelper
{
    /**
     * @param string $fileName
     * 
     * @return array<array>
     */
    public static function getExcelDataWithoutHeaders($fileName)
    {
        $fileType = IOFactory::identify($fileName);
        $reader = IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($fileName);
        $worksheet = $spreadsheet->setActiveSheetIndex(0);

        $highestRow = $worksheet->getHighestRow();
        $highestCol = $worksheet->getHighestColumn();

        $sheetData = $worksheet->rangeToArray("A2:$highestCol$highestRow", null, true, false, false);

        return $sheetData;
    }
}
