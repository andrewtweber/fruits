<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$git_config = parse_ini_file(__DIR__ . '/../.git/config');
preg_match('/(.*)@(.*):(.*)\.git/', $git_config['url'], $matches);

header('Content-Type: application/json');

$headers = apache_request_headers();
if (! isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer ' . getenv('API_TOKEN')) {
    echo json_encode(null);
    exit;
}

echo json_encode([
    'git'         => $matches[2],
    'repository'  => $matches[3],
    'software'    => 'Custom',
    'version'     => null,
    'database'    => getenv('DBNAME') ?: null,
    's3'          => getenv('S3_BUCKET') ?: null,
    'environment' => getenv('APP_ENV') ?: null,
    'debug'       => getenv('APP_DEBUG') ?: null,
]);

