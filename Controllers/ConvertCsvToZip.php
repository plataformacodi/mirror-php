<?php
// ConvertCsvToZip.php

class ConvertCsvToZip extends Controller
{
    protected function init(): void
    {
        $this->compressor = new Compressor();
    }

    protected function processFile(SplFileInfo $file): bool
    {
        $csvFilePath = $this->getFilePath($file);
        $this->logger->log(" - Compressing file: $csvFilePath");

        $zipDir = $this->workingDirectory->getZipDir() . DIRECTORY_SEPARATOR . $this->getFileContext($file);
        $this->workingDirectory->createDirectoryContext($zipDir);
        $zipFilePath = $zipDir . DIRECTORY_SEPARATOR . $this->getFileName($file) . '.zip';
        $this->compressor->compressFile($csvFilePath, $zipFilePath);
        $this->logger->log(" - - Compressed to ZIP: $zipFilePath");

        return true;
    }
}
