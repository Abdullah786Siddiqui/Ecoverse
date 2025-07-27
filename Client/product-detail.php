<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include './Components/header.html';
include './includes/Navbar.php';
include("../Server/Admin-Panel/config/db.php");

$product_id = $_GET['productid'];
$is_logged_in = $_SESSION['user_id'] ?? "";

?>


<div class="container py-4">
  <div class="row g-4">
    <?php

    $sql = "SELECT products.id , products.name , products.quantity , products.description , products.price , brand.name as brand , product_images.image_url  FROM products
              INNER JOIN product_images on product_images.product_id = products.id
              INNER JOIN brand on brand.id = products.brand_id where products.id = $product_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {


    ?>
      <div class="col-md-6">
        <div class="border rounded p-3 text-center">
          <img src="../Server/uploads/<?= $row['image_url'] ?>" alt="Product Image" class="img-fluid rounded">
        </div>
      </div>

      <!-- Product Details -->
      <div class="col-md-6 d-flex flex-column">
        <h1 class="h4 mb-2"><?= $row['name'] ?></h1>
        <p class="text-muted mb-1">SKU:123456</p>

        <div class="mb-2">
          ⭐⭐⭐⭐☆ <small>(128 reviews)</small>
        </div>

        <div class="mb-3">
          <span class="h4 text-danger">$<?= $row['price'] ?></span>
          <del class="text-muted ms-2">$129.99</del>
        </div>

        <p class="small text-muted mb-2">Ships in 1–2 business days</p>

        <p class="mb-1"><strong>Brand:</strong> <?= $row['brand']  ?></p>
      





        <?php
        $cartQty = 0;

        // cart me is product ki quantity check karo
        if (!empty($_SESSION['cart'])) {
          foreach ($_SESSION['cart'] as $item) {
            if ($item['id'] == $row['id']) {
              $cartQty = $item['quantity'];
              break;
            }
          }
        }

        // agar stock 0 hai ya cart >= stock hai to out of stock
        $isOutOfStock = ($row['quantity'] == 0 || $cartQty >= $row['quantity']);

        // badge class set karo
        $badgeClass = $isOutOfStock ? 'danger' : 'success';

        // stock text set karo
        $stockText = $isOutOfStock ? 'Out of Stock' : 'In Stock';
        ?>

        <p class="small text-<?= $badgeClass ?> mb-2">
          <?= $stockText ?>
        </p>
        <button id="buyNowBtn" class="btn btn-warning mb-2 <?= $isOutOfStock ? 'disabled' : '' ?> " >
          Buy Now
        </button>
        <button id="addToCartBtn" class="btn btn-primary  <?= $isOutOfStock ? 'disabled' : '' ?>">
          Add to Cart
        </button>







        <div class="mb-3 mt-2">
          <p class="mb-1"><strong>Estimated Delivery:</strong> Jul 12 – Jul 15</p>
          <p class="small text-muted">Free standard shipping on orders over $50</p>
        </div>

        <div>
          <p class="mb-1"><strong>Share:</strong></p>
          <div class="d-flex gap-2">
            <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i> Facebook</a>
            <a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-twitter"></i> Twitter</a>
            <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-pinterest"></i> Pinterest</a>
          </div>
        </div>

        <!-- Product Description (for mobile) -->
        <!-- <div class="d-block d-md-none mt-4">
          <h5>Product Description</h5>
          <p class="small">
            SOOTHING & HYDRATING FORMULA — Infused with 10,000ppm heartleaf extract, this peeling gel soothes sensitive skin while maintaining hydration, ensuring your skin feels refreshed and balanced after exfoliation.
          </p>
        </div> -->
      </div>


      <!-- Product Description on desktop -->
      <div class="col-md-6 mt-4 d-none d-md-block">
        <h5>Product Description</h5>
        <p class="small">
          <?= $row['description'] ?>
        </p>
      </div>
  </div>
<?php } ?>
<?php


?>
<section class="mt-5 w-100" id="reviews-section">
  <!-- Average Rating Summary -->
  <div class="text-center mb-5">
    <h2 class="fw-bold mb-3">What Our Customers Say</h2>
    <div class="d-flex justify-content-center align-items-center mb-2">
      <!-- <div class="text-warning fs-2">★★★★★</div>
      <span class="ms-2 fs-4 fw-semibold">4.8/5</span> -->
    </div>
  </div>



  <!-- Review 2 -->
  <?php


  $sql_reviews = "
    SELECT r.*, u.name , u.user_profile 
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id = $product_id
    ORDER BY r.id DESC
