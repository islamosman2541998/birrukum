$(window).on("load", function () {
  setTimeout(function () {
    $(".preloader").addClass("compleate");
  }, 200);
});

//Wow
new WOW().init(); 

$("#projects .owl-carousel").owlCarousel({
  margin: 20,
  nav: true,
  // loop: true,
  rtl: true,
  dots: true,
  responsiveClass: true,
  autoplay: false,
  // autoplayTimeout: 5000,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1,
      dots: true,
      nav: true,
    },
    700: {
      items: 2,
      dots: true,
      nav: true,
    },
    1000: {
      items: 3,
      dots: true,
      nav: true,
    },
  },
});

$(".gifts").owlCarousel({
  rtl: true,
  loop: false,
  margin: 10,
  nav: false,
  dots: true,
});
function moveToSelected(element) {
  if (element == "next") {
    var selected = $(".selected").next();
  } else if (element == "prev") {
    var selected = $(".selected").prev();
  } else {
    var selected = element;
  }

  var next = $(selected).next();
  var prev = $(selected).prev();
  var prevSecond = $(prev).prev();
  var nextSecond = $(next).next();

  $(selected).removeClass().addClass("selected");

  $(prev).removeClass().addClass("prev");
  $(next).removeClass().addClass("next");

  $(nextSecond).removeClass().addClass("nextRightSecond");
  $(prevSecond).removeClass().addClass("prevLeftSecond");

  $(nextSecond).nextAll().removeClass().addClass("hideRight");
  $(prevSecond).prevAll().removeClass().addClass("hideLeft");
}

// Eventos teclado
$(document).keydown(function (e) {
  switch (e.which) {
    case 37: // left
      moveToSelected("prev");
      break;

    case 39: // right
      moveToSelected("next");
      break;

    default:
      return;
  }
  e.preventDefault();
});
// swiper
// var swiper = new Swiper(".categories", {
//   loop: true,
//   // speed: 1000,
//   effect: "coverflow",

//   grabCursor: false,
//   slidesPerView: 1,
//   slideShadows: true,

//   centeredSlides: true,
//   slideToClickedSlide: true,
//   pagination: {
//     el: ".swiper-pagination",
//     clickable: true,
//   },
//   coverflowEffect: {
//     rotate: 0,
//     stretch: 0,
//     depth: 300,
//     modifier: 1,
   
//     //   slideShadows: true,
//   },
//   breakpoints: {
//     320: {
//       slidesPerView: 1,
//       coverflowEffect: {
//         depth: 950,
//       }
//     },
//     768: {
//       slidesPerView: 2,
//     },
//     1024: {
//       slidesPerView: 4
//       ,
//     },
//   },
// });


// swiper.on('slideChange', function () {
//   var activeSlide = swiper.slides[swiper.activeIndex];
//   var slideInfo = activeSlide.getAttribute('data-val');
//   livewire.emit('changeSelection', slideInfo);
//   });


$("#carousel div").click(function () {
  moveToSelected($(this));
});

$("#prev").click(function () {
  moveToSelected("prev");
});

$("#next").click(function () {
  moveToSelected("next");
});
// $("#quick-donation .quick-donation-head").click(function () {
//   $(this).parent().toggleClass("open");
// });

const inputs = document.querySelectorAll(".numberInput");

inputs.forEach(function (input) {
  // Add event listener for input
  input.addEventListener("input", function (event) {
    // Get the input value
    const inputValue = event.target.value;

    // Check if input value is a number
    if (!isNaN(inputValue)) {
    } else {
      // Input is not a number, clear the input value
      event.target.value = "";
    }
  });
});


// window.addEventListener('sliderInit', function(event) {
  $("#projects .gifts").owlCarousel({
      margin: 20,
      nav: true,
      // loop: true,
      rtl: true,
      dots: true,
      responsiveClass: true,
      autoplay: false,
      // autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
      0: {
          items: 1,
          dots: true,
          nav: true,
      },
      700: {
          items: 2,
          dots: true,
          nav: true,
      },
      1000: {
          items: 3,
          dots: true,
          nav: true,
      },
      },
  });
// });


// /*Btns*/
// let CardBtn = document.getElementById("CardBtn");
// let GfitsBtn = document.getElementById("GfitsBtn");

// /* Divs*/
// let Cards = document.getElementById("Cards");
// let Gfits = document.getElementById("Gfits");

// let flag = 0;

// // Add click event listeners to the buttons
// CardBtn.addEventListener("click", function () {
//   Cards.style.display = "block";
//   Gfits.style.display = "none";
//   ////
//   CardBtn.classList.add("bg-main");
//   GfitsBtn.classList.remove("bg-main");
// });

// GfitsBtn.addEventListener("click", function () {
//   Gfits.classList.remove("d-none");
//   Cards.style.display = "none";
//   Gfits.style.display = "block";
//   ////
//   CardBtn.classList.remove("bg-main");
//   GfitsBtn.classList.add("bg-main");
// });




// $('.gifts').owlCarousel({
//   rtl:true,
//   loop:false,
//   margin:10,
//   nav:false,
//   dots: true,
// });



// Add click event listeners to the buttons
// $("#Zakatout").on("click", function () {
//   $("#Zakat-out").show();
//   $("#Zakat-calc").hide();
// });

// $("#calcZakat").on("click", function () {
//   // ZakatCalcDiv.classList.remove("d-none");
//   $("#Zakat-out").hide();
//   $("#Zakat-calc").show();
// });


// // Get all elements with class 'dropdown'
// var dropdowns = document.querySelectorAll("li.dropdown");
// // Loop through each dropdown element
// dropdowns.forEach(function (dropdown) {
//   // Add event listener for mouse enter
//   dropdown.addEventListener("click", function () {
//     // Find the ul inside this dropdown and slide down
//     var ul = this.querySelector("ul");
//     if (ul) {
//       ul.style.display = "block"; // Show the ul
//     }
//   });

//   // Add event listener for mouse leave
//   dropdown.addEventListener("mouseleave", function () {
//     // Find the ul inside this dropdown and slide up
//     var ul = this.querySelector("ul");
//     if (ul) {
//       ul.style.display = "none"; // Hide the ul
//     }
//   });
// });


var swiper = new Swiper(".volunteer-swiper", {
  effect: "coverflow",
  grabCursor: false,
  slidesPerView: "auto",
  centeredSlides: true,
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 600,
    modifier: 1,
    slideShadows: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 1,
    },
    1024: {
      slidesPerView: 4,
    },
  },
  loop: true,
});



