/******/ (() => { // webpackBootstrap
/*!********************************************!*\
  !*** ./src/block-similar-products/view.js ***!
  \********************************************/
$(document).ready(function () {
  $('.similar-games-list').slick({
    dots: false,
    infinite: false,
    speed: 800,
    slidesToShow: 6,
    slidesToScroll: 6,
    prevArrow: '<button type="button" class="slick-prev"><</button>',
    nextArrow: '<button type="button" class="slick-next">></button>',
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    }, {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }, {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
    ]
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