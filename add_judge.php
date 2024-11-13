<?php 
function randomcode() {
$var = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$code = '' ;
while ($i <= 5) {
$num = rand() % 33;
$tmp = substr($var, $num, 1);
$code = $code . $tmp;
$i++;
}
return $code;
}



function randomcode2() {
$var2 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i2 = 0;
$code2 = '' ;
while ($i2 <= 5) {
$num2 = rand() % 33;
$tmp2 = substr($var2, $num2, 1);
$code2 = $code2 . $tmp2;
$i2++;
}
return $code2;
}
 

function randomcode3() {
$var3 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i3 = 0;
$code3 = '' ;
while ($i3 <= 5) {
$num3 = rand() % 33;
$tmp3 = substr($var3, $num3, 1);
$code3 = $code3 . $tmp3;
$i3++;
}
return $code3;
}  



function randomcode4() {
$var4 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i4 = 0;
$code4 = '' ;
while ($i4 <= 5) {
$num4 = rand() % 33;
$tmp4 = substr($var4, $num4, 1);
$code4 = $code4 . $tmp4;
$i4++;
}
return $code4;
}
 
?>

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];

    
     
     
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
                        
                        <li>Add Judge</li>   
                    </ul>
                </div>
                <?php
                  $query = $conn->query("SELECT COUNT(*) as judge_count FROM judges WHERE subevent_id='$sub_event_id'");
                  $row = $query->fetch();
                  $currentJudgeCountInDB = $row['judge_count'];

                  $nextJudgeNumber = $currentJudgeCountInDB + 1;
                ?>





   <form method="POST">
   <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
   <input name="code1" type="hidden" value="<?php echo randomcode(); ?>" />
  <input name="code2" type="hidden" value="<?php echo randomcode2(); ?>" />
  <input name="code3" type="hidden" value="<?php echo randomcode3(); ?>" />
  <input name="code4" type="hidden" value="<?php echo randomcode4(); ?>" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 
  
<table align="center" style="width: 40% !important;">
 <tr>
 <td>
 

 <div style="width: 100% !important;" class="panel panel-primary">
 
            <div class="panel-heading">
              <h3 class="panel-title">Add Judge</h3>
            </div>
     <div class="panel-body">
 
   <table align="center">
   <tr>
   <td>
   <div id="main">
     
     <div class="my-formx">
       
     <p class="text-boxx">
    <label for="boxx1">Judge <?php echo $nextJudgeNumber; ?> </label> <br />
    <input type="text" name="jud1" placeholder="Judge Fullname" value="" id="boxx1"> <br />
</p>

             <p><a class="add-boxx" href="#">Add Judge</a></p>
       
     </div>
 </div>
  
 <script type="text/javascript">
  jQuery(document).ready(function($) {
    let maxJudges = 10;
    let currentJudgeCount = <?php echo $currentJudgeCountInDB; ?> + 1; 
    let availableSlots = maxJudges - currentJudgeCount; 
    let nextJudgeNumber = <?php echo isset($nextJudgeNumber) ? $nextJudgeNumber : 1; ?>;
    
    $(document).on('click', '.my-formx .add-boxx', function(event) {
        event.preventDefault();

        if (availableSlots <= 0) {
            alert('Maximum Number of Judges reached!');
            return false;
        }
        currentJudgeCount++; 
        availableSlots--;   
        nextJudgeNumber++;

        let boxx_html = $('<p class="text-boxx"><label for="boxx' + currentJudgeCount + '">Judge ' + nextJudgeNumber + ' </label> <br /> <input type="text" placeholder="Judge Fullname" name="jud' + currentJudgeCount + '" value="" id="boxx' + currentJudgeCount + '" required="true" /> <br /> <a href="#" class="remove-boxx">Remove</a></p>');
        boxx_html.hide();
        $('.my-formx p.text-boxx:last').after(boxx_html);
        boxx_html.fadeIn('slow');

        return false;
    });

    $(document).on('click', '.my-formx .remove-boxx', function(event) {
        event.preventDefault();  
        const currentBox = $(this).parent();
        currentBox.css('background-color', '#FF6C6C');
        currentBox.fadeOut("slow", function() {
            currentBox.remove();
            currentJudgeCount--;  
            availableSlots++;    
        });

        return false;
    });
});


</script>







  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  
  <tr>
  <td colspan="3" align="right"><button name="add_judge" class="btn btn-primary">Save</button> <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;</td>
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

if (isset($_POST['add_judge'])) {
  $sub_event_id = $_POST['sub_event_id'];
  $se_name = $_POST['se_name'];

  $query = $conn->query("SELECT COUNT(*) as judge_count FROM judges WHERE subevent_id='$sub_event_id'");
  $row = $query->fetch();
  $currentJudgeCount = $row['judge_count'];
  $totalJudgeCountAfterInsert = $currentJudgeCount;
  $judgeNumberQuery = $conn->query("SELECT MAX(judge_ctr) as max_judge_ctr FROM judges");
  $judgeRow = $judgeNumberQuery->fetch();
  $currentJudgeNumber = $judgeRow['max_judge_ctr'] ?? 0; 
  
  for ($i = 1; $i <= 10; $i++) {
      $judge_name = $_POST['jud' . $i];
      $code = $_POST['code' . $i];

      if (!empty($judge_name)) {
          $totalJudgeCountAfterInsert++;
      }

      if ($totalJudgeCountAfterInsert > 10) {
          echo "<script>
                  alert('You can only add up to 4 judges!');
                  window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
              </script>";
          exit; 
      }
  }
  for ($i = 1; $i <= 10; $i++) {
    $judge_name = isset($_POST['jud' . $i]) ? $_POST['jud' . $i] : null;
    $code = isset($_POST['code' . $i]) ? $_POST['code' . $i] : null;

    if (!empty($judge_name)) {
        $currentJudgeNumber++; 
        $stmt = $conn->prepare("INSERT INTO judges (fullname, subevent_id, code, judge_ctr) VALUES (?, ?, ?, ?)");
        $stmt->execute([$judge_name, $sub_event_id, $code, $currentJudgeNumber]);
    }
}


  echo "<script>
          window.location = 'sub_event_details_edit.php?sub_event_id=$sub_event_id&se_name=$se_name';
          alert('Judges have been added successfully!');
      </script>";
}

?>
  
<?php include('footer.php'); ?>

    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
