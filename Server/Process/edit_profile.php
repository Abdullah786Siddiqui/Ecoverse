<?php
session_start();
include("../Admin-Panel/config/db.php");
$user_id = $_SESSION['user_id'] ?? 0;
$response = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $name  = $_POST['name'];
  $phone   = $_POST['phone'];
  $gender  = $_POST['gender'];
  $email   = $_POST['email'];

  // SQL query
  $sql = "
UPDATE users SET
   name = '$name',
    phone   = '$phone',
    gender  = '$gender',
    email   = '$email'
WHERE id = $user_id
";

  $result = $conn->query($sql);
  if ($result) {
    $response['success'] = true;
  }
}
echo json_encode($response);
