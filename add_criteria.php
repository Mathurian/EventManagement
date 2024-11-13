<!DOCTYPE html>
 <html lang="en">

 <?php
  include('header.php');
  include('session.php');


  $sub_event_id = $_GET['sub_event_id'];
  $se_name = $_GET['se_name'];


  ?>
 <script type="text/javascript" src="bootstrap/js/jquery-latest.js"></script>

 <body>
   <!-- Navbar
    ================================================== -->
   <div class="navbar navbar-inverse navbar-fixed-top">
     <div class="navbar-inner">
       <div class="container">


       </div>
     </div>
   </div>
   <header class="jumbotron subhead" id="overview">
     <div class="container">
       <h1><?php echo $se_name; ?> Settings</h1>
       <p class="lead">SWU-ETS</p>
     </div>
   </header>


   <div class="container">

     <div class="span12">



       <br />
       <div class="col-md-12">
         <ul class="breadcrumb">


           <li><a href="home.php">Event Management</a></li>

           <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>

           <li>Add Criteria</li>

         </ul>
       </div>



    <?php
      $stmt = $conn->prepare("SELECT COUNT(subevent_id) as criteria_count FROM criteria WHERE subevent_id = :sub_event_id");
      $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      $current_criteria_count = $data['criteria_count'];
    ?>

       <form method="POST">
         <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
         <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />



         <table align="center" style="width: 45% !important;">
           <tr>
             <td>


               <div style="width: 100% !important;" class="panel panel-primary">

                 <div class="panel-heading">
                   <h3 class="panel-title">Add Criteria</h3>
                 </div>

                 <div class="panel-body">

                   <table align="center">



                     <tr>

                       <td>
                       <div id="main">
    <div class="my-formxj">
        <p class="text-boxxj">
        <?php for($i = $current_criteria_count + 1; $i <= $current_criteria_count + 1; $i++): ?>
          <label for="boxxj1">Criteria No. <span class="boxxj-number"><?php echo $current_criteria_count + 1; ?></span></label> <br />
            <input type="text" name="crit<?php echo $i; ?>" placeholder="Description" value="" id="boxxj<?php echo $i; ?>" required> <br />
            <input type="number" style="margin-top: 5px !important;" name="cp<?php echo $i; ?>" placeholder="Criteria Percentage" value="" id="boxxj<?php echo $i; ?>" required><br>       
        <?php endfor; ?>
        </p>
        <p><a class="add-boxxj" href="#">Add Criteria</a></p>
    </div>
</div>



                         <script type="text/javascript">
                              jQuery(document).ready(function($) {
                              $('.my-formxj .add-boxxj').click(function() {
                                  // Get the last criteria number
                                  var lastNumber = parseInt($('.text-boxxj:last .boxxj-number').text(), 10);
                                  var nextNumber = lastNumber + 1;

                                  if (nextNumber > 5) {
                                      alert('Maximum Number of Criteria reach!');
                                      return false;
                                  }

                                  var boxxj_html = $('<p class="text-boxxj"><label for="boxxj' + nextNumber + '">Criteria No. <span class="boxxj-number">' + nextNumber + '</span></label> <br /> <input type="text" name="crit' + nextNumber + '" placeholder="Description" value="" id="boxxj' + nextNumber + '" required="true" /> <br /> <input type="number" min="0" style="margin-top: 5px !important;" name="cp' + nextNumber + '" placeholder="Criteria Percentage" value="" id="boxxj' + nextNumber + '" required="true" /> <br />  <a href="#" class="remove-boxxj">Remove</a ></p>');
                                  
                                  boxxj_html.hide();
                                  $('.my-formxj p.text-boxxj:last').after(boxxj_html);
                                  boxxj_html.fadeIn('slow');

                                  return false;
                              });

                              $('.my-formxj').on('click', '.remove-boxxj', function() {
                                  $(this).parent().css('background-color', '#FF6C6C');
                                  $(this).parent().fadeOut("slow", function() {
                                      $(this).remove();
                                      $('.boxxj-number').each(function(index) {
                                          $(this).text(index + 1);
                                      });
                                  });
                                  return false;
                              });
                          });

                         </script>


                     <tr>
                       <td colspan="5">&nbsp;</td>
                     </tr>
                     <tr>
                       <td colspan="5" align="right"><button name="add_crit" class="btn btn-primary">Save</button> <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-default">Back</a>&nbsp;</td>
                     </tr>
                   </table>
       </form>
     </div>

   </div>
   </td>
   </tr>
   </table>
   </div>

   </div>
   <?php

if (isset($_POST['add_crit'])) {
    $criteria_names = [];
    $criteria_percentages = [];
    $totalPercentage = 0;

    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["crit{$i}"], $_POST["cp{$i}"])) {
            $criteria_names[] = $_POST["crit{$i}"];
            $criteria_percentages[] = $_POST["cp{$i}"];
            $totalPercentage += $_POST["cp{$i}"];
        }
    }
    $stmt = $conn->prepare("SELECT SUM(percentage) as total_percentage FROM criteria WHERE subevent_id = :sub_event_id");
    $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $existingTotalPercentage = (int)$data['total_percentage'];
    
    if ($existingTotalPercentage + $totalPercentage > 100) {
        echo '<script>
                alert("The total percentage exceeds 100%. Please adjust the criteria percentage.");
                window.history.back();
              </script>';
        exit;
    }

    if ($data['exist'] > 0 && $data['total_percentage'] == 100) {
        echo '<script>
                window.location = "sub_event_details_edit.php?sub_event_id=' . $sub_event_id . '&se_name=' . $se_name . '";
                alert("Criteria is already 100 percent!");
              </script>';
    } else {
        $stmt = $conn->prepare("SELECT COALESCE(MAX(criteria_ctr), 0) as max_ctr FROM criteria WHERE subevent_id = :sub_event_id");
        $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
        $stmt->execute();
        $maxCtrData = $stmt->fetch(PDO::FETCH_ASSOC);
        $criteria_ctr = $maxCtrData['max_ctr'] + 1; 
        $insert_stmt = $conn->prepare("INSERT INTO criteria(criteria, subevent_id, percentage, criteria_ctr) VALUES (:name, :sub_event_id, :percentage, :criteria_ctr)");

        for ($i = 0; $i < 5; $i++) {
            if (!empty($criteria_names[$i]) && $criteria_percentages[$i] > 0) {
                $insert_stmt->bindValue(':name', $criteria_names[$i], PDO::PARAM_STR);
                $insert_stmt->bindValue(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
                $insert_stmt->bindValue(':percentage', $criteria_percentages[$i], PDO::PARAM_INT);
                $insert_stmt->bindValue(':criteria_ctr', $criteria_ctr, PDO::PARAM_INT);
                $insert_stmt->execute();
                $criteria_ctr++;  
            }
        }

        echo '<script>
                window.location = "sub_event_details_edit.php?sub_event_id=' . $sub_event_id . '&se_name=' . $se_name . '";
                alert("Criteria has been added successfully!");
              </script>';
    }
}
?>




   <?php include('footer.php'); ?>



   <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
 </body>

 </html>