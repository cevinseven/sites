$(document).ready(function () {
  var $flex = $('.flexslider');

  $flex.flexslider({
    slideshow: true,
    animation: 'slide',
    directionNav: true,
    controlNav: false,
    slideshowSpeed: 4000,
    animationSpeed: 1000,
    pauseOnHover: true,
    after: function () {
      $('.slide-nav li')
        .removeClass('active')
        .eq( $flex.data('flexslider').currentSlide )
        .addClass('active');
    }
});

  $('.slide-nav').delegate('li', 'click', function() {

    var slide = {
      target: $(this).index(),
      current: $flex.data('flexslider').currentSlide
    }

    if ( $flex.data('flexslider').animating === false){
      if (slide.target !== slide.current) {
        $('.slide-nav li')
          .removeClass('active')
          .eq(slide.target)
          .addClass('active');
        $flex.data('flexslider').flexAnimate(slide.target);
      }
    }
  });
});