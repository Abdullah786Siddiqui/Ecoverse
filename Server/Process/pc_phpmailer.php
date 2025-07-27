<?php
session_start();

header('Content-Type: application/json');
include("../Admin-Panel/config/db.php");
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$user_id = $_SESSION['user_id'] ?? 0;
$response = ['status' => 'error', 'message' => 'Something went wrong.'];

$sql = "SELECT email ,name FROM users WHERE id = $user_id ";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
  $response['message'] = 'User not found.';
  echo json_encode($response);
  exit;
}
$user = $result->fetch_assoc();
$email = $user['email'];
$name = $user['name'];


// generate token
$token = bin2hex(random_bytes(16));
$expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
$sql2 = "UPDATE users SET email_token = '$token' , token_expiry = '$expiry' WHERE id = $user_id  ";
if (!$conn->query($sql2)) {
  $response['message'] = 'Failed to update token in database.';
  echo json_encode($response);
  exit;
}

$verify_link = "http://localhost/Ecomerse-Website/Server/Process/pc_verifyemail.php?token=$token";
$mail = new PHPMailer(true);
try {
  // SMTP settings
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'abdullahsidzz333@gmail.com';
  $mail->Password = 'kohf gfst sfdv zfyu';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('abdullahsidzz333@gmail.com', 'Ecoverse');
  $mail->addAddress($email, $name);

  $mail->isHTML(true);
  $mail->Subject = 'Verify your email address';

  $mail->Body = "
  <div style='background-color: #f9f9f9; padding: 30px; font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
    <table width='100%' cellpadding='0' cellspacing='0' style='max-width: 600px; margin: auto; background-color: #fff; border: 1px solid #e0e0e0;'>
      <tr>
        <td style='padding: 20px; text-align: center; background-color: #4CAF50; color: #fff; font-size: 20px; font-weight: bold;'>
          Verify Your Email
        </td>
      </tr>
      <tr>
        <td style='padding: 30px;'>
          <p style='margin: 0 0 15px;'>Hi,</p>
          <p style='margin: 0 0 15px;'>Thank you for registering. Please click the button below to verify your email address:</p>
          <p style='text-align: center; margin: 30px 0;'>
            <a href='$verify_link' style='background-color: #4CAF50; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; display: inline-block; font-weight: bold;'>
              Verify Email
            </a>
          </p>
          <p style='font-size: 12px; color: #888; margin: 30px 0 0;'>This link will expire in 15 minutes. If you did not sign up, you can ignore this email.</p>
        </td>
      </tr>
      <tr>
        <td style='padding: 15px; text-align: center; font-size: 12px; color: #aaa;'>
          &copy; " . date('Y') . " Your Company. All rights reserved.
        </td>
      </tr>
    </table>
  </div>
";


  $mail->AltBody = <<<EOT
Hi,

Thank you for registering.

Visit the link below to verify your email:
$verify_link

This link will expire in 15 minutes.
EOT;

  $mail->send();
  $response['status'] = 'success';
  $response['message'] = 'Verification email sent.';
} catch (Exception $e) {
  $response['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
}
echo json_encode($response);
