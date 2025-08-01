


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

<?php
// $host = "sql5.freesqldatabase.com";  
// $username = "sql5792923";
// $password = "";
// $database = "sql5792923";

// $conn = new mysqli($host, $username, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection Failed: " . $conn->connect_error);
// }

  
?>
