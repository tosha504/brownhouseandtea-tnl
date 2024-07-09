intFunc = function () {
  jQuery(".isnspirations-bht__items.slider").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    infinite: false,
    swipe: true,
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 3,
          dots: true,
          arrows: false,
        },
      }, {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          swipe: true,
          dots: true,
          arrows: false,
        },
      }, {
        breakpoint: 475,
        settings: {
          slidesToShow: 1,
          swipe: true,
          dots: true,
          arrows: false,
        },
      }]
  });
};
if (window.acf) {
  acf.addAction("render_block_preview/type=isnspirations-bht", intFunc);
} else {
  intFunc();
}