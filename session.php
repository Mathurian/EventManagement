<?php
include('dbcon.php');
//Start session
 session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['id']) || ($_SESSION['id'] == '')) {
	header('Location: index.php');
	exit();
}

$session_id=$_SESSION['id'];

$session_access=$_SESSION['useraccess'];

$tabname="";

if($session_access=="Organizer")
{
$user_stmt = $conn->prepare("SELECT * FROM organizer WHERE organizer_id = :id");
$user_stmt->execute([':id' => $session_id]);
$user_row = $user_stmt->fetch();

}
else
{
$session_userid=$_SESSION['userid'];
$user_stmt1 = $conn->prepare("SELECT * FROM organizer WHERE organizer_id = :id");
$user_stmt1->execute([':id' => $session_id]);
$user_row = $user_stmt1->fetch();


$tab_stmt = $conn->prepare("SELECT * FROM organizer WHERE organizer_id = :id");
$tab_stmt->execute([':id' => $session_userid]);
$tab_row = $tab_stmt->fetch();
$tabname = $tab_row['fname']." ".$tab_row['mname']." ".$tab_row['lname'] ;    
}



$name = $user_row['fname']." ".$user_row['mname']." ".$user_row['lname'] ;



$check_pass = $user_row['password'];
$pnum = $user_row['pnum'];
$email = $user_row['email'];



$company_name = $user_row['company_name'];
$company_address = $user_row['company_address'];
$company_logo = $user_row['company_logo'];
$company_telephone = $user_row['company_telephone'];
$company_email = $user_row['company_email'];
$company_website = $user_row['company_website'];
 

?>