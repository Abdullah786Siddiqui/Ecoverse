let form = document.getElementById("updateProductForm");

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("productName").value.trim();
  const price = document.getElementById("productPrice").value.trim();
  const qty = document.getElementById("productQty").value.trim();
  const desc = document.getElementById("productDesc").value.trim();

  let nameError = document.getElementById("name-error");
  let priceError = document.getElementById("price-error");
  let qtyError = document.getElementById("qty-error");
  let desError = document.getElementById("desc-error");

  // Clear previous errors
  nameError.innerText = "";
  priceError.innerText = "";
  qtyError.innerText = "";
  desError.innerText = "";

  let hasError = false;

  if (name === "") {
    nameError.innerText = "Product name is required.";
    hasError = true;
  } else if (name.length < 3) {
    nameError.innerText = "Product name must be at least 3 characters.";
    hasError = true;
  } else if (name.length > 80) {
    nameError.innerText = "Product name cannot exceed 80 characters.";
    hasError = true;
  }

 

  if (price === "") {
    priceError.innerText = "Price is required.";
    hasError = true;
  } else if (isNaN(price) || Number(price) <= 0) {
    priceError.innerText = "Price must be a number greater than 0.";
    hasError = true;
  }

  if (qty === "") {
    qtyError.innerText = "Quantity is required.";
    hasError = true;
  } else if (isNaN(qty) || Number(qty) < 0) {
    qtyError.innerText = "Quantity must be 0 or more.";
    hasError = true;
  }


  if (desc === "") {
    desError.innerText = "Description is required.";
    hasError = true;
  } else if (desc.length < 10) {
    desError.innerText = "Description must be at least 10 characters.";
    hasError = true;
  } else if (desc.length > 500) {
    desError.innerText = "Description cannot exceed 500 characters.";
    hasError = true;
  } else {
    desError.innerText = "";
  }

  if (!hasError) {
    console.log("Form is valid. Submitting...");
    form.submit();
  }
});
