<?php
include './Components/header.html';
?>

<!-- Hide navbar on mobile -->
<div class="hide-on-mobile">
  <?php include './includes/Navbar.php'; ?>
</div>

<!-- CSS Links -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
  body,
  html {
    background: black;
    overflow: hidden;
  }

  .mySwiper {
    max-width: 430px;
    height: calc(100vh - 96px);
    margin: 0 auto;
    background: black;
  }

  video {
    object-fit: cover;
    width: 100%;
    height: 100%;
  }

  @media (max-width: 576px) {
    .hide-on-mobile {
      display: none !important;
    }

    .mobile-mb-5 {
      margin-bottom: 3rem !important;
    }
  }

  .horizontal-scroll-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
  }

  .horizontal-scroll-container::-webkit-scrollbar {
    display: none;
  }

  .img-thumb {
    flex: 0 0 auto;
    width: 80px;
    height: 80px;
    cursor: pointer;
  }

  @media (min-width: 768px) {
    .img-thumb {
      width: 70px;
      height: 70px;
    }
  }

  /* Modal at bottom */
  .modal-bottom .modal-dialog {
    position: fixed;
    bottom: 0;
    margin: 0;
    width: 100%;
    max-width: 430px;
    left: 50%;
    transform: translateX(-50%);
  }

  /* Slide-up animation */
  @keyframes slideUp {
    from {
      transform: translateY(100%);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .slide-up-modal .modal-content {
    animation: slideUp 0.4s ease-out;
  }
  @media (max-width: 576px) {
  .icon-stack {
    top: 55% !important; /* Slightly above mid to avoid bottom crowding */
    transform: translateY(-45%) !important;
  }
}
</style>

<!-- Swiper Container -->
<div class="swiper mySwiper">
  <div class="swiper-wrapper">

    <?php
    $videos = [
      '../darimouch.mp4',
      '../videoshoes.mp4',
      '../samsung.mp4'
    ];

    foreach ($videos as $i => $videoUrl) {
    ?>
      <div class="swiper-slide position-relative d-flex justify-content-center align-items-center">
        <video id="video-<?php echo $i; ?>" src="<?php echo $videoUrl; ?>" autoplay muted loop class="position-absolute video-click" data-id="<?php echo $i; ?>"></video>

        <!-- Play/Pause Button -->
        <div class="position-absolute top-50 start-50 translate-middle text-white play-btn" id="playBtn-<?php echo $i; ?>" style="z-index: 10; display: none; pointer-events: none;">
          <i class="fas fa-play fa-3x"></i>
        </div>

        <!-- Right Icons -->
        <!-- Right Side Icons -->
<div class="position-absolute top-50 end-0 translate-middle-y mt-5 d-flex flex-column align-items-center gap-3 me-3 text-white z-3 icon-stack">
          <div class="d-flex flex-column align-items-center">
            <i class="fas fa-heart fs-4 mb-1"></i>
            <small class="text-white">1.2k</small>
          </div>
          <div class="d-flex flex-column align-items-center">
            <i class="fas fa-comment fs-4 mb-1"></i>
            <small class="text-white">350</small>
          </div>
          <div class="d-flex flex-column align-items-center">
            <i class="fas fa-share fs-4 mb-1"></i>
            <small class="text-white">Share</small>
          </div>
        </div>


        <!-- Bottom Info -->
        <div class="position-absolute bottom-0 start-0 end-0 px-3 pb-4">


          <div class="horizontal-scroll-container  px-2">
            <div class="d-flex flex-nowrap gap-2">
             
                <img src="../Server/uploads/1750979066-5.jpg" class="img-thumb rounded border border-white">
                <img src="../Server/uploads/1750979066-5.jpg" class="img-thumb rounded border border-white">
                <img src="../Server/uploads/1750979066-5.jpg" class="img-thumb rounded border border-white">
                <img src="../Server/uploads/1750979066-5.jpg" class="img-thumb rounded border border-white">

              
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

<?php include("./includes/mobile-icon.php") ?>

<!-- Slide-Up Modal -->
<div class="modal fade slide-up-modal" id="productModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-bottom modal-dialog-centered">
    <div class="modal-content text-white bg-dark border-0 rounded-top shadow-lg">
      <div class="modal-body text-center">
        <img id="modalProductImage" src="" class="img-fluid rounded mb-3" alt="Product Image" style="max-height: 200px;">
        <h5 id="modalProductTitle">Product Title</h5>
        <p id="modalProductDescription" class="small">This is a sample product description.</p>
        <a href="product-detail.php?productid=17" class="btn btn-danger w-100 rounded-pill fw-bold mt-3">Checkout</a>
      </div>
    </div>
  </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Swiper vertical scroll
  var swiper = new Swiper(".mySwiper", {
    direction: "vertical",
    slidesPerView: 1,
    spaceBetween: 0,
    mousewheel: true,
  });

  // Video Play/Pause Toggle
  document.querySelectorAll('.video-click').forEach(video => {
    video.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const playBtn = document.getElementById(`playBtn-${id}`);
      const icon = playBtn.querySelector('i');

      if (this.paused) {
        this.play();
        playBtn.style.display = "none";
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-play');
      } else {
        this.pause();
        playBtn.style.display = "block";
        icon.classList.remove('fa-play');
        icon.classList.add('fa-pause');
      }
    });
  });

  // Image Click → Open Modal
  document.querySelectorAll('.img-thumb').forEach(img => {
    img.addEventListener('click', function() {
      const imgSrc = this.src;
      const productNum = this.src.match(/text=(\d+)/)?.[1] || "1";

      document.getElementById("modalProductImage").src = imgSrc;
      document.getElementById("modalProductTitle").innerText = "Product " + productNum;
      document.getElementById("modalProductDescription").innerText = "This is the description of product #" + productNum + ". Click checkout to continue.";

      const myModal = new bootstrap.Modal(document.getElementById('productModal'));
      myModal.show();
    });
  });
</script>