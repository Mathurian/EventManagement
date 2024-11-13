<!DOCTYPE html>
<html lang="en">

<?php
include('header2.php');
include('session.php');


$sub_event_id = $_GET['sub_event_id'];
$se_name = $_GET['se_name'] ?? '';



$se_query = $conn->query("select * from sub_event where subevent_id = '$sub_event_id'");
$se_row = $se_query->fetch();



?>



<body data-spy="scroll" data-target=".bs-docs-sidebar">

  <!-- Navbar
    ================================================== -->
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="#">SWU-ETS</font></a>
        <div class="nav-collapse collapse">
          <ul class="nav">


            <li class="active">
              <a href="home.php"><strong>Event Management</strong></a>
            </li>

            <li class="active">
              <a href="sports_management.php">Sports Management</a>
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account
                <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">


                <li>
                  <a target="_blank" href="edit_organizer.php">Settings</a>
                </li>

                <li>
                  <a href="logout.php">Logout
                    <?php echo $name; ?>
                  </a>
                </li>


              </ul>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>


  <header class="jumbotron subhead" id="overview">
    <div class="container">
      <h1 style="font-size: 50px;">
        <?php echo $se_name; ?> Settings
      </h1>
      <p class="lead">SWU-ETS</p>
    </div>
  </header>


  <div class="container">






    <div class="span12">



      <br />
      <div class="col-md-12">
        <ul class="breadcrumb">



          <li><a href="home.php">Event Management</a> / </li>

          <li>
            <?php echo $se_name; ?> Settings
          </li>

        </ul>
      </div>


      <?php
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM contestants WHERE subevent_id = ?");
        $stmt->execute([$sub_event_id]);
        $result = $stmt->fetch();
        $contestant_count = $result['total'];
      ?>




      <form method="POST">
        <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />


        <hr />

        <div id="myGroup">


          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#contestant" data-parent="#myGroup"><i class="icon-chevron-right"></i>
            <strong>CONTINGENT</strong></a>

          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#judges" data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>JUDGE</strong></a>

          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#criteria" data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>CRITERIA</strong></a>

          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#special_awards" data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>SPECIAL AWARDS</strong></a>

          



          <div style="border: 0px;" class="accordion-group">

            <div class="collapse indent" id="contestant">


              <section id="download-bootstrap">
                <div class="page-header">
                  <h1>Contingent's Settings
                    &nbsp;<button type="button" id="addContestantBtn" onclick="handleAddContestant();" class="btn btn-success" title="Click to add new Contestant for this Event"><i class="icon icon-plus"></i> Add Contingent</button>
                  </h1>
                </div>

                <form method="POST">
                <table class="table table-bordered" style="border-collapse: collapse; width: 100%;">
                      <thead>
                      <tr>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 50px">Select</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">No.</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Name</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Department</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Signed</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Actions</th>
        </tr>
                      </thead>

                      <tbody>
                          <?php
                            $i = 1;

                      
                            $stmt = $conn->prepare("SELECT * FROM contestants WHERE subevent_id = ? ORDER BY contestant_ctr");
                            $stmt->execute([$sub_event_id]);

                            while ($cont_row = $stmt->fetch()) {
                                $cont_id = $cont_row['contestant_id'];
                          ?>
                              <tr>
                              <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                      <input name="selector[]" type="checkbox" value="<?php echo $cont_id; ?>" title="Check to select <?php echo $cont_row['lname']; ?>" />
                                  </td>
                                  <td style="border: 1px solid #ddd; padding: 8px;">
                                      <?php echo $i++; ?>
                                  </td>
                                  <td style="border: 1px solid #ddd; padding: 8px;">
                                      <?php echo $cont_row['lname'];  ?> <?php echo $cont_row['fname'];  ?> <?php echo $cont_row['mname'];  ?>
                                  </td>
                                  <td style="border: 1px solid #ddd; padding: 8px;">
                                      <?php echo $cont_row['department'];  ?> 
                                  </td>
                                  <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                      &#10004; 
                                  </td>
                                  <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                      <a title="Click to edit <?php echo $cont_row['lname']; ?> data" href="edit_contestant.php?contestant_id=<?php echo $cont_row['contestant_id']; ?>&sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a>
                                  </td>
                              </tr>
                          <?php } ?>
                      </tbody>
                      <tfoot>
                          <tr>
                              <td colspan="4">
                                <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                                <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                                <button type="submit" name="deleteMultiple" class="btn btn-danger">Delete</button>
                              </td>
                          </tr>
                      </tfoot>
                  </table>
              </form>

              </section>

            </div>

            <script>
                document.getElementById("addContestantBtn").addEventListener("click", function(event) {
                    event.preventDefault();

                    var contestantCount = <?php echo $contestant_count; ?>;
                    var maxContestants = 20;

                    if (contestantCount >= maxContestants) {
                        alert("Maximum number of contestants reached (20). You cannot add more contestants.");
                    } else {
                        window.location.href = "add_contestant.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>";
                    }
                });

              </script>



            <?php
                $judge_count_query = $conn->query("SELECT COUNT(*) as total_judges FROM judges WHERE subevent_id='$sub_event_id'");
                $judge_count_row = $judge_count_query->fetch();
                $current_judge_count = $judge_count_row['total_judges'];

                ?>


            <div class="collapse indent" id="judges">
              <section id="download-bootstrap">
                <div class="page-header">
                  <h1>Judge's Settings
                  &nbsp;<button type="button" id="addJudgeBtn" onclick="handleAddJudge();" class="btn btn-success" title="Click to add new Contestant for this Event"><i class="icon icon-plus"></i> Add Judge</button>
                    &nbsp;<a title="Click to print Judge's Code for this Event" target="_blank" title="Click to print judges code" href="print_judges.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name;?>" class="btn btn-info"><i class="icon icon-print"></i></a></h1>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 10%;">Check to Select</th>
                    <th style="width: 20%;">Code</th>
                    <th style="width: 55%;">Fullname</th>
                    <th style="width: 15%; text-align: center;" >Assign Chairman</th>
                  </thead>
                  <form method="POST">
                    <tbody>
                      <?php
                        $judge_query = $conn->query("SELECT * FROM judges WHERE subevent_id='$sub_event_id' order by judge_ctr");
                        while ($judge_row = $judge_query->fetch()) {
                          $jxx_id = $judge_row['judge_id'];
                          $judgeType = $judge_row['jtype']; // Get the judge type from the query result
                          $nameColor = ($judgeType == "Chairman") ? "color: red;" : "color: black;";
                      ?>
                        <tr>
                          <td width="115"><input name="selector[]" type="checkbox" value="<?php echo $jxx_id;  ?>" title="Check to select <?php echo $judge_row['fullname']; ?>" /></td>
                       
                          <td>
                            <?php echo $judge_row['code']; ?>
                          </td>
                          <td style="<?php echo $nameColor; ?>">
                            <?php echo $judge_row['fullname']; echo ($judgeType) ? " - " . $judgeType : ""; ?>
                          </td>
                          
                          <td style="text-align: center;"> <!-- Align to center -->
                        <a title="Click to edit <?php echo $judge_row['fullname']; ?> data" href="edit_judge.php?judge_id=<?php echo $jxx_id; ?>&sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a>
                    </td>


                          </td>
                        </tr>





                      <?php } ?>
                      <tfoot>
                          <tr>
                              <td colspan="4">
                                  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                                  <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                                  <button type="submit" name="delete_judge" class="btn btn-danger">Delete Selected</button>
                              </td>
                          </tr>
                      </tfoot>
                </table>

                
                </td>

                </tr>
                </tbody>
      </form>
      </table>




      </section>
    </div>

    <script>
      function handleAddJudge() {
        var sub_event_id = "<?php echo $sub_event_id; ?>";
        var se_name = "<?php echo $se_name; ?>";
        window.location.href = "add_judge.php?sub_event_id=" + sub_event_id + "&se_name=" + se_name;
    }
    </script>



    <div class="collapse indent" id="criteria">
      <section id="download-bootstrap">
        <div class="page-header">
          <h1>Criteria's Settings &nbsp;<button type="button" id="addCriteria Button" onclick="handleAddCriteria();" class="btn btn-success" title="Click to add new Contestant for this Event"><i class="icon icon-plus"></i> Add Criteria</button></h1>
        </div>
        <table class="table table-bordered">
          <thead>
            <th>Check to Select</th>
            <th>No.</th>
            <th>Criteria</th>
            <th>Percentage</th>
            <th>Actions</th>
          </thead>
          <form method="POST">
            <tbody>
              <?php
              $percnt = 0;
              $crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$sub_event_id'");
              while ($crit_row = $crit_query->fetch()) {
                $percnt = $percnt + $crit_row['percentage'];
                $crit_id = $crit_row['criteria_id'];
              ?>
                <tr>
                  <td width="115"><input name="selector[]" type="checkbox" value="<?php echo $crit_id; ?>" title="Check to select <?php echo $crit_row['criteria']; ?>" /></td>
                  <td width="10">
                    <?php echo $crit_row['criteria_ctr']; ?>
                  </td>
                  <td>
                    <?php echo $crit_row['criteria']; ?>
                  </td>
                  <td width="10">
                    <?php echo $crit_row['percentage']; ?>
                  </td>
                  <td width="10"><a title="Click to edit Criteria: <?php echo $crit_row['criteria']; ?> datas" href="edit_criteria.php?crit_id=<?php echo $crit_id; ?>&sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a></td>
                </tr>
              <?php } ?>

              <tr>

                <?php
                if ($percnt < 100) { ?>
                  <td colspan="3">
                    <div class="alert alert-danger pull-right">

                      <strong>The Total Percentage is under 100%.</strong>
                    </div>
                  </td>
                  <td colspan="2">
                    <div class="alert alert-danger">

                      <strong>
                        <?php echo $percnt; ?>%
                      </strong>
                    </div>
                  </td>

                <?php } ?>

                <?php
                if ($percnt > 100) { ?>
                  <td colspan="3">
                    <div class="alert alert-danger pull-right">

                      <strong>The Total Percentage is over 100%.</strong>
                    </div>
                  </td>
                  <td colspan="2">
                    <div class="alert alert-danger">

                      <strong>
                        <?php echo $percnt; ?>%
                      </strong>
                    </div>

                  </td>

                <?php } ?>


                <?php
                if ($percnt == 100) { ?>
                  <td colspan="3"><strong class="pull-right">TOTAL</strong></td>
                  <td colspan="2">
                    <span style="font-size: 15px !important;" class="badge badge-info">
                      <?php echo $percnt; ?> %
                    </span>
                  </td>

                <?php } ?>
              </tr>


              <tfoot>
                          <tr>
                              <td colspan="4">
                                  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                                  <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                                  <button type="submit" name="delete_criteria" class="btn btn-danger">Delete Selected</button>
                              </td>
                          </tr>
                      </tfoot>
            </tbody>
          </form>
        </table>

      </section>
    </div>
    <script>
        function handleAddCriteria() {
          var sub_event_id = "<?php echo $sub_event_id; ?>";
          var se_name = "<?php echo $se_name; ?>";
          window.location.href = "add_criteria.php?sub_event_id=" + sub_event_id + "&se_name=" + se_name;
      }
    </script>

  </div>



  </div>



  </form>
  </div>
  </div>
      <style>
        .container-centered {
          margin: 0 auto;
          width: 80%; /* or whatever width you prefer */
        }
      </style>
      
  <div class="collapse indent" id="special_awards">
      <section id="download-bootstrap" class="container-centered">
        <div class="page-header">
          <h1>Special Award's Settings &nbsp;<button type="button" id="addCriteria Button" onclick="handleAddSpecialAwards();" class="btn btn-success" title="Click to add new Contestant for this Event"><i class="icon icon-plus"></i> Add Special Awards</button></h1>
        </div>
        <table class="table table-bordered">
      <thead>
        <th>Check to Select</th>
        <th>No.</th>
        <th>Special Award</th>
        <th>Score</th>
        <th>Actions</th>
      </thead>
      <form method="POST">
        <tbody>
          <?php
          $awards_query = $conn->query("SELECT * FROM special_awards WHERE subevent_id='$sub_event_id' ORDER BY awards_ctr ASC");
          while ($awards_row = $awards_query->fetch()) {
            $awards_id = $awards_row['awards_id'];
          ?>
            <tr>
              <td width="115"><input name="selector[]" type="checkbox" value="<?php echo $awards_id; ?>" title="Check to select <?php echo $awards_row['special_awards']; ?>" /></td>
              <td width="10">
                <?php echo $awards_row['awards_ctr']; ?>
              </td>
              <td>
                <?php echo $awards_row['special_awards']; ?>
              </td>
              <td width="10">
                <?php echo $awards_row['score']; ?>
              </td>
              <td width="10"><a title="Click to edit Special Award: <?php echo $awards_row['special_awards']; ?>" href="edit_specialawards.php?awards_id=<?php echo $awards_id; ?>&sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a></td>
            </tr>
          <?php } ?>

              


              <tfoot>
                          <tr>
                              <td colspan="4">
                                  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                                  <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                                  <button type="submit" name="delete_special_awards" class="btn btn-danger">Delete Selected</button>
                              </td>
                          </tr>
              </tfoot>
            </tbody>
          </form>
        </table>

      </section>
    </div>
    <script>
        function handleAddSpecialAwards() {
          var sub_event_id = "<?php echo $sub_event_id; ?>";
          var se_name = "<?php echo $se_name; ?>";
          window.location.href = "add_specialawards.php?sub_event_id=" + sub_event_id + "&se_name=" + se_name;
      }
    </script>


  </div>



  </div>



  </form>
  </div>
  </div>



  <?php
  if (isset($_POST['activate_textpoll'])) {

    $sub_event_id = $_POST['sub_event_id'];
    $tp_status = $_POST['tp_status'];

    if ($tp_status == "active") {
      $conn->query("update sub_event set txtpoll_status='deactive', txtpollview='deactive', view='deactive' where subevent_id='$sub_event_id'");

  ?>
      <script>
        window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
        alert('Textpoll Deactivated');
      </script>
    <?php
    } else {
      $conn->query("update sub_event set txtpoll_status='active', txtpollview='active', view='active' where subevent_id='$sub_event_id'");

    ?>
      <script>
        window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
        alert('Textpoll Activated');
      </script>

  <?php  }
  } ?>



  <?php


    /* contestants */

    if (isset($_POST['save_settings'])) {
      $sub_event_id = $_POST['sub_event_id'];
      $stmt = $conn->prepare("SELECT MAX(contestant_ctr) as maxCtr FROM contestants WHERE subevent_id = ?");
      $stmt->execute([$sub_event_id]);
      $row = $stmt->fetch();
      $currentMaxCtr = $row['maxCtr'] ?? 0; 
  
      for ($i = 1; $i <= 10; $i++) {
          $contestant_name = $_POST["con{$i}"] ?? '';
  
          if ($contestant_name !== "") {
              $currentMaxCtr++;  
              $stmtInsert = $conn->prepare("insert into contestants(fullname, subevent_id, contestant_ctr) values (?, ?, ?)");
              $stmtInsert->execute([$contestant_name, $sub_event_id, $currentMaxCtr]);
          }
      }
  
 
    /* end contestants */



    /* judges */
    $stmt = $conn->prepare("INSERT INTO judges (fullname, subevent_id, judge_ctr) VALUES (:judge_name, :sub_event_id, :judge_ctr)");

    for ($i = 1; $i <= 10; $i++) {
    $judge_name = $_POST["jud{$i}"] ?? '';

    if ($judge_name !== "") {
        $stmt->bindParam(':judge_name', $judge_name);
        $stmt->bindParam(':sub_event_id', $sub_event_id);
        $stmt->bindParam(':judge_ctr', $i);
        $stmt->execute();
    }
}

    /* judges */



    /* criteria */
    $stmt = $conn->prepare("INSERT INTO criteria(criteria, subevent_id, percentage, criteria_ctr) VALUES (:crit_name, :sub_event_id, :cp, :crit_ctr)");

for ($i = 1; $i <= 10; $i++) {
    $crit_name = $_POST["crit{$i}"] ?? '';
    $cp = $_POST["cp{$i}"] ?? 0;

    if ($crit_name !== "" || $cp > 0) {
        $stmt->bindParam(':crit_name', $crit_name);
        $stmt->bindParam(':sub_event_id', $sub_event_id);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':crit_ctr', $i);
        $stmt->execute();
    }
}

    /* end criteria */

  ?>
    <script>
      window.location = 'home.php';
      alert('Organizer <?php echo $fname . " " . $mname . " " . $lname; ?> registered successfully!');
    </script>
  <?php


  } ?>




