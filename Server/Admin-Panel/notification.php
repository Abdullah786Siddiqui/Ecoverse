<?php
include("./config/db.php");
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['admin_id'])) {
  header("Location: ../../Client/index.php");
  exit();
}
include("./includes/header.html");
include("./Sidebar.php");

$notification_field  = $_GET['notification'] ?? "";

?>
<style>
  /* Unread notification styles */
  .card.unread {
    background-color: #f1f7ff;
    border-left: 4px solid #0d6efd;
    box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
    transition: all 0.2s ease-in-out;
  }

  .card.unread:hover {
    /* transform: scale(1.01); */
    box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
  }

  .card.unread h6 {
    font-weight: 700;
    color: #0d6efd;
  }

  .card.unread .dot {
    background-color: #0d6efd;
  }

  /* Read notification styles */
  .card.read {
    background-color: #fff;
    opacity: 0.75;
    border-left: 4px solid transparent;
  }

  .card.read h6 {
    font-weight: 400;
    color: #6c757d;
  }

  .card.read .dot {
    background-color: #ced4da;
  }

  /* Dot common */
  .dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 5px;
    vertical-align: middle;
  }
</style>

<div class="container py-4">
  <h4 class="fw-bold mb-4">Order Notifications</h4>

  <div class="row g-2">
    <?php
    $orderJoin = "";
    if ($notification_field === 'new_customer') {
      $orderJoin = "LEFT JOIN ";
    } else {
      $orderJoin = "INNER JOIN ";
    }
    $sql_noti = "SELECT
    notifications.id AS notification_field,
    notifications.type AS notification_type,
    notifications.created_at,
    notifications.status,
    products.quantity as product_quantity,
    products.id as product_id,

    users.id AS user_id,
    users.name AS user_name,
    users.email AS user_email,
    users.phone AS user_phone,



    SUM(order_items.quantity) AS quantity_total,
    orders.id AS order_id,
    orders.total AS order_total,

    GROUP_CONCAT(
        CONCAT(order_items.quantity, '× ', products.name)
        ORDER BY products.name SEPARATOR ', '
    ) AS user_items
