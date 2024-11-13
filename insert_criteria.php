<?php
include('header.php');
include('session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub_event_id = $_POST['sub_event_id'];
    $criteria = $_POST['criteria'];
    $points = $_POST['points'];
    $colors = $_POST['criteria_color'];

    // Initialize total criteria points
    $totalPoints = 0;

    // Insert criteria data into the database and calculate total points
    foreach ($criteria as $index => $description) {
        $point = $points[$index];
        $color = $colors[$index];

        // Perform the database insertion
        $stmt = $conn->prepare("INSERT INTO criteria (sub_event_id, criteria, cr_color_code, percentage, criteria_ctr) VALUES (?, ?, ?, ?, 1)");
        $stmt->execute([$sub_event_id, $description, $color, $point]);

        // Increment total points
        $totalPoints += $point;
    }
    // Return the total points as a response
    echo json_encode(['totalPoints' => $totalPoints]);
} else {
    // Handle invalid requests
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>