<?php
if (isset($_POST['deleteMultiple'])) {
    $sub_event_id = $_POST['sub_event_id'] ?? '';
    $se_name = $_POST['se_name'] ?? '';
    $id = $_POST['selector'] ?? [];

    if (empty($id)) {
        echo "<script>
                alert('Please select at least one contestant to delete.');
                window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id';
              </script>";
        exit;  
    }
    foreach ($id as $contestant_id) {
        $conn->query("delete from contestants where contestant_id='$contestant_id'");
        $conn->query("delete from sub_results where contestant_id='$contestant_id'");
    }
    $stmt = $conn->prepare("SELECT contestant_id FROM contestants WHERE subevent_id = ? ORDER BY contestant_ctr");
    $stmt->execute([$sub_event_id]);
    $newCtr = 1;
    while ($cont_row = $stmt->fetch()) {
        $stmtUpdate = $conn->prepare("UPDATE contestants SET contestant_ctr = ? WHERE contestant_id = ?");
        $stmtUpdate->execute([$newCtr, $cont_row['contestant_id']]);
        $newCtr++;
    }
    echo "<script>
            alert('Contestant(s) successfully deleted.');
            window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id';
          </script>";
}
?>

<?php
if (isset($_POST['delete_judge'])) {
  $sub_event_id = $_POST['sub_event_id'] ?? '';
  $se_name = $_POST['se_name'] ?? '';
  $id = $_POST['selector'] ?? [];


  if (empty($id)) {
      echo "<script>
              alert('Please select at least one judge to delete.');
              window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
            </script>";
      exit;
  }
  foreach ($id as $judge_id) {
      $conn->query("delete from judges where judge_id='$judge_id'");
      $conn->query("delete from sub_results where judge_id='$judge_id'");
  }
  echo "<script>
          alert('Judge(s) successfully deleted.');
          window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
        </script>";
}

