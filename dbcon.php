<?php
// Bridge file to reuse unified PDO from config.php
require_once __DIR__ . '/config.php';

// Maintain backward compatibility: expose $conn as alias of $pdo
$conn = $pdo;
?>
