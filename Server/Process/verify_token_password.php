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

  $newPass = trim($_POST['new_password_token'] ?? '');
  $confirmPass = trim($_POST['confirm_password_token'] ?? '');

  if (empty($newPass) || empty($confirmPass)) {
    $response['message'] = 'All fields are required.';
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
}
echo json_encode($response);
