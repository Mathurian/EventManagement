<?php
// Use central DB config; optionally override DB_NAME for the comment DB via env
require_once __DIR__ . '/../config.php';

// If a separate comment database is required, reinitialize a scoped PDO using env vars
$commentDb = getenv('COMMENT_DB_NAME');
if ($commentDb && isset($pdo)) {
	$host = getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost';
	$user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
	$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
	$charset = getenv('DB_CHARSET') !== false ? getenv('DB_CHARSET') : 'utf8mb4';
	$dsn = "mysql:host={$host};dbname={$commentDb};charset={$charset}";
	$conn = new PDO($dsn, $user, $pass, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
} else {
	// default: share main connection
	$conn = $pdo;
}
?>