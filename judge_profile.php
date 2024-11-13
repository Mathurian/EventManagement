<?php 
include('session.php');

if (isset($_POST['judge_code'])) {
    $judge_code = $_POST['judge_code'];

    // Debug: Print the entered judge code
    echo "Entered Code: " . $judge_code . "<br>";

    // Use a prepared statement to fetch the judge
    $stmt = $conn->prepare("SELECT * FROM judges WHERE code = ?");
    $stmt->execute([$judge_code]);
    $row = $stmt->fetch();
    $num_row = $stmt->rowCount();

    // Debug: Print the judge details fetched from the database
	if( $num_row > 0 ) { 
		$judge_ctr = $row['judge_ctr'];

		$subevent_id = $row['subevent_id'];
		?>
		<script>
    window.location.href = "judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>";
</script>

		<?php
	} else {
		?>
		<script>
			alert('wrong code');
			window.location = 'judgelogin.php';
		</script>
		<?php
	}
}

	
	
	
	
	
