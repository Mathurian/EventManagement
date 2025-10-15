 
<!DOCTYPE html>
<html lang="en">
   
   <?php
   include('header2.php');
    include('session.php');
    error_reporting(0);
    $event_id=$_GET['event_id'];
    $judge_id=$_GET['judge_id'];
    ?>

  <body>

  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      
      <div class="span12">



        <!-- Download
        ================================================== -->
        
           <?php   
 

         
            $s_event_stmt = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id = :sid");
		$s_event_stmt->execute([':sid' => $event_id]);
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
                        height: 200px !important; /* Maintain aspect ratio */
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
                       
                    width: 1250px;            
                    height: 300px;           
                    object-fit: cover;       
                }
                .table-bordered tbody tr:first-child td {
                    border-top: 0.5px solid black !important;
                }
                .table-bordered tbody tr:last-child td {
                    border-bottom: 0.5 solid black !important;
                }
                
            </style>
          <div class="logo-container">
                <?php if (!empty($eventBanner)) { ?>
                    <!-- Path updated to point to the "uploads" directory -->
                    <img src="<?php echo htmlspecialchars($eventBanner); ?>"  alt="Event Banner">
                <?php } ?>
                
            </div>
        
             
             <table>
             <tr>
             <td align="center">
           <?php require_once __DIR__ . '/vendor/autoload.php'; use App\Support\View; use App\Support\Database; require_once __DIR__ . '/config.php'; $db = new Database($pdo); ?>
           <h2><?php echo View::e($event_row['event_name']); ?></h2> 
             </td>
              </tr>
               <tr>
             <td align="center">
           <h3><?php echo View::e($s_event_row['event_name']); ?></h3> 
            <button class="btn btn-warning pull-center non-printable" style="width: 100px;" onclick="window.print();">PRINT</button>
             </td>
              </tr>
               
             </table>
             
             </center>
          <br>
          <table class="table table-striped table-bordered" style="border: 1px solid black;">
          
        <thead>
     <th>No. &amp; Contingent Name</th>
     <th>Department</th>
        <?php
        $criteria_rows = $db->fetchAll("SELECT * FROM criteria WHERE subevent_id = :sid ORDER BY criteria_ctr ASC", [':sid' => $event_id]);
        foreach ($criteria_rows as $crit_row) {
          
        
         ?>
         
        <th><?php echo $crit_row['criteria']; ?></th>
        <?php } 
        ?>
        
        <th>Total Score</th>
        <th>Rank</th>
        
        </thead>
     <tbody>
    
    <?php
    
  
    $score_rows = $db->fetchAll("SELECT * FROM sub_results WHERE subevent_id = :sid AND judge_id = :jid ORDER BY CAST(rank AS UNSIGNED) ASC, contestant_id ASC", [':sid' => $event_id, ':jid' => $judge_id]);



if (count($score_rows) > 0) { 
foreach ($score_rows as $score_row)
 {
 
     $s1=$score_row['criteria_ctr1'];
     $s2=$score_row['criteria_ctr2'];
     $s3=$score_row['criteria_ctr3'];
     $s4=$score_row['criteria_ctr4'];
     $s5=$score_row['criteria_ctr5'];
     $s6=$score_row['criteria_ctr6'];
     $s7=$score_row['criteria_ctr7'];
     $s8=$score_row['criteria_ctr8'];
     $s9=$score_row['criteria_ctr9'];
     $s10=$score_row['criteria_ctr10'];
     $total_score=$score_row['total_score']; 
     $rank=$score_row['rank'];
     $s_result_id=$score_row['subresult_id'];
     $con_id=$score_row['contestant_id'];
      
      
      
      ?>
         <tr>
         <td>
        <?php
        $cont_rows = $db->fetchAll("SELECT * FROM contestants WHERE contestant_id = :cid", [':cid' => $con_id]);
        foreach ($cont_rows as $cont_row) {
            $c_num = $cont_row['contestant_ctr'];
            $cfnme = $cont_row['fname'];
            $cmnme = $cont_row['mname'];
            $clnme = $cont_row['lname'];
            $department = $cont_row['department'];

            echo htmlspecialchars($c_num) . ". " . htmlspecialchars($cfnme) . " " . htmlspecialchars($cmnme) . " " . htmlspecialchars($clnme);
        }
        ?>
    </td>
    <td>
        <?php echo htmlspecialchars($department); ?>
    </td>
        
          <?php
          
        $criteria_rows2 = $db->fetchAll("SELECT * FROM criteria WHERE subevent_id = :sid ORDER BY criteria_ctr ASC", [':sid' => $event_id]);
foreach ($criteria_rows2 as $crit_row) {
      
         ?>
        <td>
        
        <?php
 if($crit_row['criteria_ctr']==1)
 { ?>
     <?php echo $s1; ?> 
<?php } ?>


 <?php
 if($crit_row['criteria_ctr']==2)
 { ?>
     <?php echo $s2; ?> 
<?php } ?>


 <?php
 if($crit_row['criteria_ctr']==3)
 { ?>
    <?php echo $s3; ?> 
<?php } ?>


 <?php
 if($crit_row['criteria_ctr']==4)
 { ?>
    <?php echo $s4; ?> 
<?php } ?>


 <?php
 if($crit_row['criteria_ctr']==5)
 { ?>
    <?php echo $s5; ?> 
<?php } ?>


</td>



        <?php } ?>
        <td><?php echo $total_score; ?></td>
        <td><?php echo $rank;?></td>
        
 
         </tr>
         
         
         
         
         
        <?php } ?>
        
    
     </tbody>
     
          </table>
          
          <?php $j_stmt = $conn->prepare("SELECT * FROM judges WHERE subevent_id = :sid AND judge_id = :jid");
$j_stmt->execute([':sid' => $event_id, ':jid' => $judge_id]);
while ($j_row = $j_stmt->fetch()) { ?>
             <hr />
             <table align="center">
             <tr>
             <td align="center">
            <h4><?php echo $j_row['fullname']; ?></h4> 
            
             </td>
              </tr>
              <?php if($j_row['jtype']=="Chairman"){ ?>
                <tr>
             <td align="center">
            Chairman
             </td>
              </tr>
              <?php } ?>
         
               <tr>
             <td align="center">
            Event Judge
             </td>
              </tr>
               
             </table> <?php
     
 }
 }
 else
 {
    $s1="";
     $s2="";
     $s3="";
     $s4="";
     $s5="";
     $s6="";
     $s7="";
     $s8="";
     $s9="";
     $s10="";
      $total_score="";
 ?>
 
 <table align="center">
 <tr>
 <td>
 <div class="alert alert-warning">
 <h3>
 No data to Display. Judge is not finish scoring at this moment.
 </h3>
 </div>
 </td>
 </tr>
 </table>
 
 <?php } ?>
       
            
           <?php }   } ?>
       
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
