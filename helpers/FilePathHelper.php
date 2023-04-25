<?php

namespace app\helpers;

class FilePathHelper // TODO rename
{
    /**
     * @return string[]
     */
    public static function getStorageExcelFileNames()
    {
        $fileNames = self::getStorageFiles();
        $excelFiles = [];

        foreach ($fileNames as $fileName) {
            if (self::isExcelFile($fileName)) {
                $excelFiles[] = $fileName;
            }
        }

        return $excelFiles;
    }

    /**
     * @return string[]
     */
    public static function getStoragePdfFileNames()
    {
        $fileNames = self::getStorageFiles();
        $pdfFiles = [];

        foreach ($fileNames as $fileName) {
            if (self::isPdfFile($fileName)) {
                $pdfFiles[] = $fileName;
            }
        }

        return $pdfFiles;
    }

    /**
     * @return string[]
     */
    public static function getStorageFiles()
    {
        $rawFileNames = scandir(self::getStoragePath());
        $onlyFiles = array_filter($rawFileNames, function ($el) {
            return strpos($el, '.') !== false;
        });

        return array_diff($onlyFiles, array('.', '..'));
    }

    /**
     * @return string[]
     */
    public static function getBufferFiles()
    {
        $rawFileNames = scandir(self::getBufferPath());
        $onlyFiles = array_filter($rawFileNames, function ($el) {
            return strpos($el, '.') !== false;
        });

        return array_diff($onlyFiles, array('.', '..'));
    }

    /**
     * @return string
     */
    public static function getStoragePath()
    {
        return \Yii::getAlias('@webroot') . '/../storage/';
    }

    /**
     * @return string
     */
    public static function getBufferPath()
    {
        return \Yii::getAlias('@webroot') . '/../storage/buffer/';
    }

    /**
     * @param string $path
     * 
     * @return bool
     */
    private static function isExcelFile($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return in_array($extension, ['xls', 'xlsx']);
    }

    /**
     * @param string $path
     * 
     * @return bool
     */
    private static function isPdfFile($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return $extension === 'pdf';
    }
}
