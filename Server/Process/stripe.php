<?php
session_start();

require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();


if (!isset($_POST['cart'])) {
  die('Cart data missing.');
}

$cartData = json_decode($_POST['cart'], true);

if (!$cartData || !is_array($cartData)) {
  die('Invalid cart data.');
}


$lineItems = [];

foreach ($cartData as $item) {
  if (!isset($item['name'], $item['price'], $item['quantity'])) {
    continue; 
  }
  $priceInCents = intval(floatval($item['price']) * 100);

  $lineItems[] = [
    'price_data' => [
      'currency' => 'usd',
      'product_data' => [
        'name' => htmlspecialchars($item['name']),
      ],
      'unit_amount' => $priceInCents,
    ],
    'quantity' => intval($item['quantity']),
  ];
}

if (empty($lineItems)) {
  die('No valid items in cart.');
}

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => $lineItems,
  'mode' => 'payment',
  'success_url' => 'http://localhost/Ecomerse-Website/Server/Process/stripe-order-process.php',
  'cancel_url' => 'http://localhost/Ecomerse-Website/Client/Payment.php',
]);

header("Location: " . $session->url);
exit;
