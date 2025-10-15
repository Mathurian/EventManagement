 

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header2.php');
    include('session.php');
  ?>

 

  <body>
 
<!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
               
          <div class="nav-collapse collapse">
            <ul class="nav">

          
 
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>Judge Login</h1>
    <p class="lead">SWU-ETS</p>
  </div>
</header>
 
 <div class="container">
 
 <hr />
 
 <div id="myGroup">

    
     
           
            
                                            
         
           
            <div style="border: 0px;" class="accordion-group">
 
                <br /> 
 
             
             
             
              <div class="" id="judge">
             
                  <?php 
    $ame_query = $conn->query("SELECT * FROM main_event WHERE organizer_id = '$session_id' AND status='activated'");
    
            if($ame_query->rowCount()<=0)
            { ?>
             
               <div class="alert alert-warning"><h3><strong>NO ACTIVE EVENT</strong></h3></div>
            <?php }
            else
            {
                $ase_query = $conn->query("SELECT * FROM sub_event WHERE organizer_id = '$session_id' AND status='activated'");
                if($ase_query->rowCount()<=0)
            { ?>
            
                <div class="alert alert-warning"><h3><strong>NO ACTIVE SUB-EVENT</strong></h3></div>
           <?php }
            else
            {
                
            ?>
 
      
       <div class="input-group">
       <div class="alert alert-success alert-judge-login">
      <?php include 'csrf.php'; ?>
      <form method="POST" action="judge_profile.php" >
        <?php echo csrf_field(); ?>
            <h4>Judge's Code</h4>
            <br />
          <input id="myInputJC" style="font-size: large; height: 45px !important;" class="form-control btn-block" name="judge_code" type="password" placeholder="Enter Judge's Code" />
            <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionJC()"/> <strong>Show Code</strong></p>
                                    
                                    
                                    <script>
                                    function myFunctionJC() {
                                        var x = document.getElementById("myInputJC");
                                        if (x.type === "password") {
                                            x.type = "text";
                                        } else {
                                            x.type = "password";
                                        }
                                    }
                                    </script>
       
       <div class="pull-right">
        <button name="org_panel" class="btn btn-success" title="Click to proceed to Judging Panel"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
         <button class="btn btn-default" type="reset"><i class="icon-ban-circle"></i> <strong>CLEAR</strong></button>&nbsp;
         
     </div>
 
 
 </form>
        <br />
           </div>   
           
           
    </div> 
    
            
                
            <?php } } ?>
                
              </div>
              
              
           
           
     
            </div>
            
            
</div>

 
 
</div>
 
          
          
 <?php 

if(isset($_POST['org_panel']))
{
    
    $check_pass=$_POST['check_pass'];
    $user_password=$_POST['user_password'];
    // print($check_pass. " = " . $user_password);
    // exit;
  if($check_pass==$user_password) 
  {
   ?>
            <script>
            window.location = 'home.php';
            </script>
<?php   
  }
  else
  {
    ?>
                <script>
                window.location = 'judgelogin.php';
                alert('wrong pass');						
                </script>
<?php  
  } } ?>  

  
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
