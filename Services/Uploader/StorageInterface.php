<?php
// StorageInterface.php

interface StorageInterface
{
    public function uploadFile(string $filePath, string $destinationPath): void;
    public function uploadString(string $content, string $destinationPath): void;
}
