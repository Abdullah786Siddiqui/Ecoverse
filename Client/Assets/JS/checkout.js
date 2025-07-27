document.addEventListener("DOMContentLoaded", function () {
  let form = document.getElementById("address-form");
  let checkbox = document.getElementById("same-address");


  checkbox.addEventListener("change", function () {
    if (checkbox.checked) {
      document.getElementById("shipping-section").style.display = "none";
    } else {
      document.getElementById("shipping-section").style.display = "block";
    }
  });

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (checkbox.checked) {
      document.getElementById("shipping-section").style.display = "none";
    } else {
      document.getElementById("shipping-section").style.display = "block";
    }
    // Billing Fields
    let fullName = document.getElementById("fullName");
    let fullNameError = document.getElementById("fullName-error");

    let address = document.getElementById("address");
    let addressError = document.getElementById("address-error");

    let phone = document.getElementById("phone");
    let phoneError = document.getElementById("phone-error");

    let country = document.getElementById("country");
    let countryError = document.getElementById("country-error");

    let city = document.getElementById("city");
    let cityError = document.getElementById("city-error");

    // Shipping Fields
    let shippingName = document.getElementById("shippingName");
    let shippingNameError = document.getElementById("shippingName-error");

    let shippingAddress = document.getElementById("shippingAddress");
    let shippingAddressError = document.getElementById("shippingAddress-error");

    let shippingPhone = document.getElementById("shippingPhone");
    let shippingPhoneError = document.getElementById("shippingPhone-error");

    let shippingCountry = document.getElementById("shippingCountry");
    let shippingCountryError = document.getElementById("shippingCountry-error");

    let shippingCity = document.getElementById("shippingCity");
    let shippingCityError = document.getElementById("shippingCity-error");

    // Clear Errors
    fullNameError.innerText = "";
    addressError.innerText = "";
    phoneError.innerText = "";
    countryError.innerText = "";
    cityError.innerText = "";

    shippingNameError.innerText = "";
    shippingAddressError.innerText = "";
    shippingPhoneError.innerText = "";
    shippingCountryError.innerText = "";
    shippingCityError.innerText = "";

    let hasError = false;

    // Billing Validation
    if (fullName.value.trim() === "") {
      fullNameError.innerText = "Full name is required";
      hasError = true;
    }
    if (address.value.trim() === "") {
      addressError.innerText = "Address is required";
      hasError = true;
    }
    if (phone.value.trim() === "") {
      phoneError.innerText = "Phone number is required";
      hasError = true;
    }
    if (country.value.trim() === "") {
      countryError.innerText = "Please select a country";
      hasError = true;
    }
    if (city.value.trim() === "") {
      cityError.innerText = "Please select a city";
      hasError = true;
    }

    // Shipping Validation (if checkbox is unchecked)
    if (!checkbox.checked) {
      if (shippingName.value.trim() === "") {
        shippingNameError.innerText = "Shipping name is required";
        hasError = true;
      }
      if (shippingAddress.value.trim() === "") {
        shippingAddressError.innerText = "Shipping address is required";
        hasError = true;
      }
      if (shippingPhone.value.trim() === "") {
        shippingPhoneError.innerText = "Shipping phone is required";
        hasError = true;
      }
      if (shippingCountry.value.trim() === "") {
        shippingCountryError.innerText = "Select shipping country";
        hasError = true;
      }
      if (shippingCity.value.trim() === "") {
        shippingCityError.innerText = "Select shipping city";
        hasError = true;
      }
    }

    if (hasError) {
      return; // Stop form submission if errors
    }

    // Submit form via AJAX
    let formData = new FormData(form);


    fetch("../Server/Process/checkout-Address.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === "success") {
           window.location.reload();
        } else {
          alert("Something went wrong, please try again!");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});



