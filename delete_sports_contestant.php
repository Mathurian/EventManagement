<?php
include 'config.php';

if (isset($_GET['id'])) {
    $deleteId = $_GET['id'];

    // Perform the deletion
    $deleteStmt = $pdo->prepare("DELETE FROM sports_contestant WHERE id = ?");
    $deleteStmt->execute([$deleteId]);

    echo "Deleted successfully";
}
?>
