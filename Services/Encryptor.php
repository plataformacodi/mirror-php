<?php
// Encryptor.php

class Encryptor
{
    public function encryptFile(string $inputFilePath, string $outputFilePath, string $password): void
    {
        $data = file_get_contents($inputFilePath);

        $method = 'AES-256-CFB';
        $key    = substr(hash('sha256', $password), 0, 32); // Hex string
        $iv     = substr(hash('sha256', $password), 0, 16); // Hex string

        $encryptedData = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
        $base64Data    = base64_encode($encryptedData);

        file_put_contents($outputFilePath, $base64Data);
    }
}
