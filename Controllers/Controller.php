<?php
// Controller.php

class Controller
{
    public function __construct(
        protected array $config,
        protected Logger $logger,
        protected WorkingDirectory $workingDirectory,
        protected string $filesDirectory = '',
        protected string $filesExtension = ''
    ){}


    public function run(): void
    {
        try {
            $this->init();
            $this->processFiles();
        } catch (Exception $e) {
            $this->logger->logError($e);
        } finally {
            $this->finally();
        }
    }

    protected function init(): void
    {
        // Usefull to load the services
    }

    protected function finally(): void
    {
        // Usefull to free the services
    }

    protected function processFiles(): void
    {
        $this->logger->log('Processing all `' . $this->filesExtension . '` files from `' . $this->filesDirectory . '` directory.');
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->filesDirectory));
        $filesCounter = 0;
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $this->filesExtension) {
                try {
                    if($this->processFile($file)){
                        $filesCounter++;
                    }
                } catch (Exception $e) {
                    $this->logger->logError($e);
                }
            }
        }
        if($filesCounter === 0){
            $this->logger->log(' - No files to be processed.');
        } else {
            $this->logger->log(' - Finished: '.$filesCounter.' files processed.');

        }
    }

    protected function processFile(SplFileInfo $file): bool
    {
        throw new Exception(' - Process not implemented yet.');
    }

    //Usefull methods for processFile($file)
    protected function getFilePath(SplFileInfo $file): string
    {
        return $file->getPathname();
    }
    protected function getFileRelativePath(SplFileInfo $file): string
    {
        $filePath = $this->getFilePath($file);
        return substr($filePath, strlen($this->filesDirectory) + 1);
    }
    protected function getFileContext(SplFileInfo $file): string
    {
        $relativePath = $this->getFileRelativePath($file);
        return dirname($relativePath);
    }
    protected function getFileName(SplFileInfo $file): string
    {
        $relativePath = $this->getFileRelativePath($file);
        return basename($relativePath, '.'.$this->filesExtension); 
    }
}
