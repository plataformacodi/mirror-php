<?php
// Main.php

require 'vendor/autoload.php';

$config = require 'config.php';
$logger = new Logger($config);

try {
    $workingDirectory = new WorkingDirectory($config, $logger);
    $workingDirectory->prepare();

    $step1 = new ConvertSqlToCsv($config, $logger, $workingDirectory, $workingDirectory->getSqlDir(), 'sql');
    $step1->run();

    $step2 = new ConvertCsvToZip($config, $logger, $workingDirectory, $workingDirectory->getCsvDir(), 'csv');
    $step2->run();

    $step3 = new EncryptZipFiles($config, $logger, $workingDirectory, $workingDirectory->getZipDir(), 'zip');
    $step3->run();

    if ($config['testing']) {
        $logger->log('Testing mode is enabled: no files were uploaded to cloud storage.');
    } else {
        $step4 = new UploadEncryptedFiles($config, $logger, $workingDirectory, $workingDirectory->getEncryptedDir(), 'crypt');
        $step4->run();
    }

    $logger->log('Process finished.');
} catch (Exception $e) {
    $logger->logError($e);
} finally {
    $logFilePath = $logger->writeLogs();
    if (!$config['testing']) {
        $uploader = new Uploader($config, $logger);
        $uploader->uploadFile($logFilePath, 'logs/'.basename($logFilePath));
    }
}
