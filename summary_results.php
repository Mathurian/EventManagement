<!DOCTYPE html>
<html lang="en">
   
   <?php
   
include('header.php');
include('session.php');

$active_main_event=$_GET['main_event_id'];
 
    ?>
 
 
 
 <body>

 
 <div class="container">

 
      <div class="span12">

        
           <?php   
          $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
		while ($event_row = $event_query->fetch()) 
        { 
 
            ?>
        
             <center>
             <style>
                
                .logo-container {
                    display: flex;
                    justify-content: center;  /* To center the logo horizontally */
                    align-items: center;      /* To center the logo vertically */
                                /* Add some padding around */
                }

                .logo-container img {
                    border-radius: 50%;       /* This makes the image circular */
                    width: 150px;             /* Adjust as needed */
                    height: 150px;            /* Adjust as needed */
                    object-fit: cover;        /* Ensures the image scales correctly */
                }
            </style>
           <div class="logo-container">
            
                  <img src="logo/swulogo.png" alt="Website Logo">
             
          </div>
          
             
             <table>
        <tr>
             <td align="center">
            <h3><strong><?php echo $event_row['event_name']; ?></strong></h3> 
             </td>
              </tr>
               <tr>
                <td align="center">
                <h3>Results</h3>
                </td>
              </tr>
               
             </table>
             
             </center>
              <?php }  ?>
        <section id="download-bootstrap">
          <div class="page-header">
 
<table style="width: 100% !important;" align="center">
  
                            
                           
                            
                        
            
<?php   
$sy_query = $conn->query("select DISTINCT sy FROM main_event where organizer_id='$session_id' AND mainevent_id='$active_main_event='") or die(mysql_error());
while ($sy_row = $sy_query->fetch()) 
{
            
$sy=$sy_row['sy'];
 
$MEctrQuery = $conn->query("select * FROM main_event where sy='$sy'") or die(mysql_error());
$MECtr = $MEctrQuery->rowCount();  ?>

    
 
<tr>

<td>   
       
                        <?php   
                        $event_query = $conn->query("select * from main_event where organizer_id='$session_id' AND sy='$sy'") or die(mysql_error());
                        while ($event_row = $event_query->fetch()) {
                          $main_event_id = $event_row['mainevent_id'];
                                              
                          $SEctrQuery = $conn->query("select * FROM sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                          while ($SECtr = $SEctrQuery->fetch()) {
                              $rs_subevent_id = $SECtr['subevent_id'];
                      
                          
                              echo "<h4 align='center'>EVENT: <strong>" . htmlspecialchars($SECtr['event_name']) . "</strong></h4><hr />";
                      
                              
                              $query = $conn->query("
                              SELECT c.fname, c.mname, c.lname, c.department, MIN(sr.place_title) AS best_rank
                              FROM contestants AS c
                              JOIN sub_results AS sr ON c.contestant_id = sr.contestant_id
                              WHERE c.subevent_id = '$rs_subevent_id' AND sr.subevent_id = '$rs_subevent_id'
                              GROUP BY c.contestant_id
                              ORDER BY ABS(CAST(SUBSTRING_INDEX(sr.place_title, ' ', 1) AS SIGNED)) ASC, c.lname ASC, c.fname ASC, c.mname ASC
                          ") or die(mysql_error());
                      
                          // Display the table with contestant names, ranks, and departments
                          echo "<table align='center' class='table table-bordered' id='example'>";
                          echo "<thead><tr><th>Name</th><th>Department</th><th>Rank</th></tr></thead>";
                          echo "<tbody>";
                          while ($row = $query->fetch()) {
                              echo "<tr>";
                              echo "<td>" . htmlspecialchars($row['fname']) . " " . htmlspecialchars($row['mname']) . " " . htmlspecialchars($row['lname']) . "</td>";
                              echo "<td>" . htmlspecialchars($row['department']) . "</td>"; // Display department
                              echo "<td>" . htmlspecialchars($row['best_rank']) . "</td>";
                              echo "</tr>";
                          }
                          echo "</tbody>";
                          echo "</table>";
                              
                      
                              // End of sub-events loop
                          }
                          // End of main events loop
                      }?>
      
                        
</tr>
   </table> 
                                 
                       
 </td>
 </tr>
 
 
  <?php  }  ?>
 
  </table>
  </div>
 
 
  </section>

 
      </div>
    </div>
   

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
 