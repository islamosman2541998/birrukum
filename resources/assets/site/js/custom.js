document.querySelectorAll(".swiper-slide").forEach(function (slide, index) {
  if (window.matchMedia("(min-width: 992px)").matches) {
    slide.addEventListener("click", function () {
      // Center the clicked slide
      livewire.emit('changeSelection', slide.getAttribute('data-val'));
    });
  } else {
    slide.addEventListener("click", function () {
      livewire.emit('changeSelection', slide.getAttribute('data-val'));
    })

  }
});


$(document).ready(function () {
  $("#owl-project").owlCarousel({
    items: 1,
    navigation: true, // Show next and prev buttons
    slideSpeed: 300,
    paginationSpeed: 400,
    itemsDesktop: false,
    itemsDesktopSmall: false,
    itemsTablet: false,
    itemsMobile: false,
  });

  $('.gifts').owlCarousel({
    rtl: true,
    loop: false,
    margin: 10,
    nav: false,
    dots: true,
  });

});


$(document).on("click", '[alt="lightbox"]', function (event) {
  event.preventDefault();
  let imgSrc = event.target.currentSrc; //getting source
  console.log(imgSrc);
  $("#popup .modal-body").html("<img width='100%' src='" + imgSrc + "' />");
  $("#popup").modal("show");
});


$(document).ready(function () {
  $(function () {
      $('.warm').addClass('warm-danger').fadeIn(1000);
      setTimeout(function () {
          $('.warm').toggleClass('warm-danger');
      }, parseInt('1000'), setInterval(function () {
          $('.warm').toggleClass('warm-danger');
      }, parseInt('1000')))
  });

});


