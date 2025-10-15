<?php
session_start();
if (file_exists(__DIR__ . '/csrf.php')) {
	include_once __DIR__ . '/csrf.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_validate()) {
		echo "<script>alert('Invalid session token.'); window.location = 'sports_management.php';</script>";
		exit;
	}
}
include 'config.php';


if (isset($_POST['create'])) {
    $sportEventName = $_POST['sport_event_name'];
    $fromYear = $_POST['from_year'];
    $toYear = $_POST['to_year'];
    $dateStart = $_POST['date_start'];
    $dateEnd = $_POST['date_end'];
    $venue = $_POST['venue'];

    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM sports_event WHERE sport_event_name = :sportEventName");
    $checkStmt->bindParam(':sportEventName', $sportEventName);
    $checkStmt->execute();
    $eventCount = $checkStmt->fetchColumn();

    if ($eventCount > 0) {
        echo "<script>
                alert('Sport event with the name \"$sportEventName\" already exists!');
                window.location.href = 'sports_management.php';
              </script>";
    } else {
        $insertStmt = $pdo->prepare("INSERT INTO sports_event (sport_event_name, from_year, to_year, date_start, date_end, venue) VALUES (:sportEventName, :fromYear, :toYear, :dateStart, :dateEnd, :venue)");
        $insertStmt->bindParam(':sportEventName', $sportEventName);
        $insertStmt->bindParam(':fromYear', $fromYear);
        $insertStmt->bindParam(':toYear', $toYear);
        $insertStmt->bindParam(':dateStart', $dateStart);
        $insertStmt->bindParam(':dateEnd', $dateEnd);
        $insertStmt->bindParam(':venue', $venue);

        $insertStmt->execute();
        echo "<script>
                alert('Sport event \"$sportEventName\" created successfully!');
                window.location.href = 'sports_management.php';
              </script>";
    }
}


if (isset($_POST['add_contestant'])) {
    $contestants = $_POST['contestant']; // This is now an array of contestants
    $event_id = $_POST['id'];
    
    foreach ($contestants as $contestant) {
        // Check if the contestant already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM sports_contestant WHERE contestant = :contestant AND event_id = :id");
        $checkStmt->bindParam(':contestant', $contestant);
        $checkStmt->bindParam(':id', $event_id);
        $checkStmt->execute();
        $eventCount = $checkStmt->fetchColumn();

        if ($eventCount == 0) {
            // Insert the new contestant
            $insertStmt = $pdo->prepare("INSERT INTO sports_contestant (event_id, contestant) VALUES (:id, :contestant)");
            $insertStmt->bindParam(':contestant', $contestant);
            $insertStmt->bindParam(':id', $event_id);
            $insertStmt->execute();
        }
    }

    echo "<script>
            alert('Contestants processed successfully!');
            window.location.href = 'sports_management.php';
          </script>";
}


if (isset($_POST['add_sport'])) {
    $sportsNames = $_POST['name']; // This is now an array of sports names
    $event_id = $_POST['id'];

    foreach ($sportsNames as $name) {
        // Check if the sport name already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM sports_name WHERE name = :name AND event_id = :id");
        $checkStmt->bindParam(':name', $name);
        $checkStmt->bindParam(':id', $event_id);
        $checkStmt->execute();
        $eventCount = $checkStmt->fetchColumn();

        if ($eventCount == 0) {
            // Insert the new sport name
            $insertStmt = $pdo->prepare("INSERT INTO sports_name (event_id, name) VALUES (:id, :name)");
            $insertStmt->bindParam(':name', $name);
            $insertStmt->bindParam(':id', $event_id);
            $insertStmt->execute();
        }
    }

    echo "<script>
            alert('Sports names processed successfully!');
            window.location.href = 'sports_management.php';
          </script>";
}