?>






<?php
if (isset($_POST['delete_criteria'])) {
    $sub_event_id = $_POST['sub_event_id'] ?? '';
    $se_name = $_POST['se_name'] ?? '';
    $id = $_POST['selector'] ?? [];

    if (empty($id)) {
        echo "<script>
                alert('Please select at least one criterion to delete.');
                window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
              </script>";
        exit;  
    }
    foreach ($id as $criteria_id) {
        $conn->query("delete from criteria where criteria_id='$criteria_id'");
    }

    echo "<script>
            alert('Criteria(s) successfully deleted.');
            window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
          </script>";
}
?>

<?php
if (isset($_POST['delete_special_awards'])) {
    $sub_event_id = $_POST['sub_event_id'] ?? '';
    $se_name = $_POST['se_name'] ?? '';
    $ids = $_POST['selector'] ?? [];

    if (empty($ids)) {
        echo "<script>
                alert('Please select at least one special award to delete.');
                window.location.href = 'sub_event_details_edit.php?sub_event_id=" . urlencode($sub_event_id) . "&se_name=" . urlencode($se_name) . "';
              </script>";
        exit;
    }

    // Begin transaction
    $conn->beginTransaction();
    try {
        $stmt = $conn->prepare("DELETE FROM special_awards WHERE awards_id = :awards_id");
        foreach ($ids as $awards_id) {
            $stmt->execute([':awards_id' => $awards_id]);
        }
        // Commit the transaction
        $conn->commit();
        echo "<script>
                alert('Special Award(s) successfully deleted.');
                window.location.href = 'sub_event_details_edit.php?sub_event_id=" . urlencode($sub_event_id) . "&se_name=" . urlencode($se_name) . "';
              </script>";
    } catch (Exception $e) {
        // An error occurred; rollback the transaction
        $conn->rollBack();
        echo "<script>
                alert('Error deleting special award(s): " . addslashes($e->getMessage()) . "');
                window.location.href = 'sub_event_details_edit.php?sub_event_id=" . urlencode($sub_event_id) . "&se_name=" . urlencode($se_name) . "';
              </script>";
    }
    exit;
}
?>





  <?php include('footer.php'); ?>

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

</body>

</html>