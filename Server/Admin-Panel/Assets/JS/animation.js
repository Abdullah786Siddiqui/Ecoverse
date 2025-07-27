 const ordersToggle = document.querySelector('[href="#ordersSubmenu"]');
  const icon = document.getElementById('ordersIcon');

  ordersToggle.addEventListener('click', () => {
    icon.classList.toggle('rotate');
  });

