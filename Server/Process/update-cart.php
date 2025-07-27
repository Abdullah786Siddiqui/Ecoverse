<?php

session_start();
$response = ["success" => false, "subtotal" => 0];
if (isset($_POST['productid'], $_POST['quantity'])) {
  $product_id = (int)$_POST['productid'];
  $quantity = (int)$_POST['quantity'];
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $product_id) {
      $item['quantity'] = $quantity;
    }
  }
  unset($item);
  $subtotal = 0;
  foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
  }
  $_SESSION['final_subtotal'] = $subtotal;
  $response['success'] = true;
  $response['subtotal'] = $subtotal;
}
header('Content-Type: application/json');
echo json_encode($response);