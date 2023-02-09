var swiper = new Swiper(".home-slider", {
    grabCursor:true,
    loop:true,
    centeredSlides:true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
 });

 var swiper = new Swiper(".cate-slider", {
  loop:true,
  spaceBetween: 15,
  grabCursor:true,
  centeredSlides: true,
  breakpoints: {
    0: {
      slidesPerView: 2.5,
    },
    768: {
      slidesPerView: 3,
    },
    991: {
      slidesPerView: 5,
    },
  },
});

var swiper = new Swiper(".products-slider", {
  spaceBetween: 10,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    renderBullet: function (index, className) {
      return '<span class="' + className + '">' + (index + 1) + "</span>";
    },
  },

  breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 3.7,
        },
      },
});


 