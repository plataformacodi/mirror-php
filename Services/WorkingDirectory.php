<?php
// WorkingDirectory.php

class WorkingDirectory
{
    private string $workingDirectory = 'Output';
    private array $subDirectories = ['csv', 'zip', 'encrypted']; //if you need to change it, attention to getCsvDir(), getZipDir() and getEncryptedDir()

    public function __construct(private array $config, private Logger $logger)
    {
        $this->workingDirectory = $config['testing'] ? 'OutputTest' : 'Output';
    }

    public function getSqlDir(): string
    {
        return 'InputSQL';
    }
    public function getCsvDir(): string
    {
        return $this->workingDirectory . DIRECTORY_SEPARATOR . $this->subDirectories[0];
    }
    public function getZipDir(): string
    {
        return $this->workingDirectory . DIRECTORY_SEPARATOR . $this->subDirectories[1];
    }
    public function getEncryptedDir(): string
    {
        return $this->workingDirectory . DIRECTORY_SEPARATOR . $this->subDirectories[2];
    }

    public function prepare(): void
    {
        $this->logger->log('Preparing Directories.');
        $this->deleteDirectory($this->workingDirectory);
        $this->createDirectory($this->workingDirectory);
        foreach ($this->subDirectories as $subDirectory){
            $this->createDirectory($this->workingDirectory . DIRECTORY_SEPARATOR . $subDirectory);
        }
    }

    public function createDirectoryContext($path): void
    {
        $directories = explode(DIRECTORY_SEPARATOR, $path);
        if (empty($directories)){
            $this->logger->log(' - Attention: Trying to create an empty path.');
            return;
        }
        if ($directories[0] !== $this->workingDirectory) {
            $this->logger->log(' - Attention: Trying to create a directory out of the working directory.');
            return;
        }
        for ($i = 1; $i <= count($directories); $i++) {
            $contextPath = implode(DIRECTORY_SEPARATOR, array_slice($directories, 0, $i));
            $this->createDirectory($contextPath);
        }
    }

    private function createDirectory(string $dir): bool
    {
        $result = false;
        if (!is_dir($dir)) {
            $result = mkdir($dir, 0777, true);
        }
        return $result;
    }

    private function deleteDirectory(string $dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }
    
        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
    
        return rmdir($dir);
    }

}
