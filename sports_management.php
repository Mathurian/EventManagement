<?php
// Include your database configuration file
include 'config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;
// Function to get the tabulation data from the database
function getTabulationData($event_id, $pdo) {
    $selections = []; // Initialize an empty array to store selections

    // Write a query to get all the saved medal selections for this event
    $sql = "SELECT sports_name_id, contestant_id, rank FROM sports_tabulation WHERE event_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$event_id]);

    // Fetch all the results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Store the results in an associative array
        $selections[$row['sports_name_id']][$row['rank']] = $row['contestant_id'];
    }

    return $selections;
}

if (isset($event_id)) {
  $tabulationData = getTabulationData($event_id, $pdo);
}
?>


<!DOCTYPE html>

<html lang="en">

<?php


include('session.php');


?>




<head>
  <meta charset="utf-8">
  <title>SWU-ETS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">


  <link href="assets/css/bootstrap1.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="assets/css/docs1.css" rel="stylesheet">
  <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link rel="stylesheet" href="yearpicker.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="yearpicker.js"></script>
  

 



</head>

<body>


  <!-- Navbar
    ================================================== -->
  <div class="navbar navbar-inverse navbar-fixed-top" style="z-index: 1060;">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="#">
          <font size="3">SWU-ETS</font>
        </a>

        <div class="nav-collapse collapse">
          <ul class="nav">



            <li>
              <a href="home.php">Event Management</a>
            </li>

            <li class="active">
              <a href="sports_management.php"><strong>Sports Management</strong></a>
            </li>


            <li>
              <a href="score_sheets.php">Reports</a>
            </li>


            <li>
              <a href="rev_main_event.php">Events History</a>
            </li>

            <li>
              <a href="user-guide.php">Help?</a>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">


                <li>
                  <a target="_blank" href="edit_organizer.php">Settings</a>
                </li>

                <li>
                  <a href="logout.php">Logout <?php echo $name; ?></a>
                </li>


              </ul>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>


  <!-- Subhead
================================================== -->
  <header class="jumbotron subhead" id="overview">
    <div class="container">
      <h1>Sports Management</h1>
      <p class="lead">SWU-ETS</p>
    </div>
  </header>


  <div class="container">


    <div class="span12">


      <br />
      <div class="col-md-12">
        <ul class="breadcrumb">



        <li><a href="<?= ($tabname=="") ? "home.php" : "#" ?>">Event Management</a> / </li>
        <li>Sports Management</li>



        </ul>
      </div>




<!-- Button trigger modal -->
<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addSportsEventModal">
  <i class="icon icon-plus"></i> <strong>EVENT</strong>
</button>







