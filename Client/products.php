<?php
include './Components/header.html';
include './includes/Navbar.php';


$subCategory_id = isset($_GET['subcategory_id']) ? (int)$_GET['subcategory_id'] : 0;
$search_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

?>

<!-- Skeleton Loader -->

<div class="mx-3 mt-4 " id="skeleton-loader" style="display:none;">
  <div class="row">
    <!-- Sidebar Skeleton -->
    <aside class="col-lg-3 d-none d-lg-block">
      <div class="filter-sidebar bg-light border rounded p-4 h-100 shadow-sm bg-white">
        <h5 class="mb-4 text-primary">Filter Products</h5>
        <div class="filter-group mb-3">
          <h6 class="text-muted mb-3 border-bottom pb-2">Brand</h6>
          <div class="skeleton skeleton-check mb-3"></div>
          <div class="skeleton skeleton-check mb-3"></div>
          <div class="skeleton skeleton-check mb-3"></div>
          <div class="skeleton skeleton-check mb-3"></div>
        </div>
      </div>
    </aside>

    <!-- Main Content Skeleton -->
    <main class="col-lg-9">
      <div id="product-list">
        <div class="row g-4">
          <div class="col-sm-6 col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative">
              <div class="ratio ratio-1x1 mb-4 skeleton skeleton-img"></div>
              <div class="skeleton skeleton-title mb-3"></div>
              <div class="skeleton skeleton-price mb-3"></div>
              <div class="skeleton skeleton-rating"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative">
              <div class="ratio ratio-1x1 mb-4 skeleton skeleton-img"></div>
              <div class="skeleton skeleton-title mb-3"></div>
              <div class="skeleton skeleton-price mb-3"></div>
              <div class="skeleton skeleton-rating"></div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative">
              <div class="ratio ratio-1x1 mb-4 skeleton skeleton-img"></div>
              <div class="skeleton skeleton-title mb-3"></div>
              <div class="skeleton skeleton-price mb-3"></div>
              <div class="skeleton skeleton-rating"></div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>


<div id="main-content" style="display:none;">


  <div class="container-fluid products mt-4 h-100">
    <div class="row">
      <!-- Sidebar Desktop -->
      <aside class="col-lg-3 d-none d-lg-block   ">
        <div class="filter-sidebar bg-light border rounded p-3 h-100 shadow-sm bg-white">
          <h5 class="mb-4 text-primary">Filter Products</h5>

          <div class="filter-group mb-3">
            <h6 class="text-muted mb-3 border-bottom pb-1">Brand</h6>

            <?php
            $sql = "
      SELECT DISTINCT brand.id as brand_id,   brand.name, products.subcategory_id AS subcategory_id
      FROM products
      INNER JOIN brand ON brand.id = products.brand_id
      WHERE products.subcategory_id = $subCategory_id OR products.id = $search_id
    ";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $brand_id = $row['brand_id'];
              $brand_name = $row['name'];
            ?>
              <div class="form-check mb-2">
                <input
                  class="form-check-input brand-filter"
                  type="checkbox"
                  value="<?= htmlspecialchars($brand_name) ?>"
                  id="brand<?= $brand_id ?>"
                  <?= $search_id != 0 ? 'disabled' : '' ?>>
                <label class="form-check-label" for="brand<?= $brand_id ?>">
                  <?= htmlspecialchars($brand_name) ?>
                </label>
              </div>
            <?php } ?>
          </div>
        </div>

      </aside>
      <div class="mt-1 text-end d-lg-none  mb-2">
        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilters">
          Filters
        </button>
      </div>

      <div id="filter-loader" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <!-- Main Content -->
      <main id="products_items" class="col-lg-9">
        <div id="product-list">
          <div class="row g-3">
            <?php
            $product_result = [];
            $sql = "SELECT DISTINCT products.id as productid , products.name , products.description , products.price , brand.name as brand , product_images.image_url  
                FROM products
                INNER JOIN product_images ON product_images.product_id = products.id
                INNER JOIN brand ON brand.id = products.brand_id  
                WHERE products.subcategory_id = $subCategory_id  or products.id = $search_id   ORDER BY products.id DESC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
              $product_result[] = $row;
              $product_id = $row['productid'];
            ?>

              <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
                <a href="./product-detail.php?productid=<?= $product_id; ?>" class="text-decoration-none">
                  <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">

                    <!-- Discount Badge -->

                    <!-- Product Image -->
                    <div class="ratio ratio-1x1 mb-3 ">
                      <img
                        src="../Server/uploads/<?= $row['image_url']; ?>"
                        class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                        alt="<?= htmlspecialchars($row['name']) ?>"
                        loading="lazy">
                    </div>

                    <!-- Product Name -->
                    <h5 class="fw-semibold mb-2 text-truncate text-dark"><?= $row['name'] ?></h5>

                    <!-- Price -->
                    <p class="mb-2">
                      <span class="fw-bold text-success fs-6">Rs.<?= $row['price'] ?></span>
                      <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
                    </p>

                    <!-- Rating -->
                    <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>

                  </div>
                </a>
              </div>

            <?php } ?>


            <!-- Add more product cards here -->
          </div>

          <!-- Mobile filter button niche -->


      </main>
      <!-- filter products -->
      <main id="products_items_filter" class="col-lg-9 d-none">

      </main>

    </div>
  </div>

  <!-- Mobile Offcanvas -->
  <div class="offcanvas offcanvas-bottom d-lg-none" tabindex="-1" id="mobileFilters">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Filters</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <div class="filter-sidebar">
        <h5>Filter Products</h5>

        <div class="filter-group">
          <h6 class="text-muted">Brand</h6>
          <?php
          $sql = "SELECT  DISTINCT brand.id as id ,   brand.name , products.subcategory_id as subcategory_id FROM products
