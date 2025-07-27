<?php

header('Content-Type: application/json');
include("../Admin-Panel/config/db.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$name = $_POST['register_username'] ?? '';
$email = $_POST['register_email'] ?? '';
$password = $_POST['register_password'] ?? '';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$sql_check = "SELECT id FROM users WHERE email = '$email' ";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows) {
    echo json_encode(['success' => false, 'error' => 'email']);
    exit;
} else {




    // Insert OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp_record'] = $otp;
    $sql = "INSERT INTO otp_verification (name, email, otp,password) VALUES ('$name','$email','$otp','$hashedPassword')";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Failed to save OTP']);
        exit;
    }

    $_SESSION['signup_email'] = $email;

    // Send email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abdullahsidzz333@gmail.com';
        $mail->Password   = 'kohf gfst sfdv zfyu';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('abdullahsidzz333@gmail.com', 'Ecoverse');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Your One-Time Password (OTP) for Signup';
        $mail->Body = "
    <p>Dear <b>$name</b>,</p>
    <p>Thank you for signing up with us!</p>
    <p>Your One-Time Password (OTP) for completing your signup is:</p>
    <h2 style='color:#2c3e50;'>$otp</h2>
    <p>Please enter this OTP within the next 10 minutes to verify your account.</p>
    <p>If you did not request this, you can safely ignore this email.</p>
    <br>
    <p>Best regards,<br>
    The MyApp Team</p>
    ";

        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
        exit;
    }
    // ✅ All good
    echo json_encode(['success' => true]);
    exit;
}