FROM notifications
INNER JOIN users ON users.id = notifications.user_id
$orderJoin orders ON orders.id = notifications.order_id
$orderJoin order_items ON order_items.order_id = orders.id
$orderJoin products ON products.id = order_items.product_id
WHERE notifications.type = '$notification_field'
GROUP BY notifications.id
ORDER BY notifications.created_at DESC
";
    $result_query = $conn->query($sql_noti);
    // For order_received, order_cancelled, new_customer notifications
    if (
      ($notification_field === 'order_received' || $notification_field === 'order_cancelled' || $notification_field === 'new_customer') &&
      $result_query && $result_query->num_rows > 0
    ) {
      while ($row = $result_query->fetch_assoc()) {
        if ($notification_field === 'order_received'):
    ?>
          <!-- Order Recieved -->
          <div class="col-12 mb-2">
            <a href="./Order-Details.php?order_id=<?= $row['order_id'] ?>" class="text-decoration-none">
              <div class="card rounded-3 shadow-sm 
        <?= $row['status'] === 'unread' ? 'bg-light' : '' ?>">

                <div class="card-body d-flex gap-3 align-items-center p-3">

                  <!-- Icon -->
                  <div class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm 
            <?= $row['status'] === 'unread' ? 'bg-success' : 'bg-secondary' ?>"
                    style="width: 48px; height: 48px;">
                    <i class="fas fa-shopping-cart text-white fs-5"></i>
                  </div>

                  <!-- Order Info -->
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0 small 
                <?= $row['status'] === 'unread' ? 'fw-semibold text-dark' : 'fw-normal text-muted' ?>">
                        Order
                        <span class="<?= $row['status'] === 'unread' ? 'text-success' : 'text-secondary' ?>">
                          #<?= $row['order_id'] ?>
                        </span> placed
                      </h6>

                      <small class="time-ago 
                <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>"
                        data-time="<?= $row['created_at'] ?>">
                      </small>
                    </div>

                    <div class="small 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      <strong><?= $row['user_name'] ?></strong> &bull;
                      Qty: <strong><?= $row['quantity_total'] ?></strong> &bull;
                      Total: <strong>$<?= $row['order_total'] ?></strong>
                    </div>

                    <div class="small mt-1 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      <i class="fas fa-box-open me-1"></i>
                      <span>Items: <strong><?= $row['user_items'] ?></strong></span>
                    </div>
                  </div>

                </div>
              </div>
            </a>
          </div>





        <?php
        elseif ($notification_field === 'order_cancelled'):

        ?>
          <!-- Order Cancell -->
          <div class="col-12 mb-2">
            <a href="./Order-Details.php?order_id=<?= $row['order_id'] ?>" class="text-decoration-none">
              <div class="card rounded-3 shadow-sm 
      <?= $row['status'] === 'unread' ? 'bg-light' : '' ?>">

                <div class="card-body d-flex gap-3 align-items-center p-3">

                  <!-- Icon -->
                  <div class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm
            <?= $row['status'] === 'unread' ? 'bg-danger' : 'bg-secondary' ?>"
                    style="width: 48px; height: 48px;">
                    <i class="fas fa-times-circle text-white fs-5"></i>
                  </div>

                  <!-- Order Info -->
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0 small 
                <?= $row['status'] === 'unread' ? 'fw-semibold text-dark' : 'fw-normal text-muted' ?>">
                        Order
                        <span class="<?= $row['status'] === 'unread' ? 'text-danger' : 'text-secondary' ?>">
                          #<?= $row['order_id'] ?>
                        </span> cancelled
                      </h6>

                      <small class="time-ago 
                <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>"
                        data-time="<?= $row['created_at'] ?>">
                      </small>
                    </div>

                    <div class="small 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      <strong><?= $row['user_name'] ?></strong> &bull;
                      Qty: <strong><?= $row['quantity_total'] ?></strong> &bull;
                      Total: <strong>$<?= $row['order_total'] ?></strong>
                    </div>

                    <div class="small mt-1 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      <i class="fas fa-comment-alt me-1"></i>
                      Reason: <em>Changed mind</em>
                    </div>
                  </div>

                </div>
              </div>
            </a>
          </div>
        <?php
        elseif ($notification_field === 'new_customer'):
        ?>
          <div class="col-12 mb-2">
            <a class="text-decoration-none">
              <div class="card rounded-3 shadow-sm 
      <?= $row['status'] === 'unread' ? 'bg-light' : '' ?>">

                <div class="card-body d-flex gap-3 align-items-center p-3">

                  <!-- Icon -->
                  <div class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0 shadow-sm
            <?= $row['status'] === 'unread' ? 'bg-primary' : 'bg-secondary' ?>"
                    style="width: 48px; height: 48px;">
                    <i class="fas fa-user-plus text-white fs-5"></i>
                  </div>

                  <!-- Customer Info -->
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="mb-0 small 
                <?= $row['status'] === 'unread' ? 'fw-semibold text-dark' : 'fw-normal text-muted' ?>">
                        New customer
                        <span class="<?= $row['status'] === 'unread' ? 'text-primary' : 'text-secondary' ?>">
                          <?= $row['user_name'] ?>
                        </span> registered
                      </h6>

                      <small class="time-ago 
                <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>"
                        data-time="<?= $row['created_at'] ?>">
                      </small>
                    </div>

                    <div class="small 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      Email: <strong><?= $row['user_email'] ?></strong>
                    </div>

                    <div class="small mt-1 
              <?= $row['status'] === 'unread' ? 'text-dark' : 'text-muted' ?>">
                      Phone: <strong><?= $row['user_phone'] ?></strong>
                    </div>
                  </div>

                </div>
              </div>
            </a>
          </div>


        <?php

        endif;
      }
    }
    // For out_of_stock and low_stock notifications, always show products
    if ($notification_field === 'out_of_stock') {
      $sql2 = "SELECT products.id as product_id, name as  product_name , product_images.image_url , quantity  as product_quantity ,created_at FROM products INNER JOIN product_images on product_images.product_id = products.id where quantity = 0";
      $result2 = $conn->query($sql2);
      if ($result2 && $result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
        ?>
          <div class="col-12 mb-2">
            <div class="card rounded-3 shadow-sm bg-light position-relative">
              <div class="card-body p-3 d-flex align-items-center gap-2">
                <div class="flex-shrink-0 rounded-3 overflow-hidden shadow-sm border" style="width: 48px; height: 48px;">
                  <img src='../uploads/<?= $row['image_url'] ?>' alt="Product Image" class="img-fluid w-100 h-100 object-fit-cover">
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-start">
                    <h6 class="mb-1 small fw-semibold text-dark">
                      Product <span class="text-danger"><?= $row['product_name'] ?></span> is Out of Stock
                    </h6>
                    <div class="dropdown ms-2">
                      <button class="btn btn-sm btn-light border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v text-muted"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                          <a class="dropdown-item" href="./Product-Update.php?updationId=<?= $row['product_id'] ?>">
                            <i class="fas fa-plus me-2 text-success"></i>Restock
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item text-danger" href="#">
                            <i class="fas fa-trash me-2"></i>Delete
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="small text-dark mb-1">
                    Product ID: <strong><?= $row['product_id'] ?></strong> &bull;
                    Qty: <strong><?= $row['product_quantity'] ?></strong>
                  </div>
                  <div class="small text-dark">
                    <i class="fas fa-industry me-1"></i>
                    Status: <strong>Out of Stock</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
      } else {
        // No out of stock products
        ?>
        <div class="col-12">
          <div class="alert alert-dark text-center">
            <i class="fas fa-exclamation-circle me-2"></i> No out of stock products found.
          </div>
        </div>
        <?php
      }
    } else if ($notification_field === 'low_stock') {
      $sql2 = "SELECT products.id as product_id, name as  product_name , product_images.image_url , quantity  as product_quantity ,created_at FROM products INNER JOIN product_images on product_images.product_id = products.id where quantity <= 5";
      $result2 = $conn->query($sql2);
      if ($result2 && $result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
        ?>
          <div class="col-12 mb-2">
            <div class="card rounded-3 shadow-sm bg-light position-relative">
              <div class="card-body p-3 d-flex align-items-center gap-2">
                <div class="flex-shrink-0 rounded-3 overflow-hidden shadow-sm border border-warning" style="width: 48px; height: 48px;">
                  <img src='../uploads/<?= $row['image_url'] ?>' alt="Product Image" class="img-fluid w-100 h-100 object-fit-cover">
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-start">
                    <h6 class="mb-0 small fw-semibold text-dark">
                      Product <span class="text-warning"><?= $row['product_name'] ?></span> is Low on Stock
                    </h6>
                    <div class="dropdown ms-2">
                      <button class="btn btn-sm btn-light border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v text-muted"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                          <a class="dropdown-item" href="./Product-Update.php?updationId=<?= $row['product_id'] ?>">
                            <i class="fas fa-plus me-2 text-success"></i>Restock
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item text-danger" href="#">
                            <i class="fas fa-trash me-2"></i>Delete
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="small text-dark mb-1">
                    Product ID: <strong><?= $row['product_id'] ?></strong> &bull;
                    Qty: <strong><?= $row['product_quantity'] ?></strong>
                  </div>
                  <div class="small text-dark">
                    <i class="fas fa-exclamation-triangle me-1 text-warning"></i>
                    Status: <strong>Low Stock</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
      } else {
        // No low stock products
        ?>
        <div class="col-12">
          <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-circle me-2"></i> No low stock products found.
          </div>
        </div>
      <?php
      }
    }
    // ...existing code...
    else {
      switch ($notification_field) {
        case 'order_received':
          $message = "No received orders found.";
          $alertClass = "success";
          break;
        case 'order_cancelled':
          $message = "No cancelled orders found.";
          $alertClass = "danger";
          break;
        case 'new_customer':
          $message = "No new customers found.";
          $alertClass = "primary";
          break;
        case 'out_of_stock':
          $message = "No out of stock products found.";
          $alertClass = "dark";
          break;
        case 'low_stock':
          $message = "No low stock products found.";
          $alertClass = "warning";
          break;
        default:
          $message = "No notifications available.";
          $alertClass = "secondary";
      }
      ?>
      <div class="col-12">
        <div class="alert alert-<?= $alertClass ?> text-center">
          <i class="fas fa-exclamation-circle me-2"></i> <?= $message ?>
        </div>
      </div>
    <?php } ?>


  </div>
