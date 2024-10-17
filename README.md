# MIRROR-PHP

[English](#english-version) | [Português](#versão-em-português)

---

# English Version

MIRROR-PHP is a PHP 8.2 application designed to execute SQL queries from `.sql` files against a configured database. It exports the results to CSV files, compresses them into ZIP archives, encrypts them using AES-256 encryption, and uploads them to a cloud storage repository (Google Cloud Storage or Amazon S3).

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Directory Structure](#directory-structure)
- [Logging](#logging)
- [Testing Mode](#testing-mode)
- [Notes](#notes)
- [License](#license)

## Features

- Executes SQL queries from `.sql` files.
- Exports query results to CSV files.
- Compresses CSV files into ZIP archives.
- Encrypts ZIP files using AES-256 encryption.
- Uploads encrypted files to Google Cloud Storage or Amazon S3.
- Supports multiple database types: MySQL, PostgreSQL, MSSQL, Oracle.

## Requirements

- **PHP 8.2** or higher.
- **Composer** for dependency management.
- **PHP extensions:** `pdo`, `openssl`, `zip`.
- **Database driver extensions** for your database (e.g., `pdo_mysql` for MySQL).
- **Composer dependencies:**
  - `aws/aws-sdk-php`
  - `google/cloud-storage`

## Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/plataformacodi/mirror-php
   cd mirror-php
   ```

2. **Install Composer Dependencies**

   ```bash
   composer install
   ```

3. **Set Up Configuration**

   - Rename `config.php.example` to `config.php`.
   - Edit `config.php` and update the configuration settings with your database credentials, cloud storage credentials, and other necessary settings.
   - Read more about [Configuration](#configuration).

4. **Prepare SQL Files**

   - Place your `.sql` files in the `sql` directory.
   - You may organize SQL files into subdirectories as needed (e.g., `undergraduate`, `online`).

## Configuration

Edit the `config.php` file to set up your environment:

- **Database Settings**

  ```php
  'source' => 'mysql', // Options: 'mysql', 'postgresql', 'mssql', 'oracle'
  'db' => [
      'host' => 'localhost',
      'name' => 'your_database_name',
      'user' => 'your_username',
      'pass' => 'your_password',
  ],
  ```

- **AES Encryption Settings**

  This is a shared key provided by the developer.

  ```php
  'aes' => [
      'password' => 'your_encryption_password',
  ],
  ```

- **Cloud Storage Settings**

  Credentials will be provided by the developer.

  ```php
  'upload' => [
      'method' => 'gcs', // Options: 'gcs', 's3'
      'gcs' => [
          'credentials_file' => 'gcs_credentials.json',
          'bucket_name'      => 'your_gcs_bucket_name',
      ],
      's3' => [
          'key'         => 'your_s3_key',
          'secret'      => 'your_s3_secret',
          'bucket_name' => 'your_s3_bucket_name',
          'region'      => 'your_s3_region',
      ],
  ],
  ```

- **Testing Mode**

  ```php
  'testing' => false, // Set to true for testing mode
  ```

  Read more about [Testing Mode](#testing-mode).

## Usage

Run the main script to start the process:

```bash
php Main.php
```

The script will:

1. Execute all SQL queries from `.sql` files in the `sql` directory.
2. Export the query results to CSV files in the `csv` directory.
3. Compress the CSV files into ZIP archives in the `zip` directory.
4. Encrypt the ZIP files using AES-256 encryption, saving them in the `encrypted` directory.
5. Upload the encrypted files to the specified cloud storage.

## Directory Structure

- `config.php` - Configuration file.
- `Main.php` - Main script orchestrating the process.
- `Controllers` - Manages each step of the process.
  - `Controller.php` - Base class to be extended.
  - `ConvertSqlToCsv.php` - Handles the execution of SQL files and exports results to CSV.
  - `ConvertCsvToZip.php` - Manages the conversion of CSV files to ZIP.
  - `EncryptZipFiles.php` - Handles the encryption of ZIP files.
  - `UploadEncryptedFiles.php` - Manages the upload process of encrypted files.
- `Services` - Provides integration services.
  - `Logger.php` - Handles logging.
  - `Database.php` - Database connection and query execution.
  - `CSVExporter.php` - Exports data to CSV.
  - `Compressor.php` - Compresses files into ZIP archives.
  - `Encryptor.php` - Encrypts files using AES-256 encryption.
  - `WorkingDirectory.php` - Handles the working directory (`Output` ou `OutputTest`)
  - `Uploader` - Uploads files to cloud storage.
    - `Uploader.php` - Base class.
    - `StorageInterface.php` - Simplifies the storage interface.
    - `GCSStorage.php` - Handles Google Cloud Storage.
    - `S3Storage.php` - Handles AWS S3 Storage.
- `InputSQL` - Directory containing `.sql` files.
- `Output` or `OutputTest` - Directory containing generated files:
  - `csv/` - Generated CSV files.
  - `zip/` - Compressed ZIP archives.
  - `encrypted/` - Encrypted files ready for upload.
- `Logs/` - Log files. Read more about [Logging](#logging).
- `vendor/` - Composer dependencies.

## Logging

Logs are saved in the `logs` directory with filenames based on the timestamp (`YYYYMMDDHHMMSS.log`). The logs include detailed information about the execution process, including any errors encountered.

## Testing Mode

You can enable testing mode in the `config.php` file:

```php
'testing' => true,
```

In testing mode:

- The script will perform all operations except uploading files to cloud storage.
- Useful for verifying that all steps complete successfully before performing an actual upload.

## Notes

- **Composer Autoloading**

  Ensure you have Composer installed and run `composer install` to install the required dependencies.

- **Database Drivers**

  Make sure the necessary PHP extensions for your database are installed (e.g., `pdo_mysql` for MySQL).

- **Cloud Storage Credentials**

  - For **Google Cloud Storage**, provide the service account JSON file (`gcs_credentials.json`).
  - For **Amazon S3**, provide your AWS access key, secret key, and region.

- **Error Handling**

  The script includes try-catch blocks to handle exceptions. Errors are logged, and the script continues execution where possible.

---

**Contact:** For support or inquiries, please contact [andre@plataformacodi.com.br](mailto:andre@plataformacodi.com.br).

---

# Versão em Português

O MIRROR-PHP é uma aplicação em PHP 8.2 projetada para executar consultas SQL a partir de arquivos `.sql` em um banco de dados configurado. Ele exporta os resultados para arquivos CSV, comprime-os em arquivos ZIP, criptografa-os usando criptografia AES-256 e faz upload para um repositório de armazenamento em nuvem (Google Cloud Storage ou Amazon S3).

## Índice

- [Recursos](#recursos)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
- [Estrutura de Diretórios](#estrutura-de-diretórios)
- [Logs](#logs)
- [Modo de Teste](#modo-de-teste)
- [Notas](#notas)
- [Licença](#licença)

## Recursos

- Executa consultas SQL a partir de arquivos `.sql`.
- Exporta os resultados das consultas para arquivos CSV.
- Comprime os arquivos CSV em arquivos ZIP.
- Criptografa os arquivos ZIP usando criptografia AES-256.
- Faz upload dos arquivos criptografados para o Google Cloud Storage ou Amazon S3.
- Suporta múltiplos tipos de banco de dados: MySQL, PostgreSQL, MSSQL, Oracle.

## Requisitos

- **PHP 8.2** ou superior.
- **Composer** para gerenciamento de dependências.
- **Extensões PHP:** `pdo`, `openssl`, `zip`.
- **Extensões de driver de banco de dados** para o seu banco (ex.: `pdo_mysql` para MySQL).
- **Dependências do Composer:**
  - `aws/aws-sdk-php`
  - `google/cloud-storage`

## Instalação

1. **Clone o Repositório**

   ```bash
   git clone https://github.com/plataformacodi/mirror-php
   cd mirror-php
   ```

2. **Instale as Dependências do Composer**

   ```bash
   composer install
   ```

3. **Configure o Ambiente**

   - Renomeie `config.php.example` para `config.php`.
   - Edite `config.php` e atualize as configurações com suas credenciais de banco de dados, credenciais de armazenamento em nuvem e outras configurações necessárias.
   - Leia mais sobre a [Configuração](#configuração).

4. **Prepare os Arquivos SQL**

   - Coloque seus arquivos `.sql` no diretório `sql`.
   - Você pode organizar os arquivos SQL em subdiretórios conforme necessário (ex.: `graduacao`, `ead`).

## Configuração

Edite o arquivo `config.php` para configurar seu ambiente:

- **Configurações do Banco de Dados**

  ```php
  'source' => 'mysql', // Opções: 'mysql', 'postgresql', 'mssql', 'oracle'
  'db' => [
      'host' => 'localhost',
      'name' => 'nome_do_seu_banco_de_dados',
      'user' => 'seu_usuario',
      'pass' => 'sua_senha',
  ],
  ```

- **Configurações de Criptografia AES**

  Esta é uma chave compartilhada fornecida pelo desenvolvedor.

  ```php
  'aes' => [
      'password' => 'sua_senha_de_criptografia',
  ],
  ```

- **Configurações de Armazenamento em Nuvem**

  As credenciais serão fornecidas pelo desenvolvedor.

  ```php
  'upload' => [
      'method' => 'gcs', // Opções: 'gcs', 's3'
      'gcs' => [
          'credentials_file' => 'gcs_credentials.json',
          'bucket_name'      => 'nome_do_seu_bucket_gcs',
      ],
      's3' => [
          'key'         => 'sua_chave_s3',
          'secret'      => 'seu_segredo_s3',
          'bucket_name' => 'nome_do_seu_bucket_s3',
          'region'      => 'sua_regiao_s3',
      ],
  ],
  ```

- **Modo de Teste**

  ```php
  'testing' => false, // Defina como true para o modo de teste
  ```

  Leia mais sobre o [Modo de Teste](#modo-de-teste).

## Uso

Execute o script principal para iniciar o processo:

```bash
php Main.php
```

O script irá:

1. Executar todas as consultas SQL a partir de arquivos `.sql` no diretório `sql`.
2. Exportar os resultados das consultas para arquivos CSV no diretório `csv`.
3. Comprimir os arquivos CSV em arquivos ZIP no diretório `zip`.
4. Criptografar os arquivos ZIP usando AES-256, salvando-os no diretório `encrypted`.
5. Fazer upload dos arquivos criptografados para o armazenamento em nuvem especificado.

## Estrutura de Diretórios

- `config.php` - Arquivo de configuração.
- `Main.php` - Script principal que orquestra o processo.
- `Controllers` - Gerencia cada etapa do processo.
  - `Controller.php` - Classe base a ser estendida.
  - `ConvertSqlToCsv.php` - Lida com a execução dos arquivos SQL e exporta resultados para CSV.
  - `ConvertCsvToZip.php` - Gerencia a conversão de arquivos CSV para ZIP.
  - `EncryptZipFiles.php` - Lida com a criptografia dos arquivos ZIP.
  - `UploadEncryptedFiles.php` - Gerencia o processo de upload dos arquivos criptografados.
- `Services` - Fornece serviços de integração.
  - `Logger.php` - Gerencia logs.
  - `Database.php` - Conexão com o banco de dados e execução de consultas.
  - `CSVExporter.php` - Exporta dados para CSV.
  - `Compressor.php` - Comprime arquivos em arquivos ZIP.
  - `Encryptor.php` - Criptografa arquivos usando AES-256.
  - `WorkingDirectory.php` - Gerencia o diretório de trabalho (`Output` ou `OutputTest`)
  - `Uploader` - Faz upload de arquivos para o armazenamento em nuvem.
    - `Uploader.php` - Classe base.
    - `StorageInterface.php` - Simplifica a interface de armazenamento.
    - `GCSStorage.php` - Lida com o Google Cloud Storage.
    - `S3Storage.php` - Lida com o AWS S3 Storage.
- `InputSQL` - Diretório contendo arquivos `.sql`.
- `Output` ou `OutputTest` - Diretório contendo arquivos gerados:
  - `csv/` - Arquivos CSV gerados.
  - `zip/` - Arquivos ZIP comprimidos.
  - `encrypted/` - Arquivos criptografados prontos para upload.
- `Logs/` - Arquivos de log. Leia mais sobre [Logs](#logs).
- `vendor/` - Dependências do Composer.

## Logs

Os logs são salvos no diretório `logs` com nomes de arquivos baseados no timestamp (`YYYYMMDDHHMMSS.log`). Os logs incluem informações detalhadas sobre o processo de execução, incluindo quaisquer erros encontrados.

## Modo de Teste

Você pode habilitar o modo de teste no arquivo `config.php`:

```php
'testing' => true,
```

No modo de teste:

- O script executará todas as operações, exceto o upload dos arquivos para o armazenamento em nuvem.
- Útil para verificar se todas as etapas são concluídas com sucesso antes de realizar um upload real.

## Notas

- **Autoload do Composer**

  Certifique-se de ter o Composer instalado e execute `composer install` para instalar as dependências necessárias.

- **Drivers de Banco de Dados**

  Certifique-se de que as extensões PHP necessárias para o seu banco de dados estejam instaladas (ex.: `pdo_mysql` para MySQL).

- **Credenciais de Armazenamento em Nuvem**

  - Para **Google Cloud Storage**, forneça o arquivo JSON da conta de serviço (`gcs_credentials.json`).
  - Para **Amazon S3**, forneça sua chave de acesso AWS, chave secreta e região.

- **Tratamento de Erros**

  O script inclui blocos try-catch para lidar com exceções. Os erros são registrados em log, e o script continua a execução sempre que possível.

---

**Contato:** Para suporte ou dúvidas, entre em contato pelo e-mail [andre@plataformacodi.com.br](mailto:andre@plataformacodi.com.br).

---