INNER JOIN brand on brand.id = products.brand_id where products.subcategory_id = $subCategory_id or products.id = $search_id  ";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            $brand_id = $row['id'];
            $brand_name = $row['name'];

          ?>
            <div style="font-weight: 500;" class="form-check ">
              <input class="form-check-input brand-filter" type="checkbox" value="<?= $brand_id ?>" id="brand<?= $brand_id ?>" <?= $search_id != 0 ?  'disabled ' : '' ?>>

              <label class="form-check-label" for="brand<?= $brand_id ?>"><?= $brand_name ?></label>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

include("./includes/mobile-icon.php") ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("skeleton-loader").style.display = "block";
    document.getElementById("main-content").style.display = "none";
  });

  window.onload = function() {
    setTimeout(function() { // simulate loading
      document.getElementById("skeleton-loader").style.display = "none";
      document.getElementById("main-content").style.display = "block";
    }, 800); // 800ms loader, adjust as needed
  };


  document.querySelectorAll('.brand-filter').forEach(checkbox => {
    checkbox.addEventListener('change', () => {

      document.getElementById('products_items').classList.add('d-none');
      document.getElementById('products_items_filter').classList.remove('d-none');
      const checkedBrands = Array.from(document.querySelectorAll('.brand-filter:checked')).map(checkbox => checkbox.value);
      


      const products = <?php echo json_encode($product_result); ?>;

      let html = '';

      products.forEach(item => {
        if (checkedBrands.includes(item.brand)) {
          html += `
          <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
            <a href="./product-detail.php?productid=${item.productid}" class="text-decoration-none">
              <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
                <div class="ratio ratio-1x1 mb-3">
                  <img
                    src="../Server/uploads/${item.image_url}"
                    class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                    alt="${item.name}"
                    loading="lazy">
                </div>

                <h5 class="fw-semibold mb-2 text-truncate text-dark">${item.name}</h5>

                <p class="mb-2">
                  <span class="fw-bold text-success fs-6">Rs.${item.price}</span>
                  <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
                </p>

                <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
              </div>
            </a>
          </div>
        `;
        }
      });

      document.getElementById('products_items_filter').innerHTML = `<div class="row g-3">${html}
            </div>`

      if (checkedBrands.length === 0 || html.trim() === '') {
        document.getElementById('products_items').classList.remove('d-none');
        document.getElementById('products_items_filter').classList.add('d-none');
      }

    });
  });
</script>
<script src="./Assets/JS/products.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<?php include 'Components/footer2.html'; ?>
<?php include './Components/footer.html';  ?>