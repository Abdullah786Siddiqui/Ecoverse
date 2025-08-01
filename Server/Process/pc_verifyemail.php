<?php
session_start();
include("../Admin-Panel/config/db.php");
$token = $_GET['token'] ?? '';
$user_id = $_SESSION['user_id'] ?? 0;

$sql = "SELECT id FROM users WHERE email_token = '$token' ";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
  $conn->query("UPDATE users SET email_token = NULL, token_expiry = NULL WHERE id = $user_id");
  echo "<script>window.location.href = 'http://localhost/Ecoverse/Client/homeprofile.php?success=true'</script>";
} else {
  echo "<script>window.location.href = 'http://localhost/Ecoverse/Client/homeprofile.php?success=false'</script>";
}
