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
  
 



</head>

<body>

<style>


</style>
  <!-- Navbar
    ================================================== -->
  <div class="navbar navbar-inverse navbar-fixed-top" style="z-index: 1060;">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="#">
          <font size="3">SWU-ETS</font>
        </a>

        <div class="nav-collapse collapse">
          <ul class="nav">
            <li class="active">
              <a href="home.php"><strong>Event Management</strong></a>

            <li>
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
      <h1>Event Management</h1>
      <p class="lead">SWU-ETS</p>
    </div>
  </header>


  <div class="container">


    <div class="span12">


      <br />
      <div class="col-md-12">
        <ul class="breadcrumb">



          <li>Event Management</li>



        </ul>
      </div>



      <!-- Download
        ================================================== -->
      <section id="download-bootstrap">
        <div class="page-header">



          <table style="width: 100% !important;" align="center">

            <tr>

              <td>



            <!-- Button trigger modal -->
<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addEventModal">
  <i class="icon icon-plus"></i> <strong>EVENT</strong>
</button>

<!-- Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" style="z-index: 1050;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h4 class="modal-title" id="addEventModalLabel"><strong>ADD EVENT</strong></h4>
        </div>
        <div class="modal-body">
            <strong>Event Name:</strong><br />
            <input type="text" name="main_event" class="form-control btn-block" style="text-indent: 5px; height: 30px;" placeholder="Event Name" required value="<?php echo isset($_POST['main_event']) ? htmlspecialchars($_POST['main_event']) : ''; ?>" /><br />

            <strong>From School Year:</strong><br />
            <input type="text" class="yearpicker form-control" style="text-indent: 5px; width: 97.5%;" name="sy" value="<?php echo isset($_POST['sy']) ? htmlspecialchars($_POST['sy']) : ''; ?>" /><br />
            
            <strong>To School Year:</strong><br />
            <input type="text" class="yearpicker form-control" style="text-indent: 5px; width: 97.5%;" name="sy2" value="<?php echo isset($_POST['sy2']) ? htmlspecialchars($_POST['sy2']) : ''; ?>" /><br />
            
            <strong>Date Start:</strong><br />
            <input type="date" name="date_start" class="form-control btn-block" style="height: 30px;" required value="<?php echo isset($_POST['date_start']) ? htmlspecialchars($_POST['date_start']) : ''; ?>" /><br />

            <strong>Date End:</strong><br />
            <input type="date" name="date_end" class="form-control btn-block" style="height: 30px;" required value="<?php echo isset($_POST['date_end']) ? htmlspecialchars($_POST['date_end']) : ''; ?>" /><br />

            <strong>Venue:</strong><br />
            <textarea name="place" class="form-control btn-block" style="text-indent: 10px;" placeholder="Event Venue" required rows="2"><?php echo isset($_POST['place']) ? htmlspecialchars($_POST['place']) : ''; ?></textarea><br />
        </div>
        <div class="modal-footer">
          <button title="Click to save" name="create" type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>SAVE</strong></button>
          <button title="Clear form" type="button" onclick="resetForm()" class="btn btn-danger"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-remove"></i> CANCEL</button>
        </div>
      </form>
    </div>
  </div>
