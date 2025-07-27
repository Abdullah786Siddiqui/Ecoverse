<?php
session_start();
unset($_SESSION['user_id']);

echo '<script>window.location.href = "../Client/index.php"</script>';
