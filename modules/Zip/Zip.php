<?php

namespace app\modules\Zip;

use app\helpers\FilePathHelper;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use ZipArchive;

class Zip
{
    /** @var string */
    private $folderPath;

    /**
     * @param string $folderPath
     */
    public function __construct($folderPath)
    {
        $this->folderPath = $folderPath;
    }

    /**
     * @param string $archiveName
     * 
     * @return void
     */
    public function createArchive($archiveName)
    {
        $zip = new ZipArchive();
        $zip->open($archiveName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $filePath = $file->getRealPath();
            $zip->addFile($filePath, pathinfo($filePath, PATHINFO_BASENAME));
        }

        $zip->close();
    }
}
