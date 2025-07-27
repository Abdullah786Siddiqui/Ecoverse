<?php
session_start();
include('../Admin-Panel/config/db.php');
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$client = new Google_Client();
$client->setClientId($_ENV["CLIENT_ID"]);
$client->setClientSecret($_ENV["CLIENT_SECRET"]);
$client->setRedirectUri('http://localhost/Ecomerse-Website/Server/Process/Google-auth.php');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

  if (!isset($token['error'])) {
    $client->setAccessToken($token);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $name = $userInfo->name;
    $email = $userInfo->email;
    $role = 'user';
    $status = 'active';


    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
      // User does not exist — INSERT
      $sql = "
                INSERT INTO users 
                (name, email, password, phone, role, status, created_at, updated_at, user_profile, gender) 
                VALUES 
                ('$name', '$email', 'gooogle Auth', NULL, '$role', '$status', NOW(), NOW(), '' , NULL)
            ";

      if ($conn->query($sql)) {
        $userId = $conn->insert_id;
        $sql_noti = "INSERT INTO notifications (user_id ,type) VALUES ($userId,'new_customer')";
        $conn->query($sql_noti);
      } else {
        die("Error inserting user: " . $conn->error);
      }
    } else {
      // User already exists — GET user id
      $row = $result->fetch_assoc();
      $userId = $row['id'];
    }

    // ✅ Session set karo
    $_SESSION['user_id'] = $userId;

    header('Location: ../../Client/index.php');
    exit;
  } else {
    die("Error fetching token: " . htmlspecialchars($token['error']));
  }
} else {
  die("No code provided.");
}
