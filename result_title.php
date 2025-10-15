 
<!DOCTYPE html>
<html lang="en">
   
   <?php
   error_reporting(0);
   
   include('header2.php');
   include('session.php');
   
   $active_sub_event=$_GET['event_id'];
 
   function ordinal($i) {
    $l = substr($i, -1);
    $s = substr($i, -2);

    if ($s == '11' || $s == '12' || $s == '13') {
        return $i . 'th';
    }

    switch ($l) {
        case '1': return $i . 'st';
        case '2': return $i . 'nd';
        case '3': return $i . 'rd';
        default: return $i . 'th';
    }
}

try {
    $s_event_query = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id=?");
    $s_event_query->execute([$active_sub_event]);
    
    while ($s_event_row = $s_event_query->fetch()) {
        $MEidxx = $s_event_row['mainevent_id'];

        $event_query = $conn->prepare("SELECT * FROM main_event WHERE mainevent_id=?");
        $event_query->execute([$MEidxx]);
        
        while ($event_row = $event_query->fetch()) {
            $o_result_query = $conn->prepare("
                SELECT 
                    contestant_id, 
                    AVG(total_score) as avg_score
                FROM 
                    sub_results 
                WHERE 
                    mainevent_id = ? AND 
                    subevent_id = ?
                GROUP BY 
                    contestant_id 
                ORDER BY 
                    avg_score DESC
            ");
            $o_result_query->execute([$MEidxx, $active_sub_event]);
            $contestants = $o_result_query->fetchAll(PDO::FETCH_ASSOC);
  
            foreach ($contestants as $index => $contestant) {
                $contestant_id = $contestant['contestant_id'];
                $avg_score = $contestant['avg_score'];
                $placing = ordinal($index + 1);
  
                $update_place_title = $conn->prepare("UPDATE sub_results SET place_title=? WHERE contestant_id=?");
                $update_place_title->execute([$placing, $contestant_id]);
            }
        } // This ends the inner while loop
    } // This ends the outer while loop
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Display results in HTML as previously shown
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
           
             $s_event_stmt = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id = :sid");
		$s_event_stmt->execute([':sid' => $active_sub_event]);
		while ($s_event_row = $s_event_stmt->fetch()) 
        {
            
            $MEidxx=$s_event_row['mainevent_id'];
            $eventBanner = $s_event_row['event_banner'];
            
              $event_stmt = $conn->prepare("SELECT * FROM main_event WHERE mainevent_id = :meid");
		$event_stmt->execute([':meid' => $MEidxx]);
		while ($event_row = $event_stmt->fetch()) 
        {
            
            ?>
        
             <center>
             <style>
                @media print{
                  body {
                        color: black;
                        background: white;
                        font-size: 10pt !important; /* Reduce the font size */
                        line-height: 1.2 !important;
                    }
                    .logo-container img {
                        width: 800px !important; /* Fit the image to the container */
                        height: 300px !important; /* Maintain aspect ratio */
                    }
                    .container, .row, .span12 {
                        width: auto; /* Prevent overflow */
                        margin: 0; /* Reduce margins */
                        padding: 0; /* Reduce padding */
                    }
                  .btn {
                        display: none; /* Hide buttons */
                    }
                    .page-break {
                        page-break-after: always !important;
                    }
                    /* Avoid page breaks inside certain elements */
                    .page-break-inside-avoid {
                        page-break-inside: avoid !important;
                    }
                    .non-essential, .navigation, .footer {
                        display: none !important;
                    }
                }
                  .logo-container {
                      display: flex;
                      justify-content: center;  
                      align-items: center;     
                             
                  }

                  .logo-container img {
                      width: 1250px;             /* Adjust as needed */
                      height: 350px;            /* Adjust as needed */
                      object-fit: cover;        /* Ensures the image scales correctly */
                  }
              </style>
             <div class="logo-container">
        <?php if (!empty($eventBanner)) { ?>
            <!-- Path updated to point to the "uploads" directory -->
            <img src="<?php echo htmlspecialchars($eventBanner); ?>" alt="Event Banner">
        <?php } ?>
    </div>
    
    
   
      
             <table>
             <tr>
             <td align="center">
           <?php require_once __DIR__ . '/vendor/autoload.php'; require_once __DIR__ . '/config.php'; $db = new \App\Support\Database($pdo); ?>
           <h3><?php echo \App\Support\View::e($event_row['event_name']); ?></h3> 
             </td>
              </tr>
              <tr>
              <td align="center">
             <h4> <?php echo \App\Support\View::e($s_event_row['event_name']); ?></h4>
              </td>
              </tr>
               <tr>
             <td align="center">
            <h4>Overall Results</h4> 
          
             </td>
              </tr>
               
             </table>
             
             </center>
             <button class="btn btn-success pull-right non-printable" style="width: 100px; margin-bottom: 20px;" onclick="window.print();">PRINT</button>
          <br>
          <table class="table table-bordered">
        <thead>
        
     <th>Contingent</th>
     <th>Department</th>
        <th>Summary of Scores</th>
          <th>Contingent's Placing</th>
        </thead>
     <tbody>
     
                
     <?php
        
        $o_result_rows = $db->fetchAll("SELECT DISTINCT contestant_id, place_title FROM sub_results WHERE mainevent_id = :meid AND subevent_id = :sid ORDER BY LENGTH(place_title), place_title ASC", [':meid' => $MEidxx, ':sid' => $active_sub_event]);

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
              <td><h5><?php echo \App\Support\View::e($contXXname); ?></h5></td>
              <td><?php echo \App\Support\View::e($department); ?></td> 
               <td>
                   <table class="table table-bordered">
           <tr>
           <th>Judge</th>
           <th style="text-align: center;">Score</th>
         
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


$tot_score_rows2 = $db->fetchAll("SELECT judge_id,total_score, deduction, rank FROM sub_results WHERE contestant_id = :cid ORDER BY judge_id", [':cid' => $contestant_id]);
foreach ($tot_score_rows2 as $tot_score_row) 
{
     $totx_score=$totx_score+$tot_score_row['total_score'];
     $rank_score=$rank_score+$tot_score_row['rank'];
     $totx_deduct=$tot_score_row['deduction'];
     
    ?>
    
  
   <tr>
   <td style="width: 50% !important;"><?php $jx_id=$tot_score_row['judge_id'];
    $jname_row = $db->fetchOne("SELECT * FROM judges WHERE judge_id = :jid", [':jid' => $jx_id]);
 echo $jname_row['fullname'];
    ?></td>
   <td style="width: 25% !important; text-align: center;"><?php echo $tot_score_row['total_score']-$tot_score_row['deduction']; ?></td>
   
   </tr>
  
 
  
<?php } ?>
 

 <tr>
 <td></td>
   <td><b>Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,2) ?></b></td>
     
   </tr>

 </table>
          </td>
          
 
          
          <td style="width: 17%!important;">
          <center>
          <h3>
          <?php
          
          $pt_result_stmt = $conn->prepare("SELECT * FROM sub_results WHERE contestant_id = :cid");
          $pt_result_stmt->execute([':cid' => $contestant_id]);
          $pt_result_row = $pt_result_stmt->fetch();
    
          echo $pt_result_row['place_title'];
          
          
          ?>
        
        
          </center>
          </td>

         </tr>
         
         
 
         
         
        <?php } ?>
        <table align="center">  
              <tr>
            <?php
            $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
while ($jjn_result_row = $jjn_result_query->fetch()) {
      $jx_id=$jjn_result_row['judge_id'];
      
    $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
$jname_row = $jname_query->fetch();

    ?>
            <td>
            <table>
              <hr />
        
            <tr><td align="center">&nbsp;&nbsp;&nbsp;<u><strong><?php echo $jname_row['fullname'];?></strong></u>&nbsp;&nbsp;&nbsp;</td></tr>
             
              <?php if($jname_row['jtype']=="Chairman"){ ?>
                <tr>
             <td align="center">
            Chairman of the board
             </td>
              </tr>
              <?php }else{?>
               <tr>
             <td align="center">
            Judge
             </td>
              </tr>
              
              <?php } ?>
              
             
             
            </table>
            </td>
    
           
  
<?php } ?>
    
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
