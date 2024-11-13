<?php

include('dbcon.php');
session_start();

$error = '';

// Include PHPMailer classes to the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword']; 

    if ($newPassword !== $confirmNewPassword) {
        echo "<script>alert('Password does not match.'); window.location = 'forgot_password.php';</script>";
        exit;
    }

    $checkUser = $conn->prepare("SELECT * FROM organizer WHERE email = :email");
    $checkUser->bindParam(':email', $email, PDO::PARAM_STR);
    $checkUser->execute();

    if ($checkUser->rowCount() > 0) {
        $updatePassword = $conn->prepare("UPDATE organizer SET password = :password WHERE email = :email");
        $updatePassword->bindParam(':password', $newPassword, PDO::PARAM_STR);
        $updatePassword->bindParam(':email', $email, PDO::PARAM_STR);
        $updatePassword->execute();

        if ($updatePassword->rowCount() > 0) {
            // Send email notification
            $mail = new PHPMailer(true);

            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Replace with your mail server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'johnmarieygot21@gmail.com'; // Replace with your SMTP username
                $mail->Password   = 'jydr kyzs ejyf ewxv'; // Replace with your SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('johnmarieygot21@gmail.com', 'SWU-ETS');
                $mail->addAddress($email); // Add a recipient

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Password Updated Successfully';
                $mail->Body    = 'Hello,<br><br>Your password has been successfully updated. <br><br>Your new password: ' . $newPassword . ' ';
                $mail->AltBody = 'Hello, Your password has been successfully updated.';

                $mail->send();
            } catch (Exception $e) {
                // Handle errors here if you want to log or display error messages
            }

            echo "<script>alert('Password updated successfully'); window.location = 'index.php';</script>";
        } else {
            echo "<script>alert('Error updating password.'); window.location = 'forgot_password.php';</script>";
        }
    } else {
        echo "<script>alert('Email does not exist.'); window.location = 'forgot_password.php';</script>";
    }
}
?>

