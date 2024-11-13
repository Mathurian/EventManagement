 

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
     
     
  ?>
  <script type="text/javascript" src="bootstrap/js/jquery-latest.js"></script>
  <body>
 <!-------- DATA PRIVACY ACT MODAL -------->

<!-- Data Privacy Act Modal -->
<div id="dataPrivacyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dataPrivacyModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="dataPrivacyModalLabel">Data Privacy Act of 2012</h4>
      </div>
      <div class="modal-body" style="height: 400px; overflow-y: auto;">
        <center><h3><strong>SWU-ETS PRIVACY POLICY</strong></h3></center> <br />
        <p><strong>INTRODUCTION:</strong></p>
        <p>SWU-ETS upholds the privacy of its stakeholders and safeguards the personal data it gathers. In line with the Data Privacy Act, the Company ensures that its data collection and processing operations are executed with full transparency and adhere strictly to established legal purposes and proportionality.</p>
        <p><strong>DATA CONTROLLER:</strong></p>
        <p>SWU-ETS is the Data Controller responsible for the handling of personal data. The Company takes accountability for the information it collects, ensuring that it aligns with the privacy expectations of its users and the regulatory requirements. For any inquiries or concerns about the way personal information is managed, users can reach out directly to the administrative office of SWU-ETS via the following:</p>
        <p>Email Address: swuets@gmail.com</p>
        <p><strong>PERSONAL DATA COLLECTION:</strong></p>
        <p>SWU-ETS's data collection is confined to personal information such as names and email addresses. This data is essential for the provision of the Company's services and for maintaining communication with users</p>
        <p><strong>USE OF PERSONAL DATA:</strong></p>
        <p>The processing of personal data by the Company is limited to essential service delivery and effective user communication. The processing is conducted upon obtaining explicit consent from the users</p>
        <p><strong>USER RIGHTS UNDER THE DATA PRIVACY ACT:</strong></p>
        <p>Users retain the right to access, rectify, or erase their personal data in the Company's possession. SWU-ETS provides mechanisms for users to withdraw consent and to opt out of communications, ensuring the respect of user privacy.</p>
        <p><strong>DATA SECURITY:</strong></p>
        <p>SWU-ETS is committed to protecting users' personal data against unauthorized access and potential data breaches through robust security protocols.</p>
        <p><strong>DATA RETENTION:</strong></p>
        <p>SWU-ETS retains personal data only as long as necessary for the provision of services or as mandated by law.</p>
        <p><strong>POLICY UPDATES:</strong></p>
        <p>SWU-ETS may revise this Data Privacy Policy to reflect changes in legal requirements or adjustments in data handling procedures. Users will be notified of significant policy updates.</p>
        <p><strong>GOVERNING LAW:</strong></p>
        <p>This policy is crafted under the mandate of the Data Privacy Act and illustrates SWU-ETS's commitment to data protection.</p>
        <p><strong>CONSENT:</strong></p>
        <p>By disclosing personal information to SWU-ETS, users consent to the data handling practices detailed in this policy.</p>
        
      </div>
      <div class="modal-footer">
      <div class="form-check" style="float: left; margin-right: 10px;">
          <input type="checkbox" class="form-check-input" id="dataPrivacyAgreement">
          <label class="form-check-label" for="dataPrivacyAgreement">I agree to the Data Privacy Act of 2012</label>
        </div>
        <button type="button" class="btn btn-success btn-default" data-dismiss="modal" id="closeModalButton" disabled>Okay</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#dataPrivacyModal').modal('show');
  });
</script>

<script>
  document.getElementById('dataPrivacyAgreement').addEventListener('change', function() {
    document.getElementById('closeModalButton').disabled = !this.checked;
});
</script>



  

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
    <h1><?php echo $se_name; ?> Settings</h1>
    <p class="lead">SWU-ETS</p>
  </div>
</header>


<div class="container">

<div class="span12">



                <br />
                <div class="col-md-12">
                    <ul class="breadcrumb">
  
                    
                        <li><a href="home.php">Event Management</a></li>
                        
                        <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
                        
                        <li>Add Contestant</li>
                        
                    </ul>
                </div>
                
                

   <form method="POST" enctype="multipart/form-data">
   <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 
  
   
   
   
   <table align="center" style="width: 40% !important;">
 <tr>
 <td>
 

 <div style="width: 100% !important;" class="panel panel-primary">
 
 
            <div class="panel-heading">
              <h3 class="panel-title">Add Contestant</h3>
            </div>
 
 


 
     <div class="panel-body">
 
   <table align="center">
  
 
   <tr>
    
   <td>

      <?php
        $result = $conn->query("SELECT COUNT(*) as count FROM contestants WHERE subevent_id='$sub_event_id'");
        $row = $result->fetch();
        $contestant_count = $row['count'];
      ?>


<form method="post" action="" enctype="multipart/form-data">
   <div id="main">
     
    <div class="my-form">


            <p class="text-box">
            <label for="box1">Contestant No. <span class="box-number"><?php echo $contestant_count + 1; ?></span></label>
               <br />
                <input type="text" placeholder="Last Name" name="con1_lname" value="" id="box1"> <br />
                <input type="text" style="margin-top: 5px !important;" placeholder="First Name" name="con1_fname" value="" id="box1"> <br />
                <input type="text" style="margin-top: 5px !important;" placeholder="Middle Name" name="con1_mname" value="" id="box1"> <br />
                <input type="text" style="margin-top: 5px !important;" placeholder="Department" name="con1_department" value="" id="box1"> <br />
                <input type="text" style="margin-top: 5px !important;" placeholder="Contact" name="con1_contact" value="" id="box1"> <br />
                <input type="hidden" style="margin-top: 5px !important;" value="<?php echo rand(100000,999999); ?>" name="rand1" value="" id="box2"> <br />
                <label for="con1_image">Upload Image</label> <br />
                <input type="file" name="con1_image" id="con1_image"> <br />

            </p>
            <p><a class="add-box" href="#">Add Contestant</a></p>
      
    </div>
