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
include("../Server/Admin-Panel/config/db.php");

$user_id = $_SESSION['user_id'];
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

<style>
  body {
    background: #f5f6f8;
    font-weight: 500;
  }

  .sidebar {
    min-height: 100vh;
    background: white;
    border-right: 1px solid #ddd;
  }

  .sidebar a {
    padding: 8px 16px;
    display: block;
    color: #333;
    text-decoration: none;
    font-size: 14px;
  }

  .sidebar a.active {
    background-color: #e7f1ff;
    font-weight: 600;
  }

  @media (max-width: 767.98px) {
    .sidebar {
      position: fixed;
      top: 103px;
      /* height of navbar */
      left: -250px;
      width: 250px;
      height: calc(100vh - 56px);
      z-index: 1050;
      transition: left 0.3s ease;
    }

    .sidebar.show {
      left: 0;
    }
  }
</style>

<div class="container-fluid mx-2   ">
  <div class="row ">
    <?php
    // Sidebar User Info
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
    ?>
      <!-- Sidebar -->
      <div id="sidebar" class="col-12 col-md-3 col-lg-2 sidebar p-0  ">
        <div class="p-3">

          <!-- Title and Close button -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0">Your Account</h6>
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="toggleSidebar()">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <small class="text-muted d-block mb-3">
            <?= htmlspecialchars($row['name']) ?>
          </small>

          <a href="./homeprofile.php" id="Home">My Profile</a>
          <a href="./Profile.php" id="myorders">My Orders</a>
          <hr />
          <a href="./customer_support.php" class="active">Customer Support</a>
          <a href="./logout.php">Log Out</a>

        </div>
      </div>


    <?php
    }
    ?>

    <!-- Main Content -->
    <div class="col-12 col-md-9 col-lg-10 p-3 ">
      <!-- Toggle Button for mobile -->
        <div class="d-flex justify-content-between align-items-center mb-3 ">
        <h4 class="mb-0 mt-md-4">Customer Support</h4>
       <button class="btn btn-outline-primary d-md-none mx-2 mt-2" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i> Menu
      </button>
      </div>
      

      <div class="bg-white p-3 rounded-4 shadow-sm">
     

        <form class="d-flex mb-4 flex-wrap gap-2">
          <input class="form-control me-2" type="search" placeholder="Search help topics..." style="flex:1; min-width:200px;" />
          <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <div class="row g-3 mb-4">
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                <h6>Call Us</h6>
                <p class="small">+1 800 123 4567</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                <h6>Email Us</h6>
                <p class="small">support@example.com</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body text-center">
                <i class="fas fa-comments fa-2x text-primary mb-2"></i>
                <h6>Live Chat</h6>
                <button class="btn btn-outline-primary btn-sm mt-2">Start Chat</button>
              </div>
            </div>
          </div>
        </div>

        <h6 class="mt-4">Frequently Asked Questions</h6>
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                How do I reset my password?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body small">
                Click on "Forgot password" on the login page and follow the instructions.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                Where can I track my order?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body small">
                Go to the "My Orders" section in your account to track your order.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                How do I contact support?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body small">
                You can reach us via phone, email, or live chat listed above.
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<?php include("./includes/mobile-icon.php") ?>
<?php include 'Components/footer2.html'; ?>
<?php include './Components/footer.html'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
  }
</script>