<?php
session_start();
include("../Admin-Panel/config/db.php");


$email = $_SESSION['signup_email'] ?? '';
$inputOtp = $_POST['otp'] ?? '';

if (empty($email) || empty($inputOtp)) {
  echo json_encode(['success' => false, 'message' => 'Invalid request']);
  exit;
}

$sql = "SELECT * FROM otp_verification WHERE email = '$email' AND otp = '$inputOtp' ORDER BY created_at DESC LIMIT 1";

$result = $conn->query($sql);
if (!$result) {
  echo json_encode([
    'success' => false,
    'message' => 'Database query failed: ' . $conn->error
  ]);
  exit;
}

if ($row = $result->fetch_assoc()) {

  $name = $row['name'];
  $hashedPassword = $row['password'];


  $sqlInsert = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$hashedPassword')";
  if ($conn->query($sqlInsert)) {
    $_SESSION['user_id'] = $conn->insert_id;
    $user_id =  $_SESSION['user_id'];
    $sql_noti = "INSERT INTO notifications (user_id ,type) VALUES ($user_id,'new_customer')";
    $conn->query($sql_noti);
    $sqlDelete = "DELETE FROM otp_verification WHERE email = '$email'";
    $conn->query($sqlDelete);


    echo json_encode(['success' => true, 'message' => 'OTP verified. Account created.']);
    exit;
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to create user: ' . $conn->error]);
    exit;
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
  exit;
}
