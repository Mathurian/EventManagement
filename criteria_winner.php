<!DOCTYPE html>
<html lang="en">
<head>
    <title>Winners Per Criteria</title>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="span12">
            <center>
                <h2>Winners for Each Criteria</h2>
            </center>

            <?php
            include('header2.php');
            include('session.php');
            $event_id = $_GET['mainevent_id'];
            $judge_id = $_GET['judge_id'];

            $criteria_query = $conn->query("select * from criteria where subevent_id='$event_id' ORDER BY criteria_ctr ASC");
            while ($crit_row = $criteria_query->fetch()) {
                $winnerQuery = $conn->query("SELECT contestants.fname, contestants.lname, sub_results.total_score FROM sub_results 
                                            INNER JOIN contestants ON sub_results.contestant_id = contestants.contestant_id
                                            WHERE sub_results.subevent_id='$event_id' AND sub_results.judge_id='$judge_id'
                                            ORDER BY sub_results.criteria_ctr" . $crit_row['criteria_ctr'] . " DESC LIMIT 1");
                $winner = $winnerQuery->fetch();
                echo "<h4>" . $crit_row['criteria'] . " Winner: " . $winner['fname'] . " " . $winner['lname'] . " with Score: " . $winner['total_score'] . "</h4>";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
