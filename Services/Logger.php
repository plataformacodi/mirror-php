<?php
// Logger.php

class Logger
{
    private string $logDir = 'Logs';
    private array $logs = [];

    public function __construct(private array $config)
    {
    }

    public function log(string $message): void
    {
        $timestamp = date('Y-m-d H:i:s ');
        $logEntry  = $timestamp . $message;
        $this->logs[] = $logEntry;

        if ($this->config['testing']) {
            echo $logEntry . PHP_EOL;
        }
    }
    public function logError(Exception $e): void
    {
        $this->log('Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
    }

    public function writeLogs(): string
    {
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }

        $logFilePath = $this->logDir . DIRECTORY_SEPARATOR . date('YmdHis') . '.log';
        file_put_contents($logFilePath, implode(PHP_EOL, $this->logs));

        return $logFilePath;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}
