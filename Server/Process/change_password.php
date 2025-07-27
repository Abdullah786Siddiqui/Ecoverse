<?php
session_start();
include("../Admin-Panel/config/db.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$response = [
  'status' => 'error',
  'message' => 'Something went wrong.'
];



if ($_SERVER['REQUEST_METHOD'] === "POST") {

  $currentPass = trim($_POST['current_password'] ?? '');
  $newPass = trim($_POST['new_password'] ?? '');
  $confirmPass = trim($_POST['confirm_password'] ?? '');

  if (empty($currentPass) || empty($newPass) || empty($confirmPass)) {
    $response['message'] = 'All fields are required.';
    echo json_encode($response);
    exit;
  }



  $sql = "SELECT password FROM users WHERE id = '$user_id' LIMIT 1";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentHashed = $row['password'];
  } else {
    $response['message'] = 'User not found.';
    echo json_encode($response);
    exit;
  }


  if (!password_verify($currentPass, $currentHashed)) {
    $response['message'] = 'Current password is incorrect.';
    echo json_encode($response);
    exit;
  }
  if ($newPass !== $confirmPass) {
    $response['message'] = 'New password and confirmation do not match.';
    echo json_encode($response);
    exit;
  }
  $newHashed = password_hash($newPass, PASSWORD_DEFAULT);
  $sql = "UPDATE users SET password = '$newHashed' WHERE id = '$user_id' LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
    $response['status'] = 'success';
    $response['message'] = 'Password changed successfully.';
  } else {
    $response['message'] = 'Failed to update password.';
  }

  echo json_encode($response);
  exit;
}

echo json_encode($response);