<?php 
  include 'config.php';
  $stmt = $pdo->query('SELECT id, sport_event_name FROM sports_event');
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);


  
 
  function getEventData($event_id) {
    global $pdo;

    $stmtContestant = $pdo->prepare('SELECT * FROM sports_contestant WHERE event_id = ?');
    $stmtContestant->execute([$event_id]);
    $contestants = $stmtContestant->fetchAll(PDO::FETCH_ASSOC);

    $stmtSportsName = $pdo->prepare('SELECT * FROM sports_name WHERE event_id = ?');
    $stmtSportsName->execute([$event_id]);
    $sportsNames = $stmtSportsName->fetchAll(PDO::FETCH_ASSOC);

    return ['contestants' => $contestants, 'sportsNames' => $sportsNames];
}
 


  function hasRecords($event_id) {
    global $pdo;

    $stmt = $pdo->prepare('
        SELECT COUNT(*) AS record_count
        FROM sports_name sn
        LEFT JOIN sports_contestant sc ON sn.event_id = sc.event_id
        WHERE sn.event_id = :event_id
    ');

    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['record_count'] > 0;
}

function isContestantTagged($contestantId, $sportsNameId, $eventId) {
  global $pdo;

  $stmt = $pdo->prepare('
      SELECT COUNT(*) AS tag_count
      FROM sports_tagging
      WHERE contestant_id = :contestant_id
      AND sports_name_id = :sports_name_id
      AND event_id = :event_id
  ');

  $stmt->bindParam(':contestant_id', $contestantId, PDO::PARAM_INT);
  $stmt->bindParam(':sports_name_id', $sportsNameId, PDO::PARAM_INT);
  $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
  $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  return $result['tag_count'] > 0;
}

function fetchContestants($event_id, $pdo) {
  $query = "SELECT DISTINCT sports_contestant.id, sports_contestant.contestant, sports_tabulation.event_id
            FROM sports_tabulation
            LEFT JOIN sports_contestant ON sports_contestant.id = sports_tabulation.contestant_id WHERE sports_tabulation.event_id = :event_id";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchNames($event_id, $pdo) {
  $query = "SELECT id, name FROM sports_name WHERE event_id = :event_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchContestantsBySportsName($event_id, $sports_name_id, $pdo) {
  $query = "SELECT sc.id, sc.contestant
            FROM sports_contestant sc
            WHERE sc.id IN (
                SELECT DISTINCT st.contestant_id
                FROM sports_tabulation st
                WHERE st.event_id = :event_id AND st.sports_name_id = :sports_name_id
            )";
  
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
  $stmt->bindParam(':sports_name_id', $sports_name_id, PDO::PARAM_INT);
  $stmt->execute();
  
  // var_dump($stmt->errorInfo());
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}





function getContestantByRank($pdo, $event_id, $sport_id, $rank)
{
    $query = "
        SELECT sc.contestant
        FROM sports_contestant sc
        JOIN sports_tabulation st ON sc.id = st.contestant_id
        WHERE st.event_id = ? AND st.sports_name_id = ? AND st.rank = ?
    ";
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$event_id, $sport_id, $rank]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } catch (PDOException $e) {
        // Handle the error, e.g., log it or display a user-friendly message
        echo "Error: " . $e->getMessage();
        return false;
    }
}


?>





<br><br>




<div id="accordion">
    <?php foreach ($events as $event): ?>

      
      
      <div class="card" style="margin-bottom:20px !important;">
        <div class="card-header" style="background-color:#17a2b8; border-radius:5px;" id="heading<?= $event['id'] ?>">
          <h5 class="mb-0">
            <button class="btn btn-link bg-transparent" style="color:white !important;" data-toggle="collapse" data-target="#collapse<?= $event['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $event['id'] ?>">
            <i class="icon-calendar"></i> <?= $event['sport_event_name'] ?>
            </button>
          </h5>
        </div>

        


        <div id="collapse<?= $event['id'] ?>" class="collapse" aria-labelledby="heading<?= $event['id'] ?>" data-parent="#accordion">
          <div class="card-body">
            <div style="margin-left:30px;">
          <a href="#">
          <button class="btn btn-warning" onclick="showContestantCard('<?= $event['id'] ?>')"><i class="icon-plus"></i> Contingents</button>
          </a>
          <a href="#">
          <button class="btn btn-success" onclick="showSportsCard('<?= $event['id'] ?>')"><i class="icon-plus"></i> Sports</button>
          </a>
          <a href="#">
          <button class="btn btn-danger" <?= hasRecords($event['id']) ? '' : 'disabled' ?> onclick="showTaggingCard('<?= $event['id'] ?>')"><i class="icon-list"></i> Tagging</button>
          </a>
          <a href="#">
          <button class="btn btn-primary" <?= hasRecords($event['id']) ? '' : 'disabled' ?> onclick="showTabulationCard('<?= $event['id'] ?>')"><i class="glyphicon glyphicon-th"></i> Tabulation</button>
          </a>
          <a href="#">
          <button class="btn btn-info" onclick="showRankingCard('<?= $event['id'] ?>')">    <i class="glyphicon glyphicon-star"></i>Ranking</button>
          </a>
 
          
        </div>




        <!--------------------Add Contestant------------------------->
        <div id="contestantCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
    <h4>Add Contingent</h4>
    <form action="functions.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $event['id'] ?>" name="id">
        
        <!-- Container to hold dynamic contingent input fields -->
        <div id="contingentContainer<?= $event['id'] ?>">
            <table align="center" class="table table-bordered" id="example<?= $event['id'] ?>">
                <tr>
                    <td>
                        <strong>Contingent</strong>:<br />
                        <input placeholder="Contestant/ Department" name="contestant[]" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true" />
                    </td>
                </tr>
            </table>
        </div>
        <a href="javascript:void(0);" onclick="addContingentField(<?= $event['id'] ?>);" style="color: green; text-decoration: underline; font-weight: bold; cursor: pointer; margin-top: 10px; display: inline-block;"><i class="icon-plus"></i> Add New Contingent</a>

        <div class="modal-footer">
            <button name="add_contestant" type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>SAVE</strong></button>
            <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
        </div>
    </form>



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






    <!-- Table to Display Contestants -->
    <div style="margin-left:50px; margin-top:20px;">
    <h2>Contingents</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Contingents</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->prepare("SELECT id, contestant FROM sports_contestant WHERE event_id = ?");
            $stmt->execute([$event['id']]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['contestant']) . "</td>";
              echo "<td>";
              echo "<button class='btn btn-danger' onclick='deleteContestant(" . $row['id'] . ")'>Delete</button>";
              echo "</td>";
              echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


