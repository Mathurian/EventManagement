<!DOCTYPE html>
<html lang="en">
   
   <?php
   include('header2.php');
    include('session.php');
    ?>
<head>
<style>
button.accordion {
    background-color: #A24857;
    color: white;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
    border-radius: 10px;
}

button.accordion.active, button.accordion:hover {
    background-color: maroon;
}

button.accordion:after {
    content: '\002B';
    color: white;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

button.accordion.active:after {
    content: "\2212";
}

div.panel {
   /* display: flex;
   flex-direction: column;
   align-items: center; */
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}
.panel h4 {
             font-size: 18px; /* Larger font size for h4 */
             color: #333; /* Optional: color for h4 */
             margin-top: 15px; /* Spacing above h4 */
             font-weight: bold;
         }
.panel p {
             font-size: 16px; /* Larger font size for p */
             color: #444; /* Optional: color for p */
             line-height: 1.6; /* Line height for better readability */
         }
/* .content-container{
   display: flex;
   flex-direction: column;
   margin: 0px;
   padding: 0px;
} */
.image-container{
   display: flex;
   justify-content: center;
   align-items: center;
}
#text{
   font-size: 1rem;
   margin: 20px;
}
img {
   width: 800px;
   height: 400px;
   object-fit: cover;

}
h2{
   margin-bottom: 30px;
}
</style>
</head>
  <body data-spy="scroll" data-target=".bs-docs-sidebar">

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
          <a class="brand" href="#"> <font size="3">SWU-ETS</font></a>
 
          <div class="nav-collapse collapse">
            <ul class="nav">
            
             
      
                
                <?php
                if($tabname=="")
                { ?>
               
               
        
                <li>
                <a href="home.php">Event Management</a>
              </li>

              <li>
              <a href="sports_management.php">Sports Management</a>
            </li>
            
              <li>
                <a href="score_sheets.php">Reports</a>
              </li>
              
            
               <li>
                  <a href="rev_main_event.php">Event History</a>
              </li>
 
              
              <li class="active">
              <a href="user-guide.php"><strong>Help?</strong></a>
            </li>
              
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
 
              
              <li>
                  <a target="_blank" href="edit_organizer.php">Settings</a>
              </li>
 
              <li>
                <a href="logout.php">Logout <?php echo $name; ?></a>
              </li>
              
              
                    </ul>
                    </li>
                    
                    
                <?php } else { ?>
                
                
              
                 <li> <a href="logout.php">Tabulator: <b><?php echo $tabname ;?></b> - <i>logout</i></a></li>
 
               <?php  } ?>
 
            </ul>


          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <div class="container user-guide">
         <h2><center>USER-GUIDE FOR SWU PHINMA EVENT TABULATING SYSTEM</center></h2>
         <br>
         <!-- Introduction Section -->
         
         <button class="accordion"><strong>Introduction</strong></button>
         <div class="panel">
            <p><strong>Welcome to SWU-PHINMA Event Tabulating System, a comprehensive tabulating system designed to streamline the scoring and ranking processes in events such as pageants and sports competitions. This guide will assist event organizers in effectively using our system to enhance the efficiency and accuracy of event management.</strong></p>
         </div>

         <!-- System Overview Section -->
         <button class="accordion"><strong>System Overview</strong></button>
         <div class="panel">
            <div class="content-container">
               <h4>Our system offers a range of features to support event organizers, including:</h4>
               <ul>
                  <li id="text">Secure user authentication and role-based access control.</li>
                  <li id="text">An intuitive user interface for easy navigation.</li>
                  <li id="text">Automated tabulation of scores and rankings.</li>
                  <li id="text">Multiple reporting options for in-depth analysis.</li>
                  <li id="text">Robust data management for maintaining event integrity.</li>
               </ul>
            </div>
         </div>

         <!-- Getting Started Section -->
         <button class="accordion"><strong>Getting Started</strong></button>
         <div class="panel">
         <div class="image-container">
         <img src="images/login.png" alt="login">
         </div>
         <div class="content-container">
            <h4>Logging In</h4>
            <p>Users can create an account if they don't have one. After account creation, an email notification with login credentials is sent. Once logged in, users can proceed to login and navigate the dashboard.</p>

            <h4>Navigating the Dashboard</h4>
            <ul>
               <li id="text"><strong>Event Management:</strong> Manage events you have created.</li>
               <img src="images/event-management.png" alt="">
               <li id="text"><strong>Sports Management:</strong> Manage sports events you have created.</li>
               <img src="images/sports-management.png" alt="">
               <li id="text"><strong>Reports:</strong> Manage and print reports for each event.</li>
               <img src="images/reports.png" alt="">
               <li id="text"><strong>Event History:</strong> View the history of events, review results, and search for past events.</li>
               <img src="images/events-history.png" alt="">
               <li id="text"><strong>Help:</strong> Access the user guide for guidance and assistance.</li>
               <img src="images/help.png" alt="">
            </ul>
         </div>
      </div>

         <!-- Event Management Section -->
         <button class="accordion"><strong>Event Management</strong></button>
         <div class="panel">
         <div class="content-container">
            <h4>Creating an Event</h4>
            <p>- Navigate to the 'Event Management' section and click on '+Event'. Fill in the necessary event details and submit.</p>
            <img src="images/add-event.png" alt="">

            <h4>Managing Sub-Events</h4>
            <p>- Add sub-events by clicking 'Add Sub-Event'. Provide the required details for each sub-event.</p>
            <img src="images/add-subevent.png" alt="">

            <h4>Activating an Event</h4>
            <p>- Activate the event by clicking the 'Activate' button. This makes the event live for scoring and further management.</p>
            <img src="images/activate-button.png" alt="">

            <h4>Adding Event Details</h4>
            <p>- After activation, it will open another page where you can add details like contestants/contingents, judges, criteria, and special awards. You can always go back in this page by clicking the settings icon</p>
            <img src="images/add-event-details.png" alt="">

            <h4>Judging</h4>
            <p>- Admins or organizers should provide judges with codes to log in and access their assigned events for scoring.</p>
            <img src="images/judge-login.png" alt="">
         </div>
      </div>

         <!-- Sports Management Section -->
         <button class="accordion"><strong>Sports Management</strong></button>
         <div class="panel">
         <h4>Creating a Sports Event</h4>
         <p>- In 'Sports Management', add a new sports event with the required details.</p>
         <img src="images/add-sports-event.png" alt="">

         <h4>Adding Contestants/Contingents</h4>
         <p>- Enter details of the contestants or contingents participating in the sports event.</p>
         <img src="images/add-contingents.png" alt="">

         <h4>Adding Sports Categories</h4>
         <p>- Here you can simply add the sports in your event.</p>
         <img src="images/add-sports.png" alt="">

         <h4>Contestant Tagging in Sports</h4>
         <p>- Mark participation of each contestant in specific sports using checkboxes and save your selections.</p>
         <img src="images/sports-tagging.png" alt="">

         <h4> Tabulation</h4>
         <p>- Assign medals (gold, silver, bronze) to contestants in the tabulation section. The system will tally these for rankings.</p>
         <img src="images/sports-tabulation.png" alt="">

         <h4>View Rankings</h4>
         <p>- View and analyze the overall results in the rankings section after medal tabulation.</p>
         <img src="images/sports-ranking.png" alt="">
      </div>

      </div>
 

    <?php include('footer.php'); ?>


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


    <script>
         // Script for accordion
         var acc = document.getElementsByClassName("accordion");
         var i;

         for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
               this.classList.toggle("active");
               var panel = this.nextElementSibling;
               if (panel.style.maxHeight) {
                  panel.style.maxHeight = null;
               } else {
                  panel.style.maxHeight = panel.scrollHeight + "px";
               } 
            });
         }
      </script>

  </body>
</html>