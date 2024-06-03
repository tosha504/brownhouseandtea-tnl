intFunc = function () {
  jQuery(".best-bht__left_slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    infinite: false,
    swipe: true,
    // pauseOnHover: false,
    // responsive: [
    //   {
    //     breakpoint: 1199,
    //     settings: {
    //       slidesToShow: 1,
    //     },
    //   }, {
    //     breakpoint: 559,
    //     settings: {
    //       slidesToShow: 1,
    //       swipe: true,
    //     },
    //   }]
  });
};
if (window.acf) {
  acf.addAction("render_block_preview/type=tea-best-bht", intFunc);
} else {
  intFunc();
}