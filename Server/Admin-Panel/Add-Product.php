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

?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name = $_POST['name'];
  $description =  $_POST['description'];

  $price = $_POST['price'];
  $category_id = $_POST['category_id'];
  $subcategory_id = $_POST['subcategory_id'];
  $brand_id = $_POST['brand_id'];
  $quantity = $_POST['quantity'];


  $imageName = $_FILES['image']['name'];
  $tmpImage = $_FILES['image']['tmp_name'];
  $uploadsDir = "../uploads/";
  if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir);
  }
  $new_file = time() . "-" . basename($imageName);
  $destination = $uploadsDir . $new_file;
  if (move_uploaded_file($tmpImage, $destination)) {
    $sql = "INSERT INTO products(name, description, price, category_id, subcategory_id,quantity, brand_id)
VALUES ('$name', '$description', '$price', '$category_id', '$subcategory_id', $quantity, '$brand_id')";

    $result = $conn->query($sql);
    if ($result) {
      $product_id = $conn->insert_id; // Get the last inserted product ID
      $sql = "INSERT INTO product_images(product_id, image_url) VALUES ('$product_id', '$new_file')";
      $result = $conn->query($sql);
      if ($result) {
?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              title: "🎉 Product Added!",
              html: "<b>Your product has been successfully added to the store.</b>",
              icon: "success",
              showConfirmButton: true,
              confirmButtonColor: "#3085d6",
              confirmButtonText: "Okay",
              backdrop: `
      rgba(255,255,255,0.2)
      center center
      no-repeat
    `,
              didOpen: () => {
                const backdrop = document.querySelector(".swal2-container");
                if (backdrop) {
                  backdrop.style.backdropFilter = "blur(5px)";
                }
              },
              customClass: {
                popup: "rounded-3 shadow"
              },
              timer: 3000,
              timerProgressBar: true
            });
          });
        </script>
<?php
      } else {
        echo "Error in inserting product image.";
      }
    } else {

      echo "Error";
    }
  }
}  ?>
<style>
  /* body {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    } */

  .form-container {
    background-color: #ffffff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    max-width: 100%;
    width: 100%;
  }

  h4 {
    font-weight: 600;
    color: #343a40;
  }

  .form-label {
    font-weight: 500;
  }

  .form-control:focus,
  .form-select:focus,
  textarea:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    border-color: #0d6efd;
  }

  .upload-box {
    border: 2px dashed #adb5bd;
    border-radius: 12px;
    padding: 30px 20px;
    text-align: center;
    background-color: #f8f9fa;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .upload-box:hover {
    background-color: #e9ecef;
    border-color: #0d6efd;
    color: #0d6efd;
  }

  .upload-box i {
    font-size: 48px;
  }

  .form-footer button {
    padding: 12px 20px;
    font-weight: 500;
    transition: background-color 0.3s ease;
  }

  .form-footer button:hover {
    background-color: #0b5ed7;
  }

  small.text-muted {
    font-size: 0.8rem;
  }
</style>


<div class="form-container">
  <h4 class="mb-4 text-center ">Add New Product</h4>
  <form method="POST" id="product-form" enctype="multipart/form-data">

    <!-- Product Name & Category -->
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Product Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" placeholder="Enter product name" id="product-name" name="name">
        <p class="text-danger  mx-2" id="name-error"></p>
      </div>

      <div class="col-md-6">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <select name="category_id" id="category" class="form-select">
          <option hidden>Select Category</option>

          <?php
          $sql = "SELECT * FROM categories";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $categoryName = $row['name'];
            $categoryId = $row['id'];
            echo "<option value='$categoryId'>$categoryName</option>";
          }
          ?>
        </select>
        <p class="text-danger  mx-2" id="category-error"></p>
      </div>
    </div>

    <!-- Subcategory & Brand -->
    <div class="row g-3 ">
      <div class="col-md-6">
        <label class="form-label">Subcategory <span class="text-danger">*</span></label>
        <select name="subcategory_id" id="subcategory" class="form-select">
          <option hidden>Select subcategory</option>

        </select>
        <p class="text-danger  mx-2" id="subcategory-error"></p>
      </div>

      <div class="col-md-6">
        <label class="form-label">Brand <span class="text-danger">*</span></label>
        <select name="brand_id" class="form-select">
          <option hidden>Select Brand</option>

          <?php
          $sql = "SELECT * FROM brand";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $brandName = $row['name'];
            $brandId = $row['id'];
            echo "<option value='$brandId'>$brandName</option>";
          }
          ?>
        </select>
        <p class="text-danger  mx-2" id="brand-error"></p>

      </div>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <script>
        $(document).ready(function() {
          $('#category').change(function() {
            var categoryId = $(this).val();

            $.ajax({
              url: 'get_subcategories.php',
              type: 'POST',
              data: {
                category_id: categoryId
              },
              success: function(data) {
                $('#subcategory').html(data);
              }
            });
          });
        });
      </script>
      <!-- Description -->
      <div class="mt-1">
        <label class="form-label">Description <span class="text-danger">*</span></label>
        <textarea name="description" id="product-description" class="form-control" rows="3" placeholder="Enter product description" maxlength="100"></textarea>
        <p class="text-danger " id="description-error"></p>
      </div>

      <div class="col-md-6">
        <label class="form-label ">Price <span class="text-danger">*</span></label>
        <input type="number" class="form-control " placeholder="Enter product name" maxlength="20" name="price" id="product-price">
        <p class="text-danger " id="price-error"></p>
      </div>

      <div class="mb-3">
        <label for="product-quantity" class="form-label">Quantity</label>
        <select class="form-select" name="quantity" id="product-quantity">
          <option value="" hidden>Select Quantity</option>
          <?php
          for ($i = 1; $i <= 100; $i++) {
            echo "<option value='$i'>$i</option>";
          }
          ?>
        </select>
        <span id="quantity-error" class="text-danger small"></span>
      </div>




      <!-- Image Upload -->
      <div class="mt-4">
        <label for="product-image" class="form-label">Upload Image <span class="text-danger">*</span></label>
        <label for="product-image" class="upload-box w-100">
          <input type="file" name="image" id="product-image" accept=".jpg, .jpeg, .png" style="position: absolute; left: -9999px;">

          <i class="bi bi-cloud-arrow-up fs-1"></i>
          <div class="mt-2" id="upload-text">Click or drag to upload image</div>
        </label>
        <p class="text-success" id="image-selected" style="display:none;">✅ Image selected!</p>
        <p class="text-danger" id="image-error"></p>
      </div>

      <script>
        document.getElementById('product-image').addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
            document.getElementById('image-selected').style.display = 'block';
            document.getElementById('upload-text').innerText = 'Image Selected: ' + file.name;
          }
        });
      </script>



      <!-- Action Buttons -->
      <div class="d-flex flex-column flex-md-row justify-content-end gap-3 mt-4 form-footer">
        <button type="submit" class="btn btn-primary">Add Product</button>
      </div>
    </div>
  </form>
</div>
</div>








  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap JS (First) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Then your custom JS files -->
<script src="./assets/JS/add-Product.js"></script>
<script src="./assets/JS/subcategory.js"></script>
<script src="./assets/JS/admin.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <?php include("./Includes/footer.html"); ?>
