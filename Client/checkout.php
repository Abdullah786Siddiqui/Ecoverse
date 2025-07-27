 <?php

  include("../Server/Admin-Panel/config/db.php");
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit();
  }
  include './Components/header.html';
  include './includes/Navbar.php';



  $user_id = $_SESSION['user_id'] ?? "";
  $subtotal_VAL = 0;
  if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $items) {
      $totalprice = $items['price'] * $items['quantity'];
      $subtotal_VAL += $totalprice;
    }
  }
  $sql = "SELECT * FROM addresses WHERE user_id = '$user_id' AND type = 'billing' LIMIT 1";
  $hasAddress = false;
  $result = $conn->query($sql);
  if ($row = $result->fetch_assoc()) {
    $hasAddress = true;
  }

  ?>
 <div class="containe mt-4 " id="skeleton-loader" style="display:none;">
   <div class="row">
     <div class="col-12 col-lg-8">
       <div class="card shadow-sm rounded-4 border h-100">
         <div class="card-body ">
           <div class="border rounded-3 mb-4">

             <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-top">
               <div class="skeleton skeleton-text" style="width: 180px; height: 24px;"></div>
               <div class="skeleton skeleton-btn" style="width: 80px; height: 36px;"></div>
             </div>

             <ul class="list-group list-group-flush">
               <li class="list-group-item px-3 py-3">
                 <div class="skeleton skeleton-text" style="width: 75%; height: 18px;"></div>
               </li>
               <li class="list-group-item px-3 py-3">
                 <div class="skeleton skeleton-text" style="width: 90%; height: 18px;"></div>
               </li>
               <li class="list-group-item px-3 py-3">
                 <div class="skeleton skeleton-text" style="width: 55%; height: 18px;"></div>
               </li>
               <li class="list-group-item px-3 py-3">
                 <div class="skeleton skeleton-text" style="width: 65%; height: 18px;"></div>
               </li>
             </ul>
           </div>

           <!-- Cart Item Skeleton -->
           <div class="mb-4 p-4 border rounded-4 shadow-sm bg-white">
             <div class="d-flex flex-column flex-md-row gap-4">
               <div class="flex-shrink-0 skeleton" style="width:130px; height:130px;"></div>

               <div class="flex-grow-1 d-flex flex-column justify-content-between">
                 <div>
                   <div class="skeleton skeleton-text mb-3" style="width:55%; height:18px;"></div>
                   <div class="skeleton skeleton-text mb-2" style="width:45%; height:14px;"></div>
                   <div class="skeleton skeleton-text mb-3" style="width:35%; height:14px;"></div>
                 </div>

                 <div class="d-flex flex-wrap gap-3">
                   <div class="skeleton skeleton-btn" style="width:110px; height:36px;"></div>
                   <div class="skeleton skeleton-btn" style="width:140px; height:36px;"></div>
                 </div>
               </div>
             </div>

             <hr class="my-4">

             <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
               <div class="skeleton skeleton-text" style="width:80px; height:34px;"></div>
               <div class="skeleton skeleton-text" style="width:90px; height:28px;"></div>
             </div>
           </div>
         </div>
       </div>
     </div>

     <div class="col-12 col-lg-4">
       <div class="summary-section">
         <div class="card shadow-sm rounded-4 p-4 mb-4">
           <div class="skeleton skeleton-text mb-4" style="width:55%; height:22px;"></div>

           <div class="d-flex justify-content-between mb-3">
             <div class="skeleton skeleton-text" style="width:45%; height:18px;"></div>
             <div class="skeleton skeleton-text" style="width:35%; height:18px;"></div>
           </div>

           <div class="d-flex justify-content-between mb-3">
             <div class="skeleton skeleton-text" style="width:45%; height:18px;"></div>
             <div class="skeleton skeleton-text" style="width:25%; height:18px;"></div>
           </div>

           <hr>

           <div class="d-flex justify-content-between mb-4">
             <div class="skeleton skeleton-text" style="width:55%; height:20px;"></div>
             <div class="skeleton skeleton-text" style="width:35%; height:20px;"></div>
           </div>

           <div class="skeleton skeleton-btn mb-3" style="width:100%; height:44px;"></div>
         </div>

      
       </div>
     </div>


   </div>

 </div>
 <style>
   .skeleton {
     background-color: #e0e0e0;
     background-image: linear-gradient(90deg, #e0e0e0 0px, #f4f4f4 40px, #e0e0e0 80px);
     background-size: 600px;
     animation: shimmer 1.2s infinite linear forwards;
     border-radius: 4px;
   }

   @keyframes shimmer {
     0% {
       background-position: -600px 0;
     }

     100% {
       background-position: 600px 0;
     }
   }

   .skeleton-text {
     display: block;
   }

   .skeleton-btn {
     display: inline-block;
     border-radius: 4px;
   }

   .skeleton-icon {
     display: inline-block;
     border-radius: 50%;
   }

   /* Backdrop blur */
   .modal-backdrop.show {
     backdrop-filter: blur(5px);
     background-color: rgba(0, 0, 0, 0.2);
     /* semi-transparent black */
   }

   /* Compact form inputs */
   #main-content .form-control,
   #main-content .form-select {
     font-size: 0.9rem;
   }

   /* Adjust modal content size */
   .modal-content {
     border-radius: 1rem;
   }

   @media (max-width: 864px) {
     #mobile_icons {
       display: flex !important;

     }
   }
 </style>
 <div id="main-content" style="display:none;">
   <div class="cont p-lg-3   ">
     <div class="row g-3 ">

       <?php if ($hasAddress) : ?>
         <div class="col-12 col-lg-8">
           <div class="card shadow-sm rounded-4 border h-100">
             <div class="card-body p-md-3 ">
               <div class="border rounded-3 mb-4">

                 <!-- Shipping & Billing Section Header -->
                 <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded-top">
                   <h5 class="mb-0 text-success">Shipping & Billing</h5>
                   <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#deliveryModal">Edit</button>
                 </div>

                 <!-- Address Details -->
                 <ul class="list-group list-group-flush">
                   <li class="list-group-item px-3 py-2"><strong>Name:</strong> <?= $row['full_name'] ?></li>
                   <li class="list-group-item px-3 py-2"><strong>Address:</strong> <?= $row['address_line1'] ?></li>
                   <li class="list-group-item px-3 py-2"><strong>Phone:</strong> <?= $row['phone'] ?></li>
                   <li class="list-group-item px-3 py-2"><strong>City:</strong> <?= $row['city'] ?></li>
                 </ul>

               </div>


               <!-- Cart Items -->
               <?php

                $subtotal = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                  foreach (array_reverse($_SESSION['cart']) as $items) {
                    $totalprice = $items['price'] * $items['quantity'];
                    $subtotal += $totalprice;
                ?>
                   <div class="mb-4 p-3 border rounded-4 shadow-sm bg-white bag-item" data-id="<?= $items['id'] ?>">

                     <!-- Product Details Row -->
                     <div class="d-flex flex-column flex-md-row gap-3">

                       <!-- Product Image -->
                       <div class="flex-shrink-0" style="width: 120px; height: 120px; overflow: hidden;">
                         <img src="../Server/uploads/<?= $items['image'] ?>" class="img-fluid rounded-3 h-100 w-100 object-fit-cover" alt="Product Image">
                       </div>

                       <!-- Product Info -->
                       <div class="flex-grow-1 d-flex flex-column justify-content-between">
                         <div>
                           <h6 class="fw-bold mb-1"><?= $items['name'] ?></h6>
                           <p class="mb-1 text-body-secondary small">Colour: <span class="text-dark">Blue</span></p>
                           <p class="mb-2 text-body-secondary small">Size: <span class="text-dark">40R</span></p>
                         </div>

                         <!-- Item Actions -->
                         <div class="d-flex flex-wrap gap-2">
                           <button class="btn btn-sm btn-outline-danger" onclick="removeCart(<?= $items['id'] ?>)">
                             <i class="far fa-trash-alt me-1"></i> Remove
                           </button>
                           <button class="btn btn-sm btn-outline-secondary">
                             <i class="far fa-heart me-1"></i> Move to Wishlist
                           </button>
                         </div>
                       </div>
                     </div>

                     <!-- Divider -->
                     <hr class="my-3">

                     <!-- Quantity and Price Row -->
                     <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                       <!-- Quantity -->
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




                       <!-- Price -->
                       <div class="text-end">
                         <small class="text-muted text-decoration-line-through">£264.99</small><br>
                         <span class="fw-bold fs-5">£<?= $items['price']?></span><br>
                         <small class="text-success">You save 40%</small>
                       </div>

                     </div>
                   </div>
                 <?php

                  }
                  $_SESSION['final_subtotal'] = $subtotal_VAL;
                } else {
                  ?>

                 <h1 class="text-center">Your Cart is Empty</h1>
               <?php
                }
                ?>

             </div>
           </div>
         </div>



       <?php else: ?>
         <div class="col-12 col-lg-8">
           <div class="card shadow-sm rounded-4">
             <div class="card-body p-4">
               <h2 class="text-center mb-4" style="font-family: 'Gill Sans', 'Trebuchet MS'; color:#333;">Delivery Address</h2>

               <form id="address-form" novalidate>
                 <div class="row g-3">
                   <div class="col-12">
                     <label for="fullName" class="form-label">Full Name</label>
                     <input type="text" class="form-control" name="checkout_name" id="fullName" placeholder="Enter Your Full Name" required>
                     <div id="fullName-error" class="text-danger"></div>
                   </div>

                   <input type="hidden" id="user_id" name="user_id" value="<?= $user_id  ?>">

                   <div class="col-12">
                     <label for="address" class="form-label">Address</label>
                     <input type="text" class="form-control" name="checkout_address" id="address" placeholder="1234 Main St" required>
                     <div id="address-error" class="text-danger"></div>
                   </div>

                   <div class="col-12">
                     <label for="phone" class="form-label">Phone</label>
                     <input type="text" class="form-control" name="checkout_phone" id="phone" placeholder="+92300000000" required>
                     <div id="phone-error" class="text-danger"></div>
                   </div>

                   <div class="col-md-6">
                     <label for="country" class="form-label">Country</label>
                     <select class="form-select" id="country" name="checkout_country" required>
                       <option value="">Choose...</option>
                       <option>Pakistan</option>
                       <option>United States</option>
                       <option>India</option>
                       <option>France</option>
                     </select>
                     <div id="country-error" class="text-danger"></div>
                   </div>

                   <div class="col-md-6">
                     <label for="city" class="form-label">City</label>
                     <select class="form-select" id="city" name="checkout_city" required>
                       <option value="">Choose...</option>
                       <option>Lahore</option>
                       <option>Karachi</option>
                       <option>Multan</option>
                     </select>
                     <div id="city-error" class="text-danger"></div>
                   </div>
                 </div>

                 <hr class="my-4">

                 <div class="form-check mb-3">
                   <input type="checkbox" class="form-check-input" id="same-address" name="check_address" value="1">
                   <label class="form-check-label fw-bold" for="same-address">Shipping address is the same as billing</label>
                 </div>

                 <div id="shipping-section" class="bg-light p-3 rounded-3" style="display:none;">
                   <h5 class="mb-3">Shipping Address</h5>

                   <div class="mb-3">
                     <label for="shippingName" class="form-label">Full Name</label>
                     <input type="text" class="form-control" name="checkout_shipping_name" id="shippingName">
                     <div id="shippingName-error" class="text-danger"></div>
                   </div>

                   <div class="mb-3">
                     <label for="shippingAddress" class="form-label">Address</label>
                     <input type="text" class="form-control" name="checkout_shipping_address" id="shippingAddress">
                     <div id="shippingAddress-error" class="text-danger"></div>
                   </div>

                   <div class="mb-3">
                     <label for="shippingPhone" class="form-label">Phone</label>
                     <input type="text" class="form-control" name="checkout_shipping_phone" id="shippingPhone">
                     <div id="shippingPhone-error" class="text-danger"></div>
                   </div>

                   <div class="mb-3">
                     <label for="shippingCountry" class="form-label">Country</label>
                     <select class="form-select" name="checkout_shipping_country" id="shippingCountry">
                       <option value="">Choose...</option>
                       <option>Pakistan</option>
                       <option>India</option>
                       <option>USA</option>
                     </select>
                     <div id="shippingCountry-error" class="text-danger"></div>
                   </div>

                   <div class="mb-3">
                     <label for="shippingCity" class="form-label">City</label>
                     <select class="form-select" id="shippingCity" name="checkout_shipping_city">
                       <option value="">Choose...</option>
                       <option>Karachi</option>
                       <option>Lahore</option>
                       <option>Islamabad</option>
                     </select>
                     <div id="shippingCity-error" class="text-danger"></div>
                   </div>
                 </div>

                 <button class="btn btn-primary w-100 btn-lg mt-3" type="submit">Save</button>
               </form>
             </div>
           </div>
         </div>
       <?php endif; ?>


       <!-- </div>  -->

       <div class="col-12 col-lg-4">
         <div class="summary-section">

           <div class="card shadow-sm rounded-4 p-3 mb-3">
             <h4 class="mb-3">Order Summary</h4>

             <div class="d-flex justify-content-between mb-2">
               <span class="text-muted">Subtotal</span>
               <span class="fw-bold cart-subtotal">$ <?= $subtotal_VAL ?></span>

             </div>

             <div class="d-flex justify-content-between mb-2">
               <span class="text-muted">Delivery</span>
               <span class="fw-bold text-success">Free</span>
             </div>

             <hr>

             <div class="d-flex justify-content-between mb-3">
               <span class="fw-bold">Total (VAT included)</span>
               <span class="fw-bold text-dark cart-subtotal">$ <?= $subtotal_VAL ?></span>

             </div>
             <?php if (empty($_SESSION['cart']) || $hasAddress === false): ?>
               <a class="btn btn-primary disabled text-white w-100 fw-bold py-2" href="#">Proceed to Pay</a>
             <?php else: ?>
               <a class="btn btn-primary text-white w-100 fw-bold py-2" href="./Payment.php">Proceed to Pay</a>
             <?php endif; ?>



           </div>

          

         </div>
       </div>

     </div> <!-- End .row -->
   </div> <!-- End .container -->

   <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-md">
       <div class="modal-content">
         <div class="modal-header border-0">
           <h5 class="modal-title" id="deliveryModalLabel">Delivery Address</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <?php
          $sql_form = "