</div>









        <!--------------------Add Sport------------------------->

        <div id="sportsCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
    <h4>Add Sport</h4>
    <form action="functions.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $event['id'] ?>" name="id">
        
        <!-- Container for Dynamic Sports Name Fields -->
        <div id="sportsNameContainer<?= $event['id'] ?>">
            <table align="center" class="table table-bordered" id="exampleSports<?= $event['id'] ?>">
                <tr>
                    <td>
                        <strong>Sport Name</strong>:<br />
                        <input placeholder="Sport Name" name="name[]" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true" />
                    </td>
                </tr>
            </table>
        </div>

        <!-- Button to Add More Sports Name Fields -->
        <a href="javascript:void(0);" onclick="addSportsField(<?= $event['id'] ?>);" style="color: green; text-decoration: underline; cursor: pointer; font-weight: bold; margin-top: 10px; display: inline-block;"><i class="icon-plus"></i> Add New Sport</a>

        <div class="modal-footer">
            <button name="add_sport" type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>SAVE</strong></button>
            <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
        </div>          
    </form>



    <div style="margin-left:50px; margin-top:20px;">
    <h2>Sports</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sport Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->prepare("SELECT id, name FROM sports_name WHERE event_id = ?");
            $stmt->execute([$event['id']]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>";
              echo "<button class='btn btn-danger' onclick='deleteSport(" . $row['id'] . ")'>Delete</button>";
              echo "</td>";
              echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


    
</div>


          

        <!--------------------Add Tagging------------------------->

          <div id="taggingCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
            <h4>Sport Tagging</h4>
           
              <form action="functions.php" method="POST" enctype="multipart/form-data">
              <?php
              $eventData = getEventData($event['id']);
              $contestants = $eventData['contestants'];
              $sportsNames = $eventData['sportsNames'];
              ?>
              <input type="hidden" name="id" value="<?php echo $event['id'];?>">
          <table class="table table-bordered">
              <thead>
              <tr>
                  <th><center>Department</center></th>
                  <?php foreach ($sportsNames as $sportsName): ?>
                      <th><center><?= $sportsName['name'] ?></center></th>
                  <?php endforeach; ?>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($contestants as $contestant): ?>
              <tr>
                  <td><center><?= $contestant['contestant'] ?></center></td>
                  <?php foreach ($sportsNames as $sportsName): ?>
                      <td>
                          <center>
                              <?php
                              $isChecked = isContestantTagged($contestant['id'], $sportsName['id'], $event['id']);
                              $checkboxName = "selectedContestants[{$contestant['id']}][{$sportsName['id']}]";
                              ?>
                              <input type="checkbox" name="<?= $checkboxName ?>" value="<?= $sportsName['id'] ?>" <?= $isChecked ? 'checked' : '' ?>>
                          </center>
                      </td>
                  <?php endforeach; ?>
              </tr>
          <?php endforeach; ?>

              </tbody>
          </table>


            <div>
              <button class="btn btn-primary" style="float:right;" name="save" type="submit">Save</button>
            </div>
            </form>
          
          </div>




        <!--------------------Add Tabulation------------------------->

          <div id="tabulationCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
          <h4>Tabulation
          <!-- <button style="float:right;" class="btn btn-info" onclick="showTabulatedCard('<?= $event['id'] ?>')">    <i class="glyphicon glyphicon-eye"></i>View</button> -->

          </h4>
            <tr>
              <td>
            
            
              <?php
              $event_id = $event['id'];
              $names = fetchNames($event_id, $pdo);
              // $contestants = fetchContestants($event_id, $pdo);
              $contestants = fetchContestantsBySportsName($event['id'], $sportsName['id'], $pdo);


              
              ?>




<form action="functions.php" method="POST" enctype="multipart/form-data">
    <?php
        $event_id = $event['id'];
        $names = fetchNames($event_id, $pdo);
        $contestants = fetchContestants($event_id, $pdo);
        $tabulationData = getTabulationData($event_id, $pdo);
    ?>

    
    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

    <table align="center" class="table table-bordered" id="example">
        <thead>
            <tr>
                <th>Sports</th>
                <th>Gold</th>
                <th>Silver</th>
                <th>Bronze</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($names as $name): ?>
              <input type="hidden" name="sports_name_id[]" value="<?php echo $name['id']; ?>">

                <tr>
                    <td><?php echo $name['name']; ?></td>
                    <?php
                    // Retrieve the current selections for this sport
                    $currentSelections = $tabulationData[$name['id']] ?? [];
                    ?>
                    <td>
                    <select name="gold_medal[]">
                        <option value="">Select</option>
                            <?php foreach (fetchContestantsBySportsName($event_id, $name['id'], $pdo) as $contestant):
                                // Check if this contestant was saved as gold (1)
                                $isSelected = (isset($currentSelections[1]) && $contestant['id'] == $currentSelections[1]) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $contestant['id']; ?>" <?php echo $isSelected; ?>>
                                    <?php echo $contestant['contestant']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="silver_medal[]">
                        <option value="">Select</option>
                        <?php foreach (fetchContestantsBySportsName($event_id, $name['id'], $pdo) as $contestant):
                                // Check if this contestant was saved as gold (1)
                                $isSelected = (isset($currentSelections[2]) && $contestant['id'] == $currentSelections[2]) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $contestant['id']; ?>" <?php echo $isSelected; ?>>
                                    <?php echo $contestant['contestant']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="bronze_medal[]">
                        <option value="">Select</option>
                        <?php foreach (fetchContestantsBySportsName($event_id, $name['id'], $pdo) as $contestant):
                                // Check if this contestant was saved as gold (1)
                                $isSelected = (isset($currentSelections[3]) && $contestant['id'] == $currentSelections[3]) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $contestant['id']; ?>" <?php echo $isSelected; ?>>
                                    <?php echo $contestant['contestant']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="float:right;">
        <button class="btn btn-primary" type="submit" name="save_tabulation">Save</button>
    </div>
</form>
        </td>
    </tr>

        </table>
          </div>




            <!--------------------View Tabulation------------------------->


          <div id="tabulatedCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
          <h4>Tabulation Result</h4>
          <table align="center" class="table table-bordered" id="example">
        <thead>
            <tr>
                <th>Sports</th>
                <th>Gold</th>
                <th>Silver</th>
                <th>Bronze</th>
            </tr>
        </thead>
        <tbody>
        <?php
      foreach ($names as $name): ?>
          <tr>
              <td><?php echo $name['name']; ?></td>
              <?php
                  $goldContestant = getContestantByRank($pdo, $event['id'], $name['id'], 1);
                  $silverContestant = getContestantByRank($pdo, $event['id'], $name['id'], 2);
                  $bronzeContestant = getContestantByRank($pdo, $event['id'], $name['id'], 3);
              ?>
              <td><?php echo $goldContestant['contestant']; ?></td>
              <td><?php echo $silverContestant['contestant']; ?></td>
              <td><?php echo $bronzeContestant['contestant']; ?></td>
          </tr>
      <?php endforeach; ?>
        </tbody>
    </table>
          </div>





  <!--------------------Add Rankings------------------------->

  <div id="rankingCard<?= $event['id'] ?>" style="display:none; margin-left:50px;">
    <h4>Ranking</h4>

    <?php
    $eventData = getEventData($event['id']);
    $contestants = $eventData['contestants'];
    $sportsNames = $eventData['sportsNames'];
    ?>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>Department</center></th>
                    <th>Gold</th>
                    <th>Silver</th>
                    <th>Bronze</th>
                    <th>Total</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
              
            <?php 

    $contestantTotals = array();
    foreach ($contestants as $contestant) {
        $contestantId = $contestant['id'];
        $stmtCountBronze = $pdo->prepare('SELECT COUNT(*) FROM sports_tabulation WHERE event_id = ? AND contestant_id = ? AND rank = 3');
        $stmtCountBronze->execute([$event['id'], $contestantId]);
        $bronzeCount = $stmtCountBronze->fetchColumn();

        $stmtCountSilver = $pdo->prepare('SELECT COUNT(*) FROM sports_tabulation WHERE event_id = ? AND contestant_id = ? AND rank = 2');
        $stmtCountSilver->execute([$event['id'], $contestantId]);
        $silverCount = $stmtCountSilver->fetchColumn();

        $stmtCountGold = $pdo->prepare('SELECT COUNT(*) FROM sports_tabulation WHERE event_id = ? AND contestant_id = ? AND rank = 1');
        $stmtCountGold->execute([$event['id'], $contestantId]);
        $goldCount = $stmtCountGold->fetchColumn();

        $total = $goldCount * 3 + $silverCount * 2 + $bronzeCount;

        // Store data in the new array
        $contestantTotals[] = array(
            'contestant' => $contestant['contestant'],
            'goldCount' => $goldCount,
            'silverCount' => $silverCount,
            'bronzeCount' => $bronzeCount,
            'total' => $total,
        );
    }

    usort($contestantTotals, function($a, $b) {
        return $b['total'] - $a['total'];
    });

    $ranking = 1;
    foreach ($contestantTotals as $data): ?>
        <tr>
            <td><center><?= $data['contestant'] ?></center></td>
            <td><?= $data['goldCount'] ?></td>
            <td><?= $data['silverCount'] ?></td>
            <td><?= $data['bronzeCount'] ?></td>
            <td><?= $data['total'] ?></td>
            <td><?= $ranking ?></td>
        </tr>
<?php
        $ranking++;
    endforeach;
?>

 
            </tbody>
        </table>

</div>


          </div>
        </div>
      </div>
      <hr>
    <?php endforeach; ?>
</div>




<script>
  document.querySelectorAll('.card-header').forEach(function(header) {
    header.addEventListener('click', function() {
      var button = this.querySelector('.btn-link');
      if (button) {
        button.click();
      }
    });
  });
</script>


<script>
function deleteContestant(contestantId) {
    if (confirm("Are you sure you want to delete this contestant?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_sports_contestant.php?id=" + contestantId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response here
                alert("Contestant deleted successfully.");
                window.location.reload(); // Reload the page
            }
        };
        xhr.send();
    }
}
</script>



