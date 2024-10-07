intFunc = function () {
  jQuery(".meet-our-team-bht__slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    infinite: false,
    swipe: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          swipe: true,
        },
      }]
  });
};
if (window.acf) {
  acf.addAction("render_block_preview/type=banner-bht", intFunc);
} else {
  intFunc();
}