if (isset($_POST['save'])) {
    $selectedContestants = $_POST['selectedContestants'] ?? [];
    $event_id = $_POST['id'];
    $stmtDelete = $pdo->prepare('DELETE FROM sports_tagging WHERE event_id = ?');
    $stmtDelete->execute([$event_id]);


    $stmtDelete2 = $pdo->prepare('DELETE FROM sports_tabulation WHERE event_id = ?');
    $stmtDelete2->execute([$event_id]);

    foreach ($selectedContestants as $contestant_id => $sports) {
        foreach ($sports as $sports_name_id => $value) {
            $status = (isset($_POST['selectedContestants'][$contestant_id][$sports_name_id])) ? 1 : 0;
            $stmtInsert = $pdo->prepare('INSERT INTO sports_tagging (event_id, contestant_id, sports_name_id, status) VALUES (?, ?, ?, ?)');
            $stmtInsert->execute([$event_id, $contestant_id, $sports_name_id, $status]);


            $stmtInsert2 = $pdo->prepare('INSERT INTO sports_tabulation (event_id, contestant_id, sports_name_id) VALUES (?, ?, ?)');
            $stmtInsert2->execute([$event_id, $contestant_id, $sports_name_id]);

        }
    }
    echo "<script>
    alert('Sport tagging updated successfuly!');
    window.location.href = 'sports_management.php';
  </script>";

    exit();
}





// function updateTabulation($event_id, $gold_medals, $silver_medals, $bronze_medals, $pdo) {
//     $gold_rank = 1;
//     $silver_rank = 2;
//     $bronze_rank = 3;

//     updateMedalRank($event_id, $gold_medals, $gold_rank, $pdo);
//     updateMedalRank($event_id, $silver_medals, $silver_rank, $pdo);
//     updateMedalRank($event_id, $bronze_medals, $bronze_rank, $pdo);
// }

// function updateMedalRank($event_id, $medals, $rank, $pdo) {
//     foreach ($medals as $contestant_id) {
//         $query = "UPDATE sports_tabulation 
//                   SET rank = :rank 
//                   WHERE event_id = :event_id 
//                   AND contestant_id = :contestant_id";
        
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(':rank', $rank, PDO::PARAM_INT);
//         $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
//         $stmt->bindParam(':contestant_id', $contestant_id, PDO::PARAM_INT);
//         $stmt->execute();

//         // Check the affected rows after the update
//         $affectedRows = $stmt->rowCount();
//     }
// }
// if (isset($_POST['save_tabulation'])) {
//     $event_id = $_POST['event_id'];
//     $gold_medals = $_POST['gold_medal'];
//     $silver_medals = $_POST['silver_medal'];
//     $bronze_medals = $_POST['bronze_medal'];
//     updateTabulation($event_id, $gold_medals, $silver_medals, $bronze_medals, $pdo);

//     echo "<script>
//     alert('Sport tabulation updated successfuly!');
//     window.location.href = 'sports_management.php';
//   </script>";

//     exit();
// }



function updateSportsTabulation($event_id, $sportsNameId, $contestantId, $medalType) {
    include 'config.php';
    $rankMap = [
        'gold' => 1,
        'silver' => 2,
        'bronze' => 3
    ];
    if (!array_key_exists($medalType, $rankMap)) {
        echo "Invalid medal type!";
        return;
    }
    $rank = $rankMap[$medalType];
    $query = "UPDATE sports_tabulation
              SET rank = :rank
              WHERE event_id = :event_id AND sports_name_id = :sports_name_id AND contestant_id = :contestant_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':rank', $rank, PDO::PARAM_INT);
    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->bindParam(':sports_name_id', $sportsNameId, PDO::PARAM_INT);
    $stmt->bindParam(':contestant_id', $contestantId, PDO::PARAM_INT);
    $stmt->execute();
}



if (isset($_POST['save_tabulation'])) {
    $event_id = $_POST['event_id'];
    $goldMedals = $_POST['gold_medal'];
    $silverMedals = $_POST['silver_medal'];
    $bronzeMedals = $_POST['bronze_medal'];
    $sportsNameIds = $_POST['sports_name_id'];
    for ($i = 0; $i < count($goldMedals); $i++) {
        $goldMedal = $goldMedals[$i];
        $silverMedal = $silverMedals[$i];
        $bronzeMedal = $bronzeMedals[$i];
        $sportsNameId = $sportsNameIds[$i];
        updateSportsTabulation($event_id, $sportsNameId, $goldMedal, 'gold');
        updateSportsTabulation($event_id, $sportsNameId, $silverMedal, 'silver');
        updateSportsTabulation($event_id, $sportsNameId, $bronzeMedal, 'bronze');
    }


    
    echo "<script>
    alert('Tabulation data successfully updated!');
    window.location.href = 'sports_management.php';
  </script>";
}



?>

