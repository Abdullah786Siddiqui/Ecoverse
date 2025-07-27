<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['admin_id'])) {
  header("Location: ../../Client/index.php");
  exit();
}
include("./includes/header.html");
include("./Sidebar.php");
$status = isset($_POST['status']) ? $_POST['status'] : '';

?>




<style>
  body {
    background-color: #f1f5f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  .order-card {
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    padding: 20px;
  }

  .search-input {
    max-width: 300px;
    border-radius: 8px;
  }

  .table-container {
    max-height: 400px;
    overflow-y: auto;
    border-radius: 10px;
    background-color: #ffffff;
  }

  table thead th {
    position: sticky;
    top: 0;
    background: #f8fafc;
    z-index: 2;
  }

  .product-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 10px;
  }

  /* .table-hover tbody tr:hover {
    background-color: #f1f5f9;
  } */

  .breadcrumb-custom {
    font-size: 14px;
    color: #6b7280;
  }

  .btn-export {
    border-radius: 8px;
  }

  .breadcrumb-custom {
    background: none;
    padding: 0;
    margin-bottom: 0;
    font-size: 14px;
  }

  .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
    content: "›";
    /* Stylish separator */
    color: #6c757d;
  }

  .breadcrumb-custom .breadcrumb-item a {
    color: #0d6efd;
    /* Bootstrap Primary Color */
    text-decoration: none;
    font-weight: 500;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f1f5f9;
    /* Light blue-gray tone jo card se alag ho */
  }

  .breadcrumb-custom .breadcrumb-item.active {
    color: #6c757d;
    font-weight: 500;
  }

  @media (max-width: 991.98px) {
    .responsive-flex {
      flex-direction: column !important;
      align-items: stretch !important;
    }

    .responsive-flex .order-3 {
      order: 3 !important;
      width: 100%;
    }

    .responsive-flex .export-btn {
      width: 100%;
    }

    /* Status dropdown ko chhota hi rehne do */
  }

  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table {
    min-width: 600px;
  }

  @keyframes slideFromBottom {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .slide-up-row {
    opacity: 0;
    /* Start hidden, reveal with animation */
    animation: slideFromBottom 0.5s ease-out forwards;
  }

  .modal-backdrop.show {
    backdrop-filter: blur(5px);
    background-color: rgba(255, 255, 255, 0.3);
  }
</style>
</head>

<body>

  <div class="container m ">
    <div class="d-flex justify-content-between align-items-center my-4 flex-wrap mx-2">
      <!-- Page Title -->
      <h4 class="mb-2 mb-md-0 fw-semibold text-primary">Order List</h4>

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 breadcrumb-custom">
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Order</a></li>
          <li class="breadcrumb-item active" aria-current="page">Order List</li>
        </ol>
      </nav>
    </div>


    <div class="order-card bg-white">
      <div class="d-flex flex-row align-items-center mb-3 gap-2 responsive-flex">

        <!-- Status Dropdown -->
        <form method="POST" id="statusForm">
          <select name="status" id="state-selcxt" class="form-select shadow-sm" style="min-width: 130px; max-width: 150px;">
            <option selected hidden>Status</option>
            <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>pending</option>
            <option value="shipped" <?= $status == 'shipped' ? 'selected' : '' ?>>shipped</option>
            <option value="delivered" <?= $status == 'delivered' ? 'selected' : '' ?>>delivered</option>
            <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : '' ?>>cancelled</option>
          </select>
        </form>


        <!-- Search Box -->
        <div class="flex-grow-1 w-100 w-md-auto order-3 order-md-0">
          <input type="text" class="form-control shadow-sm mt-2 mt-md-0" placeholder="Search here...">
        </div>

        <!-- Export Button -->
        <div class="flex-shrink-0 refresh-btn">
          <button onclick="refresh()" class="btn btn-success fw-bold shadow-sm w-100">
            <i class="bi bi-arrow-repeat me-1"></i> Refresh


          </button>
        </div>


      </div>


      <div class="table-responsive">
        <div class="table-container">
          <table class="table table-hover text-center align-middle mb-0">
            <thead>
              <tr>
                <th class="text-start">Product</th>
                <th>OrderID</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody class="text-center">
              <?php
              $sql = "SELECT DISTINCT orders.id as order_id, products.name, orders.payment_method, orders.status, order_items.quantity, order_items.price  AS unit_price,
  (order_items.price * order_items.quantity) AS total_price, product_images.image_url 
FROM orders 
INNER JOIN order_items ON orders.id = order_items.order_id
INNER JOIN products ON order_items.product_id = products.id
INNER JOIN product_images ON products.id = product_images.product_id";

              if (!empty($status)) {
                $sql .= " WHERE orders.status = '$status'";
              }

              $sql .= " ORDER BY order_id DESC";
              $result = $conn->query($sql);
              if ($result->num_rows == 0) {
                echo "<tr><td colspan='7' class='text-center fw-bold text-muted py-4'>No orders found for $status  status.</td></tr>";
              } else {
                while ($row = $result->fetch_assoc()) {
              ?>
                  <tr>

                    <td class="d-flex align-items-center ">
                      <img src="../uploads/<?= $row['image_url'] ?>" class="product-img" alt="Product">
                      <span class="me-5"><?= $row['name'] ?></span>
                      <!-- <span class="<?= $row['status'] === 'cancelled' ? 'text-danger fw-bold' : '' ?>">
                        <?= $row['status'] === 'cancelled' ? 'This Order Cancel By User' : '' ?>
                      </span> -->
                    </td>
                    <td>#<?= $row['order_id'] ?></td>
                    <td>$<?= $row['unit_price'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['total_price'] ?></td>
                    <td><?= $row['payment_method'] ?></td>
                    <td>
                      <?php
                      $colour = '';
                      if ($row['status'] === "pending") {
                        $colour = 'bg-warning';
                      } elseif ($row['status'] === "shipped") {
                        $colour = 'bg-primary';
                      } elseif ($row['status'] === "delivered") {
                        $colour = 'bg-success';
                      } elseif ($row['status'] === "cancelled") {
                        $colour = 'bg-danger';
                      } ?>
                      <span
                        class="badge rounded-3 <?= $colour ?> px-3 py-2 text-white <?= $row['status'] === 'cancelled' ? 'cursor-pointer' : '' ?> text-capitalize shadow-sm"
                        <?php if ($row['status'] === 'cancelled'): ?>
                        onclick="RemoveOrder(<?= $row['order_id'] ?>)"
                        <?php endif; ?>>
                        <?= $row['status'] === 'cancelled' ? 'Remove' : $row['status'] ?>
                      </span>

                    </td>
                    <td>

                      <span onclick="updateStatus(<?= $row['order_id'] ?>, '<?= $row['status'] ?>')" class="badge rounded-3 btn  btn-danger <?= $row['status'] === 'delivered' ||  $row['status'] === 'cancelled' ? 'disabled bg-secondary  text-white border-secondary' : ' '  ?>   <?= $row['status'] === 'cancelled' ? 'bg-secondary' : 'bg-danger' ?> px-3 py-2 text-white text-capitalize shadow-sm" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        <?= $row['status'] === 'cancelled' ? 'cancel' : '  Update status' ?>

                      </span>
                    </td>


                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>


  <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg rounded-4 border-0 text-center" style="backdrop-filter: blur(8px); background-color: rgba(255, 255, 255, 0.95);">

        <div class="modal-header border-0 pb-0 d-flex flex-column align-items-center">
          <h5 class="modal-title fw-bold text-dark fs-4" id="updateStatusModalLabel">Update Order Status</h5>
          <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" onclick="handleCancel()"></button>
        </div>
        <div class="modal-body text-muted pt-2 pb-2">
          <p class="fs-5 fw-semibold text-dark mb-1">Are you sure you want to move to the next state?</p>

          <p class="mb-1">
            <span class="fw-semibold text-secondary fs-5 ">Order ID: #</span>
            <span class="fw-bold text-dark modalOrderId fs-5 "></span>
          </p>

          <p class="mb-0">
            <span class="fw-semibold text-secondary fs-5">Status Change:</span>
            <span class="fw-bold text-success currentstatus fs-5"></span>
            <span id="nextsState" class="fs-5">=></span>
          </p>
        </div>


        <div class="modal-footer border-0 d-flex justify-content-center gap-2 mt-0">
          <button type="button" style="background-color: #6c757d;
color: white;" class="btn btn-lg " onclick="handleCancel()" data-bs-dismiss="modal">Cancel</button>
          <button type="button" onclick="submitStatusUpdate()" class="btn btn-lg btn-primary ">Update</button>

        </div>


      </div>
    </div>
  </div>





  <script>
    function RemoveOrder(orderid) {


      fetch("../Server/Process/remove-order.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "order_id=" + encodeURIComponent(orderid),
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              title: "Removed!",
              text: data.message,
              icon: "success",
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        });
    }

    // <!-- Animate rows from bottom to top on page load -->
    document.addEventListener("DOMContentLoaded", function() {

      const rows = document.querySelectorAll("tbody tr");
      rows.forEach((row, index) => {
        setTimeout(() => {
          row.classList.add("slide-up-row");
        }, index * 100); // Staggered delay per row
      });
    });

    function refresh() {
      window.location.reload()

    }
     function RemoveOrder(orderid) {


      fetch("../Process/remove-order.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "order_id=" + orderid,
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              title: "Removed!",
              text: data.message,
              icon: "success",
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.message,
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./Assets/JS/order.js"></script>
  <?php include("./Includes/footer.html"); ?>