<?php
// Uploader.php

class Uploader
{
    private StorageInterface $storage;
    private bool $testing;

    public function __construct(private array $config, private Logger $logger)
    {
        $this->testing = $config['testing'];

        switch ($config['upload']['method']) {
            case 'gcs':
                $credentialsFile = $config['upload']['gcs']['credentials_file'];
                $bucketName = $config['upload']['gcs']['bucket_name'];
                $this->storage = new GCSStorage($credentialsFile, $bucketName, $logger);
                break;
            case 's3':
                $s3Config = $config['upload']['s3'];
                $this->storage = new S3Storage(
                    $s3Config['region'],
                    $s3Config['key'],
                    $s3Config['secret'],
                    $s3Config['bucket_name'],
                    $logger
                );
                break;
            default:
                throw new Exception('Unsupported upload method');
        }
    }

    public function uploadFile(string $filePath, string $destinationPath): void
    {
        if ($this->testing) {
            $this->logger->log("Testing mode enabled. Skipping upload of '$destinationPath'.");
            return;
        }

        $this->storage->uploadFile($filePath, $destinationPath);
    }

    public function lockStorage(): void
    {
        $this->logger->log("Locking storage.");
        $this->storage->uploadString('locked', 'lock');
        $this->logger->log(" - Storage locked.");

    }

    public function unlockStorage(): void
    {
        $this->logger->log("Unlocking storage.");
        $this->storage->uploadString('unlocked', 'lock');
        $this->logger->log(" - Storage unlocked.");
    }
}
