intFunc = function () {
  jQuery(".banner-bht.slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: true,
    arrows: false,
    infinite: false,
    swipe: true,

  });
};
if (window.acf) {
  acf.addAction("render_block_preview/type=banner-bht", intFunc);
} else {
  intFunc();
}