<!DOCTYPE html>
<html lang="en">
    

<?php
error_reporting(0);
include('header2.php');
include('session.php');
$judge_ctr = $_GET['judge_ctr'];
$subevent_id = $_GET['subevent_id'];
$getContestant_id = $_GET['contestant_id'];
$pageStat = $_GET['pStat'];

?>

<?php $event_query = $conn->query("select * from sub_event where subevent_id='$subevent_id'");
while ($event_row = $event_query->fetch()) { ?>

    <?php
    $se_MEidxx = $event_row['mainevent_id'];
    $se_namexx = $event_row['event_name'];
    $se_statusxx = $event_row['status'];
    ?>

<?php } ?>
<?php

if ($se_statusxx == "activated") {


    $judge_query = $conn->query("select * from judges where subevent_id='$subevent_id' and judge_ctr='$judge_ctr'");
    


    $num_row = $judge_query->rowCount();
    if ($num_row > 0) {

        while ($judge_row = $judge_query->fetch()) {
            $j_id = $judge_row['judge_id'];
            $j_name = $judge_row['fullname'];
            $j_code = $judge_row['code'];
            $jtype = $judge_row['jtype'];
?>

<?php }
    }
} ?>


<body>
<style>

  .custom-navbar {
    margin-bottom: 20px; 
}

.custom-navbar .nav > li > a {

}

    .custom-navbar .nav > li > a.nav-btn {
        background-color: green; 
        color: white;
    
    }

    .custom-navbar .nav > li:first-child > a.nav-btn:hover {
        background-color: green; 
        color: white;
    }


    .custom-navbar .nav > li:nth-child(2) > a.nav-btn {
        background-color: orange;
        color: white; 
    }


    .custom-navbar .nav > li:nth-child(2) > a.nav-btn:hover {
        background-color: orange;
        color: white; 
    }
#banner {
    width: 100%;
    height: 400px;
    object-fit: fill;
    display: block; /* To remove any default padding/margin */
}



</style>







    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top custom-navbar">
        <div class="navbar-inner">
            <div class="container">
                
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="judgelogin.php">
                    <font color="white">Logout</font>
                </a>
                

                <div class="nav-collapse collapse">
        <ul class="nav" style="margin-right: 10px;">
            <li style="margin-right: 10px;" >
                <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>"
                   
                   style="margin-top: 8px; padding: 5px 10px; color: #C0C0C0; font-size: 13px">
                   <strong> Main Event: <?php echo htmlspecialchars($se_namexx); ?></strong>
                </a>
            </li>
            <li style="margin-right: 10px;">
                <a href="judge_panel_awards.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>"
                   
                   style="margin-top: 8px; padding: 5px 10px;">
                    Special Awards Panel
                </a>
            </li>

            <li style="text-align: center;">
                <a>
                    <font color="white">Judge: <?php echo $j_name; ?>&nbsp;&nbsp;&nbsp;<?php echo $jtype; ?></font>
                </a>
            </li>
            <a href="video-guide.php">
    <button type="button" class="btn btn-success btn-lg">
        Watch guide
    </button>
</a>

   




                        
                    </ul>
                </div>

            </div>
        </div>
    </div>
  

    <!-- Subhead
