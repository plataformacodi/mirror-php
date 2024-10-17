<?php
class CSVExporter
{
    public function export(PDOStatement $stmt, string $csvFilePath): int
    {
        $rowCount = 0;
        $file = fopen($csvFilePath, 'w');

        $columns = $this->getColumnNames($stmt);
        $this->writeHeaderLine($file, $columns);

        // Reset the statement to fetch data again
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->writeDataRow($file, $row);
            $rowCount++;
        }

        fclose($file);
        return $rowCount;
    }

    private function getColumnNames(PDOStatement $stmt): array
    {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_keys($row);
    }

    private function writeHeaderLine($file, array $columns)
    {
        $headerLine = [];
        foreach ($columns as $column) {
            $headerLine[] = $this->escapeValue($column);
        }
        fwrite($file, implode(',', $headerLine) . "\n");
    }

    private function writeDataRow($file, array $row)
    {
        $fields = [];
        foreach ($row as $value) {
            if (is_numeric($value)) {
                $fields[] = $value;
            } else {
                $fields[] = $this->escapeValue($value);
            }
        }
        fwrite($file, implode(',', $fields) . "\n");
    }

    private function escapeValue($value): string
    {
        $escapedValue = str_replace('"', '""', $value);
        return '"' . $escapedValue . '"';
    }
}
?>
