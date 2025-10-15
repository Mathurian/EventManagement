<?php 
require_once __DIR__ . '/bootstrap.php';
// Centralized PDO connection using environment variables for modern PHP compatibility
// Expected environment variables (with sensible local defaults):
// DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET

$dbHost = getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost';
$dbName = getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'swuetsdb3';
$dbUser = getenv('DB_USER') !== false ? getenv('DB_USER') : 'tabulation_user';
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'dittibop';
$dbCharset = getenv('DB_CHARSET') !== false ? getenv('DB_CHARSET') : 'utf8mb4';

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";

$pdoOptions = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $dbUser, $dbPass, $pdoOptions);
?>