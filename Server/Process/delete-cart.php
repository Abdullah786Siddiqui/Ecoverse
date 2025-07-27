<?php

include("../Admin-Panel/config/db.php");
session_start();
header('Content-Type: application/json');
$response = [
  "success" => false,
  "cart_count" => 0,
  "subtotal" => 0
];
if (isset($_POST['productid'])) {
  $product_id = (int)$_POST['productid'];

  foreach ($_SESSION['cart'] as $key => $items) {
    if ($items['id'] == $product_id) {
      unset($_SESSION['cart'][$key]);
    }
  }
  $_SESSION['cart'] = array_values($_SESSION['cart']);

  $subtotal = 0;
  foreach ($_SESSION['cart'] as $items) {
    $subtotal += $items['price'] *  $items['quantity'];
  };
   
  $response['success'] = true;
  $response['cart_count'] = count($_SESSION['cart']);
  $response['subtotal'] = $subtotal;
$_SESSION['final_subtotal'] = $subtotal;
  echo json_encode($response);
} else {
  echo json_encode(["success" => false, "message" => "Product ID not provided"]);
}