</div>

<script type="text/javascript">
let currentContestantNumber = <?php echo $contestant_count + 2; ?>; 
let maxContestants = 19;
let totalContestants = <?php echo $contestant_count; ?>;
let remainingContestants = maxContestants - totalContestants;

jQuery(document).ready(function($) {
    $('.my-form .add-box').click(function() {
        if (totalContestants >= maxContestants) {
            alert('You can only add up to 20 contestants.');
            return false;
        }
        var box_html = $(
     '<p class="text-box"><label for="box' + currentContestantNumber + '">Contestant No. <span class="box-number">' + currentContestantNumber + '</span></label> <br /> <input type="text"  placeholder="Last Name" name="con' + currentContestantNumber + '_lname" value="" id="box' + currentContestantNumber + '" required="true" /> <br /> <input type="text" style="margin-top: 5px !important;" placeholder="First Name" name="con' + currentContestantNumber + '_fname" value="" id="box' + currentContestantNumber + '" required="true" /> <br /> <input type="text" style="margin-top: 5px !important;" placeholder="Middle Name" name="con' + currentContestantNumber + '_mname" value="" id="box' + currentContestantNumber + '"> <br /> <input type="text" style="margin-top: 5px !important;" placeholder="Department" name="con' + currentContestantNumber + '_department" value="" id="box' + currentContestantNumber + '" required="true" /> <br /> <input type="text" style="margin-top: 5px !important;" placeholder="Contact Number" name="con' + currentContestantNumber + '_contact" value="" id="box' + currentContestantNumber + '" required="true" /> <br /> <input type="hidden" value="<?php echo rand(100000,999999); ?>' + currentContestantNumber + '" name="con' + currentContestantNumber + '_rand" id="box' + currentContestantNumber + '" required="true" /> <label for="con' + currentContestantNumber + '_image">Upload Image</label> <br /> <input type="file" name="con' + currentContestantNumber + '_image" id="con' + currentContestantNumber + '_image" /> <a href="#" class="remove-box">Remove</a></p>'
);
        box_html.hide();
        $('.my-form p.text-box:last').after(box_html);
        box_html.fadeIn('slow');
        
         currentContestantNumber++;
        totalContestants++; 

        return false;
    });
    $('.my-form').on('click', '.remove-box', function() {
        const currentBox = $(this).parent();
        currentBox.css('background-color', '#FF6C6C');
        currentBox.fadeOut("slow", function() {
            const followingBoxes = currentBox.nextAll();
            followingBoxes.each(function() {
                const currentNumber = parseInt($(this).find('.box-number').text());
                $(this).find('.box-number').text(currentNumber - 1);
            });
            currentBox.remove();
            currentContestantNumber--;  
            totalContestants--;
        });
        remainingContestants++;
        return false;
    });
});
</script>

<script>
    $(document).ready(function() {
      $('#dataPrivacyModal').modal('show');
    });
</script>


  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3" align="right"><button name="add_contestant" class="btn btn-primary">Save</button> <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;</td>
  </tr>
  
  </table>
 </form>
</div>
 
          </div>
 </td>
 </tr>
 </table> 
 
 
          </div>
          
    </div>      
    <?php 

if (isset($_POST['add_contestant'])) {

    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];
    $basePath = 'contestant_image/';
    $successfulUploads = 0;
    $stmtMaxCtr = $conn->prepare("SELECT MAX(contestant_ctr) as maxCtr FROM contestants WHERE subevent_id = ?");
    $stmtMaxCtr->execute([$sub_event_id]);
    $row = $stmtMaxCtr->fetch();
    $currentMaxCtr = $row['maxCtr'] ?? 0;  
  
    for ($i = 1; $i <= 20; $i++) {
        $lname = $_POST["con{$i}_lname"] ?? '';
        $fname = $_POST["con{$i}_fname"] ?? '';
        $mname = $_POST["con{$i}_mname"] ?? '';
        $department = $_POST["con{$i}_department"] ?? '';
        $contact = $_POST["con{$i}_contact"] ?? '';
        $image = $_FILES["con{$i}_image"]['name'] ?? '';
        $rand_code = $_POST["rand{$i}"] ?? '';

        if (!empty($lname) && !empty($fname)) {
            $currentMaxCtr++; 
            $imagePath = $basePath . basename($image);

            $stmtInsert = $conn->prepare("INSERT INTO contestants (lname, fname, mname, department, contact, image_url, subevent_id, contestant_ctr, rand_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->execute([$lname, $fname, $mname, $department, $contact, $image, $sub_event_id, $currentMaxCtr, $rand_code]);

            if (move_uploaded_file($_FILES["con{$i}_image"]['tmp_name'], $imagePath)) {
                $successfulUploads++;
            }
        }
    }

    if ($successfulUploads > 0) {
        echo '<script>
            window.location = "sub_event_details_edit.php?sub_event_id=' . $sub_event_id . '&se_name=' . $se_name . '";
            alert("Contestants have been added successfully");
        </script>';
    }
}

?>

<?php include('footer.php'); ?>

  
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
