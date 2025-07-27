<?php
include("../Admin-Panel/config/db.php");
session_start();
header('Content-Type: application/json');
$response = [];
$orderId = $_POST['orderid'];
$currentStatus = $_POST['orderstatus'];
if(isset($orderId) && isset($currentStatus)){

$status_flow = ["pending", "shipped", "delivered"];
$currentIndex = array_search($currentStatus, $status_flow);
$nextStatus = '';
if ($currentIndex !== false && isset($status_flow[$currentIndex + 1])) {
  $nextStatus = $status_flow[$currentIndex + 1];
  $sql = "UPDATE orders SET status = '$nextStatus' WHERE id = '$orderId'";
  $result =  $conn->query($sql);
  if ($result) {
    $response['success'] = true;
    $response['nextstate'] = $nextStatus;
    $response['currentstate'] = $nextStatus;
    
  } else {
    $response['success'] = false;
    $response['error'] = "Database update failed.";
  }
}
//  else {
//   $response['success'] = false;
//   $response['error'] = "Invalid current status or already at final status.";
// }
}else{
  $response['success'] = false;
  $response['error'] = 'tract order pr aya nh nahi ';
}
echo json_encode($response);
