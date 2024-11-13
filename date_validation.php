<?php
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mainEventId = $_POST['main_event_id'];
    $selectedDate = $_POST['selected_date'];

    try {
        // Perform a database query to check if the selected date is within the range
        $query = "SELECT mainevent_id FROM main_event WHERE mainevent_id = ? AND ? BETWEEN date_start AND date_end ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$mainEventId, $selectedDate]);
        
        if ($stmt->rowCount() > 0) {
            // The date is valid
            echo 'valid';
        } else {
            // The date is not valid
            echo 'invalid';
        }
    } catch (PDOException $e) {
        // Log the error or inform the administrator, for now, let's just display an error message
        echo 'error';
    }
}
?>
