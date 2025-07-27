<?php
session_start();
include("../Admin-Panel/config/db.php");
$response = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

$user_id = $_SESSION['user_id'] ?? 0;

  $imageName = $_FILES['image']['name'];
  $tmpImage = $_FILES['image']['tmp_name'];
  $uploadsDir = "../uploads/";


  $new_file = time() . "-" . basename($imageName);
  $destination = $uploadsDir . $new_file;
  if (move_uploaded_file($tmpImage, $destination)) {
    $sql = "UPDATE users set user_profile = '$new_file' where id = $user_id";

    $result = $conn->query($sql);
    if ($result) {

     $response['success'] = true;
    } else {
      echo "Error in inserting product image.";
    }
  }
}
echo json_encode($response);