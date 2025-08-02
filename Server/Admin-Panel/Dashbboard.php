 <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../../Client/index.php");
        exit();
    }
    include("./config/db.php");
    include("./includes/header.html");
    include("./Sidebar.php");

    ?>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

 <h3 class="text-center mt-3">Welcome to Admin Panel</h3>
 <style>
     :root {
         --primary: #4e73df;
         --secondary: #1cc88a;
         --danger: #e74a3b;
         --warning: #f6c23e;
         --info: #36b9cc;
         --bg: #f8f9fc;
         --card: #ffffff;
         --shadow: rgba(0, 0, 0, 0.1);
     }

     body {
         background: var(--bg);
         color: #5a5c69;
     }

     .card {
         background: var(--card);
         border: none;
         border-radius: 0.75rem;
         box-shadow: 0 0.25rem 1rem var(--shadow);
         transition: transform 0.3s ease;
     }

     .card:hover {
         transform: translateY(-5px);
     }

     .table thead {
         background-color: var(--primary);
         color: white;
         position: sticky;
         top: 0;
     }

     .badge {
         font-size: 0.8rem;
     }

     .table-responsive {
         max-height: 300px;
         overflow-y: auto;
     }

     .kpi-icon {
         font-size: 2rem;
     }

     .chart-container {
         position: relative;
         height: 300px;
         width: 100%;
     }

     table {
         overflow-x: hidden;
     }
 </style>
 </head>

 <body>
     <div class="container-fluid p-4">
         <div class="row g-4">
             <?php

                $sql = "SELECT 
    COUNT(DISTINCT orders.id) AS order_count,
    SUM(orders.total) AS total_sales,
    COUNT(DISTINCT CASE WHEN orders.status = 'delivered' THEN orders.id END) AS paid_orders
FROM 
    orders
    INNER JOIN order_items ON orders.id = order_items.order_id
WHERE 
    orders.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01');

";
                $result = $conn->query($sql);
                if ($row = $result->fetch_assoc()) {
                ?>
                 <!-- KPI Cards -->
                 <div class="col-md-3">
                     <div class="card p-3 text-center">
                         <div class="kpi-icon mb-2 text-success"><i class="bi bi-cart-check"></i></div>
                         <h6>Total Order this Month</h6>
                         <h4>$<?= $row['order_count'] ?></h4>
                     </div>
                 </div>
                 <div class="col-md-3">
                     <div class="card p-3 text-center">
                         <div class="kpi-icon mb-2 text-warning"><i class="bi bi-currency-dollar"></i></div>
                         <h6>Total Income</h6>
                         <h4>$<?= $row['total_sales'] ?></h4>
                     </div>
                 </div>
                 <div class="col-md-3">
                     <div class="card p-3 text-center">
                         <div class="kpi-icon mb-2 text-info"><i class="bi bi-receipt"></i></div>
                         <h6>Orders Paid</h6>
                         <h4>$<?= $row['paid_orders'] ?></h4>

                     </div>
                 </div>
             <?php } ?>
             <?php
                $sql_user = "SELECT COUNT(id) as user_count from users";
                $result_user = $conn->query($sql_user);
                if ($row = $result_user->fetch_assoc()) {
                ?>
                 <div class="col-md-3">
                     <div class="card p-3 text-center">
                         <div class="kpi-icon mb-2 text-primary"><i class="bi bi-people"></i></div>
                         <h6>Total Users</h6>
                         <h4><?= $row['user_count'] ?></h4>
                     </div>
                 </div>
             <?php } ?>
             <!-- Graph + Tables -->
             <div class="col-lg-12">
                 <div class="card p-3 mb-4">
                     <h5 class="mb-3">Recent Orders Graph</h5>
                     <div class="chart-container">
                         <canvas id="ordersChart"></canvas>
                     </div>
                 </div>
             </div>

           

             <!-- Tables -->
             <div class="col-md-6">
                 <div class="card p-3">
                     <h5 class="mb-3">Top Products</h5>
                     <?php
                        $sql_tp = "SELECT 
    products.id AS product_id,
    products.name AS product_name,
    SUM(order_items.quantity) AS total_quantity_sold
