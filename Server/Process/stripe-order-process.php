<?php
session_start();

include("../Admin-Panel/config/db.php");



$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'] ?? [];
$subtotal = $_SESSION['final_subtotal'] ?? 0;
$payment_method = 'Card';


$sql = "SELECT id FROM addresses WHERE user_id = $user_id LIMIT 1";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
  $address_id = $row['id'];

  // Insert order
  $sql_order = "INSERT INTO orders (user_id, address_id, total, status,payment_method)
                  VALUES ($user_id, $address_id, $subtotal, 'pending','$payment_method')";
  if ($conn->query($sql_order)) {
    $order_id = $conn->insert_id;

    // Insert order items
    foreach ($cart_items as $item) {
      $product_id = $item['id'];
      $quantity = $item['quantity'];
      $price = $item['price'];

      $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES ($order_id, $product_id, $quantity, $price)";
      $conn->query($sql_item);

      // direct stock decrease
      $sql_stock = "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id";
      $conn->query($sql_stock);
      $sql_notification = "INSERT INTO notifications (user_id,order_id,type) values
            ($user_id,$order_id ,'order_received')";
        $conn->query($sql_notification);
        // $sql_check_stock = "SELECT quantity FROM products WHERE id = $product_id";
        // $result_stock = $conn->query($sql_check_stock);
        // if ($row_stock = $result_stock->fetch_assoc()) {
        //     if ($row_stock['quantity'] <= 0) {
        //         $sql_notification_stock = "INSERT INTO notifications (product_id, type) 
        //                            VALUES ($product_id, 'out_of_stock')";
        //         $conn->query($sql_notification_stock);
        //     }
        // }
    }
 

    // Clear cart
    unset($_SESSION['cart']);

    header("Location: ../../Client/payment.php?payment=true");
    exit();
  } else {
    header("Location: ../../Client/payment.php?payment=false");
    exit();
  }
} else {
  echo "No address found for this user.";
}