================================================== -->
    <?php

    if ($se_statusxx == "activated") {


        $judge_query = $conn->query("select * from judges where subevent_id='$subevent_id' and judge_ctr='$judge_ctr'");

        $num_row = $judge_query->rowCount();
        if ($num_row > 0) {

            while ($judge_row = $judge_query->fetch()) {
                $j_id = $judge_row['judge_id'];
                $j_name = $judge_row['fullname'];
                $j_code = $judge_row['code'];
        ?>


                <!-- Subhead
================================================== -->
                <table style="background-color: #30475E; width: 100% !important; height: 150px;" align="center" border="0">
                    <?php
                    $subevent_id = $_GET['subevent_id'];
                    $stmt = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id = ?");
                    $stmt->execute([$subevent_id]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            $banner = $row['event_banner'];
                        }
                    } else {
                        echo "No data found for subevent_id: $subevent_id";
                    }
                    ?>


                    <tr>
                        <th colspan="2">
                            <img id="banner" src="<?= $banner; ?>" alt="Table Header Image">
                        </th>
                    </tr>

                </table>



                <br />
        <?php }
        }
    } else {
        $j_name = "Event is still inactive. Please contact the Event Organizer."; ?>


        <table style="background-color: #30475E; width: 100% !important; height: 150px; text-indent: 25px;" align="center" border="0">
            <tr>
                <td>
                    <h1 style="color: whitesmoke !important;">Judge's Panel - <font color="red"><?php echo $j_name; ?></font>
                    </h1>
                    <h4 style="color: whitesmoke !important;">SWU-ETS</h4>
                </td>
            </tr>
        </table>

    <?php
    }
    ?>



    <div class="container">
        <div class="row">
            <div class="span12">



                <?php if ($num_row > 0) { ?>

                    <ul class="nav nav-tabs alert-success">

                        <?php


                        if ($pageStat == "Change") {
                            $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' AND contestant_id='$getContestant_id'");
                            while ($cont_row = $cont_query->fetch()) {

                        ?>

                                <li><a><strong>Change Score Panel - <?php echo $cont_row['fullname']; ?></strong></a></li>

                            <?php }
                        } else {
                            $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' order by contestant_ctr");
                            while ($cont_row = $cont_query->fetch()) {
                                $con_idTab = $cont_row['contestant_id'];
                                $con_ctr = $cont_row['contestant_ctr'];

                            ?>

                                <?php

                                ?>
                                <?php if ($getContestant_id == $con_idTab) { ?>
                                    <li class="active"><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><strong><?php echo $cont_row['contestant_ctr']?>. <strong><?php echo $cont_row['lname']; ?></strong> <?php echo $cont_row['fname']; ?></strong> <strong><?php echo $cont_row['mname']; ?></strong></a></li>
                                <?php } else {  ?>
                                    <li class=""><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><?php echo $cont_row['contestant_ctr']?>. <?php echo $cont_row['lname']; ?> <?php echo $cont_row['fname']; ?> <?php echo $cont_row['mname']; ?> </a></li>


                            <?php }
                            } ?>

                            <?php if ($getContestant_id == "allTally") { ?>
                                <li class="active"><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=allTally"><strong>View Tally</strong></a></li>

                            <?php } else { ?>

                                <li class=""><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=allTally">View Tally</a></li>

                            <?php   } ?>





                        <?php   } ?>

                    </ul>

                    <?php
                    if ($getContestant_id == "allTally") { ?>


                        <table align="center" class="table table-bordered">

                            <tr>
                                <td align="center" colspan="5">

                                    <center>
                                        <h3><strong><?php echo $se_namexx; ?></strong></h3>
                                        <p><strong class="alert alert-danger">In case of a tie, you can edit the score of the contestants.</strong></p>
                                    </center>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <center>Contestant Name</center>
                                </td>
                                <td>
                                    <center>Scoresheet</center>
                                </td>
                                <td style="background:#e4f6e2">
                                    <center>Final Score</center>
                                </td>
                                <td bgcolor="green">
                                    <center>
                                        <font color="white">Rank</font>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        Action
                                    </center>
                                </td>
                            </tr>

                            <?php
                            $rankCtr = 0;


                            $score_queryzz = $conn->query("select DISTINCT contestant_id from sub_results where subevent_id='$subevent_id' AND judge_id='$j_id' ORDER BY total_score DESC");
                            while ($cont_row = $score_queryzz->fetch()) {

                                $rankCtr = $rankCtr + 1;

                                $conID = $cont_row['contestant_id'];

                                $score_query = $conn->query("select * from sub_results where contestant_id='$conID' AND judge_id='$j_id'");
                                while ($score_row = $score_query->fetch()) {
                                    $s1 = $score_row['criteria_ctr1'];
                                    $s2 = $score_row['criteria_ctr2'];
                                    $s3 = $score_row['criteria_ctr3'];
                                    $s4 = $score_row['criteria_ctr4'];
                                    $s5 = $score_row['criteria_ctr5'];
                                    $s6 = $score_row['criteria_ctr6'];
                                    $s7 = $score_row['criteria_ctr7'];
                                    $s8 = $score_row['criteria_ctr8'];
                                    $s9 = $score_row['criteria_ctr9'];
                                    $s10 = $score_row['criteria_ctr10'];
                                }

                            ?>

                                <tr>

                                    <td align="center">

                                        <strong>
                                            <?php
                                            $contzx_query = $conn->query("select fname,mname,lname,contestant_ctr from contestants where contestant_id='$conID'");
                                            $contzx_row = $contzx_query->fetch();
                                            echo $contzx_row['contestant_ctr'];
                                            echo "\n";
                                            echo $contzx_row['fname'];
                                            echo "\n";
                                            echo $contzx_row['mname'];
                                            echo "\n";
                                            echo $contzx_row['lname'];

                                            ?>
                                        </strong>

                                    </td>

                                    <td align="center">

                                        <table align="center" class="table table-bordered">
                                            <tr>
                                                <?php

                                                $totzxzxzxzxz = 0;

                                                $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                while ($crit_row = $criteria_query->fetch()) {

                                                    $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                }
                                                ?>


                                                <?php


                                                $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                while ($crit_row = $criteria_query->fetch()) {

                                                ?>

                                                    <td>
                                                        <center>
                                                            <font size="2"><?php echo $crit_row['criteria'] . " - " . $crit_row['percentage'] . "%"; ?></font>
                                                        </center>
                                                    </td>

                                                <?php } ?>
                                            </tr>

                                            <tr>
                                                <?php

                                                $totzxzxzxzxz = 0;

                                                $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                while ($crit_row = $criteria_query->fetch()) {

                                                    $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                }
                                                ?>


                                                <?php


                                                $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                while ($crit_row = $criteria_query->fetch()) {



                                                ?>

                                                    <td align="center">


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 1) { ?>
                                                            <?php echo $s1; ?>
                                                        <?php } ?>


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 2) { ?>
                                                            <?php echo $s2; ?>
                                                        <?php } ?>


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 3) { ?>
                                                            <?php echo $s3; ?>
                                                        <?php } ?>


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 4) { ?>
                                                            <?php echo $s4; ?>
                                                        <?php } ?>


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 5) { ?>
                                                            <?php echo $s5; ?>

                                                        <?php } ?>


                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 6) { ?>
                                                            <?php echo $s6; ?>

                                                        <?php } ?>



                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 7) { ?>
                                                            <?php echo $s7; ?>
                                                        <?php } ?>

                                                        <?php
                                                        if ($crit_row['criteria_ctr'] == 8) { ?>
                                                            <?php echo $s8; ?>

                                                        <?php } ?>





                                                    </td>


                                                <?php } ?>
                                            </tr>


                                        </table>
                                        <font size="2"><strong>Comment:</strong> <?php echo $comments; ?></font>

                                    </td>


                                    <!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking --><!-- auto ranking -->
                            
                                    <?php

