<?php
session_start();
include("../Admin-Panel/config/db.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$feedback = $_POST['feedback_user'] ?? null;
$rating = $_POST['rating'] ?? null;
$product_id = $_POST['product_id'] ?? null;

if (!$user_id || !$feedback || !$rating || !$product_id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

$sql = "INSERT INTO reviews (user_id, product_id, rating, review_text) VALUES ($user_id, $product_id, $rating, '$feedback')";
$result = $conn->query($sql);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit review']);
}
?>
