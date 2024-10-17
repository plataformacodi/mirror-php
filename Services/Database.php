<?php
// Database.php

class Database
{
    private PDO $connection;

    public function __construct(private array $config, private Logger $logger)
    {
        $this->connect();
    }

    private function connect(): void
    {
        $source   = $this->config['source'];
        $dbConfig = $this->config['db'];

        try {
            switch ($source) {
                case 'mysql':
                    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']};charset=utf8mb4";
                    break;
                case 'postgresql':
                    $dsn = "pgsql:host={$dbConfig['host']};dbname={$dbConfig['name']}";
                    break;
                case 'mssql':
                    $dsn = "sqlsrv:Server={$dbConfig['host']};Database={$dbConfig['name']}";
                    break;
                case 'oracle':
                    $dsn = "oci:dbname=//{$dbConfig['host']}/{$dbConfig['name']};charset=UTF8";
                    break;
                default:
                    throw new Exception('Unsupported database source');
            }

            $this->connection = new PDO($dsn, $dbConfig['user'], $dbConfig['pass']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->logger->log('Database connection established.');
        } catch (PDOException $e) {
            $this->logger->log('Database connection failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function executeQueryFromFile(string $sqlFilePath): PDOStatement
    {
        $query = file_get_contents($sqlFilePath);
        $stmt  = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
