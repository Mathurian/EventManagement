<?php

include('dbcon.php');
session_start();

$error = '';

// Include PHPMailer classes to the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/bootstrap.php';

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (file_exists(__DIR__ . '/csrf.php')) {
        include_once __DIR__ . '/csrf.php';
        if (!csrf_validate()) {
            echo "<script>alert('Invalid session token.'); window.location = 'forgot_password.php';</script>";
            exit;
        }
    }
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword']; 

    if ($newPassword !== $confirmNewPassword) {
        echo "<script>alert('Password does not match.'); window.location = 'forgot_password.php';</script>";
        exit;
    }

    $checkUser = $conn->prepare("SELECT organizer_id, email FROM organizer WHERE email = :email");
    $checkUser->bindParam(':email', $email, PDO::PARAM_STR);
    $checkUser->execute();

    if ($checkUser->rowCount() > 0) {
        // Hash new password securely
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePassword = $conn->prepare("UPDATE organizer SET password = :password WHERE email = :email");
        $updatePassword->bindParam(':password', $hash, PDO::PARAM_STR);
        $updatePassword->bindParam(':email', $email, PDO::PARAM_STR);
        $updatePassword->execute();

        if ($updatePassword->rowCount() > 0) {
            // Send email notification without exposing password
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = getenv('SMTP_USER') ?: '';
                $mail->Password   = getenv('SMTP_PASS') ?: '';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = getenv('SMTP_PORT') ?: 587;

                $fromEmail = getenv('SMTP_FROM') ?: ($mail->Username ?: 'no-reply@example.com');
                $fromName  = getenv('SMTP_FROM_NAME') ?: 'SWU-ETS';
                $mail->setFrom($fromEmail, $fromName);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Updated Successfully';
                $mail->Body    = 'Hello,<br><br>Your password has been updated successfully. If you did not request this change, please contact support immediately.';
                $mail->AltBody = 'Your password has been updated successfully.';

                if ($mail->Username && $mail->Password) {
                    $mail->send();
                }
            } catch (Exception $e) {
                // Silently ignore mail errors to not block UX
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

