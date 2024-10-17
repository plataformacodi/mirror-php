<?php
// Compressor.php

class Compressor
{
    public function compressFile(string $sourceFilePath, string $zipFilePath): void
    {
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $zip->addFile($sourceFilePath, basename($sourceFilePath));
            $zip->close();
        } else {
            throw new Exception("Could not create ZIP file: $zipFilePath");
        }
    }
}
