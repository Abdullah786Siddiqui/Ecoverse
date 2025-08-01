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
<style>
  .promo-tile {
    position: relative;
    color: #000;
    border-radius: 10px;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 1.5rem;
    min-height: 200px;
  }

  .promo-tile::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(231, 224, 224, 0.5);
    backdrop-filter: blur(1px);
  }

  .promo-content {
    position: relative;
    z-index: 2;
  }

  .promo-tile h5,
  .promo-tile h6 {
    font-weight: bold;
  }

  .text-sm {
    font-size: 0.875rem;
    color: #333;
  }

  .cta {
    color: #e63946;
    font-weight: 600;
    font-size: 0.875rem;
  }

  @media (max-width: 576px) {
    .promo-tile {
      min-height: 150px;
      padding: 1rem;
    }
  }
</style>
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


  .profile-picture-wrapper .camera-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    background: #fff;
    color: #333;
    border-radius: 50%;
    padding: 6px;
    font-size: 16px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: 0.2s;
  }

  .profile-picture-wrapper .camera-icon:hover {
    background: #f0f0f0;
  }

  @media (max-width: 375px) {
    #sidebar_mob {
      display: none !important;

    }
  }

  @media (max-width: 767.98px) {
    .sidebar {
      position: fixed;
      top: 102px;
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

<div class="container-fluid ">
  <div class="row">
    <?php
    // Sidebar User Info
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
    ?>
      <!-- Sidebar -->
      <!-- Sidebar -->
      <div id="sidebar1" class="col-12 col-md-3 col-lg-2 sidebar p-0 ">
        <div class="p-3">

          <!-- Title and Close button -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0">Your Account</h6>
            <button class="btn btn-sm btn-outline-secondary d-md-none">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <small class="text-muted d-block mb-3">
            <?= htmlspecialchars($row['name']) ?>
          </small>

          <a href="./homeprofile.php" id="Home" class="active">My Profile</a>
          <a href="./Profile.php" id="myorders">My Orders</a>
          <hr />
          <a href="./customer_support.php">Customer Support</a>
          <a href="./logout.php">Log Out</a>

        </div>
      </div>
    <?php
    }
    ?>

    <div class="col-md-9 col-lg-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Profile</h4>
        <button class="btn btn-outline-primary d-md-none" id="togglesidebar">
          <i class="fas fa-bars"></i> Menu
        </button>
      </div>

      <div class="card shadow-lg border-0 rounded-4 mt-4 p-4 bg-white">
        <?php
        $sql = "SELECT users.name, users.gender , users.password as pass , users.id AS user_id, users.role, users.status, users.email, users.created_at,
        users.phone, addresses.city, addresses.country, addresses.address_line1 AS address, users.user_profile as user_profile
        FROM users
        LEFT JOIN addresses ON users.id = addresses.user_id
        WHERE users.id = $user_id";

        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
        ?>
          <div class="card-body">
            <div class="d-flex flex-column flex-sm-row align-items-center text-center text-sm-start gap-4 mb-4">
              <div>

                <form method="POST" enctype="multipart/form-data" id="profileForm">
                  <div class="profile-picture-wrapper" style="position: relative; width: 120px; height: 120px;">
                    <img
                      src="<?= empty($row['user_profile']) ? './Assets/Images/user.png' : '../Server/uploads/' . $row['user_profile'] ?>"
                      alt="User Avatar"
                      class="rounded-circle img-fluid shadow"
                      style="width: 120px; height: 120px; object-fit: cover;"
                      id="profile-preview">
                    <input
                      type="file"
                      name="image"
                      id="profile-image-home"
                      accept="image/*"
                      style="display: none;">

                    <label for="profile-image-home" class="camera-icon  btn"
                      style="position: absolute; bottom: 0; right: 0; background: #fff; border-radius: 50%; cursor: pointer; padding: 5px;">
                      <i class="ri-camera-fill"></i>
                    </label>
                  </div>
                </form>

              </div>
              <div>
                <h4 class="fw-bold mb-0"><?= htmlspecialchars($row['name']) ?></h4>
                <p class="text-secondary small mb-1"><?= htmlspecialchars($row['email']) ?></p>

              </div>
            </div>

            <hr class="my-4">
            <!-- change password -->
            <div class="d-flex justify-content-center">
              <div id="change_password_div" class="col-12 col-md-6 d-none">
                <div class="p-3 border rounded-3 h-100">
                  <form method="post" id="change_password_form">
                    <label class="text-muted fw-semibold mb-2">
                      <i class="bi bi-key me-1"></i> Change Password
                    </label>

                    <input
                      type="password"
                      name="current_password"
                      class="form-control mb-2"
                      placeholder="Current Password">

                    <input
                      type="password"
                      name="new_password"
                      class="form-control mb-2"
                      placeholder="New Password">

                    <input
                      type="password"
                      name="confirm_password"
                      class="form-control mb-1  "
                      placeholder="Confirm New Password">
                    <p id="error_pc" class="text-danger text-center"></p>

                    <button type="submit" class="btn btn-primary w-100 mb-2">
                      <i class="bi bi-shield-lock"></i> Change Password
                    </button>
                    <!-- <button type="button" class="btn btn-light w-100 mb-2 border d-flex align-items-center justify-content-center gap-3 shadow-sm">
                      <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20" height="20">
                      <span class="fw-bold"> Continue with Google</span>
                    </button> -->

                    <!-- Continue with Email -->
                    <button id="continueToEmai" type="button" class="btn btn-light w-100 mb-2 border d-flex align-items-center justify-content-center gap-3 shadow-sm">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555z" />
                        <path d="M0 4.697v7.104l5.803-3.804L0 4.697zM6.761 8.83l-6.761 4.43A2 2 0 0 0 2 14h12a2 2 0 0 0 1.999-0.74l-6.76-4.43L8 9.586l-1.239-.756zM16 4.697l-5.803 3.603L16 11.801V4.697z" />
                      </svg>
                      <span class="fw-bold">Continue with Email</span>
                    </button>

                  </form>

                </div>
              </div>

            </div>
            <!-- chnage password with token email -->
            <div class="d-flex justify-content-center">
              <div id="change_password_div_email" class="col-12 col-md-6 d-none">
                <div class="p-3 border rounded-3 h-100">
                  <form method="post" id="change_password_form_token">
                    <label class="text-muted fw-semibold mb-2">
                      <i class="bi bi-key me-1"></i> Change Password
                    </label>



                    <input
                      type="password"
                      name="new_password_token"
                      class="form-control mb-2"
                      placeholder="New Password">

                    <input
                      type="password"
                      name="confirm_password_token"
                      class="form-control mb-1  "
                      placeholder="Confirm New Password">
                    <p id="error_pc_token" class="text-danger text-center"></p>



                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Change password</button>

                  </form>

                </div>
              </div>

            </div>
            <!-- user information  -->
            <div class="row g-4  " id='user_information'>

              <!-- Address -->
              <div class="col-12 col-md-4">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-person me-1"></i> Name
                  </h6>
                  <p class="mb-0 <?= empty($row['name']) ? 'text-muted fst-italic' : 'text-black' ?>">
                    <?= empty($row['name']) ? 'No name provided' : htmlspecialchars($row['name']) ?>
                  </p>
                </div>
              </div>

              <!-- Email -->
              <div class="col-12 col-md-4">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-envelope me-1"></i> Email
                  </h6>
                  <p class="mb-0 <?= empty($row['email']) ? 'text-muted fst-italic' : 'text-black' ?>">
                    <?= empty($row['email']) ? 'No email provided' : htmlspecialchars($row['email']) ?>
                  </p>
                </div>
              </div>




              <!-- Phone -->
              <div class="col-12 col-md-4">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-telephone me-1"></i> Phone
                  </h6>
                  <p class="mb-0 <?= empty($row['phone']) ? 'text-muted fst-italic' : 'text-black' ?>">
                    <?= empty($row['phone']) ? 'No phone number provided' : htmlspecialchars($row['phone']) ?>
                  </p>
                </div>
              </div>

              <!-- Gender -->
              <div class="col-12 col-md-4">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-gender-ambiguous me-1"></i> Gender
                  </h6>
                  <p class="mb-0 <?= empty($row['gender']) ? 'text-muted fst-italic' : 'text-black' ?>">
                    <?= empty($row['gender']) ? 'Not specified' : htmlspecialchars(ucfirst($row['gender'])) ?>
                  </p>
                </div>
              </div>
              <div id="change_password" class="col-12 col-md-4 cursor-pointer">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-key me-1"></i> Change Password
                  </h6>
                  <p class="mb-0 text-black fst-italic">

                    *********
                  </p>
                </div>
              </div>


              <!-- Member Since -->
              <div class="col-12 col-md-4">
                <div class="p-3 border rounded-3 h-100">
                  <h6 class="text-muted fw-semibold mb-2">
                    <i class="bi bi-calendar me-1"></i> Member Since
                  </h6>
                  <p class="mb-0 text-black">
                    <?= htmlspecialchars(date('M d, Y', strtotime($row['created_at']))) ?>
                  </p>
                </div>
              </div>

            </div>

            <!-- user information edit -->

            <div class="d-none" id="user_information_edit">
              <form method="post" id="profile_form">
                <div class="row g-4">

                  <!-- Address -->
                  <div class="col-12 col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                      <label class="text-muted fw-semibold mb-2">
                        <i class="bi bi-geo-alt me-1"></i> Name
                      </label>
                      <textarea
                        name="name"
                        class="form-control <?= empty($row['name']) ? 'text-muted' : 'text-black' ?>"
                        rows="2"
                        placeholder="Enter your name"><?= htmlspecialchars($row['name'] ?? '') ?></textarea>

                    </div>
                  </div>
                  <!-- Email -->
                  <div class="col-12 col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                      <label class="text-muted fw-semibold mb-2">
                        <i class="bi bi-envelope me-1"></i> Email
                      </label>
                      <input
                        type="email"
                        name="email"
                        class="form-control <?= empty($row['email']) ? 'text-muted' : 'text-black' ?>"
                        placeholder="Enter your email"
                        value="<?= htmlspecialchars($row['email'] ?? '') ?>">
                    </div>
                  </div>


                  <!-- Phone -->
                  <div class="col-12 col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                      <label class="text-muted fw-semibold mb-2">
                        <i class="bi bi-telephone me-1"></i> Phone
                      </label>
                      <input
                        type="text"
                        name="phone"
                        class="form-control <?= empty($row['phone']) ? 'text-muted' : 'text-black' ?>"
                        placeholder="Enter your phone number"
                        value="<?= htmlspecialchars($row['phone'] ?? '') ?>">
                    </div>
                  </div>

                  <!-- Gender -->
                  <div class="col-12 col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                      <label class="text-muted fw-semibold mb-2">
                        <i class="bi bi-gender-ambiguous me-1"></i> Gender
                      </label>
                      <select name="gender" class="form-select <?= empty($row['gender']) ? 'text-muted' : 'text-black' ?>">
                        <option value="">Select gender</option>
                        <option value="male" <?= ($row['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= ($row['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= ($row['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                      </select>
                    </div>
                  </div>





                  <!-- Save Button -->
                  <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                      <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                  </div>

                </div>
              </form>
            </div>

            <hr class="my-4">




          </div>

          <div class="text-center text-md-end mt-4">
            <a id="editbtn" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm me-2">Edit Profile</a>



          </div>
      </div>

    <?php
        } else {
          echo '<div class="card-body text-center text-muted">User data not found.</div>';
        }
    ?>
    </div>

  </div>
</div>
<?php include("./includes/mobile-icon.php") ?>
<script >
  
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("togglesidebar").addEventListener("click", function() {
      const sidebar = document.getElementById('sidebar1');
      sidebar.classList.toggle('show');

    })
    document.getElementById('editbtn').addEventListener("click", function() {
      document.getElementById('user_information').classList.add('d-none');
      document.getElementById('user_information_edit').classList.remove('d-none');
      document.getElementById('editbtn').classList.add('d-none');

    })


    function cancelEdit() {
      document.getElementById('user_information_edit').classList.add('d-none');
      document.getElementById('user_information').classList.remove('d-none');
    }

    const form = document.getElementById('profile_form');
    form.addEventListener('submit', function(e) {
      e.preventDefault(); 

      const formData = new FormData(form);

      fetch("../Server/Process/edit_profile.php", {
          method: "POST",
          body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
                icon: "success",
                title: "<h3 style='font-weight:500'>Profile Updated!</h3>",
                text: "Your changes have been saved.",
                timer: 1000,
                showConfirmButton: false,
                width: 320,
                padding: "1rem",
                background: "#f0f9f5",
                color: "#274c3a",
                customClass: {
                  popup: "swal2-popup-compact"
                },
                timerProgressBar: true
              })
              .then(() => {
                window.location.reload();
              })

          } else {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: "Something went wrong, please try again!",
              confirmButtonColor: "#d33",
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Something went wrong, please try again!",
            confirmButtonColor: "#d33",
          });
        });
    });
    const form1 = document.getElementById("profileForm");
    const fileInput = document.getElementById("profile-image-home");

    fileInput.addEventListener("change", function() {
      const formData = new FormData(form1);

      fetch('../Server/Process/profile_image.php', {
          method: "POST",
          body: formData
        })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            window.location.reload()
          } else {
            Swal.fire({
              icon: "error",
              text: "Failed to update image"
            });
          }
        });
    });
    let changePasword = document.getElementById("change_password").addEventListener("click", function() {
      document.getElementById('user_information').classList.add('d-none');
      document.getElementById('change_password_div').classList.remove('d-none');
      document.getElementById('editbtn').classList.add('d-none');

    })
    let changePaswordForm = document.getElementById("change_password_form")
    changePaswordForm.addEventListener("submit", function(e) {
      e.preventDefault();
      let changeformData = new FormData(changePaswordForm);
      fetch("../Server/Process/change_password.php", {
          method: "POST",
          body: changeformData,
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            Swal.fire({
                icon: "success",
                title: "<h3 style='font-weight:500'>Password Changed!</h3>",
                text: "Your password has been updated successfully.",
                timer: 1500,
                showConfirmButton: false,
                width: 320,
                padding: "1rem",
                background: "#f0f9f5",
                color: "#274c3a",
                customClass: {
                  popup: "swal2-popup-compact"
                },
                timerProgressBar: true
              })

              .then(() => {
                window.location.reload();
              })

          } else {
            document.getElementById("error_pc").innerText = data.message
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Something went wrong catch, please try again!",
            confirmButtonColor: "#d33",
          });
        });
    })


    let continueEmail = document.getElementById("continueToEmai")
    continueEmail.addEventListener("click", function() {
      Swal.fire({
        title: "Sending Email...",
        html: "Please wait while we send you a verification link.",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      fetch("../Server/Process/pc_phpmailer.php", {
          method: "POST",
        })
        .then((res) => res.json())
        .then((data) => {
          if (data.status === "success") {

            Swal.fire({
              iconHtml: `
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#0d6efd" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.708 2.825L15 12V5.383zM1 5.383V12l4.708-2.792L1 5.383zM6.761 9.13L1.528 13H14.47l-5.233-3.87L8 9.944 6.761 9.13z"/>
          </svg>
        `,
              title: "Check Your Email",
              html: `
          <p style="margin:0; font-size: 14px; color:#555">
            We sent a verification link to your email.<br>
            Please open your inbox and follow the link to continue.
          </p>
        `,
              showConfirmButton: true,
              confirmButtonText: "OK",
              width: 350,
              padding: "1.2rem",
              background: "#fff",
              color: "#333",
              customClass: {
                popup: "swal2-popup-compact"
              }
            });

          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.message,
            });
          }
        });

    })


    const success = "<?php echo $_GET['success'] ?? ''; ?>";
    if (success === 'true') {
      const userInfo = document.getElementById('user_information');
      if (userInfo) userInfo.classList.add('d-none');
      document.getElementById('change_password_div_email').classList.remove('d-none');
      document.getElementById('editbtn').classList.add('d-none');

      changePaswordtoken = document.getElementById("change_password_form_token")
      changePaswordtoken.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData3 = new FormData(changePaswordtoken);
        fetch("../Server/Process/verify_token_password.php", {
            method: "POST",
            body: formData3
          })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              Swal.fire({
                  icon: "success",
                  title: "<h3 style='font-weight:500'>Password Changed!</h3>",
                  text: "Your password has been updated successfully.",
                  timer: 1500,
                  showConfirmButton: false,
                  width: 320,
                  padding: "1rem",
                  background: "#f0f9f5",
                  color: "#274c3a",
                  customClass: {
                    popup: "swal2-popup-compact"
                  },
                  timerProgressBar: true
                })

                .then(() => {
                  window.location.href = 'http://localhost/Ecoverse/Client/homeprofile.php'
                })
            } else {
              document.getElementById("error_pc_token").innerText = data.message
            }
          })

      })

    }

  });

</script>


<?php include 'Components/footer2.html'; ?>
<?php include './Components/footer.html'; ?>