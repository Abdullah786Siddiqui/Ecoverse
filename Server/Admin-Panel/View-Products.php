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
?>
<style>
  .product-img {
    width: 45px;
    height: 45px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .table-responsive {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.04);
    background-color: #ffffff;
  }



  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fbfd;
  }

  .table-hover tbody tr:hover {
    background-color: #eef2f7;
  }

  .badge-status {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
  }

  .badge-out {
    background-color: #ffe6e6;
    color: #dc3545;
  }

  .badge-in {
    background-color: #e6f4ea;
    color: #28a745;
  }

  .table td,
  .table th {
    vertical-align: middle;
    font-size: 0.85rem;
    padding: 12px 16px;
  }

  .cursor-pointer {
    cursor: pointer;
  }
</style>

<div class="container  p-3">
  <h4 class="mb-4 text-center ">View Product List</h4>

  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 table-control-wrapper">

    <div class="d-flex align-items-center gap-2 flex-wrap">

      <label for="showEntries">Showing</label>
      <select id="showEntries" class="form-select form-select-sm" style="width: 70px;">
        <option selected>10</option>
        <option>25</option>
        <option>50</option>
      </select>
    </div>

    <input type="text" class="form-control w-50 flex-grow-1 " placeholder="Search here..." />

    <a href="./Add-Product.php" class="btn add-btn  btn-outline-primary"><i class="bi bi-plus"></i> Add new</a>
  </div>




  <div class="">
    <table class="table table-hover  align-middle">
      <thead class="">
        <tr>
          <th>Product</th>
          <th>ID</th>
          <th>Price</th>
          <th>Quantity</th>
          <th> Status</th>
          <th> remove</th>
          <th> Update</th>
          <th>Start Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT DISTINCT 
    products.id, 
    products.name, 
    products.quantity, 
    products.description, 
    products.price, 
    brand.name AS brand, 
    product_images.image_url
FROM products
INNER JOIN product_images ON product_images.product_id = products.id
INNER JOIN brand ON brand.id = products.brand_id
ORDER BY products.id DESC  ;
";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
        ?>
          <tr>
            <td>
              <div class="d-flex align-items-center gap-2 delete_product" data-id="<?= $row['id'] ?>">
                <img src="../uploads/<?= htmlspecialchars($row['image_url']); ?>" alt="Product" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                  <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                  <small class="text-muted"><?= htmlspecialchars($row['brand']) ?></small>
                </div>
              </div>
            </td>
            <td class="text-muted text-nowrap">#<?= $row['id'] ?></td>
            <td class="text-nowrap"><strong>$<?= number_format($row['price'], 2) ?></strong></td>
            <td><?= $row['quantity'] ?></td>

            <td>
              <?php
              $badgeClass = 'secondary';

              if ($row['quantity'] > 0) {
                $badgeClass = 'success';
              } elseif ($row['quantity'] == 0) {
                $badgeClass = 'danger';
              }
              ?>
              <span class="badge bg-<?= $badgeClass ?> p-2 d-flex justify-content-center">
                <?= $row['quantity'] > 0 ? 'In Stock' : 'Out of Stock' ?>
              </span>
            <td onclick="removeProduct(<?= $row['id'] ?>)" class=" cursor-pointer">

              <span class="badge bg-danger p-2 px-3 d-flex justify-content-center">
                Remove
              </span>
            </td>

            <td class="cursor-pointer ">

              <a href="./Product-Update.php?updationId=<?= $row['id'] ?>"
                class="badge bg-warning text-white  text-decoration-none px-3 py-2">
               Update
              </a>

            </td>

            <td class="text-nowrap">28 June 2025</td>


          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  
  <script src="./Assets/JS/add-Product.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <?php include("./Includes/footer.html"); ?>