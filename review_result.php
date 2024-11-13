 
   
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
          $event_query = $conn->query("select * from main_event where mainevent_id='$mainevent_id'") or die(mysql_error());
		while ($event_row = $event_query->fetch()) 
        { 
             $s_event_query = $conn->query("select * from sub_event where subevent_id='$subevent_id'") or die(mysql_error());
		while ($s_event_row = $s_event_query->fetch()) 
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
        $o_result_query = $conn->query("
        SELECT contestant_id, 
               CAST(SUBSTRING_INDEX(place_title, ' ', 1) AS UNSIGNED) AS numeric_rank
        FROM sub_results 
        WHERE mainevent_id='$mainevent_id' 
          AND subevent_id='$subevent_id' 
        GROUP BY contestant_id 
        ORDER BY numeric_rank ASC
      ") or die(mysql_error());
while ($o_result_row = $o_result_query->fetch()) {
    
  $contestant_id = $o_result_row['contestant_id'];

  $cname_query = $conn->query("SELECT * FROM contestants WHERE contestant_id='$contestant_id'") or die(mysql_error());
  while ($cname_row = $cname_query->fetch()) {
      $contXXname = $cname_row['contestant_ctr'] . " " . $cname_row['lname'] . " " . $cname_row['fname'] . " " . $cname_row['mname'];
      $department = $cname_row['department']; 
  }
    
         ?>
         <tr>
         <tr>
               <td><h5><?php echo $contXXname; ?></h5></td>
               <td><?php echo $department; ?></td> 
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
$tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
while ($tot_score_row = $tot_score_query->fetch()) 
{
  $divz=$divz+1;  
    $place_title=$tot_score_row['place_title'];
  
} 


$tot_score_query = $conn->query("select judge_id,total_score,rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
while ($tot_score_row = $tot_score_query->fetch()) 
{
     $totx_score=$totx_score+$tot_score_row['total_score'];
   
    ?>
    
  
   <tr>
   <td><?php $jx_id=$tot_score_row['judge_id'];
    $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
$jname_row = $jname_query->fetch();
 echo $jname_row['fullname'];
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
          <td><strong><?php echo $place_title ?></strong></td>
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
   	$judge_query = $conn->query("SELECT * FROM judges WHERE subevent_id='$subevent_id' order by judge_ctr") or die(mysql_error());
    while ($judge_row = $judge_query->fetch()) 
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
   	$crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$subevent_id'") or die(mysql_error());
    while ($crit_row = $crit_query->fetch()) 
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
