

<?php
session_start();
include("../Admin-Panel/config/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $_POST['login_email'];
  $password = $_POST['login_password'];
  $sql = "SELECT * FROM users where email = '$email' ";
  $result = $conn->query($sql);
  if ($row = $result->fetch_assoc()) {
    $hashed_Password = $row['password'];

    if (password_verify($password, $hashed_Password)) {


      if ($row['role'] === "admin") {
        $_SESSION['admin_id'] = $row['id'];
        echo json_encode(['success' => true, 'redirect' => '../Server/Admin-Panel/Dashbboard.php']);
        exit;
      }
      if ($row['role'] === "user") {
        $_SESSION['user_id'] = $row['id'];
        echo json_encode(['success' => true, 'redirect' => '../Client/index.php']);
        exit;
      }
    } else {
      echo json_encode(['success' => false, 'error' => 'password']);
      exit();
    }
  } else {
    echo json_encode(['success' => false, 'error' => 'email']);
    exit;
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
