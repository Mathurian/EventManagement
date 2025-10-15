 
   
<!DOCTYPE html>
<html lang="en">
   
   <?php
   include('header2.php');
    include('session.php');
  
  $mainevent_id=$_GET['mainevent_id'];
   $subevent_id=$_GET['sub_event_id'];
    ?>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
 
 


  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      
      <div class="span12">



        <!-- Download
        ================================================== -->
        
          <?php   
         $event_stmt = $conn->prepare("SELECT * FROM main_event WHERE mainevent_id = :meid");
		$event_stmt->execute([':meid' => $mainevent_id]);
		while ($event_row = $event_stmt->fetch()) 
        { 
             $s_event_stmt = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id = :sid");
		$s_event_stmt->execute([':sid' => $subevent_id]);
		while ($s_event_row = $s_event_stmt->fetch()) 
        {
           
            ?>
             
        
             <center>
             
             <style>
                
                .logo-container {
                    display: flex;
                    justify-content: center;  
                    align-items: center;      
                               
                }

                .logo-container img {
                    border-radius: 50%;     
                    width: 150px;             
                    height: 150px;            
                    object-fit: cover;        
                }
            </style>
           <div class="logo-container">
            
                  <img src="logo/swulogo.png" alt="Website Logo">
             
          </div>
             
             <table>
             <tr>
             <td align="center">
            <h2><?php echo $event_row['event_name']; ?></h2> 
             </td>
              </tr>
               <tr>
             <td align="center">
            <h3>Event Review - <?php echo $s_event_row['event_name']; ?></h3> 
             </td>
              </tr>
               
             </table>
             
             </center>
         
            <h3>Contingents</h3>
         
          <table class="table table-bordered">
        <thead>
        
     <th>Contingent</th>
     <th>Department</th>
        <th>Summary of Scores </th>
           <th>Contingent's Placing</th>
        </thead>
     <tbody>
     
     
     <?php
        require_once __DIR__ . '/vendor/autoload.php'; use App\Support\Database; require_once __DIR__ . '/config.php'; $db = new Database($pdo);
        $o_result_rows = $db->fetchAll("
        SELECT contestant_id, 
               CAST(SUBSTRING_INDEX(place_title, ' ', 1) AS UNSIGNED) AS numeric_rank
        FROM sub_results 
        WHERE mainevent_id = :meid
          AND subevent_id = :sid
        GROUP BY contestant_id 
        ORDER BY numeric_rank ASC
      ", [':meid' => $mainevent_id, ':sid' => $subevent_id]);
foreach ($o_result_rows as $o_result_row) {
    
  $contestant_id = $o_result_row['contestant_id'];

  $cname_rows = $db->fetchAll("SELECT * FROM contestants WHERE contestant_id = :cid", [':cid' => $contestant_id]);
  foreach ($cname_rows as $cname_row) {
      $contXXname = $cname_row['contestant_ctr'] . " " . $cname_row['lname'] . " " . $cname_row['fname'] . " " . $cname_row['mname'];
      $department = $cname_row['department']; 
  }
    
         ?>
         <tr>
         <tr>
              <?php require_once __DIR__ . '/vendor/autoload.php'; use App\Support\View; ?>
              <td><h5><?php echo View::e($contXXname); ?></h5></td>
              <td><?php echo View::e($department); ?></td> 
               <td>
           <table class="table table-bordered">
           <tr>
           <th>Judge</th>
           <th>Score</th>
   
           </tr>
         <?php

$divz=0;
$totx_score=0;
$rank_score=0;
$tot_score_rows = $db->fetchAll("SELECT * FROM sub_results WHERE contestant_id = :cid", [':cid' => $contestant_id]);
foreach ($tot_score_rows as $tot_score_row) 
{
  $divz=$divz+1;  
    $place_title=$tot_score_row['place_title'];
  
} 


$tot_score_rows2 = $db->fetchAll("SELECT judge_id,total_score,rank FROM sub_results WHERE contestant_id = :cid", [':cid' => $contestant_id]);
foreach ($tot_score_rows2 as $tot_score_row) 
{
     $totx_score=$totx_score+$tot_score_row['total_score'];
   
    ?>
    
  
   <tr>
   <td><?php $jx_id=$tot_score_row['judge_id'];
    $jname_row = $db->fetchOne("SELECT * FROM judges WHERE judge_id = :jid", [':jid' => $jx_id]);
 echo View::e($jname_row['fullname']);
    ?></td>
   <td><?php echo $tot_score_row['total_score']; ?></td>

     
   </tr>
  
 
  
<?php } ?>
 

 <tr>
    <td></td>
   <td><b>Ave: <?php echo round($totx_score/$divz,2) ?></b></td>
   
   </tr>

 </table>
          </td>
  <td><strong><?php echo View::e($place_title) ?></strong></td>
         </tr>
         
         
 
         
         
        <?php } ?>
        
    
     </tbody>
     
          </table>
    
    
      
            <h3>Judges</h3>
        
                 <table class="table table-bordered">
  <thead>
 
   
  <th>Code</th>
  <th>Fullname</th>
   
  
  </thead>
   
  <tbody>
  <?php    
    	$judge_stmt = $conn->prepare("SELECT * FROM judges WHERE subevent_id = :sid ORDER BY judge_ctr");
    	$judge_stmt->execute([':sid' => $subevent_id]);
    	while ($judge_row = $judge_stmt->fetch()) 
        { ?>
  <tr>
  
  
     <td><?php echo $judge_row['code']; ?></td>
    <td><?php echo $judge_row['fullname']; ?></td>
    
        
  </tr>
 

   


   <?php } ?>
  </tbody>
 </table>    
          
          
          
          
          
           
            <h3>Criteria</h3>
         
             <table class="table table-bordered">
  <thead>
  

  <th>Criteria</th>
  <th>Percentage</th>
  
  </thead>
  
  <tbody>
  <?php    
  $percnt=0;
    	$crit_stmt = $conn->prepare("SELECT * FROM criteria WHERE subevent_id = :sid");
    	$crit_stmt->execute([':sid' => $subevent_id]);
    	while ($crit_row = $crit_stmt->fetch()) 
        { $percnt=$percnt+$crit_row['percentage'];
            $crit_id=$crit_row['criteria_id'];
            ?>
  <tr>
  
   
      <td><?php echo $crit_row['criteria']; ?></td>
       <td><?php echo $crit_row['percentage']; ?></td>
        
  </tr>
   <?php } ?>
   
     <tr>
  
    <?php
      if($percnt<100)
      { ?>
     <td colspan="2">
       <div class="alert alert-danger pull-right">
  
  <strong>The Total Percentage is under 100%.</strong> 
</div>
     </td>
      <td colspan="1">
        <div class="alert alert-danger">
  
  <strong><?php  echo $percnt; ?></strong> 
</div> 
    </td>
       
        <?php } ?>
        
         <?php
      if($percnt>100)
      { ?>
     <td colspan="2">
     <div class="alert alert-danger pull-right">
  
  <strong>The Total Percentage is over 100%.</strong> 
</div>
      </td>
       <td colspan="1">
        <div class="alert alert-danger">
  
  <strong><?php  echo $percnt; ?></strong> 
</div>
    
    </td>
       
        <?php } ?>
        
        
         <?php
      if($percnt==100)
      { ?>
    <td colspan="1"></td>
      <td colspan="1">
     <span class="badge badge-info">Total: <?php  echo $percnt; ?></span>
    </td>
        
        <?php } ?>
  </tr>
 
  </tbody>
 
  </table>
     
  
  
  
  
           <?php }  } ?>
       
 
    </div>

  </div>
 
 </div>
 
 <?php include('footer.php'); ?>



    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
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
