<?php
session_start();
include("../Admin-Panel/config/db.php");



if (isset($_POST['productid'])) {
  $product_id = intval($_POST['productid']);
  $isBuyNow = isset($_POST['buynow']) ? true : false;

  $response = [];


  $sql = "SELECT products.id, products.name, products.price, products.quantity, product_images.image_url
            FROM products
            INNER JOIN product_images ON products.id = product_images.product_id
            WHERE products.id = $product_id";
  $result = $conn->query($sql);

  if ($row = $result->fetch_assoc()) {
    $dbStock = intval($row['quantity']); // DB stock

    $product = [
      'id' => $row['id'],
      'name' => $row['name'],
      'price' => $row['price'],
      'image' => $row['image_url'],
      'quantity' => 1,
    ];

    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
      if ($item['id'] == $product['id']) {
        $found = true;

        $cartQty = $item['quantity'];


        if ($dbStock == 0) {
          $response["success"] = false;
          $response["message"] = "No more stock available.";

          header('Content-Type: application/json');
          echo json_encode($response);
          exit();
        }
        if (($cartQty + 1) > $dbStock) {
          $response["success"] = false;
          $response["message"] = "No more stock available.";
    
          header('Content-Type: application/json');
          echo json_encode($response);
          exit();
        } elseif (($cartQty + 1) == $dbStock) {
          $response["reload"] = true;
        }


        if ($isBuyNow) {
          if ($cartQty == 0) {
            $item['quantity'] = 1;
          }
        } else {
          $item['quantity'] += 1;
        }




        $response["success"] = true;
        $response["quantity"] = $item['quantity'];
        $response["stock"] = $dbStock - $item['quantity'];
        break;
      }
    }
    unset($item);

    // agar cart me nahi mila to add karo
    if (!$found) {
      $_SESSION['cart'][] = $product;

      $response["success"] = true;
      $response["quantity"] = 1;
      $response["stock"] = $dbStock - 1;
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Product not found!";
  }

  $response["cart_count"] = count($_SESSION['cart']);

  header('Content-Type: application/json');
  echo json_encode($response);
}
