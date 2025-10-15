<!DOCTYPE html>
<html lang="en">
  
<?php
include('header2.php');
?>

<body>
    
    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

 
        </div>
      </div>
    </div>
    <!-- ... Navbar content ... -->

    <header class="jumbotron subhead" id="overview">
  <div class="container">
    <center><h2>Southwestern University PHINMA - Event Tabulating System</h2></center>
   
  </div>
</header>

<div class="container">        
        <?php include 'csrf.php'; ?>
        <form method="POST" action="reset_password.php">
            <?php echo csrf_field(); ?>
            <br />  
            <table cellpadding="10" cellspacing="0" border="0" align="center">
                <thead>
                    <th align="center" style="background-color: #A24857; text-indent: 7px; color: white;"><h4>RESET PASSWORD</h4></th>
                </thead>
                <tr style="background-color: #D3D3D3;">
                    <td>
                        <?php if (!empty($error)): ?>
                            <p style="color: red;"><?php echo $error; ?></p>
                        <?php endif; ?>

                        <h5><i class="icon-user"></i> EMAIL:</h5>
                        <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="email" placeholder="Email" required="true" autofocus="true" />
                        
                        <h5><i class="icon-lock"></i> NEW PASSWORD:</h5>
                        <div style="position: relative;">
                            <input style="font-size: large; height: 35px !important; text-indent: 7px !important; padding-right: 30px;" class="form-control btn-block" type="password" id="newPassword" name="newPassword" placeholder="New Password" required="true" />
                            <span style="position: absolute; right: 10px; top: 10px; cursor: pointer;" onclick="togglePasswordVisibility()">
                                <i id="eyeIcon" class="icon-eye-open"></i> <!-- Eye icon (can use Font Awesome or similar library) -->
                            </span>
                        </div>
                        <h5><i class="icon-lock"></i> CONFIRM NEW PASSWORD:</h5>
                        <div style="position: relative;">
                            <input style="font-size: large; height: 35px !important; text-indent: 7px !important; padding-right: 30px;" class="form-control btn-block" type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required="true" />
                            <span style="position: absolute; right: 10px; top: 10px; cursor: pointer;" onclick="togglePasswordVisibility()">
                                <i id="eyeIcon" class="icon-eye-open"></i> <!-- Eye icon (can use Font Awesome or similar library) -->
                            </span>
                        </div>
                        <br />
                        <button style="width: 160px !important;" type="submit" class="btn btn-success pull-right"> <strong>RESET PASSWORD</strong></button>
                        <br />
                        <br />
                        <strong>Remembered your password? Login <a href="index.php">here &raquo;</a></strong> &nbsp;&nbsp;&nbsp;  <br />
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("newPassword");
            var passwordInput1 = document.getElementById("confirmNewPassword");
            var eyeIcon = document.getElementById("eyeIcon");
            if (passwordInput.type === "password" && passwordInput1.type === "password") {
                passwordInput.type = "text";
                passwordInput1.type = "text";
                eyeIcon.className = "icon-eye-close"; // Change the icon (assuming you're using an icon library)
            } else {
                passwordInput.type = "password";
                passwordInput1.type = "password";
                eyeIcon.className = "icon-eye-open"; // Change back the icon
            }
        }
    </script>





    <!-- Footer -->
    <footer class="footer">
        <div class="container d-flex justify-content-center">
            <font size="2"><strong>Southwestern University PHINMA - Event Tabulating System &COPY; <?= date("Y") ?> </strong></font> <br />
        </div>
    </footer>

    <!-- Scripts -->
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