</div>





<?php
$sql = "UPDATE notifications
SET status = 'read'
WHERE type = '$notification_field'";

$result1 = $conn->query($sql);

if (!$result1) {
  echo "<h2>No product found</h2>";
}

?>







<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- Bootstrap CSS + Icons -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script>
  function timeAgo(time) {
    const timestamp = new Date(time).getTime();
    const now = Date.now();
    const difference = now - timestamp;

    const minutes = Math.floor(difference / (1000 * 60));
    const hours = Math.floor(difference / (1000 * 60 * 60));
    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
    const months = Math.floor(difference / (1000 * 60 * 60 * 24 * 30));

    if (minutes < 60) {
      return minutes <= 1 ? "1 minute ago" : `${minutes} minutes ago`;
    } else if (hours < 24) {
      return hours <= 1 ? "1 hour ago" : `${hours} hours ago`;
    } else if (days < 30) {
      return days <= 1 ? "1 day ago" : `${days} days ago`;
    } else {
      return months <= 1 ? "1 month ago" : `${months} months ago`;
    }
  }

  function updateTimeAgo() {
    document.querySelectorAll('.time-ago').forEach(el => {
      const time = el.getAttribute('data-time');
      el.textContent = timeAgo(time);
    });
  }

  // Run initially
  updateTimeAgo();
  // Then every 60 seconds
  setInterval(updateTimeAgo, 60000);
</script>


<script src="./Assets/JS/update.product.js"></script>
<?php include("./Includes/footer.html"); ?>