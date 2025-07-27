window.addToCart = function (productId) {
  fetch("../Server/Process/add-to-cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "productid=" + productId,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        document.getElementById("cartCount").innerText = data.cart_count;

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "✅ Product successfully added!",
          showConfirmButton: false,
          timer: 2000,
          toast: true,
          backdrop: false,
          customClass: {
            popup: "custom-swal-toast",
            title: "custom-swal-title",
          },
          showClass: {
            popup: "animate__animated animate__fadeIn",
          },
          hideClass: {
            popup: "animate__animated animate__fadeOut",
          },
        }).then(() => {
           if (data.reload) {
        window.location.reload();
      }
          if (!isLoggedIn) {
            if (window.location.href.includes("product-detail.php")) {
              window.location.reload();
            }
          }
        });
      }
     
    })
    .catch((error) => console.error("Error:", error));
};
window.buynow = function (productId) {
  fetch("../Server/Process/add-to-cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "productid=" + productId + "&buynow=1",
  })
    .then((response) => response.text())
    .then(() => {
      window.location.href = "../Client/checkout.php";
    });
};
function removeCart(productid) {
  fetch("../Server/Process/delete-cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "productid=" + productid,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        document.querySelector(`.bag-item[data-id="${productid}"]`)?.remove();

        if (data.cart_count === 0) {
          location.reload();
        }

        document.querySelectorAll(".cart-count").forEach((element) => {
          element.innerText = data.cart_count;
        });

        document.querySelectorAll(".cart-subtotal").forEach((element) => {
          element.innerText = "£" + data.subtotal;
        });
      }
    });
}
