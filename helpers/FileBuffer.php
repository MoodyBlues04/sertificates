<?php

namespace app\helpers;

class FileBuffer
{
    public static function clear()
    {
        $filesToDelete = FilePathHelper::getBufferFiles();
        foreach ($filesToDelete as $file) {
            unlink(FilePathHelper::getBufferPath() . $file);
        }
    }
}
