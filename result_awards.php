<!DOCTYPE html>
<html lang="en">

<?php
error_reporting(0);

include('header2.php');
include('session.php');

$active_sub_event = $_GET['event_id'];

function ordinal($i)
{
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

    $special_awards_query = $conn->prepare("SELECT special_awards FROM special_awards WHERE subevent_id=?");
    $special_awards_query->execute([$active_sub_event]);
    $special_awards = $special_awards_query->fetchAll(PDO::FETCH_ASSOC);

    while ($s_event_row = $s_event_query->fetch()) {
        $MEidxx = $s_event_row['mainevent_id'];
        $eventBanner = $s_event_row['event_banner'];

        $event_query = $conn->prepare("SELECT * FROM main_event WHERE mainevent_id=?");
        $event_query->execute([$MEidxx]);

        while ($event_row = $event_query->fetch()) {
            $o_result_query = $conn->prepare("
                SELECT 
                    contestant_id, 
                    AVG(awards_ctr1) as avg_awards_ctr1,
                    AVG(awards_ctr2) as avg_awards_ctr2,
                    AVG(awards_ctr3) as avg_awards_ctr3,
                    AVG(awards_ctr4) as avg_awards_ctr4,
                    AVG(awards_ctr5) as avg_awards_ctr5,
                    AVG(awards_ctr6) as avg_awards_ctr6,
                    AVG(awards_ctr7) as avg_awards_ctr7,
                    AVG(awards_ctr8) as avg_awards_ctr8,
                    AVG(awards_ctr9) as avg_awards_ctr9,
                    AVG(awards_ctr10) as avg_awards_ctr10
                FROM 
                    sub_results_awards 
                WHERE 
                    mainevent_id = ? AND 
                    subevent_id = ?
                GROUP BY 
                    contestant_id 
                ORDER BY 
                    avg_awards_ctr1 DESC
            ");
            $o_result_query->execute([$MEidxx, $active_sub_event]);
            $contestants = $o_result_query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($contestants as $index => $contestant) {
                $contestant_id = $contestant['contestant_id'];
                $avg_awards_ctr1 = $contestant['avg_awards_ctr1'];
                $avg_awards_ctr2 = $contestant['avg_awards_ctr2'];
                $avg_awards_ctr3 = $contestant['avg_awards_ctr3'];
                $avg_awards_ctr4 = $contestant['avg_awards_ctr4'];
                $avg_awards_ctr5 = $contestant['avg_awards_ctr5'];
                $avg_awards_ctr6 = $contestant['avg_awards_ctr6'];
                $avg_awards_ctr7 = $contestant['avg_awards_ctr7'];
                $avg_awards_ctr8 = $contestant['avg_awards_ctr8'];
                $avg_awards_ctr9 = $contestant['avg_awards_ctr9'];
                $avg_awards_ctr10 = $contestant['avg_awards_ctr10'];

                $placing = ordinal($index + 1);

                $update_place_title = $conn->prepare("UPDATE sub_results SET place_title=? WHERE contestant_id=?");
                $update_place_title->execute([$placing, $contestant_id]);
            }
        } 
    } 
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


$special_award_names_query = $conn->prepare("SELECT special_awards FROM special_awards WHERE subevent_id=?");
$special_award_names_query->execute([$active_sub_event]);
$special_award_names = $special_award_names_query->fetchAll(PDO::FETCH_ASSOC);


$judge_count_query = $conn->prepare("SELECT COUNT(DISTINCT judge_id) as judge_count FROM sub_results_awards WHERE mainevent_id = ? AND subevent_id = ?");
$judge_count_query->execute([$MEidxx, $active_sub_event]);
$judge_count_result = $judge_count_query->fetch();
$judge_count = $judge_count_result['judge_count'];

?>


<body data-spy="scroll" data-target=".bs-docs-sidebar">

    <div class="container">
    


        <div class="row">

            <div class="span12">

            <style>
               @media print {
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
                    table {
                        table-layout: fixed !important; /* This will allow you to set exact widths on cells */
                        width: 100% !important;
                        /* font-size: 10pt !important; Smaller font size for tables */
                    }
                    th, td {
                        padding: 4px; /* Reduce padding as needed */
                    }
                    .btn {
                        display: none; /* Hide buttons */
                    }
                    /* .page-title{
                        font-size: 15pt !important;
                    }
                    .award-name{
                        font-size: 15pt !important;
                    } */
                    @page {
                        size: auto; /* Auto page size */
                        margin: 10mm; /* Set print margin */
                    }
                    /* Force page breaks after certain elements */
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
                    justify-content: center;  /* To center the logo horizontally */
                    align-items: center;      /* To center the logo vertically */
                                /* Add some padding around */
                }

                .logo-container img {
                    width: 1250px;             /* Adjust as needed */
                    height: 350px;            /* Adjust as needed */
                    object-fit: cover;        /* Ensures the image scales correctly */
                }
            </style>
            <br>
            <div class="logo-container">
                <?php if (!empty($eventBanner)) { ?>
                    <!-- Path updated to point to the "uploads" directory -->
                    <img src="<?php echo htmlspecialchars($eventBanner); ?>"  alt="Event Banner">
                <?php } ?>
                
            </div>
        
          <br>
            <h1 class="page-title"><center>SPECIAL AWARDS</center></h1>
            <center>
            <button class="btn btn-success pull-right non-printable" style="width: 100px; margin-bottom: 20px;" onclick="window.print();">PRINT</button>
            </center>
            <?php

                $s_event_query = $conn->query("select * from sub_event where subevent_id='$active_sub_event'") or die(mysql_error());
                while ($s_event_row = $s_event_query->fetch()) {
                    $MEidxx = $s_event_row['mainevent_id'];
                    $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
                    while ($event_row = $event_query->fetch()) {

                        $judge_ids_query = $conn->prepare("
                        SELECT DISTINCT judge_id
                        FROM sub_results_awards 
                        WHERE mainevent_id = ? AND subevent_id = ?
                    ");
                    $judge_ids_query->execute([$MEidxx, $active_sub_event]);
                    $judge_ids = $judge_ids_query->fetchAll(PDO::FETCH_COLUMN, 0);

                        // Loop through each special award
                        foreach ($special_award_names as $awardIndex => $award) {
                            $award_name = $award['special_awards'];
                            $award_column = 'awards_ctr' . ($awardIndex + 1);

            ?>
            <center>
                
              

                <h1 class="award-name" style="font-size: 30px; font-weight: bold;"><?php echo "$award_name"; ?></h1>

                <table class="table table-bordered">
                    <thead>
                        <th>Contingent</th>
                        <th>Department</th>
                        <?php
                        // Display headers for each judge
                        for ($i = 1; $i <= $judge_count; $i++) {
                            echo "<th><center>Judge $i</center></th>";
                        }
                        ?>
                        <th><center>Average Score</center></th>
                    </thead>
                    <tbody>

                    <?php
foreach ($contestants as $index => $contestant) {
    $contestant_id = $contestant['contestant_id'];


    $contestant_query = $conn->prepare("SELECT * FROM contestants WHERE contestant_id=?");
    $contestant_query->execute([$contestant_id]);
    $cname_row = $contestant_query->fetch();
    $contXXname = $cname_row['contestant_ctr'] . " " . $cname_row['lname'] . " " . $cname_row['fname'] . " " . $cname_row['mname'];
    $department = $cname_row['department'];

    echo "<tr>";
    echo "<td><h5>$contXXname</h5></td>";
    echo "<td>$department</td>";


    $scores = [];


   
    foreach ($judge_ids as $judge_id) {
        $judge_score_query = $conn->prepare("
            SELECT $award_column
            FROM sub_results_awards 
            WHERE mainevent_id = ? AND subevent_id = ? AND contestant_id = ? AND judge_id = ?
        ");
        $judge_score_query->execute([$MEidxx, $active_sub_event, $contestant_id, $judge_id]);
        $judge_score_result = $judge_score_query->fetch();


   
        if ($judge_score_result && isset($judge_score_result[$award_column])) {
            $judge_score = round($judge_score_result[$award_column]);
            $scores[] = $judge_score; 
            echo "<td><center>$judge_score</center></td>";
        } else {
            echo "<td>N/A</td>";
        }
    }

  
    if (count($scores) > 0) {
        $average_score = number_format(array_sum($scores) / count($scores), 2);
    } else {
        $average_score = "N/A";
    }

    echo "<td><center>$average_score</center></td>";
    echo "</tr>";
}
?>



                                    </tbody>
                                </table>

                            </center>
                    <?php
                        } 
                    } 
                }
                    ?>
            </div>


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
        </div>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
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
