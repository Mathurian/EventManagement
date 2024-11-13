<?php
include 'config.php'; // Make sure this is the correct path to your config file

if (isset($_GET['id'])) {
    $deleteId = $_GET['id'];

    // Perform the deletion
    $deleteStmt = $pdo->prepare("DELETE FROM sports_name WHERE id = ?");
    $deleteStmt->execute([$deleteId]);

    echo "Sport deleted successfully";
}
?>
