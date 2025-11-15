/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./src/block-games-line/view.js ***!
  \**************************************/
$(document).ready(function () {
  $('.games-wrapper').slick({
    autoplay: true,
    dots: false,
    speed: 1000,
    autoplaySpeed: 1000,
    infinite: true,
    pauseOnHover: false,
    pauseOnFocus: false,
    slidesToShow: 6,
    slidesToScroll: 1,
    arrows: false,
    touchThreshold: 300,
    centerMode: true,
    // variableWidth: true,
    easing: 'linear',
    responsive: [{
      // tablet      
      breakpoint: 991,
      settings: {
        slidesToShow: 4
      }
    }, {
      // mobile portrait      
      breakpoint: 479,
      settings: {
        slidesToShow: 3
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