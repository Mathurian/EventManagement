 

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    $crit_id=$_GET['crit_id'];
     
  ?>
  
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
    <p class="lead">Judging Management System</p>
  </div>
</header>
    <div class="container">

    <form method="POST" id="criteriaForm">

    <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 <input value="<?php echo $crit_id; ?>" name="crit_id" type="hidden" />
 
  
   <div class="col-lg-3">
   </div>
   <div class="col-lg-6">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Edit Criteria</h3>
            </div>
 
 


 
     <div class="panel-body">
  
   <!-- ... [Rest of your HTML and PHP code above this line] ... -->

<table align="center">
<?php    
$crit_query = $conn->query("SELECT * FROM criteria WHERE criteria_id='$crit_id'") or die(mysql_error());
while ($crit_row = $crit_query->fetch()) { ?>
    <tr>
        <td>
            Criteria no. <br />
            <span class="form-control" style="display:inline-block; width: auto; padding: 6px 12px;"><?php echo $crit_row['criteria_ctr']; ?></span>
            <!-- Hidden input to pass crit_ctr value with POST data -->
            <input type="hidden" name="crit_ctr" value="<?php echo $crit_row['criteria_ctr']; ?>" />
        </td>
        <td>&nbsp;</td>
        <td>
            Criteria <br />
            <input name="criteria" type="text" class="form-control" value="<?php echo $crit_row['criteria']; ?>" />
        </td>
        <td>&nbsp;</td>
        <td>
            Percentage <br />
            <input name="percentage" type="text" class="form-control" value="<?php echo $crit_row['percentage']; ?>" />
        </td>
    </tr>
<?php } ?>


    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5" align="right"><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;<button name="edit_crit" class="btn btn-success">Update</button></td>
    </tr>
</table>



 
</div>
 
          </div>
          
        
  </div>
  
 <div class="col-lg-3">
   </div>
 
</form>
          </div>
          
          
<?php 

if(isset($_POST['edit_crit'])) {
    
  $se_name = $_POST['se_name'];
  $sub_event_id = $_POST['sub_event_id'];
  $crit_id = $_POST['crit_id'];
  $percentage = $_POST['percentage'];
  $crit_ctr = $_POST['crit_ctr'];
  $criteria = $_POST['criteria'];

  // Fetch total percentage from the database, excluding the current criteria being updated
  $stmt = $conn->prepare("SELECT SUM(percentage) as total_percentage FROM criteria WHERE subevent_id = :sub_event_id AND criteria_id != :crit_id");
  $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
  $stmt->bindParam(':crit_id', $crit_id, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  $existingPercentage = $data['total_percentage'];

  if ($existingPercentage + $percentage > 100) {
      // If total percentage exceeds 100% after the update
      echo '<script>
          alert("The updated percentage causes the total to exceed 100%. Please adjust the criteria percentage.");
          window.history.back();
      </script>';
      exit;
  } else {
      // If everything is fine, proceed with the update
      $conn->query("UPDATE criteria SET criteria='$criteria', criteria_ctr='$crit_ctr', percentage='$percentage' WHERE criteria_id='$crit_id'");
      
      echo '<script>
          window.location = "sub_event_details_edit.php?sub_event_id='.$sub_event_id.'&se_name='.$se_name.'";
          alert("Criteria '.$criteria.' updated successfully!");
      </script>';
  }
}
?>
  
  
<?php include('footer.php'); ?>


    
  </body>
</html>
