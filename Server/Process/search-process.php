<?php
session_start();
include("../Admin-Panel/config/db.php");


header("Content-Type: text/html; charset=UTF-8");

$query = trim($_GET['query'] ?? '');

if ($query === '') {
  echo "<p class='text-muted'>No query provided.</p>";
  exit;
}
$sql = "SELECT id, name , subcategory_id  FROM products WHERE name LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<div class='list-group shadow-sm rounded'>";

  while ($row = $result->fetch_assoc()) {
    $name = $row['name'];
    $id = (int) $row['id'];

    echo "
            <a href='../Client/products.php?id=$id' class='list-group-item list-group-item-action d-flex justify-content-start gap-2 align-items-center'>
               <i class='fas fa-search'></i>

<span class='fw-semibold text-dark'>$name</span>
            </a>
        ";
  }

  echo "</div>";
} else {
  echo "<p class='text-muted'>No products found for <strong>$query</strong></p>";
}