$all_scores_query = $conn->query("SELECT * FROM sub_results WHERE subevent_id='$subevent_id' AND judge_id='$j_id' ORDER BY total_score DESC") or die(mysql_error());

$rank = 1;
$prevScore = -1;
$tieRank = 1; // Rank to be assigned in case of a tie
$tieCount = 0;
$scores = [];

while ($row = $all_scores_query->fetch()) {
    $currentScore = $row['total_score'];
    $currentContestantID = $row['contestant_id'];
    $scores[$currentContestantID] = $currentScore; // Storing score for display

    if ($prevScore != $currentScore) {
        // Update rank only if current score is different from previous
        $rank += $tieCount;
        $tieRank = $rank;
        $tieCount = 0;
    }

    // Update the rank for the current contestant
    $conn->query("UPDATE sub_results SET rank='$tieRank' WHERE subevent_id='$subevent_id' AND contestant_id='$currentContestantID' AND judge_id='$j_id'");

    $prevScore = $currentScore;
    $tieCount++;
}



?>



   <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end --> <!-- auto ranking end -->

                                   
                                    <td style="background:#e4f6e2">

                                        <center>
                                            <br />
                                            <br />
                                            <font size="6"> <strong> <?php echo $scores[$conID]; ?> </strong> </font>
                                        </center>

                                    </td>
                                   


                                    <td bgcolor="green">
                                        <center>
                                            <br />
                                            <br />
                                            <font size="6" color="white">
                                                <?php
                                                $rank_query = $conn->query("select * from sub_results where subevent_id='$subevent_id' and judge_id='$j_id' and contestant_id='$conID'");
                                                $rowRQ = $rank_query->fetch();

                                                echo $rowRQ['rank'];

                                                ?>
                                        </center>

                                    </td>



                                    <td width="10">
                                        <br />
                                        <br />
                                        <a title="Change <?php echo $contzx_row['fullname']; ?> scores" href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $conID; ?>" class="btn btn-success"><i class="icon-pencil"></i></a>
                                    </td>

                                </tr>



                            <?php } ?>

                        </table>




                        <a href="#" title="Back to Top" class="btn btn-default pull-right"><i class="icon-chevron-up"></i></a>

                        <footer class="footer">


                            <?php

                            if ($pageStat == "Change") {
                                $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' AND contestant_id='$getContestant_id'");
                                while ($cont_row = $cont_query->fetch()) {
                                    $con_idTab = $cont_row['contestant_id'];
                            ?>
                                    <strong>Edit Score Mode :</strong> <?php echo $cont_row['fullname']; ?>
                                <?php }
                            } else {

                                $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' order by contestant_ctr");
                                while ($cont_row = $cont_query->fetch()) {
                                    $con_idTab = $cont_row['contestant_id'];

                                ?>
                                    <?php if ($getContestant_id == $con_idTab) { ?>
                                        <strong><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><?php echo $cont_row['fullname']; ?></a></strong> &middot;
                                    <?php } else { ?>
                                        <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><?php echo $cont_row['fullname']; ?></a> &middot;
                                <?php }
                                } ?>
                                <?php if ($getContestant_id == "allTally") { ?>


                                <?php } else { ?>
                                    <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=allTally">View Tally</a>
                            <?php  }
                            } ?>

                            <div class="container">
                                <center>

                                    <font size="4">Event Tabulating System &middot; &COPY; <?= date("Y") ?></font>
                                    <hr />



                                </center>

                            </div>

                        </footer>


                        <!-- end all tally -->





                        <!-- update --> <!-- update --> <!-- update --> <!-- update --> <!-- update --> <!-- update --> <!-- update -->

                        <?php } else {


                        $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' AND contestant_id='$getContestant_id' ORDER BY contestant_id ASC ");
                        while ($cont_row = $cont_query->fetch()) {

                            $image_url = $cont_row['image_url'];
                            $contestant_name = $cont_row['lname'] . " " . $cont_row['fname']. " " . $cont_row['mname'];
                            $contestant_dept = $cont_row['department'];
                            $contestant_no = $cont_row['contestant_ctr'];

                            $score_query = $conn->query("select * from sub_results where contestant_id='$getContestant_id' AND judge_id='$j_id'");
                            while ($score_row = $score_query->fetch()) {
                                $s1 = $score_row['criteria_ctr1'];
                                $s2 = $score_row['criteria_ctr2'];
                                $s3 = $score_row['criteria_ctr3'];
                                $s4 = $score_row['criteria_ctr4'];
                                $s5 = $score_row['criteria_ctr5'];
                                $s6 = $score_row['criteria_ctr6'];
                                $s7 = $score_row['criteria_ctr7'];
                                $s8 = $score_row['criteria_ctr8'];
                                $s9 = $score_row['criteria_ctr9'];
                                $s10 = $score_row['criteria_ctr10'];
                                $comment1 = $score_row['comments'];
                           
                            }

                        ?>
                            <table align="center" style="width: 100% !important;">
                                <tr>
                                <tr>
                                    <td align="center">
                                        <img style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 20px;" src="contestant_image/<?= $image_url ?>" alt="">
                                        <h4>Name: <?= $contestant_name ?></h4>
                                        <h4>Department: <?= $contestant_dept ?></h4>
                                        <h4>Contestant No: <?= $contestant_no ?></h4>
                                    </td>

                                </tr>

                                <td align="center">



                                    Total Score Earned:
                                    <strong><?php $score_query = $conn->query("select * from sub_results where subevent_id='$subevent_id' and judge_id='$j_id' and contestant_id='$getContestant_id'");
                                            while ($score_row = $score_query->fetch()) {
                                                echo $score_row['total_score'] . "%";
                                            } ?> of 100% </strong>

                                    <br />
                                    <br />

                                    <?php
                                    $jstat_rowx = 0;

                                    $jstat_query = $conn->query("select * from sub_results where subevent_id='$subevent_id' and judge_id='$j_id' and contestant_id='$getContestant_id'");
                                    while ($jstat_row = $jstat_query->fetch()) {
                                        $jstat_rowx = 1;
                                    }

                                    if ($jstat_rowx == 1) { ?>



                                        <form method="POST" action="edit_submit_judging.php">

                                            <input type="hidden" value="<?php echo $cont_row['fullname']; ?>" name="contestant_name" />
                                            <input type="hidden" value="<?php echo $getContestant_id; ?>" name="contestant_id" />
                                            <input type="hidden" value="<?php echo $j_id; ?>" name="judge_id" />
                                            <input type="hidden" value="<?php echo $judge_ctr; ?>" name="judge_ctr" />
                                            <input type="hidden" value="<?php echo $se_MEidxx; ?>" name="mainevent_id" />
                                            <input type="hidden" value="<?php echo $subevent_id; ?>" name="subevent_id" />

                                            <table align="center" class="table table-bordered">

                                                <tr>
                                                    <?php

                                                    $totzxzxzxzxz = 0;

                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                    }

                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $random_red = dechex(rand(0x00, 0x60));
                                                        $random_green = dechex(rand(0x00, 0x60));
                                                        $random_blue = dechex(rand(0x00, 0x60));
                                                        $random_color = '#' . str_pad($random_red, 2, '0', STR_PAD_LEFT) 
                                                                            . str_pad($random_green, 2, '0', STR_PAD_LEFT) 
                                                                            . str_pad($random_blue, 2, '0', STR_PAD_LEFT);    
                                                    ?>
                                                    <td width="10" style="background-color: <?= $random_color ?>; color: white;">
                                                        <center>
                                                            <font size="2"><?php echo $crit_row['criteria'] . " - <b>" . $crit_row['percentage'] . "%</b>"; ?></font>
                                                        </center>
                                                    </td>

                                                    <?php } ?>
                                                </tr>

                                                <tr>
                                                    <?php
                                                    $totzxzxzxzxz = 0;
                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                    }

                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $colors = $crit_row['cr_color_code'];
                                                    ?>
                                                        <td width="10">
                                                            <center>
                                                                <input type="number" 
                                                                    class="form-control" 
                                                                    style="width: 97%;" 
                                                                    name="cp<?php echo $crit_row['criteria_ctr']; ?>" 
                                                                    value="<?php echo ${'s' . $crit_row['criteria_ctr']}; ?>"
                                                                    <?php echo ($pageStat != "Change") ? 'readonly' : ''; ?>
                                                                    onchange="validateScore(this, <?php echo $crit_row['percentage']; ?>)">
                                                            </center>
                                                        </td>
                                                    <?php } ?>
                                                </tr>


                                            </table>

                                            <tr>
                                                <td>
                                                    <?php if ($pageStat == "Change") {
                                                    ?>
                                                        <strong>COMMENTS:</strong><br />

                                                        <textarea name="jcomment<?php echo $index; ?>" class="form-control" style="width: 99%;" placeholder="Enter comments here..."><?php echo $comment1; ?></textarea>
                                                    <?php } else { ?>
                                                        <strong>COMMENTS:</strong><br />

                                                        <textarea readonly="true" name="jcomment" class="form-control" style="width: 99%;" placeholder="Enter comments here..."><?php echo $comment1; ?></textarea>
                                                    <?php } ?>
                                                </td>
                                            </tr>


                                </td>
                                </tr>
                            </table>

                            <div class="modal-footer">
                                <?php if ($totzxzxzxzxz > 100 or $totzxzxzxzxz < 100) {
                                            if ($totzxzxzxzxz > 100) { ?>
                                        <div class="alert alert-danger pull-right">

                                            <strong>The Total Percentage is over 100%. Pls. contact event organizer.</strong>
                                        </div>
                                    <?php }
                                            if ($totzxzxzxzxz < 100) { ?>
                                        <div class="alert alert-danger pull-right">

                                            <strong>The Total Percentage is under 100%. Pls. contact event organizer.</strong>
                                        </div>
                                    <?php }
                                        } else {
                                            if ($pageStat == "Change") { ?>

                                        <a title="click to cancel, changes made will never be save." href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $getContestant_id; ?>&pStat=xChange" class="btn btn-default"><i class="icon-remove"></i> <strong>CANCEL</strong></a>
                                        <button title="Click to update scores." type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>UPDATE</strong></button>
                                    <?php } else { ?>
                                        <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $getContestant_id; ?>&pStat=Change" class="btn btn-default"><i class="icon-pencil"></i> <strong>CHANGE</strong></a>
                                <?php }
                                        } ?>

                            </div>

                            </form>



                            <!-- end update --><!-- end update --><!-- end update --><!-- end update --><!-- end update --><!-- end update -->






                        <?php } else { ?>






                            <!-- submit --> <!-- submit --> <!-- submit --> <!-- submit --> <!-- submit --> <!-- submit --> <!-- submit -->

                            <form method="POST" action="submit_judging.php">

                                <input type="hidden" value="<?php echo $cont_row['fullname']; ?>" name="contestant_name" />
                                <input type="hidden" value="<?php echo $getContestant_id; ?>" name="contestant_id" />
                                <input type="hidden" value="<?php echo $j_id; ?>" name="judge_id" />
                                <input type="hidden" value="<?php echo $judge_ctr; ?>" name="judge_ctr" />
                                <input type="hidden" value="<?php echo $se_MEidxx; ?>" name="mainevent_id" />
                                <input type="hidden" value="<?php echo $subevent_id; ?>" name="subevent_id" />


                                <table align="center" style="width: 100%;">
                                    <tr>
                                        <td>

                                            <table align="center" class="table table-bordered">

                                                <tr>
                                                    <?php

                                                    $totzxzxzxzxz = 0;

                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $colors = $crit_row['cr_color_code'];
                                                        $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                        $random_red = dechex(rand(0x00, 0x60));
                                                        $random_green = dechex(rand(0x00, 0x60));
                                                        $random_blue = dechex(rand(0x00, 0x60));
                                                        $random_color = '#' . str_pad($random_red, 2, '0', STR_PAD_LEFT) 
                                                                            . str_pad($random_green, 2, '0', STR_PAD_LEFT) 
                                                                            . str_pad($random_blue, 2, '0', STR_PAD_LEFT); 
                                                    ?>

                                                        <td width="10" style="background-color: <?= $random_color ?>; color: white;">
                                                            <center>
                                                                <font size="2"><?php echo $crit_row['criteria'] . " - <b>" . $crit_row['percentage'] . "%</b>"; ?></font>
                                                            </center>
                                                        </td>

                                                    <?php } ?>
                                                </tr>


                                                <tr>
                                                    <?php
                                                    $totzxzxzxzxz = 0;
                                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$subevent_id' order by criteria_ctr ASC");
                                                    while ($crit_row = $criteria_query->fetch()) {
                                                        $totzxzxzxzxz = $crit_row['percentage'] + $totzxzxzxzxz;
                                                    ?>
                                                        <td>
                                                            <center>
                                                                <input type="number" 
                                                                    class="form-control" 
                                                                    style="width: 90%;" 
                                                                    name="cp<?php echo $crit_row['criteria_ctr']; ?>" 
                                                                    min="-1"
                                                                    max="<?php echo $crit_row['percentage']; ?>"
                                                                    onchange="validateScore(this, <?php echo $crit_row['percentage']; ?>)">
                                                                    
                                                            </center>
                                                        </td>
                                                    <?php } ?>
                                                </tr>


                                            </table>

                                    <tr>
                                        <td>
                                            <strong>COMMENTS:</strong><br />
                                            <textarea name="jcomment" class="form-control" style="width: 99%;" placeholder="Enter comments here..."></textarea>
                                          
                                        </td>
                                    </tr>

                                    </td>
                                    </tr>
                                </table>





                                <div class="modal-footer">

                                    <?php if ($totzxzxzxzxz > 100 or $totzxzxzxzxz < 100) {
                                            if ($totzxzxzxzxz > 100) { ?>
                                            <div class="alert alert-danger pull-right">
                                                <strong>The Total Percentage is over 100%. Pls. contact event organizer.</strong>
                                            </div>
                                        <?php }

                                            if ($totzxzxzxzxz < 100) { ?>
                                            <div class="alert alert-danger pull-right">
                                                <strong>The Total Percentage is under 100%. Pls. contact event organizer.</strong>
                                            </div>
                                        <?php }
                                        } else { ?>
                                        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> <strong>SUBMIT</strong></button>
                                    <?php  } ?>

                                </div>

                            </form>

                            <!-- END submit --><!-- END submit --><!-- END submit --><!-- END submit --><!-- END submit --><!-- END submit -->

                    <?php }
                                } ?>






            </div>
        </div>
    </div>



    <div class="footer">


        <?php

                        if ($pageStat == "Change") {
                            $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' AND contestant_id='$getContestant_id'");
                            while ($cont_row = $cont_query->fetch()) {
                                $con_idTab = $cont_row['contestant_id'];
        ?>
                <strong>Edit Score Mode :</strong> <?php echo $cont_row['fullname']; ?>
            <?php }
                        } else {

                            $cont_query = $conn->query("select * from contestants where subevent_id='$subevent_id' order by contestant_ctr");
                            while ($cont_row = $cont_query->fetch()) {
                                $con_idTab = $cont_row['contestant_id'];

            ?>
                <?php if ($getContestant_id == $con_idTab) { ?>
                    <strong><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><?php echo $cont_row['fullname']; ?></a></strong> &middot;
                <?php } else { ?>
                    <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=<?php echo $con_idTab; ?>"><?php echo $cont_row['fullname']; ?></a> &middot;
            <?php }
                            } ?>
            <?php if ($getContestant_id == "allTally") { ?>
                <strong><a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=allTally">View Tally</a></strong>
                <a href="selection.php"><strong>
                        <font color="red">Exit</font>
                    </strong></a>
            <?php } else { ?>
                <a href="judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>&contestant_id=allTally">View Tally</a>
        <?php  }
                        } ?>






        <div class="container">
            <center>

                <?php include('footer.php'); ?>
             


            </center>

        </div>

    </div>



<?php }
                } else { ?>

<hr />
<a class="btn btn-danger btn-block" href="selection.php">Back to Selection Panel</a>


<?php include('footer.php'); ?>


<?php } ?>



<script>
function validateScore(inputElement, maxScore) {
    var enteredScore = parseFloat(inputElement.value);
    if (enteredScore > maxScore) {
        alert("You can only enter score up to " + maxScore);
        inputElement.value = ''; // Reset the input field
        return false;
    }
    return true;
}
</script>





<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap-modal.js"></script> <!-- or bootstrap.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

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