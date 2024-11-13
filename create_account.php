
<!DOCTYPE html>
<html lang="en">

    <?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include('header.php');
    ?>

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
    <h1>Account Registration</h1>
    <p class="lead">SWU - ETS</p>
  </div>
</header>
    <div class="container">

  <div class="col-lg-3">
 
  </div>
  <div class="col-lg-6">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Event Organizer Registration Form</h3>
            </div>
            <div class="panel-body">
            
   <form method="POST">
 
    <table align="center">
    <tr><td colspan="7"><strong>Basic Information</strong><hr /></td></tr>
    <tr>
    <td>
    <label class="control-label" >Firstname:</label>
    <input type="text" name="fname" class="form-control" placeholder="Firstname" aria-describedby="basic-addon1" required autofocus>
 </td>
    <td>&nbsp;</td>
    <td>
    <label class="control-label" >Middlename:</label>
    <input type="text" name="mname" class="form-control" placeholder="Middlename" aria-describedby="basic-addon1" required autofocus>
 </td>
    <td>&nbsp;</td>
    <td>
    <label class="control-label" >Lastname:</label>
    <input type="text" name="lname" class="form-control" placeholder="Lastname" aria-describedby="basic-addon1" required autofocus>
 </td>
    <td>&nbsp;</td>
    <td>
    <label class="control-label" >Email Address:</label>
    <input type="text" name="email" class="form-control" placeholder="Email Address" aria-describedby="basic-addon1" required autofocus>
 </td>
    </tr>
    
    
     <tr><td colspan="7">&nbsp;</td></tr>
     <tr><td colspan="7"><strong>Account Security</strong><hr /></td></tr>
     <tr>
    <td>
    <label class="control-label" >Username:</label>
    <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required autofocus>
 </td>
    <td>&nbsp;</td>
    <td>
    <label class="control-label" >Password:</label>
    <input id="password" type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
 </td>
    <td>&nbsp;</td>
    <td>
    <label class="control-label" >Confirm Pass:</label>
    <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
 </td>
 
    </tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    <td><span id='message'></span></td>
    </tr>
    
    
    </table>
 <br />
       <div class="btn-group pull-right">
  <button name="register" type="submit" class="btn btn-primary">Register</button>
  <a href="index.php" type="button" class="btn btn-default">Cancel</a>
  
  
   </form>
   
</div>
<strong>Already have an account? Login <a href="index.php">here &raquo;</a></strong> &nbsp;&nbsp;&nbsp; 
    
            </div>
          </div>
  </div>
  <div class="col-lg-3">
 
  </div>
 
          </div>
          
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container" style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <font size="2"><strong>Southwesterm University PHINMA - Event Tabulating System &middot; &COPY; <?= date("Y") ?></strong></font>
      </div>
    </footer>
   
   


    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="javascript/jquery1102.min.js"></script>
    
    
    
     <script>
 
    $('#password, #confirm_password').on('keyup', function () {
      if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
      } else 
        $('#message').html('Not Matching').css('color', 'red');
    });
    
    </script>


  </body>
</html>


<?php 
if(isset($_POST['register'])) {
    include('dbcon.php'); // Assuming dbcon.php returns a PDO connection in $conn

    $fname = $_POST['fname']; 
    $mname = $_POST['mname'];  
    $lname = $_POST['lname']; 
    $email = $_POST['email']; 
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    $password2 = $_POST['password2'];  

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM organizer WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Username already exists
        echo "<script>alert('Username already exists. Please choose another username.');</script>";
    } else {
        // Proceed with registration
        if ($password == $password2) {
            // Insert new organizer
            $insertStmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, email, username, password, access, status) VALUES (:fname, :mname, :lname, :email, :username, :password, 'Organizer', 'offline')");
            $insertStmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $insertStmt->bindParam(':mname', $mname, PDO::PARAM_STR);
            $insertStmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
            $insertStmt->bindParam(':password', $password, PDO::PARAM_STR); // Consider using password_hash for security
            $insertStmt->execute();

            // Send email notification

            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);

            try {
                // SMTP configuration
                $mail->SMTPDebug = 2; // Enable verbose debug output
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Replace with your mail server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'johnmarieygot21@gmail.com'; // Replace with your SMTP username
                $mail->Password   = 'jydr kyzs ejyf ewxv'; // Replace with your SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('johnmarieygot21@gmail.com', 'SWU-ETS'); // Replace with your from address
                $mail->addAddress($email, $fname); // Add a recipient

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Account Registration Confirmation';
                $mail->Body    = 'Hello ' . $fname . ',<br><br>Your account has been successfully created. <br><br>Username: ' . $username . ' <br><br> Password: ' . $password . ' ';
                $mail->AltBody = 'Hello ' . $fname . ',\n\nYour account has been successfully created.';

                $mail->send();
                echo 'Email has been sent';
            } catch (Exception $e) {
                echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }

            echo "<script>
                    alert('Organizer $fname $mname $lname registered successfully!');
                    window.location = 'index.php';
                  </script>";
        } else {
            echo "<script>alert('Passwords do not match.');</script>";
        }
    }
}
?>



 
