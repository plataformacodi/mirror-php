<?php
// UploadEncryptedFiles.php

class UploadEncryptedFiles extends Controller
{
    protected function init(): void
    {
        $this->uploader = new Uploader($this->config, $this->logger);
        $this->uploader->lockStorage();
    }

    protected function processFile(SplFileInfo $file): bool
    {
        $encryptedFilePath = $this->getFilePath($file);
        $this->logger->log(" - Uploading file: $encryptedFilePath");

        $destinationPath = $this->getFileContext($file) . '/' . $this->getFileName($file) . '.crypt';
        $this->uploader->uploadFile($encryptedFilePath, $destinationPath);

        return true;
    }

    protected function finally(): void
    {
        $this->uploader->unlockStorage();
    }
}
