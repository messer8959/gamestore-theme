$( document ).ready(function() {
	$('.slider-wrapper').slick({
    autoplay: false,
  	dots: false, 
    fade:true, 
    speed: 1000,
    autoplaySpeed: 500,  
    infinite: true,  
    slidesToShow: 1,
    pauseOnHover: false,
    pauseOnFocus: false,   
    slidesToScroll: 1,  
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><</button>',
    nextArrow: '<button type="button" class="slick-next">></button>',
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
   
	
});