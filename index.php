 

<!DOCTYPE html>
<html lang="en">
  
  <?php
  include('header2.php');
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
    <center><h2>Southwestern University PHINMA - Event Tabulating System</h2></center>
   
  </div>
</header>



        <div class="container">        
            <form method="POST" action="login.php">
                <br />  
                <table cellpadding="10" cellspacing="0" border="0" align="center">
                    <thead>
                        <th align="center" style="background-color: #A24857; text-indent: 7px; color: white;"><h4>ADMIN LOGIN</h4></th>
                    </thead>
                    <tr style="background-color: #D3D3D3;">
                        <td>
                            <h5><i class="icon-user"></i>  USERNAME:</h5>
                            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="username" placeholder="Username" required="true" autofocus="true" />
                            
                            <h5><i class="icon-lock"></i>  PASSWORD:</h5>
                            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="password"  name="password" placeholder="Password" required="true" />
                          
                            <a href="forgot_password.php" style="margin-top: 10px; display: block;">Forgot Password?</a>

                            <br />
                            <br />
                            <button style="width: 160px !important;" type="submit" class="btn btn-success pull-right"> <strong>LOGIN</strong></button>
                            <strong>Don't have an account? Register <a href="create_account.php">here &raquo;</a></strong> &nbsp;&nbsp;&nbsp;  <br />
                        </td>
                    </tr>
                </table>
            </form>
        </div>

 
   


    <!-- Footer
    ================================================== -->
    <footer class="footer">
        <div class="container d-flex justify-content-center">
            <font size="2"><strong>Southwestern University PHINMA - Event Tabulating System &COPY; <?= date("Y") ?> </strong></font> <br />
        </div>
    </footer>


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
