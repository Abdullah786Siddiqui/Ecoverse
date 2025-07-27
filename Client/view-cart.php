<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ./index.php");
  exit();
}
include './Components/header.html';

include './includes/Navbar.php';


$subtotal = 0;

?>
<style>
  .hover-text-danger:hover {
    color: #dc3545 !important;
    /* Bootstrap 5 Danger color */
  }
</style>

<div class="container ">

  <div style="background-color: whitesmoke;" class="bag-section ">
    <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    ?>
      <h2 class="mt-4">Your bag (<span class="cart-count "><?= count($_SESSION['cart']) ?></span>)items</h2>

      <p id='bag-sec' class=""></p>
      <?php


      foreach (array_reverse($_SESSION['cart'])  as  $items) {
        $totalprice = $items['price'] * $items['quantity'];
        $subtotal += $totalprice;

      ?>

        <div class="bag-item border rounded-3 p-3 mb-3 bg-white shadow-sm" data-id="<?= $items['id'] ?>">

          <!-- 🖼 Image + Details -->
          <div class="row g-2">
            <div class="col-3 col-sm-2">
              <img src="../Server/uploads/<?= $items['image'] ?>"
                class="img-fluid rounded-2 w-100 h-auto">
            </div>

            <div class="col-9 col-sm-10">
              <h6 class="mb-1 fw-semibold"><?= $items['name'] ?></h6>
              <p class="text-muted mb-0 small">Colour: blue</p>
              <p class="text-muted mb-1 small">Size: 40R</p>

              <div class="item-actions d-flex flex-wrap align-items-center gap-2 mt-2">
                <button class="btn btn-link p-0 text-danger small" onclick="removeCart(<?= $items['id'] ?>)">
                  <i class="far fa-trash-alt"></i> Remove
                </button>

                <span class="vr mx-1 d-none d-sm-inline"></span>

                <button class="btn btn-link p-0 text-danger small">
                  <i class="far fa-heart"></i> Wishlist
                </button>
              </div>
            </div>
          </div>

          <!-- Divider -->
          <hr class="my-2">

          <!-- 📦 Quantity + Price -->
          <div class="row g-2 align-items-center">
            <div class="quantity">
            <select class="form-select form-select-sm" style="width: 70px;"
              onchange="updateQuantity(<?= $items['id'] ?>, this.value)">
              <?php
              $itemid = $items['id'];
              $sql = "SELECT quantity AS stock FROM products WHERE id = $itemid";
              $result = $conn->query($sql);

              if ($row = $result->fetch_assoc()) {
                $stockQty = $row['stock'];
                $currentQty = $items['quantity'];

                // Always show max 10 or less if stock is lower
                $maxQty = ($stockQty <= 10) ? $stockQty : 10;


                for ($i = 1; $i <= $maxQty; $i++) {
                  $selected = ($i == $currentQty) ? 'selected' : '';
                  echo "<option value=\"$i\" $selected>$i</option>";
                }
              } else {
                echo "<option>Error: stock not found</option>";
              }
              ?>
            </select>
          </div>
            


            <div class="col text-end">
              <div class="small text-muted text-decoration-line-through">£264.99</div>
              <div class="fw-bold text-dark">£<?= $totalprice ?></div>
              <div class="text-success small">You save 40%</div>
            </div>
          </div>
        

        </div>

      <?php
      }
  

      ?>




  </div>

  <div class="summary-section my-4">
    <h2>Total</h2>
    <div class="card shadow-sm rounded-3 p-3">

      <h4 class="mb-3">Order Summary</h4>

      <div class="d-flex justify-content-between mb-2">
        <span class="text-muted">Subtotal</span>
        <span class="fw-bold cart-subtotal">£<?= $subtotal ?></span>
      </div>

      <div class="d-flex justify-content-between mb-2">
        <span class="text-muted">Delivery</span>
        <span class="fw-bold text-success">Free</span>
      </div>

      <hr>

      <div class="d-flex justify-content-between mb-3 gap-2">
        <span class="fw-bold">Total (VAT included)</span>
        <span class="fw-bold text-dark cart-subtotal">£<?= $subtotal ?></span>
      </div>

      <a href="./checkout.php" class="btn btn-primary w-100 fw-bold py-2 mb-2">Go to Checkout</a>
      <a class="w-100 btn btn-warning text-white w-100 fw-bold py-2" type="submit">Continue Shopping</a>
    </div>

    <!-- Voucher Section -->

  </div>

</div>
<?php    } else {
?>
  <div class="empty-cart-section text-center my-5">
    <img src="https://cdn-icons-png.flaticon.com/128/10967/10967193.png" alt="Empty Cart" style="width: 150px; opacity: 0.8;">
    <h2 class="mt-4">Your Cart is Empty</h2>
    <p class="text-muted">Looks like you haven’t added anything to your bag yet.</p>
    <a href="./index.php" class="btn btn-primary mt-3 px-4 py-2 fw-bold">Continue Shopping</a>
  </div>


<?php }  ?>
<?php include("./includes/mobile-icon.php") ?>

<script src="./Assets/JS/cart.js"></script>
<script>
  function updateQuantity(productid, val) {
    fetch("../Server/Process/update-cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `productid=${productid}&quantity=${val}`,
      })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          // Update subtotal in summary section
          document.querySelectorAll(".cart-subtotal").forEach(el => {
            el.textContent = "$ " + data.subtotal;
          });
        }
      });
  }
</script>

<?php include 'Components/footer2.html'; ?>
<?php include './Components/footer.html';  ?>