</div>







            <?php
            $sy_query = $conn->query("select DISTINCT sy, sy2 FROM main_event where organizer_id='$session_id'") or die(mysql_error());
            while ($sy_row = $sy_query->fetch()) {

              $sy = $sy_row['sy'];
              $sy2 = $sy_row['sy2'];



              $MEctrQuery = $conn->query("select * FROM main_event where sy='$sy'") or die(mysql_error());
              $MECtr = $MEctrQuery->rowCount();

            ?>

              <tr>

                <td>



                  <a data-toggle="collapse" href="#MainEvents<?php echo $sy; ?>" style="text-align: left !important; text-indent: 7px !important" class="btn btn-info btn-block"><i class="icon icon-folder-close"></i><?php echo "Year"; ?> <?php echo $sy; ?> <?php echo "-"; ?> <?php echo $sy2; ?> <span class="badge badge-info pull-right" style="margin-right: 7px !important;"><strong><?php if ($MECtr > 0 and $MECtr < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                          echo $MECtr . " Event";
                                                                                                                                                                                                                                                                                                                                                                                                                        } elseif ($MECtr > 1) {
                                                                                                                                                                                                                                                                                                                                                                                                                          echo $MECtr . " Events";
                                                                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                                                          echo "0 Event";
                                                                                                                                                                                                                                                                                                                                                                                                                        }; ?></strong> </span> </a>



                  <div class="panel-collapse collapse" id="MainEvents<?php echo $sy; ?>">

                    <br />

                    <table align="right" style="width: 97% !important;" id="example">


                      <?php

                      $myME_ctr = 0;

                      $event_query = $conn->query("select * from main_event where organizer_id='$session_id' AND sy='$sy'") or die(mysql_error());
                      while ($event_row = $event_query->fetch()) {



                        $myME_ctr++;

                        $main_event_id = $event_row['mainevent_id'];


                        $SEctrQuery = $conn->query("select * FROM sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                        $SECtr = $SEctrQuery->rowCount();

                      ?>

                        <tr>
                          <td colspan="3">

                            <!-- view events feature -->

                            <?php
                            if ($event_row['status'] == "deactivated") { ?>

                              <a style="text-align: left !important; text-indent:7px !important;" data-toggle="collapse" class="btn btn-default btn-block" title="Complete Event name: <?php echo $event_row['event_name']; ?>. This Main Event is deactivated" href="#collapse2<?php echo $main_event_id; ?>"><?php echo $myME_ctr . ". " . substr($event_row['event_name'], 0, 22); ?><span class="badge badge-default pull-right" style="margin-right: 7px !important;"><?php if ($SECtr > 0 and $SECtr < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                              echo $SECtr . " Sub-Event";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } elseif ($SECtr > 1) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                              echo $SECtr . " Sub-Events";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                              echo "0 Sub-Event";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }; ?></span></a>

                            <?php } else { ?>

                              <a title="Complete Event name: <?php echo $event_row['event_name']; ?>" style="text-align: left !important; text-indent:7px !important;" data-toggle="collapse" class="btn btn-info btn-block" href="#collapse2<?php echo $main_event_id; ?>"><?php echo $myME_ctr . ". " . substr($event_row['event_name'], 0, 22); ?><span class="badge badge-warning pull-right" style="margin-right: 7px !important;"><strong><?php if ($SECtr > 0 and $SECtr < 2) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                  echo $SECtr . " Sub-Event";
                                                                                                                                                                                                                                                                                                                                                                                                                                                } elseif ($SECtr > 1) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                  echo $SECtr . " Sub-Events";
                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                  echo "0 Sub-Event";
                                                                                                                                                                                                                                                                                                                                                                                                                                                }; ?></strong></span></a>

                            <?php } ?>

                          </td>



                        </tr>




                        <tr>

                          <td colspan="3">

                            <!-- start of List of sub-events -->

            

                            <div id="collapse2<?php echo $main_event_id; ?>" class="panel-collapse collapse">

                              <table align="right" style="width: 97% !important;" id="example">


                                <tr>

                                  <td colspan="3">

                                    <div id="myGroup<?php echo $main_event_id; ?>">

                                    <?php if ($event_row['status'] == "deactivated") { ?>
                                        <a class="btn btn-default"><i class="icon-list"></i></a>
                                    <?php } else { ?>
                                        <a class="btn btn-info" data-toggle="collapse" data-target="#listSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>">Event List</a>
                                    <?php } ?>

                                    <?php if ($event_row['status'] == "deactivated") { ?>
                                        <a class="btn btn-default"><i class="icon-plus"></i></a>
                                        <a class="btn btn-default"><i class="icon-pencil"></i></a>
                                        <a class="btn default"><i class="icon-trash"></i></a>
                                        <a class="btn btn-default" title="Click to print data of Main Event: <?php echo $event_row['event_name']; ?>" href="print_all_results.php?main_event_id=<?php echo $main_event_id; ?>" data-toggle="collapse" data-target="#edit" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-print"></i></a>
                                        <a class="btn btn-success" data-toggle="collapse" data-target="#ActivateDeactivate<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>" title="Click to activate <?php echo $event_row['event_name']; ?>. Current Status is: Deactivated">Activate</a>
                                       
                                    <?php } else { ?>
                                        <a class="btn btn-primary" data-toggle="collapse" data-target="#addSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>">Add sub-event</a>
                                        <a class="btn btn-success" data-toggle="collapse" data-target="#editEvent<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>">Edit Main Event</a>

                                        <?php if ($event_row['status'] == "activated") { ?>
                                            <a data-toggle="collapse" data-target="#ActivateDeactivate<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>" class="btn btn-warning" title="Click to deactivate <?php echo $event_row['event_name']; ?>. Current Status is: Activated" data-toggle="collapse" data-target="#keys" data-parent="#myGroup<?php echo $main_event_id; ?>">Deactivate</a>
                                        <?php } else if ($event_row['status'] == "deactivated") { ?>
                                            <a data-toggle="collapse" data-target="#ActivateDeactivate<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>" class="btn btn-danger" title="Click to activate <?php echo $event_row['event_name']; ?>. Current Status is: Deactivated" data-toggle="collapse" data-target="#keys" data-parent="#myGroup<?php echo $main_event_id; ?>">Activate</a>
                                        <?php } ?>

                                        <a class="btn btn-danger" data-toggle="collapse" data-target="#deleteEvent<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>">Delete</a>
                                        <a target="_blank" class="btn btn-default" title="Click to print data of Main Event: <?php echo $event_row['event_name']; ?>" href="print_all_results.php?main_event_id=<?php echo $main_event_id; ?>" data-toggle="collapse" data-target="#edit" data-parent="#myGroup<?php echo $main_event_id; ?>">Print</a>
                                    <?php } ?>


                                      <br />

                                      <div style="border: 0px !important;" class="accordion-group">

                                        <div class="collapse indent" id="listSubEvents<?php echo $main_event_id; ?>">

                                          <h4>List of Sub-Events</h4>
                                          <table align="center" class="table table-bordered" id="example">

                                            <thead>
                                              <th><strong>Sub-Event Title</strong></th>
                                              <th>
                                                <center><strong>Status</strong></center>
                                              </th>
                                              <th>
                                                <center><strong>Actions</strong></center>
                                              </th>
                                            </thead>

                                            <?php
                                            $se_ctr = 0;
                                            $sub_event_query = $conn->query("select * from sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                                            while ($sub_event_row = $sub_event_query->fetch()) {
                                              $se_ctr++;
                                              $sub_event_id = $sub_event_row['subevent_id'];   ?>

                                              <tr>

                                                <td>
                                                  <strong><?php echo $se_ctr . ". " . $sub_event_row['event_name']; ?></strong>

                                                  <div id="editMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="panel-collapse collapse">

                                                    <div class="pull-right">
                                                      <table class="table table-bordered">

                                                        <tr>
                                                          <td>
                                                            <h4>Edit Sub-Event Title</h4>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>

                                                            <form method="POST" enctype="multipart/form-data">
                                                              <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_row['subevent_id']; ?>" />
                                                              <input type="hidden" name="se_name" value="<?php echo $sub_event_row['event_name']; ?>" />
                                                              <input type="hidden" name="se_banner" value="<?php echo $sub_event_row['event_banner']; ?>" />
                                                              <input name="se_new_name" type="text" placeholder="Enter Sub-Event Title" value="<?php echo $sub_event_row['event_name']; ?>" /> <br>
                                                              <input type="file" name="se_new_banner" value="<?php echo $sub_event_row['event_banner']?>">
                                                              <br />
                                                              <button style="margin-right: 5px !important;" name="edit_se" class="btn btn-success pull-right"><i class="icon-ok"></i> <strong>UPDATE</strong></button>
                                                            </form>

                                                          </td>
                                                        </tr>
                                                      </table>

                                                    </div>

                                                  </div>

                                                  

                                                  <?php

if (isset($_POST['edit_se'])) {

  $se_name = $_POST['se_name'];
  $sub_event_id = $_POST['sub_event_id'];
  $se_new_name = $_POST['se_new_name'];

  // Check if a new banner is uploaded
  if (isset($_FILES['se_new_banner']) && $_FILES['se_new_banner']['error'] === 0) {
    $se_new_banner = $_FILES['se_new_banner'];

    // Define variables for upload
    $target_directory = 'uploads/';
    $target_file = $target_directory . basename($se_new_banner['name']);
    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $max_file_size = 100 * 1024 * 1024; // 100 MB

    // Validate file
    if (in_array(strtolower($file_extension), $allowed_extensions) && $se_new_banner['size'] <= $max_file_size) {
      // Update query with new banner path
      $conn->query("update sub_event set event_name='$se_new_name', event_banner='$target_file' where subevent_id='$sub_event_id'");
      move_uploaded_file($se_new_banner['tmp_name'], $target_file);
    } else {
      echo '<script>alert("Invalid file format or file size exceeded.");</script>';
    }
  } else {
    // If no new banner uploaded, keep the old one
    $conn->query("update sub_event set event_name='$se_new_name' where subevent_id='$sub_event_id'");
  }

  // Redirect and success message
  ?>
  <script>
    window.location = 'home.php';
    alert('Sub-Event title updated successfully!');
  </script>
  <?php
}
?>

                                                  <br />

                                                  <div id="deleteMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="panel-collapse collapse">

                                                    <div class="pull-right">

                                                      <table class="table table-bordered">

                                                        <tr>
                                                          <td>
                                                            <h4>Delete Sub-Event</h4>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td>

                                                            <?php
                                                            $place_query = $conn->query("select * from sub_results where subevent_id='$sub_event_id'") or die(mysql_error());
                                                            if ($place_query->rowCount() == 0) { ?>

                                                              <form method="POST">

                                                                <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_row['subevent_id']; ?>" />
                                                                <input type="hidden" name="se_name" value="<?php echo $sub_event_row['event_name']; ?>" />

                                                                <input id="myInput" name="entered_pass" type="password" placeholder="Enter Organizer's Password" />
                                                                <br />
                                                                <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionDSE()" /> <strong>Show Password</strong></p>


                                                                <script>
                                                                  function myFunctionDSE() {
                                                                    var x = document.getElementById("myInput");
                                                                    if (x.type === "password") {
                                                                      x.type = "text";
                                                                    } else {
                                                                      x.type = "password";
                                                                    }
                                                                  }
                                                                </script>


                                                                <br />
                                                                <button style="margin-right: 5px !important;" name="deleteSubEvent" class="btn btn-danger pull-right"><i class="icon-ok"></i> <strong>DELETE</strong></button>
                                                              </form>

                                                            <?php } else { ?>
                                                              <div class="alert alert-warning">
                                                                <h3>Cannot delete Sub-Event. There are saved data for this Sub-Event.</h3>
                                                              </div>

                                                            <?php } ?>


                                                          </td>
                                                        </tr>
                                                      </table>

                                                    </div>

                                                  </div>


                                                  <?php

                                                  if (isset($_POST['deleteSubEvent'])) {

                                                    $sub_event_id = $_POST['sub_event_id'];
                                                    $entered_pass = $_POST['entered_pass'];
                                                    $se_name = $_POST['se_name'];

                                                    if ($check_pass == $entered_pass) {

                                                      $conn->query("delete from sub_event where subevent_id='$sub_event_id'");

                                                      $conn->query("delete from contestants where subevent_id='$sub_event_id'");

                                                      $conn->query("delete from criteria where subevent_id='$sub_event_id'");

                                                      $conn->query("delete from judges where subevent_id='$sub_event_id'");

                                                  ?>


                                                      <script>
                                                        window.location = 'home.php';
                                                        alert('Sub-Event: <?php echo $se_name; ?> and its related data deleted successfully. . .');
                                                      </script>


                                                    <?php } else { ?>

                                                      <script>
                                                        window.location = 'home.php';
                                                        alert('Bad Password! Try Again');
                                                      </script>


                                                  <?php }
                                                  }  ?>


                                                </td>

                                                <?php
                                                if ($sub_event_row['status'] == "activated") { ?>

                                                  <td width="10">
                                                    <center><strong><i style="color: green;">Active</i></strong></center>
                                                  </td>

                                                  <td width="175">
                                                    <center>

                                                      <a title="Click to Deactivate <?php echo $sub_event_row['event_name']; ?>. Current Status: Active" target="_blank" onclick="javascript: setTimeout(window.close, 10);" href="sub_event_stat_update.php?status=<?php echo $sub_event_row['status']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>&sub_event_id=<?php echo $sub_event_row['subevent_id']; ?>" class="btn btn-danger"><i class="icon icon-off"></i></a>

                                                      <a title="Click to view <?php echo $sub_event_row['event_name']; ?> Data and Settings" href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_row['subevent_id']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>" class="btn btn-primary"><i class="icon icon-cog"></i></a>


                                                      <a title="Click to edit <?php echo $sub_event_row['event_name']; ?>'s Title" data-toggle="collapse" data-target="#editMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a>



                                                      <a data-toggle="collapse" data-target="#deleteMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" title="Click to delete <?php echo $sub_event_row['event_name']; ?>." class="btn btn-danger"><i class="icon icon-trash"></i></a>

                                                    </center>
                                                  </td>

                                                <?php } else {  ?>

                                                  <td width="10">
                                                    <center><strong><i>Inactive</i></strong></center>
                                                  </td>

                                                  <td width="175">
                                                    <center>
                                                      <a title="Click to Activate <?php echo $sub_event_row['event_name']; ?>. Current Status: Deactive" target="_blank" onclick="javascript: setTimeout(window.close, 10);" href="sub_event_stat_update.php?status=<?php echo $sub_event_row['status']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>&sub_event_id=<?php echo $sub_event_row['subevent_id']; ?>" class="btn btn-success"><i class="icon icon-off"></i></a>
                                                      <a class="btn btn-default"><i class="icon icon-cog"></i></a>
                                                      <a class="btn btn-default"><i class="icon icon-pencil"></i></a>
                                                      <a class="btn btn-default"><i class="icon icon-trash"></i></a>

                                                    </center>
                                                  </td>

                                                <?php } ?>

                                              </tr>

                                            <?php }
                                            if ($se_ctr > 0) { ?>


                                            <?php } else { ?>

                                              <tr>
                                                <td colspan="3">
                                                  <div class="alert alert-warning">
                                                    <h3>
                                                      No data to display. Add Sub-Event <a href="#" data-toggle="collapse" data-target="#addSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"> here &raquo;</a>
                                                    </h3>
                                                  </div>
                                                </td>
                                              </tr>

                                            <?php } ?>
                                          </table>


                                        </div>

                                        <div class="collapse" id="ActivateDeactivate<?php echo $main_event_id; ?>">

                                          <?php if ($event_row['status'] == "activated") { ?>
                                            <h4>Deactivate Event <i><?php echo $event_row['event_name']; ?></i>?</h4>
                                            <?php } else {
                                            if ($event_row['status'] == "deactivated") { ?>
                                              <h4>Activate Event <i><?php echo $event_row['event_name']; ?></i>?</h4>
                                          <?php }
                                          } ?>


                                          <table align="center" class="table table-bordered" id="example">
                                            <tr>
                                              <td>

                                                <form method="POST">

                                                  <input name="status" type="hidden" value="<?php echo $event_row['status']; ?>" />
                                                  <input name="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
                                                  <input name="ma_name" type="hidden" value="<?php echo $event_row['event_name']; ?>" />



                                                  <?php
                                                  if ($event_row['status'] == "activated") { ?>


                                                    <div class="modal-body">
                                                      <strong>Confirmation Password</strong>:<br />
                                                      <input placeholder="Enter Organizer's Password" name="check_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true" />
                                                    </div>

                                                    <div class="modal-footer">
                                                      <button class="btn btn-danger" name="activation"><i class="icon icon-eye-close"></i> <strong>DEACTIVATE</strong></button>
                                                    </div>


                                                    <?php
                                                  } else {
                                                    if ($event_row['status'] == "deactivated") {
                                                    ?>

                                                      <div class="modal-body">
                                                        <strong>Confirmation Password</strong>:<br />
                                                        <input placeholder="Enter Organizer's Password" name="check_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true" />
                                                      </div>

                                                      <div class="modal-footer">
                                                        <button class="btn btn-success" name="activation"><i class="icon icon-eye-open"></i> <strong>ACTIVATE</strong></button>
                                                      </div>


                                                  <?php }
                                                  } ?>

                                                </form>

                                              </td>
                                            </tr>
                                          </table>

                                        </div>

                                        <div class="collapse indent" id="addSubEvents<?php echo $main_event_id; ?>">

                                          <!-- ADD Sub-Events -->

                                          <h4>Add Sub-Events</h4>
                                          <table align="center" class="table table-bordered" id="example">
                                            <tr>
                                              <td>

                                              <form id="subEventForm" method="POST" enctype="multipart/form-data">
                                                  <input name="main_event_id" id="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
                                                  <strong>Sub-Event Title</strong>:<br />
                                                  <input placeholder="Enter Sub-Event title" name="sub_event_name" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true" />
                                                  <br />
                                                  <strong>Date</strong>:<br />
                                                  <input name="event_date" id="event_date" class="form-control btn-block" style="height: 30px !important;" type="date" required="true" />
                                                  <br />
                                                  <strong>Time</strong>:<br />
                                                  <input placeholder="hh:mm" name="event_time" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="time" required="true" />
                                                  <br />
                                                  <strong>Type of Event</strong>:<br />
                                                  <div class="form-group">
                                                    <select class="form-control btn-block" name="event_type" id="exampleFormControlSelect1" placeholder="Type of Event" required>
                                                      <option value="" disabled selected hidden>Type of Event</option>
                                                      <option>Academic</option>
                                                      <option>Non-Academic</option>
                                                    </select>
                                                  </div>
                                                  <strong>Venue</strong>:<br />
                                                  <textarea placeholder="Enter Sub-Event Venue" rows="2" name="event_place" class="form-control btn-block" style="text-indent: 7px !important;" required="true"></textarea>
                                                  <br />
                                                  <strong>Sub Event Banner </strong><br>
                                                  <input class="form-control" type="file" name="banner"><br>
                                                  <div class="modal-footer">
                                                    <button name="add_event" id="save_button" class="btn btn-success"><i class="icon-ok"></i> <strong>SAVE</strong></button>
                                                    <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
                                                  </div>
                                                </form>

                                              </td>
                                            </tr>
                                          </table>

                                          <!-- End of ADD Sub-Events -->

                                        </div>
                                        <script>
                                          $(document).ready(function() {
                                              var dateIsValid = true;  // a flag to keep track of date validation

                                              $('#event_date').change(function() {
                                                  var selectedDate = $(this).val();
                                                  var mainEventId = $('#main_event_id').val();

                                                  $.ajax({
                                                      type: 'POST',
                                                      url: 'date_validation.php', 
                                                      data: {
                                                          main_event_id: mainEventId,
                                                          selected_date: selectedDate
                                                      },
                                                      success: function(response) {
                                                          console.log(response);
                                                          
                                                          if (response === 'valid') {
                                                              dateIsValid = true;
                                                          } else {
                                                              dateIsValid = false;
                                                              alert('Date does not fall within the scheduled date range');
                                                          }
                                                      }
                                                  });
                                              });

                                              
                                              $('#subEventForm').on('submit', function(e) {
                                                  if (!dateIsValid) {
                                                      e.preventDefault(); 
                                                      alert('Date does not fall within the scheduled date range');
                                                  }
                                              });
                                          });

                                        </script>

                                        <div class="collapse indent" id="editEvent<?php echo $main_event_id; ?>">

                                          <!-- start of edit of main events -->

                                          <h4>Edit Event Details</h4>
                                          <table align="center" class="table table-bordered" id="example">
                                            <tr>
                                              <td>

                                                <form method="POST">


                                                  <?php
                                                  $edit_event_query = $conn->query("select * from main_event where organizer_id='$session_id' and mainevent_id='$main_event_id'") or die(mysql_error());
                                                  while ($edit_event_row = $edit_event_query->fetch()) {
                                                    $edit_mainevent_id = $edit_event_row['mainevent_id'];


                                                  ?>


                                                    <input name="main_event_id" type="hidden" value="<?php echo $edit_mainevent_id; ?>" />

                                                    <strong>Event Name:</strong><br />
                                                    <input type="text" name="main_event" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" placeholder="Event Name" required="true" value="<?php echo $edit_event_row['event_name']; ?>" />
                                                    <br />

                                                    <strong>Date Start:</strong><br />
                                                    <input type="date" name="date_start" class="form-control btn-block" style="height: 30px !important;" required="true" value="<?php echo $edit_event_row['date_start']; ?>" />
                                                    <br />

                                                    <strong>Date End:</strong><br />
                                                    <input type="date" name="date_end" class="form-control btn-block" style="height: 30px !important;" required="true" value="<?php echo $edit_event_row['date_end']; ?>" />
                                                    <br />

                                                    <strong>Venue:</strong><br />
                                                    <textarea placeholder="Enter Sub-Event Venue" rows="2" name="place" class="form-control btn-block" style="text-indent: 7px !important;" required="true"><?php echo $edit_event_row['place']; ?></textarea>
                                                    
                                             



                                                  <?php } ?>

                                                  <div class="modal-footer">
                                                    <button name="edit_event" class="btn btn-success"><i class="icon-ok"></i> <strong>UPDATE</strong></button>
                                                  </div>

                                                </form>

                                              </td>
                                            </tr>
                                          </table>


                                          <!-- end of edit of main events -->
                                        </div>

                                        <div class="collapse" id="deleteEvent<?php echo $main_event_id; ?>">

                                          <h4>Delete Event <i><?php echo $event_row['event_name']; ?></i>?</h4>


                                          <?php
                                          $place_query = $conn->query("select * from sub_results where mainevent_id='$main_event_id'") or die(mysql_error());
                                          if ($place_query->rowCount() == 0) { ?>

                                            <table align="center" class="table table-bordered" id="example">
                                              <tr>
                                                <td>

                                                  <form method="POST">


                                                    <input name="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
                                                    <input name="ma_name" type="hidden" value="<?php echo $event_row['event_name']; ?>" />

                                                    <div class="modal-body">
                                                      <strong>Confirmation Password</strong>:<br />
                                                      <input placeholder="Enter Organizer's Password" name="entered_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true" />
                                                    </div>

                                                    <div class="modal-footer">
                                                      <button class="btn btn-danger" name="deleteEvent"><i class="icon-trash"></i> <strong>DELETE</strong></button>
                                                    </div>




                                                  </form>

                                                </td>
                                              </tr>
                                            </table>

                                          <?php } else { ?>
                                            <div class="alert alert-warning">
                                              <h3>Cannot delete event. There are saved data for this event.</h3>
                                            </div>

                                          <?php } ?>

                                        </div>

                                      </div>

                                    </div>
                                  </td>


                                </tr>

                              </table>

                            </div>



                            <!-- End of List of sub-events -->


                          </td>
                        </tr>

                      <?php  } ?>

                    </table>

                  </div>

                </td>
              </tr>


            <?php  }  ?>

          </table>





          <?php
          $displayError = false; // Initialize the variable
          if (isset($_POST['create'])) {
            $event_name = $_POST['main_event'];
            $date_start = $_POST['date_start'];
            $date_end = $_POST['date_end'];
            $event_place = $_POST['place'];
            $event_sy = $_POST['sy'];
            $event_sy2 = $_POST['sy2'];

            function validateYearRange($fromYear, $toYear)
            {
              if ($fromYear == -1 || $toYear == -1) {
                return false;
              }

              // Convert years to integers for comparison
              $fromYear = intval($fromYear);
              $toYear = intval($toYear);

              if (abs($toYear - $fromYear) !== 1) {
                return false;
              }
              return true;
            }

            function validateDateRange($startDate, $endDate)
            {
              $startTimestamp = strtotime($startDate);
              $endTimestamp = strtotime($endDate);

              if ($startTimestamp > $endTimestamp) {
                return false;
              }
              return true;
            }

            if (($event_sy2 - $event_sy) === 1 && $event_sy2 > $event_sy && validateDateRange($date_start, $date_end)) {
              $org_query = $conn->query("select * from main_event where organizer_id='$session_id'") or die(mysql_error());
              $num_row = $org_query->rowCount();
              if ($num_row > 0) {
                  $conn->query("insert into main_event(event_name,status,organizer_id,date_start,date_end,place,sy,sy2)
                  values('$event_name','activated','$session_id','$date_start','$date_end','$event_place','$event_sy', '$event_sy2')");
              } else {
                  $conn->query("insert into main_event(event_name,status,organizer_id,date_start,date_end,place,sy,sy2)
                  values('$event_name','activated','$session_id','$date_start','$date_end','$event_place','$event_sy', '$event_sy2')");
              }
              ?>
               <script>
            alert('Event <?php echo $event_name; ?> successfully added...');
            window.location = 'home.php';
        </script>
        <?php
    } else {
        // Redirect with error query parameter
        $displayError = true; // Set the error flag
    }
}

// Check for error query parameter
if ($displayError) {
  echo "<script>alert('Invalid year range or date range');</script>";
}
?>




          <?php

          if (isset($_POST['add_event'])) {

            $main_event_id = $_POST['main_event_id'];
            $sub_event_name = $_POST['sub_event_name'];
            $event_date = $_POST['event_date'];
            $event_time = $_POST['event_time'];
            $event_place = $_POST['event_place'];
            $event_type = $_POST['event_type'];
            $subevent_banner = $_FILES['banner']['name'];
            $target_directory = 'uploads/';
            $target_file = $target_directory . basename($subevent_banner);
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            $max_file_size = 100 * 1024 * 1024; // 100 MB
            if (in_array(strtolower($file_extension), $allowed_extensions) && $_FILES['banner']['size'] <= $max_file_size) {
              $conn->query("insert into sub_event(mainevent_id,event_name,status,eventdate,eventtime,event_type,place,event_banner,organizer_id)
  values('$main_event_id','$sub_event_name','deactivated','$event_date','$event_time','$event_type', '$event_place','$target_file','$session_id')");

              move_uploaded_file($_FILES['banner']['tmp_name'], $target_file);
            } else {
              echo '<script>alert("Invalid file format or file size exceeded.");</script>';
            }

          ?>
            <script>
              window.location = 'home.php';
              alert('Sub-Event <?php echo $sub_event_name; ?> created successfully!');
            </script>
          <?php } ?>



          <?php
if (isset($_POST['activation'])) {
    // Assuming $check_pass is defined somewhere securely, e.g., from a database
    // $check_pass = 'your_secure_password';

    $status = $_POST['status'];
    $main_event_id = $_POST['main_event_id'];
    $check_pass2 = $_POST['check_pass'];
    $ma_name = $_POST['ma_name']; // Assuming this is used for something else in your code

    if ($check_pass == $check_pass2) {
        // Toggle the status based on the current status
        $new_status = ($status == "activated") ? 'deactivated' : 'activated';
        $update_main_event = $conn->query("UPDATE main_event SET status='$new_status' WHERE mainevent_id='$main_event_id'");
        $update_sub_event = $conn->query("UPDATE sub_event SET status='$new_status' WHERE mainevent_id='$main_event_id'");

        if ($update_main_event && $update_sub_event) {
            // Success message
            $alertMessage = ($status == "activated") ? "Event deactivated successfully." : "Event activated successfully.";
            echo "<script>alert('$alertMessage'); window.location = 'home.php';</script>";
        } else {
            // Database error handling
            echo "<script>alert('Database error. Unable to update event status.'); window.location = 'home.php';</script>";
        }
    } else {
        // Password mismatch
        echo "<script>alert('Password mismatch. Unable to change event status.'); window.location = 'home.php';</script>";
    }
}

// Check for error query parameter
if (isset($_GET['error']) && $_GET['error'] == 'true') {
    echo "<script>alert('Invalid year range or date range');</script>";
}
?>





          <?php

          if (isset($_POST['edit_event'])) {

            $main_event_id = $_POST['main_event_id'];
            $event_name = $_POST['main_event'];
            $date_start = $_POST['date_start'];
            $date_end = $_POST['date_end'];
            $event_place = $_POST['place'];

            $conn->query("update main_event set event_name='$event_name',date_start='$date_start',date_end='$date_end',place='$event_place' where mainevent_id='$main_event_id'");
          ?>
            <script>
              window.location = 'home.php';
              alert('Event <?php echo $event_name; ?> updated successfully!');
            </script>
          <?php } ?>



          <?php

          if (isset($_POST['deleteEvent'])) {

            $main_event_id = $_POST['main_event_id'];

            $entered_pass = $_POST['entered_pass'];
            $ma_name = $_POST['ma_name'];

            if ($entered_pass == $check_pass) {
              $delquery = $conn->query("select * from sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
              while ($del_row = $delquery->fetch()) {

                $sub_event_id = $del_row['subevent_id'];

                $conn->query("delete from contestants where subevent_id='$sub_event_id'");

                $conn->query("delete from criteria where subevent_id='$sub_event_id'");

                $conn->query("delete from judges where subevent_id='$sub_event_id'");

                $conn->query("delete from sub_results where subevent_id='$sub_event_id'");
              }

              $conn->query("delete from sub_event where mainevent_id='$main_event_id'");

              $conn->query("delete from main_event where mainevent_id='$main_event_id'");

          ?>


              <script>
                window.location = 'home.php';
                alert('Event: <?php echo $ma_name; ?> and its Sub-Events and related data deleted successfully. . .');
              </script>

            <?php  } else { ?>

              <script>
                alert('Confirmation did not match. Try again.');
                window.location = 'home.php';
              </script>


          <?php }
          }  ?>





        </div>

      </section>


    </div>
  </div>

  <?php include('footer.php'); ?>


  <script>
    $('.yearpicker').yearpicker()
  </script>

<script>
   $(document).ready(function() {
    // Check if the section is collapsed or not in sessionStorage
    var isCollapsed = sessionStorage.getItem('collapse2<?php echo $main_event_id; ?>');

    if (isCollapsed === "shown") {
        $('#collapse2<?php echo $main_event_id; ?>').addClass('show'); // Changed from 'in' to 'show' for Bootstrap 4+
    }

    // Listen for collapse events
    $('#collapse2<?php echo $main_event_id; ?>').on('shown.bs.collapse', function() {
        sessionStorage.setItem('collapse2<?php echo $main_event_id; ?>', 'shown');
    }).on('hidden.bs.collapse', function() {
        sessionStorage.setItem('collapse2<?php echo $main_event_id; ?>', 'hidden');
    });
});
</script>


<script>
                      function resetForm() {
                          document.getElementsByName('main_event')[0].value = '';
                          document.getElementsByName('sy')[0].value = '';
                          document.getElementsByName('sy2')[0].value = '';
                          document.getElementsByName('date_start')[0].value = '';
                          document.getElementsByName('date_end')[0].value = '';
                          document.getElementsByName('place')[0].value = '';
                      }
</script>




 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/holder/holder.js"></script>
  <script src="assets/js/google-code-prettify/prettify.js"></script>
  <script src="assets/js/application.js"></script>
  <script src="yearpicker.js"></script>
  








</body>

</html>