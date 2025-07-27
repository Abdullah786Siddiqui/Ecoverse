<?php
// $host = "sql106.infinityfree.com";  
// $username = "if0_39570205";
// $password = "k51EZK91Pe";
// $database = "if0_39570205_ecomerse_website";

// $conn = new mysqli($host, $username, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection Failed: " . $conn->connect_error);
// }

  
?>


<?php
$host = "localhost";  
$username = "root";
$password = "";
$database = "ecomerse_website";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

  
?>
