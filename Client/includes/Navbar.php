 <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  include("../Server/Admin-Panel/config/db.php");
  include $_SERVER['DOCUMENT_ROOT'] . '/Ecoverse/Client/Components/header.html';

  $is_logged_in = isset($_SESSION['user_id']);
  $username = "";
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $user_id ";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
      $username = $row['name'];
      $email = $row['email'];
      $profile = $row['user_profile'];
    }
  }
  //   echo '<pre>';
  // print_r($_SESSION['user']);
  // echo '</pre>';

  ?>
  <style>
    
  </style>

 <link rel="stylesheet" href="./Assets/CSS/navbar.css">

 <!-- DESKTOP & TABLET NAV -->
 <nav class="navbar navbar-expand-lg bg-white border-bottom pt-2  ">
   <div class="container-fluid mx-2 navbar_des  ">

     <!-- Logo -->
     <a class="navbar-brand d-flex align-items-start fs-4" href="./index.php">
       <strong class="mb-2"><img class="" height="32px" src="./Assets/Images/shopping_cart_37dp_1F1F1F_FILL0_wght400_GRAD0_opsz40.svg" alt=""><span class="fw-bold">Ecoverse</span></strong>
     </a>

     <!-- Search -->
     <form autocomplete="off" class="d-flex flex-grow-1 mx-4 position-relative " role="search" id="searchForm">
       <div class="input-group flex-grow-1">
         <input
           class="form-control search-box searchInput"
           type="search"
           placeholder="What can we help you find today?"
           oninput="searchFunc(this.value)" />
         <button id="search-btn" class="btn btn-primary " type="submit">
           <i class="bi bi-search"></i>
         </button>
       </div>

       <!-- Card positioned absolutely -->
       <div
         class="card position-absolute start-0 w-100  d-none"
         style="top: 100%; z-index: 1000;"
         id="resultCard">
         <div class="card " id='output'>
         </div>
       </div>
     </form>





     <!-- Icons -->
     <div id='icons_navbar' class="d-flex align-items-center gap-2">
       <!-- <a href="#"
         class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center position-relative"
         style="width: 40px; height: 40px;">
         <i class="	bi bi-heart-fill"></i>
       </a> -->

       <!-- Cart -->
       <a onclick="checkauth('cart')"
         class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center position-relative"
         style="width: 40px; height: 40px;">
         <i class="fas fa-cart-shopping"></i>

         <!-- Circular Badge -->
         <span
           class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle d-flex align-items-center justify-content-center " id='cartCount'
           style="width: 18px; height: 18px; font-size: 0.65rem;">
           <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>

         </span>
       </a>




       <!-- Account Dropdown -->
       <div class="dropdown drop">
         <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
           <img src="<?= empty($profile) ? './Assets/Images/user.png' : '../Server/uploads/' . $profile ?>" width="40" height="40" class="rounded-circle me-1">
           My Account
         </a>

         <?php if (isset($_SESSION['user_id'])): ?>
           <div class="dropdown-menu dropdown-menu-end p-3 drop" style="width: 250px; z-index: 1100; overflow: hidden">
             <div class="text-center mb-2">
               <img src="<?= empty($profile) ? './Assets/Images/user.png' : '../Server/uploads/' . $profile ?>" width="50" height="50" class="rounded-circle mb-2">

               <div><strong><?= htmlspecialchars($username) ?></strong></div>
               <small class="text-muted d-block text-truncate"><?= htmlspecialchars($row['email']) ?></small>
               <a href="./homeprofile.php" class="btn btn-outline-primary btn-sm w-100 mt-2">View Profile</a>
             </div>
             <hr>
             <a class="dropdown-item" href="./homeprofile.php"><i class="bi bi-person me-2"></i> My Account</a>

             <a class="dropdown-item" href="./Profile.php"><i class="bi bi-bag-check me-2"></i> My Orders</a>
             <hr>
             <a class="dropdown-item text-danger" href="./logout.php"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a>
           </div>

         <?php else: ?>
           <ul class="dropdown-menu dropdown-menu-end shadow-sm drop">
             <li><a class="dropdown-item cursor-pointer " onclick="showAuthModal('login')"><i class="bi bi-box-arrow-in-right me-2"></i> Login</a></li>
             <li><a class="dropdown-item cursor-pointer " onclick="showAuthModal('signup')"><i class="bi bi-pencil-square me-2"></i> Register</a></li>

           </ul>
         <?php endif; ?>
       </div>

     </div>
   </div>

 </nav>

 <!-- DESKTOP NAV LINKS -->
 <nav class="navbar2 bg-white border-bottom py-2  navbar_desktop ">
   <div class="container-fluid mx-2 d-flex justify-content-between">
     <div class="d-flex gap-4 flex-wrap">
       <?php
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
        ?>
         <div class="dropdown">
           <a href="#" class="nav-link" data-bs-toggle="dropdown">
             <?= htmlspecialchars($row['name']) ?>
           </a>

           <ul class="dropdown-menu">
             <?php
              $cat_id = $row['id'];
              $sub_sql = "SELECT * FROM subcategories WHERE category_id = $cat_id";
              $sub_result = $conn->query($sub_sql);

              if ($sub_result->num_rows > 0) {
                while ($sub_row = $sub_result->fetch_assoc()) {
                  $subcat_id = $sub_row['id'];
              ?>
                 <li>
                   <a class="dropdown-item" href="./products.php?subcategory_id=<?= $subcat_id ?>">
                     <?= htmlspecialchars($sub_row['name']) ?>
                   </a>
                 </li>
             <?php
                }
              } else {
                echo "<li><span class='dropdown-item text-muted'>No subcategories</span></li>";
              }
              ?>
           </ul>
         </div>
       <?php
        }
        ?>
           <!-- <a href="./test.php" class="btn btn-primary">Inspire</a> -->

     </div>
   </div>
 </nav>


 <!-- MOBILE SEARCH & MENU -->

 <?php include 'AuthModal.php'; ?>


 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
 <script>
   const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
 </script>
 <script src="./Assets/JS/auth.js"></script>
 <script src="./Assets/JS/cart.js"></script>
 <script src="./Assets/JS/search.js"></script>
 <script src="./Assets/JS/search2.js"></script>




 <?php include $_SERVER['DOCUMENT_ROOT'] . '/Ecoverse/Client/Components/footer.html';; ?>