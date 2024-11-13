<!DOCTYPE html>
<html lang="en">
   
   <?php
   include('header2.php');
    include('session.php');
    ?>
<head>
<style>
        .video-container {
            position: relative;
            padding-bottom: 30%; /* 16:9 Aspect Ratio */
            padding-top: 25px;
            height: 0;
            margin-bottom: 50px;

        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%; /* Your desired width */
            height: 100%; /* Your desired height */
        }
        button {
            margin-left: 50px;
        }
        h1{
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
  <body data-spy="scroll" data-target=".bs-docs-sidebar">

   <!-- Navbar -->
   <div class="navbar navbar-inverse navbar-fixed-top custom-navbar">
        <div class="navbar-inner">
            <button type="button" id="backButton" class="btn btn-success">
                Back
            </button>
            <!-- Other navbar content -->
        </div>
    </div>
    <br><br>

    <!-- Centered Video Container -->
    
    <h1>SWUETS - JUDGE USER GUIDE</h1>
    <div class="video-container">
        
        <iframe src="https://www.youtube.com/embed/NPcsJ13Ghnc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script>
        document.getElementById('backButton').addEventListener('click', function() {
            window.history.back();
        });
    </script>


    

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