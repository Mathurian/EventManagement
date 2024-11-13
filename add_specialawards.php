<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
include('session.php');

$sub_event_id = $_GET['sub_event_id'] ?? '';
$se_name = $_GET['se_name'] ?? '';

?>

<script type="text/javascript" src="bootstrap/js/jquery-latest.js"></script>

<body>
    <!-- Navbar ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <!-- Navigation content -->
            </div>
        </div>
    </div>
    <header class="jumbotron subhead" id="overview">
        <div class="container">
            <h1><?php echo htmlspecialchars($se_name); ?> Settings</h1>
            <p class="lead">SWU-ETS</p>
        </div>
    </header>

    <div class="container">
        <div class="span12">
            <br />
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="home.php">Event Management</a></li>
                    <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo htmlspecialchars($sub_event_id); ?>&se_name=<?php echo htmlspecialchars($se_name); ?>"><?php echo htmlspecialchars($se_name); ?> Settings</a></li>
                    <li>Add Special Awards</li>
                </ul>
            </div>

          
            <?php
                // Assuming $conn is your PDO database connection
                $stmt = $conn->prepare("SELECT MAX(awards_ctr) as awards_count FROM special_awards WHERE subevent_id = :sub_event_id");
                $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $current_awards_count = ($data['awards_count'] ?? 0) + 1;
            ?>

            <form method="POST">
                <input value="<?php echo htmlspecialchars($sub_event_id); ?>" name="sub_event_id" type="hidden" />
                <input value="<?php echo htmlspecialchars($se_name); ?>" name="se_name" type="hidden" />

                <table align="center" style="width: 45% !important;">
                    <tr>
                        <td>
                            
                        <div style="width: 100% !important; margin-left: auto; margin-right: auto;" class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="text-align: center;">Add Special Awards</h3>
                            </div>
                            <div class="panel-body" style="text-align: center;">
                                <div id="main">
                                    <div class="my-formsa">
                                        <p class="text-boxsa">
                                            <label for="boxsa1">Special Award <span class="boxsa-number"><?php echo $current_awards_count; ?></span></label> <br />
                                            <input type="text" name="special_awards[]" placeholder="Award Name" required> <br />
                                            <input type="number" style="margin-top: 5px !important;" name="scores[]" placeholder="Score" required><br>       
                                        </p>
                                        <p><a class="add-boxsa" href="#">Add Special Award</a></p>

                                        <button type="submit" name="add_awards" class="btn btn-primary">Save</button>
                                        <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>" class="btn btn-default">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var lastNumber = <?php echo $current_awards_count; ?>;
                                $('.my-formsa .add-boxsa').click(function() {
                                    lastNumber++;
                                    var boxsa_html = $('<p class="text-boxsa"><label for="boxsa' + lastNumber + '">Special Award <span class="boxsa-number">' + lastNumber + '</span></label> <br /> <input type="text" name="special_awards[]" placeholder="Award Name" required /> <br /> <input type="number" style="margin-top: 5px !important;" name="scores[]" placeholder="Score" required /> <br /> <a href="#" class="remove-boxsa">Remove</a></p>');
                                    boxsa_html.hide();
                                    $('.my-formsa p.text-boxsa:last').after(boxsa_html);
                                    boxsa_html.fadeIn('slow');
                                    return false;
                                });

                                function validateScores() {
                                    var valid = true;
                                    $('input[name="scores[]"]').each(function() {
                                        var score = parseInt($(this).val(), 10);
                                        if (score < 1 || score > 10) {
                                            alert('Only scores between 1 to 10 are allowed.');
                                            $(this).focus(); // Focus on the invalid input
                                            valid = false;
                                            return false; // Break the loop
                                        }
                                    });
                                    return valid;
                                }

                                // Attach the validation function to the form's submit event
                                $('form').submit(function(e) {
                                    if (!validateScores()) {
                                        e.preventDefault(); // Prevent form submission if validation fails
                                    }
                                });

                                $('.my-formsa').on('click', '.remove-boxsa', function() {
                                    $(this).parent().css('background-color', '#FF6C6C');
                                    $(this).parent().fadeOut("slow", function() {
                                        $(this).remove();
                                        $('.boxsa-number').each(function(index) {
                                            $(this).text(index + lastNumber - 1);
                                        });
                                    });
                                    return false;
                                });
                            });
                        </script>

    <?php
// Place this at the top of your add_specialawards.php file

if (isset($_POST['add_awards'])) {
    // Extract the Sub Event ID and Event Name from the POST request
    $sub_event_id = $_POST['sub_event_id'] ?? null;
    $se_name = $_POST['se_name'] ?? null;

    // Initialize an array to keep track of errors
    $errors = [];
    $success = false;

    // Check if the Sub Event ID is provided
    if (empty($sub_event_id)) {
        $errors[] = "Sub Event ID is required.";
    }

    // Begin a transaction
    $conn->beginTransaction();

    try {
        // Get the next awards_ctr from the database
        $stmt = $conn->prepare("SELECT COALESCE(MAX(awards_ctr), 0) + 1 AS next_awards_ctr FROM special_awards WHERE subevent_id = :sub_event_id");
        $stmt->bindParam(':sub_event_id', $sub_event_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $next_awards_ctr = $result['next_awards_ctr'];

        // Prepare the statement to insert the special award
        $stmt = $conn->prepare("INSERT INTO special_awards (subevent_id, special_awards, score, awards_ctr) VALUES (:sub_event_id, :special_awards, :score, :awards_ctr)");

        // Loop through each award field in the submitted form
        foreach ($_POST['special_awards'] as $index => $award_name) {
            if (empty($award_name)) {
                continue; // Skip empty award names
            }
            $score = $_POST['scores'][$index] ?? 0;

            // Execute the statement using the next_awards_ctr from the database
            $stmt->execute([
                ':sub_event_id' => $sub_event_id,
                ':special_awards' => $award_name,
                ':score' => $score,
                ':awards_ctr' => $next_awards_ctr++
            ]);
        }

        // Commit the transaction
        $conn->commit();
        $success = true;
    } catch (PDOException $e) {
        $conn->rollBack();
        $errors[] = $e->getMessage();
    }

    // Output the result
    if ($success) {
        $alertMessage = 'Special awards have been added successfully!';
    } else {
        $alertMessage = 'An error occurred: ' . implode(' ', $errors);
    }

    echo "<script type='text/javascript'>
            alert('".addslashes($alertMessage)."');
            window.location.href='sub_event_details_edit.php?sub_event_id=".urlencode($sub_event_id)."&se_name=".urlencode($se_name)."';
          </script>";
    exit;
}

?>


    <?php include('footer.php'); ?>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>