FROM 
    order_items
INNER JOIN 
    orders
ON 
    orders.id = order_items.order_id
INNER JOIN 
    products
ON 
    products.id = order_items.product_id
WHERE 
    MONTH(orders.created_at) = MONTH(CURRENT_DATE())
AND 
    YEAR(orders.created_at) = YEAR(CURRENT_DATE())
GROUP BY 
    products.id,
    products.name
ORDER BY 
    total_quantity_sold DESC
LIMIT 5;
";
                        $result_tp = $conn->query($sql_tp)

                        ?>
                     <div>
                         <table class="table">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>Product</th>
                                     <th>Quantity</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    while ($row_tp = $result_tp->fetch_assoc()) {
                                    ?>
                                     <tr>
                                         <td><?= $row_tp['product_id'] ?></td>
                                         <td><?= $row_tp['product_name'] ?></td>
                                         <td class="text-center"><?= $row_tp['total_quantity_sold'] ?></td>
                                     </tr>
                                 <?php   } ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>

             <div class="col-md-6">
                 <div class="card p-3">
                     <h5 class="mb-3">Recent Orders</h5>
                     <?php
                        $sql_ro = "
SELECT 
    orders.id,
    users.name ,
    orders.status,
    orders.total,
    orders.created_at as order_date
FROM 
    orders
    INNER JOIN users
    on users.id = orders.user_id
ORDER BY 
     order_date DESC 
LIMIT 5

";
                        $result_ro = $conn->query($sql_ro)
                        ?>
                     <div class="table-responsive">
                         <table class="table">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Customer</th>
                                     <th>Status</th>
                                     <th>Total</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php




                                    while ($row_ro = $result_ro->fetch_assoc()) {
                                        $badgeClass = '';
                                        if ($row_ro['status'] === "pending") {
                                            $badgeClass = 'bg-warning text-dark';
                                        } elseif ($row_ro['status'] === "shipped") {
                                            $badgeClass = 'bg-primary';
                                        } elseif ($row_ro['status'] === "delivered") {
                                            $badgeClass = 'bg-success';
                                        } elseif ($row_ro['status'] === "cancelled") {
                                            $badgeClass = 'bg-danger';
                                        }
                                    ?>
                                     <tr>
                                         <td><?= $row_ro['id'] ?></td>
                                         <td><?= $row_ro['name'] ?></td>
                                         <td><span class="badge <?= $badgeClass ?>"><?= $row_ro['status'] ?></span></td>
                                         <td><?= $row_ro['total'] ?></td>
                                     </tr>
                                 <?php   } ?>


                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>

         </div>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
     <script>
         const ctx = document.getElementById('ordersChart').getContext('2d');
         new Chart(ctx, {
             type: 'line',
             data: {
                 labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                 datasets: [{
                     label: 'Orders',
                     data: [120, 150, 140, 180, 210, 200, 240],
                     borderColor: '#4e73df',
                     backgroundColor: 'rgba(78, 115, 223, 0.15)',
                     tension: 0.4,
                     fill: true
                 }]
             },
             options: {
                 responsive: true,
                 maintainAspectRatio: false,
                 plugins: {
                     legend: {
                         display: false
                     }
                 },
                 scales: {
                     x: {
                         grid: {
                             display: false
                         }
                     },
                     y: {
                         beginAtZero: true,
                         grid: {
                             color: '#e9ecef'
                         }
                     }
                 }
             }
         });
     </script>



     <!-- Bootstrap JS (First) -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Then your custom JS files -->
     <script src="./assets/JS/add-Product.js"></script>
     <script src="./assets/JS/subcategory.js"></script>
     <script src="./assets/JS/admin.js"></script>





 </body>

 </html>