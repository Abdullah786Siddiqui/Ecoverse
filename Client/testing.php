<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>eCommerce Homepage</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <!-- <style>
    .testimonial-wrapper {
      overflow-x: auto;
      white-space: nowrap;
      scroll-snap-type: x mandatory;
      padding-bottom: 1rem;
    }

    .testimonial-scroll {
      display: flex;
      gap: 1rem;
      padding: 1rem 2rem;
    }

    .testimonial-box {
      width: 300px;
      scroll-snap-align: start;
    }

    .testimonial {
      min-height: 180px;
      font-style: italic;
      border-left: 4px solid #ffc107;
      transition: transform 0.3s ease;
    }

    .testimonial:hover {
      transform: translateY(-5px);
    }
  </style> -->
</head>

<body>

  <!-- Carousel Placeholder -->
  <div class="carousel-placeholder bg-light text-center py-5">
    <h2>Carousel Yahan Tha</h2>
  </div>

  <!-- Featured Products -->
  <!-- Featured Products -->
  <section class="py-5 bg-white" id="featured">
    <div class="container">
      <h2 class="text-center mb-4">Featured Products</h2>
      <div class="row g-4">
        <!-- Product Card 1 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 1">
            <div class="card-body">
              <h5 class="card-title">Wireless Headphones</h5>
              <p class="card-text">$89.99</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
        <!-- Product Card 2 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 2">
            <div class="card-body">
              <h5 class="card-title">Smart Watch</h5>
              <p class="card-text">$129.99</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
        <!-- Product Card 3 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 3">
            <div class="card-body">
              <h5 class="card-title">Bluetooth Speaker</h5>
              <p class="card-text">$59.99</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
        <!-- Product Card 4 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 4">
            <div class="card-body">
              <h5 class="card-title">Digital Camera</h5>
              <p class="card-text">$499.00</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
        <!-- Product Card 5 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 5">
            <div class="card-body">
              <h5 class="card-title">Fitness Tracker</h5>
              <p class="card-text">$69.00</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
        <!-- Product Card 6 -->
        <div class="col-md-4 product-card">
          <div class="card shadow-sm h-100">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product 6">
            <div class="card-body">
              <h5 class="card-title">LED Monitor</h5>
              <p class="card-text">$179.00</p>
              <button class="btn btn-primary w-100">Buy Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Categories Section -->
  <section class="py-5 bg-light" id="categories">
    <div class="container">
      <h2 class="text-center mb-4">Shop by Categories</h2>
      <div class="row text-center g-4">
        <div class="col-md-3" data-animate>
          <div class="category-box p-4 shadow-sm bg-white rounded">
            <h5>Clothing</h5>
          </div>
        </div>
        <div class="col-md-3" data-animate>
          <div class="category-box p-4 shadow-sm bg-white rounded">
            <h5>Electronics</h5>
          </div>
        </div>
        <div class="col-md-3" data-animate>
          <div class="category-box p-4 shadow-sm bg-white rounded">
            <h5>Accessories</h5>
          </div>
        </div>
        <div class="col-md-3" data-animate>
          <div class="category-box p-4 shadow-sm bg-white rounded">
            <h5>Home & Kitchen</h5>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Deal of the Day -->
  <section class="py-5 bg-warning text-dark" id="deal">
    <div class="container text-center" data-animate>
      <h2 class="mb-3">🔥 Deal of the Day</h2>
      <p class="lead">Get 30% off on all electronics today only!</p>
      <button class="btn btn-dark px-4 py-2 mt-3">Shop Now</button>
    </div>
  </section>

  <!-- Testimonials -->



  <!-- Footer Placeholder -->
  <div class="footer-placeholder bg-dark text-white text-center py-5">
    <h4>Footer Yahan Tha</h4>
  </div>

  <!-- <script>
  gsap.registerPlugin(ScrollTrigger);

  // Animate product cards with stagger
  gsap.from(".product-card", {
    opacity: 0,
    y: 50,
    duration: 1,
    stagger: 0.2,
    ease: "power2.out",
    scrollTrigger: {
      trigger: "#featured",
      start: "top 80%",
      toggleActions: "play none none reverse"
    }
  });

  // Animate categories
  gsap.from("#categories .col-md-3", {
    opacity: 0,
    scale: 0.8,
    duration: 1,
    stagger: 0.2,
    ease: "back.out(1.7)",
    scrollTrigger: {
      trigger: "#categories",
      start: "top 80%",
    }
  });

  // Animate deal section
  gsap.from("#deal", {
    opacity: 0,
    y: 100,
    duration: 1.2,
    ease: "bounce.out",
    scrollTrigger: {
      trigger: "#deal",
      start: "top 90%",
    }
  });

  // Animate testimonials
  gsap.from("#testimonials .testimonial", {
    x: -100,
    opacity: 0,
    duration: 1,
    stagger: 0.3,
    ease: "expo.out",
    scrollTrigger: {
      trigger: "#testimonials",
      start: "top 85%",
    }
  });
</script> -->
<script>
  gsap.registerPlugin(ScrollTrigger);

  gsap.from(".testimonial-box", {
    opacity: 0,
    x: 100,
    duration: 1,
    ease: "power2.out",
    stagger: 0.1,
    scrollTrigger: {
      trigger: "#testimonials",
      start: "top 80%",
      end: "bottom 60%",
      toggleActions: "play none none reverse"
    }
  });
</script>

</body>

</html>