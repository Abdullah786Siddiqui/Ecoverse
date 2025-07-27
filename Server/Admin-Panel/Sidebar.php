<?php

include("./includes/header.html");
include("./config/db.php");

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if (isset($_SESSION['admin_id'])) {
  $admin_id = $_SESSION['admin_id'] ?? "";
  $sql = "SELECT * FROM users WHERE id = $admin_id  ";
  $result = $conn->query($sql);
  if ($row = $result->fetch_assoc()) {
    $adminName = $row['name'] ?? "";
  }
}
$count_low_stock = 0;
$count_out_stock = 0;
$unread = 0

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
  .content-wrapper {
    margin-left: 0;
    transition: margin-left 0.3s ease;
  }

  .content-wrapper.shifted {
    margin-left: 260px;
  }

  .navbar-custom {
    background: linear-gradient(90deg, #ffffff, #f7f8fc);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    z-index: 1050;
  }

  .sidebar-toggle-btn {
    border: none;
    background: transparent;
    font-size: 1.8rem;
    color: #1e88e5;
    cursor: pointer;
    transition: transform 0.3s ease, color 0.3s ease;
  }

  .sidebar-toggle-btn:hover {
    transform: rotate(180deg) scale(1.1);
    color: #2563EB;
  }



  



 

  .badge {
    font-size: 0.6rem;
    padding: 2px 5px;
  }

  .user-info span {
    font-size: 0.85rem;
  }

  .user-info small {
    font-size: 0.7rem;
  }

  /* @media (max-width: 1000px) {
    .search-bar {
      display: none !important;
    }

    .admin {
      display: block !important;
    }

    .navbar-nav .nav-item:not(.only-gear) {
      display: none !important;
    }
  } */

  

  .rotating-gear i {
    animation: spin 4s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: -260px;
    width: 260px;
    height: 100%;
    background-color: #fff;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
    transition: left 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
  }

  .sidebar {
    left: -260px;
  }

  .sidebar.active {
    left: 0;
  }

 




  .sidebar .nav-link {
    padding: 0.75rem 1.5rem;
    color: #333;
    font-weight: 500;
    display: flex;
    align-items: center;
  }

  .sidebar .nav-link:hover,
  .sidebar .nav-link.active {
    background-color: #e9f2ff;
    color: #2563EB;
  }

  .sidebar .nav-link i {
    margin-right: 10px;
    font-size: 1.1rem;
  }

  .sidebar .submenu a {
    padding-left: 2.5rem;
    font-size: 0.85rem;
    color: #555;
    display: block;
    padding-top: 0.4rem;
    padding-bottom: 0.4rem;
  }

  .cursor-pointer {
    cursor: pointer;
  }
</style>
<div class="sidebar active " id="sidebar">
  <div class="d-block py-3 px-4 fs-4 fw-bold text-primary border-bottom text-decoration-none cursor-pointer ">
    <a href="./Dashbboard.php"
      class="text-decoration-none text-primary"
      style="color: #2563EB;"
      onmouseover="this.style.color='#2563EB'"
      onmouseout="this.style.color='#2563EB'">
      Adminix
    </a>

  </div>


  <div id="sidebarAccordion">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="./Dashbboard.php">
          <i class="bi bi-speedometer2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ecommerceMenu" role="button">
          <i class="bi bi-cart"></i> Ecommerce
        </a>
        <div class="collapse submenu" id="ecommerceMenu" data-bs-parent="#sidebarAccordion">
          <a href="./Add-Product.php" class="nav-link click"><i class="bi bi-plus-circle me-2"></i>Add Product</a>
          <a href="./View-Products.php" class="nav-link click"><i class="bi bi-list-check me-2"></i>Product List</a>

        </div>
      </li>




      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#orderMenu" role="button">
          <i class="bi bi-receipt"></i> Order
        </a>
        <div class="collapse submenu" id="orderMenu" data-bs-parent="#sidebarAccordion">
          <a href="./View-Orders.php" class="nav-link"><i class="bi bi-card-checklist me-2"></i>Order List</a>




        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#userMenu" role="button">
          <i class="bi bi-person"></i> User
        </a>
        <div class="collapse submenu" id="userMenu" data-bs-parent="#sidebarAccordion">
          <a href="./Users.php" class="nav-link ">
            <i class="bi bi-people-fill"></i> User List
          </a>
        </div>
      </li>

      <hr class="w-75 mx-3">

      <li class="nav-item">
        <a class="nav-link" href="../Process/logout-admin.php">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </li>





    </ul>
  </div>
</div>
<div class="content-wrapper shifted" id="contentWrapper">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 py-2 sticky-top">
    <div class="container-fluid d-flex align-items-center">

      <!-- Sidebar Toggle Button -->
      <button class="sidebar-toggle-btn me-3 sidebarToggle">
        <i id="toggleIcon" class="bi bi-arrow-right-circle"></i>
      </button>

      <!-- Admin greeting -->
      <h2 class="admin d-none">Hi Admin, <?= $adminName ?></h2>

      <!-- Alternative to Search Bar -->
      <div class="flex-grow-1 me-3">
        <h5 class="mb-0 text-muted">Dashboard</h5>
      </div>

      <!-- Right side icons -->
      <ul class="navbar-nav flex-row align-items-center gap-2 gap-sm-1">



       
        <?php
        $sql_count1 = "SELECT COUNT(quantity) as count FROM products WHERE quantity  <= 5";
        $result_count = $conn->query($sql_count1);

        $row_low_stock = $result_count->fetch_assoc();
        $count_low_stock = $row_low_stock['count'];


        $sql_count2 = "SELECT COUNT(quantity) as count FROM products WHERE quantity = 0";
        $result_count = $conn->query($sql_count2);

        $row_low_stock = $result_count->fetch_assoc();
        $count_out_stock = $row_low_stock['count'];

        ?>

        <li class="nav-item dropdown cursor-pointer">
          <a
            class="nav-link position-relative "
            href="#"
            id="notificationDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="bi bi-bell fs-5 "></i>
            <?php
            $sql_count_total = "SELECT COUNT(*) AS count 
               FROM notifications 
               WHERE status = 'unread'";
            $result_total = $conn->query($sql_count_total);
            if ($row = $result_total->fetch_assoc()) {
              $unread = $row['count'];
              $noti_count = $unread + $count_low_stock + $count_out_stock;

            ?>
              <span
                class="position-absolute top-25  start-100 translate-middle badge rounded-pill bg-danger shadow-sm"
                style="font-size: 0.7rem; padding: 0.2em 0.5em;">
                <?= $noti_count ? $noti_count : 0 ?>
                <span class="visually-hidden">unread notifications</span>
              </span>
            <?php }
            ?>
          </a>

          <ul
            class="dropdown-menu dropdown-menu-end shadow border-0 p-0 rounded-4 cursor-pointer"
            aria-labelledby="notificationDropdown"
            style="width: 260px; max-width: 90vw;">

            <!-- Header -->
            <li class="px-3 py-2 border-bottom">
              <span class="fw-semibold small">Notifications</span>
            </li>

            <!-- Notification List -->
            <li>
              <ul class="list-unstyled mb-0">

                <!-- Order Placed -->
                <li class="px-2 py-2 border-bottom">
                  <a href="./notification.php?notification=order_received"
                    class="d-flex justify-content-between align-items-center gap-2 text-decoration-none text-dark">

                    <div class="d-flex align-items-start gap-2">
                      <div
                        class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 36px; height: 36px; background-color: #28a745;">
                        <i class="bi bi-cart-check text-white fs-5"></i>
                      </div>

                      <div>
                        <div class="fw-semibold small">Orders received</div>
                        <div class="text-muted x-small">New Orders Placed</div>
                      </div>
                    </div>
                    <?php
                    $sql_count1 = "SELECT COUNT(*) AS count 
               FROM notifications 
               WHERE status = 'unread' AND type = 'order_received'";
                    $result_count = $conn->query($sql_count1);

                    if ($row = $result_count->fetch_assoc()) {
                      if ($row['count'] > 0) {
                    ?>
                        <span
                          class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center shadow"
                          style="
      min-width: 26px;
      height: 26px;
      font-size: 0.8rem;
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
      border: 1px solid #fff;
    ">
                          <?= $row['count'] ?>
                        </span>
                    <?php
                      }
                    }
                    ?>


                  </a>
                </li>


                <!-- Order Cancelled -->
                <li class="px-2 py-2 border-bottom">
                  <a href="./notification.php?notification=order_cancelled"
                    class="d-flex justify-content-between align-items-center gap-2 text-decoration-none text-dark">

                    <div class="d-flex align-items-start gap-2">
                      <div
                        class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 30px; height: 30px; background-color: #dc3545;">
                        <i class="bi bi-x-circle text-white fs-6"></i>
                      </div>

                      <div>
                        <div class="fw-semibold small text-danger">Orders cancelled</div>
                        <div class="text-muted x-small">Check cancellation </div>
                      </div>
                    </div>
                    <?php
                    $sql_count2 = "SELECT COUNT(*) AS count 
               FROM notifications 
               WHERE status = 'unread' AND type = 'order_cancelled'";
                    $result_count = $conn->query($sql_count2);

                    if ($row = $result_count->fetch_assoc()) {
                      if ($row['count'] > 0) {
                    ?>
                        <span
                          class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center shadow"
                          style="
      min-width: 26px;
      height: 26px;
      font-size: 0.8rem;
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
      border: 1px solid #fff;
    ">
                          <?= $row['count'] ?>
                        </span>
                    <?php
                      }
                    }
                    ?>


                  </a>
                </li>

                <!-- New User Registered -->
                <li class="px-2 py-1 border-bottom d-flex justify-content-between align-items-start gap-1">
                  <a href="./notification.php?notification=new_customer" class="d-flex justify-content-between align-items-start gap-1 w-100 text-decoration-none">
                    <div class="d-flex align-items-start gap-1">
                      <div
                        class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 30px; height: 30px; background-color: #0d6efd;">
                        <i class="bi bi-person-plus text-white fs-6"></i>
                      </div>
                      <div>
                        <div class="fw-semibold small">New customers</div>
                        <div class="text-muted x-small">Welcome new signups</div>
                      </div>
                    </div>

                    <?php
                    $sql_count3 = "SELECT COUNT(*) AS count 
            FROM notifications 
            WHERE status = 'unread' AND type = 'new_customer'";
                    $result_count = $conn->query($sql_count3);

                    if ($row = $result_count->fetch_assoc()) {
                      if ($row['count'] > 0) {
                    ?>
                        <span
                          class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center shadow"
                          style="
min-width: 26px;
height: 26px;
font-size: 0.8rem;
box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
border: 1px solid #fff;
">
                          <?= $row['count'] ?>
                        </span>
                    <?php
                      }
                    }
                    ?>
                  </a>
                </li>


                <!-- Low Stock -->
                <li class="px-2 py-1 border-bottom">
                  <a href="./notification.php?notification=low_stock" class="d-flex justify-content-between align-items-start gap-1 text-decoration-none text-dark w-100">
                    <div class="d-flex align-items-start gap-1">
                      <div
                        class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 30px; height: 30px; background-color: #ffc107;">
                        <i class="bi bi-exclamation-triangle text-dark fs-6"></i>
                      </div>
                      <div>
                        <div class="fw-semibold small text-warning">Low stock</div>
                        <div class="text-muted x-small">Replenish inventory soon</div>
                      </div>
                    </div>
                    <?php if ($count_low_stock > 0) { ?>
                      <span
                        class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center shadow"
                        style="
              min-width: 26px;
              height: 26px;
              font-size: 0.8rem;
              box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
              border: 1px solid #fff;
            ">
                        <?= $count_low_stock ?>
                      </span>
                    <?php } ?>

                  </a>
                </li>



                <li class="px-2 py-2 border-bottom">
                  <a href="./notification.php?notification=out_of_stock"
                    class="d-flex justify-content-between align-items-center gap-2 text-decoration-none text-dark">

                    <div class="d-flex align-items-start gap-1 ">
                      <div
                        class="rounded-circle d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 30px; height: 30px; background-color: #6c757d;">
                        <i class="bi bi-box text-white fs-6"></i>
                      </div>
                      <div>
                        <div class="fw-semibold small text-secondary">Out of stock</div>
                        <div class="text-muted x-small">Update or restock items</div>
                      </div>
                    </div>
                    <?php if ($count_out_stock > 0) { ?>
                      <span
                        class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center shadow"
                        style="
      min-width: 26px;
      height: 26px;
      font-size: 0.8rem;
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
      border: 1px solid #fff;
    ">
                        <?= $count_out_stock ?>
                      </span>

                    <?php   } ?>

                  </a>
                </li>
              </ul>
            </li>

            <!-- Footer -->
            <!-- <li class="border-top py-2 d-flex justify-content-center">
              <button class="btn btn-primary btn-sm rounded-pill px-3 w-75">
                View all
              </button>
            </li> -->

          </ul>
        </li>





        <!-- <li class="nav-item position-relative">
          <a class="nav-link " href="#">
            <i class="bi bi-chat-dots"></i>
            <span class="badge bg-primary rounded-pill position-absolute top-0 start-100 translate-middle">1</span>
          </a>
        </li> -->

        <li class="nav-item">
          <a id="" class="nav-link  sidebarToggle " href="#">
            <i class="bi bi-arrows-fullscreen"></i>
          </a>
        </li>

       

        <!-- User Info -->
     <li class="nav-item d-flex align-items-center gap-2 ms-2">
  <a>
    <img src="./assets/Images/Abdullah.jpg"
         class="rounded-circle shadow-sm"
         style="object-fit: cover;"
         width="40" height="40" alt="User">
  </a>
  <div class="user-info d-none d-sm-block">
    <span class="fw-semibold small"><?= $adminName ?></span><br>
    <small class="text-muted fw-bold">Admin</small>
  </div>
</li>


      </ul>
    </div>
  </nav>


  <!-- main content -->



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
          var targetSelector = link.getAttribute('href');
          var target = document.querySelector(targetSelector);

          if (target) {
            var bsCollapse = bootstrap.Collapse.getOrCreateInstance(target);

            if (target.classList.contains('show')) {
              // Agar already open hai, to band kar
              bsCollapse.hide();
              e.preventDefault(); // Bootstrap ka default toggle prevent kar
            } else {
              // Agar band hai to khol de
              bsCollapse.show();
              e.preventDefault(); // Bootstrap ka default toggle prevent kar
            }
          }
        });
      });
    });

    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('contentWrapper');
    const sidebarToggle = document.querySelectorAll('.sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');

    sidebarToggle.forEach((toggle) => {
      toggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        contentWrapper.classList.toggle('shifted');

        if (sidebar.classList.contains('active')) {
          toggleIcon.classList.remove('bi-arrow-right-circle');
          toggleIcon.classList.add('bi-arrow-left-circle');
        } else {
          toggleIcon.classList.remove('bi-arrow-left-circle');
          toggleIcon.classList.add('bi-arrow-right-circle');
        }
      });
    });

 
 


  </script>


  <?php include("./Includes/footer.html"); ?>