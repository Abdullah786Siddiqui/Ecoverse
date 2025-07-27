<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../Client/index.php");
    exit();
  }
include("./config/db.php");
include("./Sidebar.php");
$product_id = $_GET['updationId'] ?? "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $name       = $_POST['update_product_name'];
  $price      = $_POST['update_product_price'];
  $quantity   = $_POST['update_product_quantity'];
  $desc       = $_POST['update_product_desc'] ?? "";

  // ✅ Update products table
  $conn->query("UPDATE products 
                  SET name='$name', price='$price', quantity='$quantity', description='$desc' 
                  WHERE id='$product_id'");



  if (!empty($_FILES['productImage']['name'])) {
    $fileName = $_FILES['productImage']['name'];
    $tmpName  = $_FILES['productImage']['tmp_name'];
    $uploadsDir = "../uploads/";

    if (!is_dir($uploadsDir)) {
      mkdir($uploadsDir, 0755, true);
    }

    $new_file = time() . "-" . basename($fileName);
    $destination = $uploadsDir . $new_file;

    if (move_uploaded_file($tmpName, $destination)) {
      // ✅ update image url in DB
      $conn->query("UPDATE product_images 
                      SET image_url='$new_file' 
                      WHERE product_id=$product_id");
    }
  }


  echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Product updated successfully!',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      })
    </script>";
  // .then(() => {
  //     window.location.href = 'View-Products.php'; // ya jis page pe redirect karna ho
  //   });
}


$sql = "SELECT 
    products.id, 
    products.name, 
    products.quantity, 
    products.description, 
    products.price, 
    brand.name AS brand, 
    product_images.image_url,
    categories.name as catename,
    subcategories.name as subcatename
FROM products
INNER JOIN product_images ON product_images.product_id = products.id
INNER JOIN brand ON brand.id = products.brand_id
INNER JOIN categories ON products.category_id = categories.id
INNER JOIN subcategories ON products.subcategory_id =subcategories.id

where products.id = $product_id  ";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
?>
  <style>
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
  </style>

  <form method="post" id="updateProductForm" enctype="multipart/form-data">
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
          <h4 class="fw-semibold mb-0">Update Product</h4>

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 breadcrumb-custom">
              <li class="breadcrumb-item"><a href="./Dashbboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="./View-Products.php">Ecommerse</a></li>
              <li class="breadcrumb-item active" aria-current="page">Updation</li>
            </ol>
          </nav>
        </div>

        <div class="row g-4 align-items-start">
          <!-- Left: Image -->
          <div class="col-md-4">
            <div class="text-center">
              <label class="form-label fw-medium"></label>
              <img src="../uploads/<?= $row['image_url'] ?>" class="img-fluid rounded-3 border mb-3" alt="Product Image">
              <div class="mb-2 text-start  ">
                <label for="productImage" class="form-label  fw-semibold small text-muted">
                  <i class="bi bi-image me-1"></i> Change Product Image
                </label>
                <div class="input-group input-group-sm shadow-sm">
                  <span class="input-group-text bg-light"><i class="bi bi-upload"></i></span>
                  <input type="file" name="productImage" id="productImage" class="form-control form-control-sm">
                </div>
              </div>

            </div>
          </div>

          <!-- Right: Fields -->
          <div class="col-md-8">
            <div class="row g-3">

              <!-- Product Name -->
              <div class="col-md-6">
                <label for="productName" class="form-label fw-medium">Product Name</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-box"></i></span>
                  <input type="text" value="<?= $row['name'] ?>" name="update_product_name" id="productName" class="form-control" placeholder="Enter product name">
                </div>
                <small class="text-danger" id="name-error"></small>
              </div>





              <!-- Price -->

              <div class="col-md-6">
                <label for="productPrice" class="form-label fw-medium">Price</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                  <input type="number" value="<?= $row['price'] ?>" name="update_product_price" id="productPrice" class="form-control" placeholder="0.00">
                </div>
                <small class="text-danger" id="price-error"></small>
              </div>

              <!-- Quantity -->
              <div class="col-md-6 ">
                <label for="productQty" class="form-label fw-medium">Quantity</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-stack"></i></span>
                  <input type="number" value="<?= $row['quantity'] ?>" name="update_product_quantity" id="productQty" class="form-control" placeholder="0">
                </div>
                <small class="text-danger" id="qty-error"></small>
              </div>




              <!-- Category -->
              <div class="col-md-6">
                <label class="form-label fw-medium">Category</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-collection"></i></span>
                  <div class="form-control bg-light"><?= $row['catename'] ?></div>
                </div>
              </div>

              <!-- Subcategory -->
              <div class="col-md-6">
                <label class="form-label fw-medium">Subcategory</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-list-nested"></i></span>
                  <div class="form-control bg-light"><?= $row['subcatename'] ?></div>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Brand</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-tag"></i></span>
                  <div class="form-control bg-light"><?= $row['brand'] ?></div>
                </div>
              </div>
              <div class="col-md-12">
                <label for="productDesc" class="form-label fw-medium">Description</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                  <textarea name="update_product_desc" id="productDesc" class="form-control" rows="3" placeholder="Enter product description"><?= $row['description'] ?></textarea>
                </div>
                <small class="text-danger" id="desc-error"></small>
              </div>


              <!-- Submit -->
              <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                  <i class="bi bi-check2-circle"></i> Save Changes
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

<?php } ?>
<!-- Bootstrap CSS + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script src="./Assets/JS/update.product.js"></script>
<?php include("./Includes/footer.html"); ?>