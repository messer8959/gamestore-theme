
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

$( document ).ready(function() {
	$('.slider-wrapper').slick({
    autoplay: true,
  	dots: false,  
    speed: 1000,
    autoplaySpeed: 500,  
    infinite: true,  
    slidesToShow: 7,  
    slidesToScroll: 1,  
    arrows: false,  
    touchThreshold:300,
    centerMode: true,
    // variableWidth: true,  
    responsive: [    
    	{
      	// tablet      
      	breakpoint: 991,      
      	settings: {        
        slidesToShow: 4      
       }
     },    
       {      
       	// mobile portrait      
       	breakpoint: 479,      
       	settings: {        
       	slidesToShow: 3      
       	}    
       }  
   ]});
   
	$('.slider-prev').click(function(){
		$(this).closest('.section').find(".list").slick('slickPrev');
	});

	$('.slider-next').click(function(){
		$(this).closest('.section').find(".list").slick('slickNext');
  });
});

