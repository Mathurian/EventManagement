<?php
		include('dbcon.php');
		session_start();

		// Guard: ensure POST
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				header('Location: index.php');
				exit;
		}

		$username = isset($_POST['username']) ? trim($_POST['username']) : '';
		$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

		// Validate CSRF token if present
		if (file_exists(__DIR__ . '/csrf.php')) {
			include_once __DIR__ . '/csrf.php';
			if (!csrf_validate()) {
				?>	<script>
					alert('Invalid session token. Please try again.');
					window.location = 'index.php';
				</script><?php
				exit;
			}
		}

		// Prepared query, match by username only; verify password via hashing
		$stmt = $conn->prepare("SELECT organizer_id, org_id, username, password, access FROM organizer WHERE username = :username LIMIT 1");
		$stmt->execute([':username' => $username]);
		$row = $stmt->fetch();

		$validPassword = false;
		if ($row) {
			$stored = (string)$row['password'];
			if (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0) {
				$validPassword = password_verify($password, $stored);
			} else {
				// Legacy plaintext fallback for first login; upgrade hash on success
				$validPassword = hash_equals($stored, $password);
				if ($validPassword) {
					$newHash = password_hash($password, PASSWORD_DEFAULT);
					$upd = $conn->prepare("UPDATE organizer SET password = :hash WHERE organizer_id = :id");
					$upd->execute([':hash' => $newHash, ':id' => $row['organizer_id']]);
				}
			}
		}

		if ($row && $validPassword) { 
			// Prevent session fixation
			session_regenerate_id(true);
		 
			if ($row['access'] === "Organizer") {
				$_SESSION['useraccess'] = "Organizer";
				$_SESSION['id'] = $row['organizer_id'];
					header('Location: home.php');
			} else {
				$_SESSION['useraccess'] = "Tabulator";
				$_SESSION['id'] = $row['org_id'];
				$_SESSION['userid'] = $row['organizer_id'];
					header('Location: score_sheets.php');
			}
		} else { 
			header('Location: index.php');
		}
				
	?>
		