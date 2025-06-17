jQuery(document).ready(function ($) {
  // Do some fancy stuff.

  // masonry
  $('.region-content-bottom').masonry({
    itemSelector: '.block',
    gutter: 15
  });


  // carousel
  var carouselWidth = $(".carousel-inner")[0].scrollWidth;
  var cardWidth = $(".carousel-item").width();
  var scrollPosition = 0;

  $(".carousel-control-next").on("click", function () {
    if (scrollPosition < (carouselWidth - cardWidth * 4)) { //check if you can go any further
      scrollPosition += cardWidth * 3;  //update scroll position
      $(".carousel-inner").animate({ scrollLeft: scrollPosition },600); //scroll left
    }
  });

  $(".carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth * 3;
      $(".carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });

  if($("#multiItemCarousel").length){
    var multipleCardCarousel = document.querySelector(
      "#multiItemCarousel"
    );
    if (window.matchMedia("(min-width: 768px)").matches) {
      var carousel = new bootstrap.Carousel(multipleCardCarousel, {
        interval: false,
        wrap: false,
      });
    } else {
      $(multipleCardCarousel).addClass("slide");
    }

  }

});
