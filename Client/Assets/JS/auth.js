function checkauth() {
  if (isLoggedIn) {
    window.location.href = "./view-cart.php";
  } else {
    sessionStorage.setItem("postLoginAction", "./view-cart.php");
    showLoginModal();
  }
}

function showLoginModal() {
  const modal = new bootstrap.Modal(document.getElementById("authModal"));
  modal.show();
}

function showSignup() {
  document.getElementById("authModalTitle").innerText = "Signup";
  document.getElementById("loginForm").classList.add("d-none");
  document.getElementById("signupForm").classList.remove("d-none");
}

function showLogin() {
  document.getElementById("authModalTitle").innerText = "Login";
  document.getElementById("signupForm").classList.add("d-none");
  document.getElementById("loginForm").classList.remove("d-none");
}

function showAuthModal(type) {
  const modal = new bootstrap.Modal(document.getElementById("authModal"));
  modal.show();
  if (type === "signup") {
    document.getElementById("authModalTitle").innerText = "Signup";
    document.getElementById("loginForm").classList.add("d-none");
    document.getElementById("signupForm").classList.remove("d-none");
  } else {
    document.getElementById("authModalTitle").innerText = "Login";
    document.getElementById("signupForm").classList.add("d-none");
    document.getElementById("loginForm").classList.remove("d-none");
  }
}

const form = document.getElementById("signupForm");
form.addEventListener("submit", function (e) {
  e.preventDefault();

  const nameInput = document.getElementById("register_username");
  const emailInput = document.getElementById("register_email");
  const passwordInput = document.getElementById("register_password");

  const nameError = document.getElementById("nameError_register");
  const emailError = document.getElementById("emailError_register");
  const passwordError = document.getElementById("passwordError_register");

  // Clear previous errors
  nameError.textContent = "";
  emailError.textContent = "";
  passwordError.textContent = "";

  let hasError = false;

  // Validation
  if (nameInput.value.trim() === "") {
    nameError.textContent = "Name is required.";
    hasError = true;
  }

  if (emailInput.value.trim() === "") {
    emailError.textContent = "Email is required.";
    hasError = true;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
    emailError.textContent = "Invalid email format.";
    hasError = true;
  }

  if (passwordInput.value.trim() === "") {
    passwordError.textContent = "Password is required.";
    hasError = true;
  }

  // Only show Swal if there are NO errors


  if (!hasError) {
    Swal.fire({
      title: "Creating your account...",
      html: `<p style="margin: 0; font-size: 0.9rem;">Sending OTP to your email...</p>`,
      allowOutsideClick: false,
      showConfirmButton: false,
      background: "#f0f9ff",
      color: "#1e8a35ff",
      width: "25rem",
      didOpen: () => {
        Swal.showLoading();
        const popup = Swal.getPopup();
        popup.style.borderRadius = "0.75rem";
        popup.style.boxShadow = "0 4px 12px rgba(0,0,0,0.1)";
        popup.style.padding = "1.2rem";
      },
    });
  }

  const formData = new FormData(form);

  fetch("../Server/Process/register-process.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((response) => {
      Swal.close();

      if (response.success) {
        document.getElementById("signup-section").classList.add("d-none");
        document.getElementById("otp-section").classList.remove("d-none");
      } else {
        if (response.error === "email") {
          emailError.textContent = "This email already exists";
        }
      }
    })
    .catch(() => {
      Swal.close();
      alert("Something went wrong. Try again.");
    });
});

// Verify OTP
document.getElementById("verifyOtpBtn").addEventListener("click", function () {
  const otp = document.querySelector('input[name="otp"]').value;
  document.getElementById("otperror").textContent = "";

  fetch("../Server/Process/verify-otp.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `otp=${otp}`,
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.success) {
        Swal.fire({
          icon: "success",
          title: `<span style="
      font-size: 1.2rem;
      font-weight: 600;
      color: #2f855a;
  ">Register Successfuliy!</span>`,
          html: `
    <p style="
      color: #4a5568; 
      font-size: 0.85rem; 
      margin: 0;
    ">Welcome to Ecoverse!</p>
  `,
          position: "center",
          showConfirmButton: false,
          timer: 1000,
          timerProgressBar: true,
          background: "#f0fff4",
          color: "#2f855a",
          width: "22rem",
          customClass: {
            popup: "small-swal-popup",
          },
          didOpen: () => {
            const popup = Swal.getPopup();
            popup.style.borderRadius = "0.75rem";
            popup.style.boxShadow = "0 4px 12px rgba(0,0,0,0.1)";
            popup.style.padding = "1rem";
          },
        }).then(() => {
          document.getElementById("otp-section").classList.remove("d-none");
          window.location.reload();
        });
      } else {
        document.getElementById("otperror").textContent = "Invalid OTP";
      }
    })
    .catch(() => {
      alert("Something went wrong verifying OTP.");
    });
});

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const emailInput = document.getElementById("login_email");
    const passwordInput = document.getElementById("login_password");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // clear previous errors
    emailError.textContent = "";
    passwordError.textContent = "";

    let hasError = false;

    // Email validation
    if (emailInput.value.trim() === "") {
      emailError.textContent = "Email is required.";
      hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
      emailError.textContent = "Invalid email format.";
      hasError = true;
    }

    // Password validation
    if (passwordInput.value.trim() === "") {
      passwordError.textContent = "Password is required.";
      hasError = true;
    }

    if (hasError) {
      return; // stop if errors
    }
    const formData = new FormData(form);

    fetch("../Server/Process/login-process.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: `<span style="
                font-size: 1.2rem;
                font-weight: 600;
                color: #2f855a;
            ">Login Successful!</span>`,
            html: `
              <p style="
                color: #4a5568; 
                font-size: 0.85rem; 
                margin: 0;
              ">Welcome back!</p>
            `,
            position: "center",
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            background: "#f0fff4",
            color: "#2f855a",
            width: "22rem",
            customClass: {
              popup: "small-swal-popup",
            },
            didOpen: () => {
              const popup = Swal.getPopup();
              popup.style.borderRadius = "0.75rem";
              popup.style.boxShadow = "0 4px 12px rgba(0,0,0,0.1)";
              popup.style.padding = "1rem";
            },

            willClose: () => {
              document.getElementById("authModal").classList.add("d-none");
              if (data.redirect) {
                window.location.href = data.redirect;
              }
              const action = sessionStorage.getItem("postLoginAction");
              sessionStorage.removeItem("postLoginAction");

              const actionData2 = sessionStorage.getItem(
                "postLoginActioncheckout"
              );
              sessionStorage.removeItem("postLoginActioncheckout");
              if (action) {
                window.location.href = action;
              } else if (actionData2) {
                const { productId, action } = JSON.parse(actionData2);
                if (action === "buy") {
                  buynow(productId);
                } else {
                  addToCart(productId);
                }
              }
            },
          });
        } else {
          emailError.textContent = "";
          passwordError.textContent = "";
          if (data.error === "email") {
            document.getElementById("emailError").textContent = "Invalid email";
          }
          if (data.error === "password") {
            document.getElementById("passwordError").textContent =
              "Invalid password";
          }
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Something went wrong.");
      });
  });
});
