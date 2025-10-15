<?php 
include('session.php');

if (isset($_POST['judge_code'])) {
    if (file_exists(__DIR__ . '/csrf.php')) {
        include_once __DIR__ . '/csrf.php';
        if (!csrf_validate()) {
            header('Location: judgelogin.php');
            exit;
        }
    }
    $judge_code = $_POST['judge_code'];

    // Removed debug echo to avoid information disclosure

    // Use a prepared statement to fetch the judge
    $stmt = $conn->prepare("SELECT * FROM judges WHERE code = ?");
    $stmt->execute([$judge_code]);
    $row = $stmt->fetch();
    $num_row = $stmt->rowCount();

    // Debug: Print the judge details fetched from the database
	if( $num_row > 0 ) { 
		$judge_ctr = $row['judge_ctr'];

		$subevent_id = $row['subevent_id'];
    		header("Location: judge_panel.php?judge_ctr={$judge_ctr}&subevent_id={$subevent_id}");
    		exit;
	} else {
        header('Location: judgelogin.php');
        exit;
	}
}

	
	
	
	
	