";

  $result_reviews = $conn->query($sql_reviews);

  if ($result_reviews->num_rows > 0) {
    while ($review = $result_reviews->fetch_assoc()) {
  ?>
      <div class="card mb-3 border-0 shadow-sm rounded-3">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="me-3">
              <img
                src="<?= empty($review['user_profile']) ? './Assets/Images/user.png' : '../Server/uploads/' . $review['user_profile'] ?>"
                alt="User Profile"
                class="rounded-circle bg-primary"
                style="width:40px; height:40px; object-fit:cover;">

            </div>
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between">
                <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($review['name']) ?></h6>
                <small class="text-muted">
                  <?php if (!empty($review['created_at'])): ?>
                    <?= date('M d, Y', strtotime($review['created_at'])) ?>
                  <?php endif; ?>
                </small>
              </div>
              <div class="text-warning mt-1">
                <?php
                $rating = $review['rating'];
                for ($i = 1; $i <= 5; $i++) {
                  if ($i <= $rating) {
                    echo '<i class="fas fa-star"></i>';
                  } else {
                    echo '<i class="far fa-star"></i>';
                  }
                }
                ?>
              </div>
            </div>
          </div>

          <p class="mt-2 mb-0 text-muted"><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
        </div>
      </div>

  <?php
    }
  } else {
    echo "<p>No reviews yet.</p>";
  }
  ?>


  <!-- Review Form -->
  <?php if ($is_logged_in) { ?>
    <section class=" mt-5" id="leave-review-section">
      <div class="card border-0 shadow-lg rounded-4 p-4 mx-lg-5">
        <h4 class="mb-4 fw-bold text-center text-gradient">Leave Your Review</h4>

        

        <!-- Star Rating -->
        <form id="ratingForm" method="post" action="../Server/Process/review-process.php">
          <div class="mb-4 text-center">
            <label class="form-label fw-semibold d-block mb-2">Your Rating</label>
            <div class="star-rating d-inline-flex flex-row-reverse gap-1">
              <input type="radio" name="rating" id="star5" value="5">
              <label for="star5" title="5 stars">★</label>

              <input type="radio" name="rating" id="star4" value="4">
              <label for="star4" title="4 stars">★</label>

              <input type="radio" name="rating" id="star3" value="3">
              <label for="star3" title="3 stars">★</label>

              <input type="radio" name="rating" id="star2" value="2">
              <label for="star2" title="2 stars">★</label>

              <input type="radio" name="rating" id="star1" value="1">
              <label for="star1" title="1 star">★</label>
            </div>
            <div id="rating-error" class="mt-1 text-danger"></div>

          </div>

          <h2></h2>

          <input type="hidden" id="rating_input" name="rating">
          <input type="hidden" name="product_id" value="<?= $product_id ?>">



          <!-- Feedback Text -->
          <div class="mb-4">
            <label for="reviewText" class="form-label fw-semibold">Your Feedback</label>
            <textarea name="feedback_user" class="form-control rounded-3 shadow-sm" id="reviewText" rows="4" placeholder="Share your experience..."></textarea>
            <div id="feedback-error" class="mt-2 text-danger"></div>

          </div>


          <!-- Submit Button -->
          <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold">Submit Review</button>
        </form>
      </div>
    </section>
    <?php include("./includes/mobile-icon.php") ?>
  <?php } else {
  } ?>


  <?php include './includes/AuthModal.php'; ?>


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      
      const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
      const buyNowBtn = document.getElementById('buyNowBtn');
      const addToCartBtn = document.getElementById('addToCartBtn');

      buyNowBtn.addEventListener('click', () => {
        checkSession(<?= $product_id ?>, 'buy');
      });

      addToCartBtn.addEventListener('click', () => {
        checkSession(<?= $product_id ?>, 'cart');
      });


      function checkSession(productId, action) {
        if (isLoggedIn) {
          if (action === 'buy') {
            buynow(productId);
          } else {
            addToCart(productId);
          }
        } else {
          sessionStorage.setItem('postLoginActioncheckout', JSON.stringify({
            productId,
            action
          }));
          showLoginModal();
        }
      }

      function showLoginModal() {
        const modal = new bootstrap.Modal(document.getElementById('authModal'));
        modal.show();
      }

      function showSignup() {
        document.getElementById('authModalTitle').innerText = 'Signup';
        document.getElementById('loginForm').classList.add('d-none');
        document.getElementById('signupForm').classList.remove('d-none');
      }

      function showLogin() {
        document.getElementById('authModalTitle').innerText = 'Login';
        document.getElementById('signupForm').classList.add('d-none');
        document.getElementById('loginForm').classList.remove('d-none');
      }
    })
    document.getElementById("ratingForm").addEventListener("submit", function(e) {
      e.preventDefault(); // stop form from reloading

      const selected = document.querySelector('input[name="rating"]:checked');
      const feedback = document.querySelector('#reviewText').value.trim();
      const ratingInput = document.getElementById("rating_input");

      // Reset error messages
      document.getElementById("rating-error").textContent = "";
      document.getElementById("feedback-error").textContent = "";

      let hasError = false;

      if (!selected) {
        document.getElementById("rating-error").textContent = "Please select a rating!";
        hasError = true;
      }

      if (!feedback) {
        document.getElementById("feedback-error").textContent = "Please enter your feedback!";
        hasError = true;
      }

      if (hasError) {
        return;
      }

      // Set hidden input value for rating
      ratingInput.value = selected.value;

      const formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            window.location.reload()
          } else {
            alert(data.message);
          }
        })
        .catch(err => {
          alert("Request failed: " + err.message);
        });
      


    });
  
  </script>
  <script src="./Assets/JS/cart.js"></script>


<?php include 'Components/footer2.html'; ?>
  <?php include './Components/footer.html';  ?>