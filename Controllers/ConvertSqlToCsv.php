<?php
// ConvertSqlToCsv.php

class ConvertSqlToCsv extends Controller
{
    protected function init(): void
    {
        $this->logger->log('Connecting to database.');
        $this->db = new Database($this->config, $this->logger);
        $this->csvExporter = new CSVExporter();
    }

    protected function processFile(SplFileInfo $file): bool
    {
        $sqlFilePath = $this->getFilePath($file);
        $this->logger->log(" - Processing SQL file: $sqlFilePath");
        $data = $this->db->executeQueryFromFile($sqlFilePath);

        $csvDir = $this->workingDirectory->getCsvDir() . DIRECTORY_SEPARATOR . $this->getFileContext($file);
        $this->workingDirectory->createDirectoryContext($csvDir);
        $csvFilePath = $csvDir . DIRECTORY_SEPARATOR . $this->getFileName($file) . '.csv';
        $rowCount = $this->csvExporter->export($data, $csvFilePath);
        $this->logger->log(" - - Exported $rowCount rows to CSV: $csvFilePath");

        return true;
    }
}
