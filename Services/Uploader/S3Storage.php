<?php
// S3Storage.php

use Aws\S3\S3Client;

class S3Storage implements StorageInterface
{
    private S3Client $s3Client;
    private string $bucketName;
    private Logger $logger;

    public function __construct(string $region, string $key, string $secret, string $bucketName, Logger $logger)
    {
        $this->s3Client = new S3Client([
            'version'     => 'latest',
            'region'      => $region,
            'credentials' => [
                'key'    => $key,
                'secret' => $secret,
            ],
        ]);

        $this->bucketName = $bucketName;
        $this->logger = $logger;
    }

    public function uploadFile(string $filePath, string $destinationPath): void
    {
        $this->s3Client->putObject([
            'Bucket'     => $this->bucketName,
            'Key'        => $destinationPath,
            'SourceFile' => $filePath,
        ]);

        $this->logger->log("File '$destinationPath' uploaded to Amazon S3.");
    }

    public function uploadString(string $content, string $destinationPath): void
    {
        $this->s3Client->putObject([
            'Bucket' => $this->bucketName,
            'Key'    => $destinationPath,
            'Body'   => $content,
        ]);

        $this->logger->log("String content uploaded to '$destinationPath' on Amazon S3.");
    }
}
