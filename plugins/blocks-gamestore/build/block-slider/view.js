/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./src/block-slider/view.js ***!
  \**********************************/
// document.addEventListener('DOMContentLoaded', function () {
//     var swiperHero = new Swiper('.hero-slider .slider-container', {
//         loop: true,
//         autoplay: {
//             delay: 5000,
//             disableOnInteraction: false,
//         },
//         slidesPerView: 'auto',
//         speed: 1500,
//         grabCursor: true,
//         mousewheelControl: true,
//         keyboardControl: true,
//     });
// });

$(document).ready(function () {
  $('.slider-wrapper2').slick({
    arrows: false,
    dots: false,
    centerMode: true,
    centerPadding: '60px',
    speed: 900,
    autoplaySpeed: 1500,
    slidesToShow: 5,
    autoplay: true,
    pauseOnFocus: false,
    pauseOnHover: false,
    variableWidth: true,
    responsive: [{
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 5
      }
    }, {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }]
  });
  $('.slider-prev').click(function () {
    $(this).closest('.section').find(".list").slick('slickPrev');
  });
  $('.slider-next').click(function () {
    $(this).closest('.section').find(".list").slick('slickNext');
  });
});
/******/ })()
;
//# sourceMappingURL=view.js.map