<?php
session_start();
include("../Admin-Panel/config/db.php");
$response = [];
$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$sql = "UPDATE orders set status = 'cancelled' where id = $order_id";
$result = $conn->query($sql);
$sql_notification = "INSERT INTO notifications (user_id,order_id,type) values
            ($user_id,$order_id ,'order_cancelled')";
$conn->query($sql_notification);
if ($result) {
  $response['success'] = true;
  $response['message'] = "Order Cancel Sucesfully";
} else {
  $response['success'] = false;
}
echo json_encode($response);
