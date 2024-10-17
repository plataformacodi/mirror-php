<?php
// GCSStorage.php

use Google\Cloud\Storage\StorageClient;

class GCSStorage implements StorageInterface
{
    private StorageClient $gcsClient;
    private $bucket;
    private Logger $logger;

    public function __construct(string $credentialsFile, string $bucketName, Logger $logger)
    {
        $this->gcsClient = new StorageClient([
            'keyFilePath' => $credentialsFile,
        ]);

        $this->bucket = $this->gcsClient->bucket($bucketName);
        $this->logger = $logger;
    }

    public function uploadFile(string $filePath, string $destinationPath): void
    {
        $this->bucket->upload(
            fopen($filePath, 'r'),
            ['name' => $destinationPath]
        );
    }

    public function uploadString(string $content, string $destinationPath): void
    {
        $this->bucket->upload(
            $content,
            ['name' => $destinationPath]
        );
    }
}
