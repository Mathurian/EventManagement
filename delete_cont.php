<?php
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteMultiple'])) {

    $idsToDelete = implode(',', $_POST['selector']); // Combining all selected ids
    
    // Ensure you use prepared statements to protect against SQL injection
    $deleteQuery = $conn->prepare("DELETE FROM contestants WHERE contestant_id IN (" . str_repeat('?,', count($_POST['selector']) - 1) . "?)");
    
    // Execute and check if successful
    if ($deleteQuery->execute($_POST['selector'])) {
        header("Location: sub_event_details_edit.php?message=Deleted successfully");
        exit();
    } else {
        // Handle the error
        echo "Error while deleting records.";
    }
}
?>
