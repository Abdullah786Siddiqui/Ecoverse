<?php
session_start();
unset($_SESSION['admin_id']);

echo '<script>window.location.href = "../../Client/index.php"</script>';
