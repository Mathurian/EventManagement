<?php
// Composer autoloader and environment bootstrap
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
}

if (class_exists(\Dotenv\Dotenv::class)) {
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->safeLoad();
}
?>

