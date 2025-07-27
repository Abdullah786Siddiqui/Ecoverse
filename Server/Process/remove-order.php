<?php
session_start();
include("../Admin-Panel/config/db.php");
$response = [];
$order_id = $_POST['order_id'];
print_r($order_id);
$sql = "DELETE FROM orders where id = $order_id ";
$result = $conn->query($sql);
if ($result) {
  $response['success'] = true;
  $response['message'] = "Order Remove Sucesfully";
} else {
  $response['success'] = false;
}
echo json_encode($response);
