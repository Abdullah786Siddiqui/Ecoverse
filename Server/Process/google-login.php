<?php
session_start();
include("../Admin-Panel/config/db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $email = $_POST['login_email'];
  $password = $_POST['login_password'];


  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
  $result = $conn->query($sql);

  if ($row = $result->fetch_assoc()) {

    if ($row['role'] === "user") {
      $_SESSION['user_id'] = $row['id'];
      echo json_encode(['success' => true, 'redirect' => '../Client/index.php']);
      exit;
    }

  } else {
    echo json_encode(['success' => false, 'error' => 'Invalid email or password']);
    exit;
  }

} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
