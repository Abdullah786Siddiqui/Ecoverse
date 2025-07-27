let form = document.getElementById("product-form");

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const productName = document.getElementById("product-name").value.trim();
  const priceInput = document.getElementById("product-price").value.trim();
  const description = document
    .getElementById("product-description")
    .value.trim();
  const image = document.getElementById("product-image").files.length;
  const brand = document.querySelector('select[name="brand_id"]');
  const category = document.getElementById("category");
  const subcategory = document.getElementById("subcategory");
  const quantity = document.getElementById("product-quantity").value;
  const quantityValue = parseInt(quantity, 10);

  let brandError = document.getElementById("brand-error");
  let categoryError = document.getElementById("category-error");
  let subcategoryError = document.getElementById("subcategory-error");
  let nameError = document.getElementById("name-error");
  let priceError = document.getElementById("price-error");
  let descriptionError = document.getElementById("description-error");
  let imageError = document.getElementById("image-error");
  let quantityError = document.getElementById("quantity-error");

  // First clear all previous errors
  nameError.innerText = "";
  priceError.innerText = "";
  descriptionError.innerText = "";
  imageError.innerText = "";
  brandError.innerText = "";
  categoryError.innerText = "";
  subcategoryError.innerText = "";
  quantityError.innerText = "";

  let hasError = false;

  if (productName === "") {
    nameError.innerText = "Please fill out the Product Name field";
    hasError = true;
  } else if (productName.length < 3) {
    nameError.innerText = "Product name must be at least 3 characters long.";
    hasError = true;
  } else if (productName.length > 80) {
    nameError.innerText = "Product name cannot exceed 80 characters.";
    hasError = true;
  }
  // } else if (!/^[a-zA-Z0-9\s]+$/.test(productName)) {
  //   nameError.innerText =
  //     "Product name can only contain letters, numbers, and spaces.";
  //   hasError = true;
  // }

  if (priceInput === "") {
    priceError.innerText = "Product price is required.";
    hasError = true;
  } else if (isNaN(priceInput)) {
    priceError.innerText = "Price must be a number.";
    hasError = true;
  } else if (Number(priceInput) <= 0) {
    priceError.innerText = "Price must be greater than zero.";
    hasError = true;
  } else if (/^0[0-9]+$/.test(priceInput)) {
    priceError.innerText = "Price cannot start with leading zeros.";
    hasError = true;
  } else if (Number(priceInput) > 100000) {
    priceError.innerText = "Price cannot exceed 1,00,000.";
    hasError = true;
  }

  if (!quantity) {
    quantityError.innerText = "Please select a quantity.";
    hasError = true;
  } else if (isNaN(quantityValue) || quantityValue <= 0) {
    quantityError.innerText = "Invalid quantity selected.";
    hasError = true;
  } else if (quantityValue > 100000) {
    quantityError.innerText = "Quantity cannot exceed 1,00,000.";
    hasError = true;
  }

  if (description === "") {
    descriptionError.innerText = "Product description is required.";
    hasError = true;
  } else if (description.length < 10) {
    descriptionError.innerText =
      "Description must be at least 10 characters long.";
    hasError = true;
  } else if (description.length > 1000) {
    descriptionError.innerText = "Description cannot exceed 1000 characters.";
    hasError = true;
  }

  if (image === 0) {
    imageError.innerText = "Please select an image file.";
    hasError = true;
  }
  if (brand.value === "" || brand.value === "Select Brand") {
    brandError.innerText = "Please select a Brand.";
    hasError = true;
  }

  if (category.value === "" || category.value === "Select Category") {
    categoryError.innerText = "Please select a Category.";
    hasError = true;
  }

  if (subcategory.value === "" || subcategory.value === "Select Subcategory") {
    subcategoryError.innerText = "Please select a Subcategory.";
    hasError = true;
  }

  if (!hasError) {
    form.submit();
    console.log("Form submitted successfully!");
  }
});

function removeProduct(productId) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch("../Process/delete-product.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "productid=" + encodeURIComponent(productId),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            // Remove row
            document.querySelector(`.delete_product[data-id="${productId}"]`)?.closest("tr")?.remove();

            Swal.fire({
              title: "Deleted!",
              text: "Product has been deleted.",
              icon: "success",
              timer: 1500,
              showConfirmButton: false,
            });
          } else {
            Swal.fire({
              title: "Error!",
              text: data.message || "Something went wrong.",
              icon: "error",
            });
          }
        })
        .catch(() => {
          Swal.fire({
            title: "Error!",
            text: "Server error. Please try again later.",
            icon: "error",
          });
        });
    }
  });
}


