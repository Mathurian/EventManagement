<?php
// Minimal CSRF helper for forms
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

function csrf_token(): string {
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

function csrf_field(): string {
	$token = htmlspecialchars(csrf_token(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function csrf_validate(): bool {
	if (!isset($_POST['csrf_token'], $_SESSION['csrf_token'])) {
		return false;
	}
	return hash_equals($_SESSION['csrf_token'], (string)$_POST['csrf_token']);
}
?>