SELECT u.name, u.id as user_id, u.role, u.status, u.email, u.created_at,
a.phone, a.city, a.country, a.full_name, a.address_line1 as address, a.type, u.user_profile
FROM users u
INNER JOIN addresses a ON u.id = a.user_id
WHERE u.id = $user_id
";

          $result_form = $conn->query($sql_form);

          $billing = null;
          $shipping = null;

          while ($row = $result_form->fetch_assoc()) {
            if ($row['type'] == 'billing') {
              $billing = $row;
            } elseif ($row['type'] == 'shipping') {
              $shipping = $row;
            }
          }

          if ($billing):
          ?>

           <div class="modal-body pt-0">
             <form id="address-form" novalidate>
               <div class="row g-2">
                 <div class="col-12">
                   <label for="fullName" class="form-label">Full Name</label>
                   <input type="text" value="<?= htmlspecialchars($billing['name']) ?>" class="form-control" name="checkout_name" id="fullName" placeholder="Enter Your Full Name" required>
                   <div id="fullName-error" class="text-danger small"></div>
                 </div>

                 <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>">
                 <input type="hidden" name="update_address" value="update">

                 <div class="col-12">
                   <label for="address" class="form-label">Address</label>
                   <input type="text" value="<?= htmlspecialchars($billing['address']) ?>" class="form-control" name="checkout_address" id="address" placeholder="1234 Main St" required>
                   <div id="address-error" class="text-danger small"></div>
                 </div>

                 <div class="col-12">
                   <label for="phone" class="form-label">Phone</label>
                   <input type="text" value="<?= htmlspecialchars($billing['phone']) ?>" class="form-control" name="checkout_phone" id="phone" placeholder="+92300000000" required>
                   <div id="phone-error" class="text-danger small"></div>
                 </div>

                 <div class="col-md-6">
                   <label for="country" class="form-label">Country</label>
                   <select class="form-select" id="country" name="checkout_country" required>
                     <option disabled value="">Choose...</option>
                     <option value="Pakistan" <?= ($billing['country'] == 'Pakistan') ? 'selected' : '' ?>>Pakistan</option>
                     <option value="United States" <?= ($billing['country'] == 'United States') ? 'selected' : '' ?>>United States</option>
                     <option value="India" <?= ($billing['country'] == 'India') ? 'selected' : '' ?>>India</option>
                     <option value="France" <?= ($billing['country'] == 'France') ? 'selected' : '' ?>>France</option>
                   </select>
                   <div id="country-error" class="text-danger small"></div>
                 </div>

                 <div class="col-md-6">
                   <label for="city" class="form-label">City</label>
                   <select class="form-select" id="city" name="checkout_city" required>
                     <option disabled value="">Choose...</option>
                     <option value="Lahore" <?= ($billing['city'] == 'Lahore') ? 'selected' : '' ?>>Lahore</option>
                     <option value="Karachi" <?= ($billing['city'] == 'Karachi') ? 'selected' : '' ?>>Karachi</option>
                     <option value="Multan" <?= ($billing['city'] == 'Multan') ? 'selected' : '' ?>>Multan</option>
                   </select>
                   <div id="city-error" class="text-danger small"></div>
                 </div>
               </div>

               <hr class="my-3">

               <div class="form-check mb-2">
                 <input type="checkbox" class="form-check-input" id="same-address" name="check_address" value="1">
                 <label class="form-check-label fw-bold small" for="same-address">Shipping address is the same as billing</label>
               </div>

               <div id="shipping-section" class="bg-light p-2 rounded-3 small" style="display:none;">
                 <h6 class="mb-2">Shipping Address</h6>

                 <div class="mb-2">
                   <label for="shippingName" class="form-label">Full Name</label>
                   <input type="text" value="<?= htmlspecialchars($shipping['full_name'] ?? '') ?>" class="form-control" name="checkout_shipping_name" id="shippingName">
                   <div id="shippingName-error" class="text-danger small"></div>
                 </div>

                 <div class="mb-2">
                   <label for="shippingAddress" class="form-label">Address</label>
                   <input type="text" value="<?= htmlspecialchars($shipping['address'] ?? '') ?>" class="form-control" name="checkout_shipping_address" id="shippingAddress">
                   <div id="shippingAddress-error" class="text-danger small"></div>
                 </div>

                 <div class="mb-2">
                   <label for="shippingPhone" class="form-label">Phone</label>
                   <input type="text" value="<?= htmlspecialchars($shipping['phone'] ?? '') ?>" class="form-control" name="checkout_shipping_phone" id="shippingPhone">
                   <div id="shippingPhone-error" class="text-danger small"></div>
                 </div>

                 <div class="col-md-6">
                   <label for="shippingCountry" class="form-label">Country</label>
                   <select class="form-select" id="shippingCountry" name="checkout_shipping_country">
                     <option disabled value="">Choose...</option>
                     <option value="Pakistan" <?= (isset($shipping) && $shipping['country'] == 'Pakistan') ? 'selected' : '' ?>>Pakistan</option>
                     <option value="United States" <?= (isset($shipping) && $shipping['country'] == 'United States') ? 'selected' : '' ?>>United States</option>
                     <option value="India" <?= (isset($shipping) && $shipping['country'] == 'India') ? 'selected' : '' ?>>India</option>
                     <option value="France" <?= (isset($shipping) && $shipping['country'] == 'France') ? 'selected' : '' ?>>France</option>
                   </select>
                   <div id="shippingCountry-error" class="text-danger small"></div>
                 </div>

                 <div class="col-md-6">
                   <label for="shippingCity" class="form-label">City</label>
                   <select class="form-select" id="shippingCity" name="checkout_shipping_city">
                     <option disabled value="">Choose...</option>
                     <option value="Lahore" <?= (isset($shipping) && $shipping['city'] == 'Lahore') ? 'selected' : '' ?>>Lahore</option>
                     <option value="Karachi" <?= (isset($shipping) && $shipping['city'] == 'Karachi') ? 'selected' : '' ?>>Karachi</option>
                     <option value="Multan" <?= (isset($shipping) && $shipping['city'] == 'Multan') ? 'selected' : '' ?>>Multan</option>
                   </select>
                   <div id="shippingCity-error" class="text-danger small"></div>
                 </div>
               </div>

               <button class="btn btn-primary w-100 btn-sm mt-3" type="submit">Save</button>
             </form>
           </div>

         <?php endif; ?>

       </div>
     </div>
   </div>

 </div>

 <?php include("./includes/mobile-icon.php") ?>

 <script src="./Assets/JS/checkout.js"></script>
 <script src="./Assets/JS/cart.js"></script>


 <script>
   document.addEventListener("DOMContentLoaded", function() {
     document.getElementById("skeleton-loader").style.display = "block";
     document.getElementById("main-content").style.display = "none";
   });

   window.onload = function() {
     setTimeout(function() { // simulate loading
       document.getElementById("skeleton-loader").style.display = "none";
       document.getElementById("main-content").style.display = "block";
     }, 800); 
   };

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
            
           document.querySelectorAll(".cart-subtotal").forEach(el => {
             el.textContent = "$ " + data.subtotal;
           });
         }
       });
   }
   document.getElementById('same-address').addEventListener('change', function() {
     document.getElementById('shipping-section').style.display = this.checked ? 'block' : 'none';
   });
 </script>
 <?php include './Components/footer.html';  ?>