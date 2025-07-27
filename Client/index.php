<?php
include_once 'Components/header.html';
include_once './includes/Navbar.php';

?>


<!-- Carousel Section -->

<!-- <div id="proCarousel" class="carousel slide carousel-fade " data-bs-ride="carousel" data-bs-interval="3000">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#proCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#proCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#proCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://img.lazcdn.com/us/domino/a3f182f2-240f-4e66-80b0-5c9710b68a21_PK-1976-688.jpg_2200x2200q80.jpg_.webp" class="d-block w-100 img-fluid" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="https://img.lazcdn.com/us/domino/155b0275-3101-4a78-ab12-2724891122c4_PK-1976-688.jpg_2200x2200q80.jpg_.webp" class="d-block w-100 img-fluid" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="https://img.lazcdn.com/us/domino/b97596f5-2266-4758-8e82-01608445732b_PK-1976-688.jpg_2200x2200q80.jpg_.webp" class="d-block w-100 img-fluid" alt="Slide 3">
    </div>
  </div>
</div> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
  /* 🔹 Common Styles */
  .swiper {
    width: 100%;
    margin: 0 auto;
    overflow: hidden;
    /* border-radius: 10px; */
  }

  .swiper-slide img {
    width: 100%;
    display: block;
    object-fit: cover;
  }

  /* 🔹 Desktop (width >= 769px) */
  @media (min-width: 769px) {
    .swiper {
      max-width: 1600px;
      height: 400px;
    }

    .swiper-slide img {
      height: 400px;
    }
  }

  /* 🔹 Mobile (width <= 768px) */
  @media (max-width: 768px) {
    .swiper {
      max-width: 100%;
      height: 220px;
    }

    .swiper-slide img {
      height: 220px;
    }
    .swiper-slide img {
    /* width: 100%;
    display: block; */
    object-fit:fill;
  }
  }
</style>

<!-- Swiper HTML -->
<div class="swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/a3f182f2-240f-4e66-80b0-5c9710b68a21_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
    <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/155b0275-3101-4a78-ab12-2724891122c4_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
    <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/b97596f5-2266-4758-8e82-01608445732b_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
      <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/5e628089-d6c7-43ed-ae49-555f17feef58_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
      <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/e373c4d3-c451-44aa-a293-32bd1f90eb78_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
      <div class="swiper-slide">
      <img src="https://img.lazcdn.com/us/domino/29361361-c0aa-4c69-8f76-1cd9855c13c7_PK-1976-688.jpg_2200x2200q80.jpg_.webp">
    </div>
  </div>
  <!-- Pagination (dots) -->
  <div class="swiper-pagination"></div>
</div>

<!-- Swiper Init -->
<script>
  new Swiper('.swiper', {
    loop: true,
    autoplay: { delay: 3000 },
    pagination: { el: '.swiper-pagination', clickable: true },
  });
</script>



<!-- Featured Products -->
<div class="container py-5 d-flex flex-column">
  <h2 class="text-start mb-3 ">Browse by Category</h2>
  <div class="row g-4">

    <!-- Category 1 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 ">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/2278/2278984.png" alt="Electronics" class="category-icon mb-2">
        <div class="category-title">Electronics</div>
      </div>
    </div>


    <!-- Category 2 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/12516/12516451.png" alt="Fashion" class="category-icon mb-2">
        <div class="category-title">Fashion</div>
      </div>
    </div>



    <!-- Category 9 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/3075/3075977.png" alt="Grocery" class="category-icon mb-2">
        <div class="category-title">Grocery</div>
      </div>
    </div>



    <!-- Category 4 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/1940/1940922.png" alt="Beauty" class="category-icon mb-2">
        <div class="category-title">Beauty</div>
      </div>
    </div>

    <!-- Category 5 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/763/763812.png" alt="Sports" class="category-icon mb-2">
        <div class="category-title">Sports</div>
      </div>
    </div>

    <!-- Category 6 -->
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
      <div class="text-center category-card p-3 bg-white">
        <img src="https://cdn-icons-png.flaticon.com/128/3145/3145765.png" alt="Books" class="category-icon mb-2">
        <div class="category-title">Books</div>
      </div>
    </div>

  </div>
</div>




<div class=" d-flex  justify-content-center">
  <div class="row g-3">

    <!-- Macbook Air -->
    <a class="col-12 col-md-6 ">
      <div class="promo-tile h-100 " style="background-image: url('https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fGxhcHRvcHxlbnwwfHwwfHx8MA%3D%3D');">
        <div class="promo-content">
          <div class="text-sm">Get up to 15% off</div>
          <h5>New Macbook Air</h5>
          <div class="cta">SHOP NOW</div>
        </div>
      </div>
    </a>

    <!-- Furniture + Shoes + Earbuds -->
    <div class="col-12 col-md-6">
      <div class="row g-3">

        <!-- Furniture Collection -->
        <div class="col-12">
          <div class="promo-tile" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=900&q=80');">
            <div class="promo-content">
              <div class="text-sm">Get up to 50% off</div>
              <h5>Furniture Collection</h5>
              <div class="cta">SHOP NOW</div>
            </div>
          </div>
        </div>

        <!-- Shoes -->
        <div class="col-6">
          <div class="promo-tile" style="background-image: url('https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mjd8fHNob2VzfGVufDB8fDB8fHww');">
            <div class="promo-content">
              <div class="text-sm">Get up to 20% off</div>
              <h6>New Shoes Sale</h6>
              <div class="cta">SHOP NOW</div>
            </div>
          </div>
        </div>

        <!-- Earbuds -->
        <div class="col-6">
          <div class="promo-tile" style="background-image: url('https://images.unsplash.com/photo-1699290438461-c89f6db093be?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDMwfHx8ZW58MHx8fHx8');">
            <div class="promo-content">
              <div class="text-sm">Get up to 30% off</div>
              <h6>Realme Earbuds</h6>
              <div class="cta">SHOP NOW</div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

</head>

<body>

<div class="homepage">
    <h1 class="text-center my-5">Features Products</h1>

  <div class="container">

    <div class="row g-4">
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                src="../Server/uploads/1750983047-10.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                 src="../Server/uploads/1751154824-w1.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                src="../Server/uploads/1751056174-EIF SKIN CAR E.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                 src="../Server/uploads/1751153642-s5.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                 src="../Server/uploads/1751151270-s3.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      <div class="col-sm-6 col-md-4 mb-4 product-card-animate">
        <a href="#" class="text-decoration-none">
          <div class="card border-0 shadow-sm rounded-4 h-100 p-4 position-relative hover-shadow">
            <div class="ratio ratio-1x1 mb-3">
              <img
                 src="../Server/uploads/1750985785-12.jpg"
                class="img-fluid rounded-3 object-fit-cover w-100 h-100"
                alt="Product Name"
                loading="lazy">
            </div>

            <h5 class="fw-semibold mb-2 text-truncate text-dark">Product Name</h5>

            <p class="mb-2">
              <span class="fw-bold text-success fs-6">Rs.900</span>
              <small class="text-muted text-decoration-line-through ms-2">Rs.1,120</small>
            </p>

            <div class="text-warning small">★★★★☆ <span class="text-muted">(1)</span></div>
          </div>
        </a>
      </div>
      

    </div>
  </div>
</div>



  
  </a>
</div>


  </div>
</div>

  <?php include("./includes/SECTION.php") ?>


  <?php include("./includes/mobile-icon.php") ?>
  <?php include 'Components/footer2.html'; ?>

  <?php include 'Components/footer.html'; ?>