<?php
// EncryptZipFiles.php

class EncryptZipFiles extends Controller
{
    protected function init(): void
    {
        $this->encryptor = new Encryptor();
    }

    protected function processFile(SplFileInfo $file): bool
    {
        $zipFilePath = $this->getFilePath($file);
        $this->logger->log(" - Encrypting file: $zipFilePath");

        $encryptedDir = $this->workingDirectory->getEncryptedDir() . DIRECTORY_SEPARATOR . $this->getFileContext($file);
        $this->workingDirectory->createDirectoryContext($encryptedDir);
        $encryptedFilePath = $encryptedDir . DIRECTORY_SEPARATOR . $this->getFileName($file) . '.crypt';
        $this->encryptor->encryptFile($zipFilePath, $encryptedFilePath, $this->config['aes']['password']);
        $this->logger->log(" - - Encrypted to: $encryptedFilePath");

        return true;
    }
}