<script>
function deleteSport(sportId) {
    if (confirm("Are you sure you want to delete this sport?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_sports_sports.php?id=" + sportId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert("Sport deleted successfully.");
                window.location.reload(); // Reload the page
            }
        };
        xhr.send();
    }
}
</script>




<script>
// Function to add new contingent input field
function addContingentField(eventId) {
    var container = document.getElementById('contingentContainer' + eventId);
    var table = container.querySelector('table');
    var newRow = table.insertRow(-1); // Insert a row at the end of the table
    var newCell = newRow.insertCell(0); // Insert a cell in the row at index 0

    // Add the new input field with a remove link
    newCell.innerHTML = '<strong>Contingent</strong>:<br /><input placeholder="Contestant/ Department" name="contestant[]" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true" /> <a href="javascript:void(0);" onclick="removeContingentField(this);" style="color: red; text-decoration: underline; cursor: pointer;"><i class="icon-minus"></i> Remove</a>';
}

// Function to remove a contingent input field
function removeContingentField(element) {
    // Find the row that contains the remove link and remove it
    var row = element.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script>



<script>
// Function to add new sports name input field
function addSportsField(eventId) {
    var container = document.getElementById('sportsNameContainer' + eventId);
    var table = container.querySelector('table');
    var newRow = table.insertRow(-1); // Insert a row at the end of the table
    var newCell = newRow.insertCell(0); // Insert a cell in the row at index 0

    // Add the new input field
    newCell.innerHTML = '<strong>Sport Name</strong>:<br /><input placeholder="Sport Name" name="name[]" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true" /> <a href="javascript:void(0);" onclick="removeSportsField(this);" style="color: red; text-decoration: underline; cursor: pointer;"><i class="icon-minus"></i> Remove</a>';
}

// Function to remove a sports name input field
function removeSportsField(element) {
    var row = element.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script>


<script>
  function showContestantCard(eventId) {
    document.getElementById('sportsCard' + eventId).style.display = 'none';
    document.getElementById('contestantCard' + eventId).style.display = 'block';
    document.getElementById('tabulationCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'none';

  }

  function showSportsCard(eventId) {
    document.getElementById('contestantCard' + eventId).style.display = 'none';
    document.getElementById('sportsCard' + eventId).style.display = 'block';
    document.getElementById('tabulationCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'none';
    document.getElementById('tabulatedCard' + eventId).style.display = 'none';

  }

  function showTaggingCard(eventId) {
    document.getElementById('contestantCard' + eventId).style.display = 'none';
    document.getElementById('sportsCard' + eventId).style.display = 'none';
    document.getElementById('tabulationCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'block';
    document.getElementById('tabulatedCard' + eventId).style.display = 'none';

  }


  function showTabulationCard(eventId) {
    document.getElementById('contestantCard' + eventId).style.display = 'none';
    document.getElementById('sportsCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'none';
    document.getElementById('tabulationCard' + eventId).style.display = 'block';
    document.getElementById('tabulatedCard' + eventId).style.display = 'none';

  }

  function showRankingCard(eventId) {
    document.getElementById('contestantCard' + eventId).style.display = 'none';
    document.getElementById('sportsCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'none';
    document.getElementById('tabulationCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'block';
    document.getElementById('tabulatedCard' + eventId).style.display = 'none';

  }


  function showTabulatedCard(eventId) {
    document.getElementById('contestantCard' + eventId).style.display = 'none';
    document.getElementById('sportsCard' + eventId).style.display = 'none';
    document.getElementById('taggingCard' + eventId).style.display = 'none';
    document.getElementById('tabulationCard' + eventId).style.display = 'none';
    document.getElementById('rankingCard' + eventId).style.display = 'none';
    document.getElementById('tabulatedCard' + eventId).style.display = 'block';

  }




</script>









<!-- Modal -->
<div class="modal fade" id="addSportsEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true" style="z-index: 1050;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addEventModalLabel"><strong>ADD EVENT</strong></h4>
      </div>
      <div class="modal-body">
        <form method="POST" action="functions.php" id="eventForm">
          <strong>Sports Event Name:</strong><br />
          <input type="text" name="sport_event_name" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" placeholder="Sports Event Name" required value="<?php echo isset($_POST['sport_event_name']) ? htmlspecialchars($_POST['sport_event_name']) : ''; ?>" /><br />

          <strong>From School Year:</strong><br />
          <input type="text" class="yearpicker form-control" style="text-indent: 5px !important; width: 97.5% !important;" name="from_year" value="<?php echo isset($_POST['sy']) ? htmlspecialchars($_POST['sy']) : ''; ?>" /><br />
          
          <strong>To School Year:</strong><br />
          <input type="text" class="yearpicker form-control" style="text-indent: 5px !important; width: 97.5% !important;" name="to_year" value="<?php echo isset($_POST['sy2']) ? htmlspecialchars($_POST['sy2']) : ''; ?>" /><br />
          
          <strong>Date Start:</strong><br />
          <input type="date" name="date_start" class="form-control btn-block" style="height: 30px !important;" required value="<?php echo isset($_POST['date_start']) ? htmlspecialchars($_POST['date_start']) : ''; ?>" /><br />

          <strong>Date End:</strong><br />
          <input type="date" name="date_end" class="form-control btn-block" style="height: 30px !important;" required value="<?php echo isset($_POST['date_end']) ? htmlspecialchars($_POST['date_end']) : ''; ?>" /><br />

          <strong>Venue:</strong><br />
          <textarea name="venue" class="form-control btn-block" placeholder="Event Venue" required rows="2"><?php echo isset($_POST['place']) ? htmlspecialchars($_POST['place']) : ''; ?></textarea><br />
      </div>
      <div class="modal-footer">
        <button title="Click to save" name="create" type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>SAVE</strong></button>
        <button title="Clear form" type="button" onclick="resetForm()" class="btn btn-danger"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove"></i> <strong>CANCEL</strong></button>
      </div>
    </form>
  </div>
</div>









<script>
    $('.yearpicker').yearpicker()
</script>



<!------EVENT INSERT TO DATABASE ------>
<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);


$conn = new PDO('mysql:host=localhost;dbname=swuetsdb3', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
  
    if (!isset($_SESSION['id'])) {
        echo "<script>alert('You must be logged in to create an event.');</script>";
        exit; 
    }

   
    $organizer_id = $_SESSION['id'];

   
    $conn->beginTransaction();

    try {
       
        $sql = "INSERT INTO sports_management (sport_event_name, status, organizer_id, sy_1, sy_2, dateStart, dateEnd, venue) 
                VALUES (:sport_event_name, :status, :organizer_id, :sy_1, :sy_2, :dateStart, :dateEnd, :venue)";
        $stmt = $conn->prepare($sql);

        
        $stmt->bindParam(':sport_event_name', $_POST['sport_event_name']);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':organizer_id', $organizer_id);
        $stmt->bindParam(':sy_1', $_POST['sy']);
        $stmt->bindParam(':sy_2', $_POST['sy2']);
        $stmt->bindParam(':dateStart', $_POST['date_start']);
        $stmt->bindParam(':dateEnd', $_POST['date_end']);
        $stmt->bindParam(':venue', $_POST['place']);

      
        $status = 'activated'; 

      
        $stmt->execute();

        
        $conn->commit();

        echo "<script>alert('New event added successfully!');</script>";
    } catch(PDOException $e) {
       
        $conn->rollBack();
        echo "<script>alert('PDO Error: " . $e->getMessage() . "');</script>";
    }
}
?>












<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap-transition.js"></script>
  <script src="assets/js/bootstrap-alert.js"></script>
  <script src="assets/js/bootstrap-modal.js"></script>
  <script src="assets/js/bootstrap-dropdown.js"></script>
  <script src="assets/js/bootstrap-scrollspy.js"></script>
  <script src="assets/js/bootstrap-tab.js"></script>
  <script src="assets/js/bootstrap-tooltip.js"></script>
  <script src="assets/js/bootstrap-popover.js"></script>
  <script src="assets/js/bootstrap-button.js"></script>
  <script src="assets/js/bootstrap-collapse.js"></script>
  <script src="assets/js/bootstrap-carousel.js"></script>
  <script src="assets/js/bootstrap-typeahead.js"></script>
  <script src="assets/js/bootstrap-affix.js"></script>
  <script src="assets/js/holder/holder.js"></script>
  <script src="assets/js/google-code-prettify/prettify.js"></script>
  <script src="assets/js/application.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="path/to/bootstrap.min.js"></script>
</body>
</html>