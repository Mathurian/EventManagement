 

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    $contestant_id=$_GET['contestant_id'];
     
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
    <p class="lead">SWU-ETS</p>
  </div>
</header>
    <div class="container">

   <form method="POST">
    <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 <input value="<?php echo $contestant_id; ?>" name="contestant_id" type="hidden" />
 
  
   <div class="col-lg-3">
   </div>
   <div class="col-lg-6">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Edit Contestant</h3>
            </div>
 
 


 
     <div class="panel-body">
  
   <table align="center">
  
  
  <?php    
   	$cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_id='$contestant_id'");
    while ($cont_row = $cont_query->fetch()) 
        { ?>
   <tr>
    
  
   <td>&nbsp;</td>
   <td>
    <strong> Contestant Last Name </strong> <br />
    <input name="lname" type="text" class="form-control" value="<?php echo $cont_row['lname']; ?>" />

    <strong> Contestant First Name </strong> <br />
    <input name="fname" type="text" class="form-control" value="<?php echo $cont_row['fname']; ?>" />

    <strong> Contestant Middle Name </strong> <br />
    <input name="mname" type="text" class="form-control" value="<?php echo $cont_row['mname']; ?>" />

    <strong> Contestant Department </strong> <br />
    <input name="department" type="text" class="form-control" value="<?php echo $cont_row['department']; ?>" />

    <strong> Contestant Contact </strong> <br />
    <input name="contact" type="text" class="form-control" value="<?php echo $cont_row['contact']; ?>" />

    
   </td>
   </tr>
  <?php } ?>
  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3" align="right"><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;<button name="edit_contestant" class="btn btn-success">Update</button></td>
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
// ... (earlier code)

if(isset($_POST['edit_contestant']))
{
    // Fetch data from POST request
    $se_name = $_POST['se_name'];
    $sub_event_id = $_POST['sub_event_id'];
    $contestant_id = $_POST['contestant_id'];
    $lastname = $_POST['lname'];
    $firstname = $_POST['fname'];
    $middlename = $_POST['mname'];
    $department = $_POST['department'];
    $contact = $_POST['contact'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE contestants SET lname = :lastname, fname = :firstname, mname = :middlename, department = :department, contact = :contact WHERE contestant_id = :contestant_id");

    // Bind parameters
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':middlename', $middlename);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':contestant_id', $contestant_id, PDO::PARAM_INT);

    // Execute and check for success
    if($stmt->execute()) {
        echo "<script>
                alert('Contestant updated successfully!');
                window.location = 'sub_event_details_edit.php?sub_event_id={$sub_event_id}&se_name={$se_name}';
              </script>";
    } else {
        echo "<script>alert('Error updating contestant.');</script>";
    }
}
// ... (rest of the code)
?>

  
  
<?php include('footer.php'); ?>


  
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
