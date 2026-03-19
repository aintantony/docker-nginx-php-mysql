<?php
function getDbConnection(): PDO
{
    $host   = getenv('DB_HOST')     ?: 'mysql';
    $port   = getenv('DB_PORT')     ?: '3306';
    $dbname = getenv('DB_DATABASE') ?: 'appdb';
    $user   = getenv('DB_USERNAME') ?: 'appuser';
    $pass   = getenv('DB_PASSWORD') ?: '';

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}
