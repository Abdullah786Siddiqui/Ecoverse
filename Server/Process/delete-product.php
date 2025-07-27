<?php
session_start();
include("../Admin-Panel/config/db.php");
$response = [];
$product_id = $_POST['productid'];
$sql = "DELETE FROM products WHERE id = $product_id";
$result = $conn->query($sql);
if ($result) {
  $response['success'] = true;
  $response['message'] = "Product Remove Successfully";
} else {
  $response['success'] = false;
}
echo json_encode($response);