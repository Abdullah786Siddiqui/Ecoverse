<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../../vendor/autoload.php';
$validity_email = $_GET['email'] ?? '';
$validity_password = $_GET['password'] ?? '';
$client = new Google_Client();
$client->setClientId('5919550015-mstm7brgo6o71m4g1th23g2ohebr47qp.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Ecomerse-Website/Server/Process/Google-auth.php');
$client->addScope("email");
$client->addScope("profile");

$login_url = $client->createAuthUrl();

?>
<div class="modal fade custom-fade" id="authModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="authModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm rounded-4 overflow-hidden">
      <div class="modal-header bg-white border-bottom py-3 px-4">
        <h5 class="modal-title fw-semibold text-secondary" id="authModalTitle">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body  px-4 py-4">

        <!-- Login Form -->

        <form id="loginForm" class="auth-form">
          <div class="mb-3">
            <label class="form-label text-muted small">Email</label>
            <input type="email" name="login_email" id="login_email" class="form-control" placeholder="Enter your Email">
            <div id="emailError" class="error text-danger mt-1"></div>

          </div>

          <div class="mb-3">
            <label class="form-label text-muted small">Password</label>
            <input type="password" name="login_password" id="login_password" class="form-control" placeholder="Enter your password">
            <div id="passwordError" class="error text-danger mt-1"></div>
            <p class="text-end my-3 text-primary">foget password?</p>
          </div>

          <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-2">Login</button>
          <a href="<?= htmlspecialchars($login_url) ?>" type="button" class="btn btn-light w-100 mb-2 border d-flex align-items-center justify-content-center gap-3 shadow-sm">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20" height="20">
            <span class="fw-bold"> Continue with Google</span>
          </a>
          <p class="text-center mt-3 small text-muted">
            Don't have an account?
            <a href="#" onclick="showSignup()" class="text-decoration-none">Signup</a>
          </p>
        </form>


        <!-- Signup Form -->
        <!-- Signup form -->
        <form id="signupForm" method="post" class="auth-form d-none">

          <div id="signup-section">
            <div class="mb-3">
              <label class="form-label text-muted small">Name</label>
              <input type="text" name="register_username" id="register_username" class="form-control" placeholder="Your full name">
              <div class="text-danger " id='nameError_register'></div>

            </div>
            <div class="mb-3">
              <label class="form-label text-muted small">Email</label>
              <input type="email" name="register_email" id="register_email" class="form-control" placeholder="you@example.com">
              <div class="text-danger " id='emailError_register'></div>
            </div>
            <div class="mb-3">
              <label class="form-label text-muted small">Password</label>
              <input type="password" name="register_password" id="register_password" class="form-control" placeholder="Enter password">
              <div class="text-danger " id='passwordError_register'></div>

            </div>


            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 mb-2">Signup</button>
            <a href="<?= htmlspecialchars($login_url) ?>" type="button" class="btn btn-light w-100 mb-2 border d-flex align-items-center justify-content-center gap-3 shadow-sm">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20" height="20">
            <span class="fw-bold"> Continue with Google</span>
          </a>
            <p class="text-center mt-3 small text-muted">
              Already have an account?
              <a href="#" onclick="showLogin()" class="text-decoration-none">Login</a>
            </p>

          </div>


        </form>

        <!-- OTP verification section -->
        <div id="otp-section" class="auth-form d-none mt-3">
          <div class="mb-3">
            <label class="form-label text-muted small">Enter OTP sent to your email</label>
            <input type="text" name="otp" class="form-control" placeholder="6-digit OTP" required>
            <div id="otperror" class="error text-danger mt-1"></div>
          </div>

          <button type="button" id="verifyOtpBtn" class="btn btn-primary w-100 fw-semibold py-2">Verify OTP</button>
        </div>






      </div>
    </div>
  </div>
</div>