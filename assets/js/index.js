/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (() => {

jQuery(document).ready(function () {
  console.log('ready');
  var burger = jQuery(".burger"),
    burgerSpan = jQuery(".burger span"),
    nav = jQuery('.header__nav'),
    body = jQuery('body'),
    sidebar = jQuery('.custom-sidebar-shop'),
    searchBar = jQuery('#header-nav-search li a'),
    seachFormPopup = jQuery('.search-form-tnl'),
    closeSeachForm = jQuery('#closeSeachForm');
  burger.on("click", function () {
    burgerSpan.toggleClass("active");
    nav.toggleClass("active");
    body.toggleClass("fixed-page");
  });
  searchBar.on('click', function (e) {
    e.preventDefault();
    seachFormPopup.addClass('active');
    body.addClass("fixed-page");
  });
  closeSeachForm.on('click', function (e) {
    e.preventDefault();
    seachFormPopup.removeClass('active');
    body.removeClass("fixed-page");
  });
  jQuery('.variations_form').on('submit', function (e) {
    e.preventDefault();
    var form = jQuery(this);
    var variation_id = form.find('select[name="product_variation"]').val();
    var product_id = form.find('input[name="product_id"]').val();
    var data = {
      action: 'woocommerce_ajax_add_to_cart',
      product_id: product_id,
      variation_id: variation_id
    };
    jQuery.ajax({
      type: 'post',
      url: wc_add_to_cart_params.ajax_url,
      data: data,
      success: function success(response) {
        if (response.error & response.product_url) {
          window.location = response.product_url;
          return;
        }
        // Trigger event so the page updates
        jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, form]);
      }
    });
  });
  if (body.hasClass('home')) {
    jQuery(window).scroll(function () {
      var scrollTop = jQuery(window).scrollTop();
      if (scrollTop > 40) {
        jQuery(".header").css({
          "background": "var(--white)",
          "box-shadow": "0 4px 12px -4px rgba(66, 68, 90, 0.2)"
        });
      } else {
        jQuery(".header").css({
          "background": "#ffffff50",
          "box-shadow": "none"
        });
      }
    });
  }
  setTimeout(function () {
    if (getCookie('popupCookie') != 'submited') {
      jQuery('.cookies').css("display", "block").hide().fadeIn(2000);
    }
    jQuery('a.submit').click(function () {
      jQuery('.cookies').fadeOut();
      //sets the coookie to five minutes if the popup is submited (whole numbers = days)
      setCookie('popupCookie', 'submited', 7);
    });
  }, 5000);
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  if (getCookie('ageVerification') !== 'submited') {
    jQuery('.age-verefication').css('display', 'block');
  }
  jQuery('div.woocommerce').on('change', 'input.qty', function () {});
  function mobNavMenu() {
    jQuery(".menu-item-has-children").on("click", function (e) {
      jQuery(jQuery(this)).children("ul .sub-menu").slideToggle(500);
      if (jQuery(jQuery(this)).siblings().children("ul .sub-menu").css("display") == "block") {
        jQuery(jQuery(this)).siblings().children("ul .sub-menu").slideUp(500);
      }
      if (!jQuery(this).hasClass("active")) {
        jQuery(this).toggleClass("active");
        jQuery(this).siblings('.menu-item-has-children.active').toggleClass("active");
      } else {
        jQuery(this).removeClass("active");
      }
    });
  }
  if (jQuery(window).width() < 1200) {
    mobNavMenu();
  }
  jQuery(".product-featured-bht__slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    arrows: false,
    infinite: false,
    swipe: true,
    responsive: [{
      breakpoint: 769,
      settings: {
        slidesToShow: 2
      }
    }, {
      breakpoint: 576,
      settings: {
        slidesToShow: 1
      }
    }]
  });
  jQuery(window).on("load", function () {
    jQuery("form.variations_form").on("show_variation", function (event, variation) {
      if (variation.price_per_serving) {
        jQuery("#price_per_serving_value").text(variation.price_per_serving);
      } else {
        jQuery(".price-per-serving-wrapper").hide();
      }
    });

    // When no variation is selected or reset
    jQuery("form.variations_form").on("reset_data", function () {
      jQuery("#price_per_serving_value").text("");
    });
    if (jQuery('.flex-control-nav.flex-control-thumbs li').length > 3) {
      jQuery(".flex-control-nav.flex-control-thumbs").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        infinite: false,
        swipe: true
      }).css('display', 'block');
    }
  }).on('click', function () {
    jQuery('.woocommerce-product-gallery__image.flex-active-slide img').css({
      'height': jQuery('.woocommerce-product-gallery__image.flex-active-slide img').innerWidth(),
      "border-radius": "20px"
    });
  });
  jQuery('#checkout_apply_coupon').click(function (ev) {
    ev.preventDefault();
    var code = jQuery('#checkout_coupon_code').val();
    var data = {
      action: 'ajaxapplucoupon',
      coupon_code: code
    };
    jQuery.post(wc_checkout_params.ajax_url, data, function (returned_data) {
      if (returned_data.result == 'error') {
        alert('error');
        jQuery('p.resoult-coupon').html(returned_data.message);
      } else {
        setTimeout(function () {
          jQuery(document.body).trigger('update_checkout');
        }, 500);
        console.log(returned_data + code);
      }
    });
  });

  //shop-page
  jQuery('.overlay').on('click', function (e) {
    if (sidebar.hasClass('active')) {
      sidebar.removeClass('active');
      jQuery(this).removeClass('active');
      body.removeClass("fixed-page");
    }
  });

  //shop-page
  jQuery('.filter-call').on('click', function (e) {
    e.preventDefault();
    body.addClass("fixed-page");
    sidebar.addClass('active');
    jQuery('.overlay').addClass('active');
  });
  jQuery('#close-aside-button').on('click', function (e) {
    e.preventDefault();
    sidebar.removeClass('active');
    body.removeClass("fixed-page");
    jQuery('.overlay').removeClass('active');
  });
  if (jQuery(window).width() < 990) {
    jQuery('.products .woocommerce-LoopProduct-link.woocommerce-loop-product__link').on('click', function (e) {
      e.preventDefault();
      var siblingsChildren = jQuery(this).parent().siblings().children('.add-to-cart-wrap ,.add-to-cart-wrap-single');
      var curerentChildren = jQuery(this).parent().children('.add-to-cart-wrap ,.add-to-cart-wrap-single');
      if (siblingsChildren.hasClass('active')) {
        siblingsChildren.removeClass('active');
      }
      if (curerentChildren.hasClass('active')) {
        curerentChildren.removeClass('active');
      } else {
        curerentChildren.addClass('active');
      }
    });
  }
  jQuery('.variations_form').on('show_variation', function (event, variation) {
    jQuery(".backorder-button").remove();
    if (!variation.is_in_stock && !variation.is_purchasable) {
      jQuery('.single_add_to_cart_button').hide();
      jQuery('.quantity').hide();

      // Optionally, add a custom button
      // jQuery('<button type="button" class="backorder-button">Powiadom o dostępności</button>')
      //   .insertAfter('.single_variation_wrap');
    } else {
      // Ensure that add to cart button and quantity input are visible if in stock
      jQuery('.single_add_to_cart_button').show();
      jQuery('.quantity').show();
    }
  });
  jQuery('.variations_form').on('hide_variation', function () {
    // Reset visibility when no variation is selected
    jQuery('.single_add_to_cart_button').show();
    jQuery('.quantity').show();
    jQuery(".backorder-button").remove();
  });
  loop_select_variable();
  function loop_select_variable() {
    // Handle toggling variation
    body.on('click', '.toggler-variation', function (e) {
      e.preventDefault();
      var parent = jQuery(this).parent();
      jQuery(this).toggleClass('active');
      jQuery(parent).find('ul').toggleClass('active');
    });

    // Handle selecting a variation
    body.on('click', '.select-variation ul li', function (e) {
      e.preventDefault();
      var btn = jQuery(this).closest('.select-variation').find('.add_to_cart_button'),
        btn_stock = jQuery(this).closest('.select-variation').find('.loop-not-stock'),
        parent = jQuery(this).parent(),
        parent_parent = jQuery(this).closest('.select-variation'),
        id = jQuery(this).attr('data-id'),
        price = jQuery(this).attr('data-price'),
        stock = jQuery(this).closest('.product').find('.stock-label-loop');
      console.log(price);

      // Update product image
      btn.closest('.product.type-product').find('a.woocommerce-LoopProduct-link.woocommerce-loop-product__link div.thumbnail-wrap img').attr('srcset', jQuery(this).attr('image-url-data'));

      // Handle stock availability
      if (jQuery(this).attr('stock-data') == 'in-stock') {
        jQuery(btn_stock).css('display', 'none');
        jQuery(btn).css('display', 'flex');
        jQuery(stock).css('display', 'none');
      } else {
        var href_stock = jQuery(this).attr('href-data');
        jQuery(btn).css('display', 'none');
        jQuery(btn_stock).attr('href', href_stock + "&outofstock");
        jQuery(btn_stock).css('display', 'block');
        jQuery(stock).css('display', 'block');
      }

      // Handle sale promotion
      if (jQuery(this).attr('sale') == 'yes') {
        jQuery(btn).addClass('promotion-btn');
      } else {
        jQuery(btn).removeClass('promotion-btn');
      }

      // Update button and variation details
      jQuery(btn).attr('data-product_id', id).attr('href', '/?add-to-cart=' + id);
      jQuery(btn).find('.price-variation').text(price);
      jQuery(parent_parent).find('.price-variation-toggler').text(jQuery(this).text());

      // Close dropdown after selection
      jQuery(parent).toggleClass('active');
      jQuery(parent_parent).find('.toggler-variation').toggleClass('active');
    });
  }

  //single-page woo
  jQuery(document).on("click", '.cart-qty.plus, .cart-qty.minus', function (e) {
    e.preventDefault();
    var input = jQuery(this).parent().find('.input-text.qty.text');
    var input_val = parseInt(input.val());
    if (jQuery(this).hasClass('plus')) {
      input.val(input_val + 1);
      input.attr('value', input_val + 1);
    } else {
      var new_val = input_val - 1;
      if (new_val > 0) {
        input.val(input_val - 1);
        input.attr('value', input_val - 1);
      }
    }
    input.trigger("change");
  });
  jQuery('.cart-link').click(function (e) {
    e.preventDefault();
    jQuery('body').toggleClass('xoo-wsc-cart-active');
    jQuery('.xoo-wsc-modal').toggleClass('xoo-wsc-cart-active');
  });
  jQuery(document).on('click', '.question', function (e) {
    console.log(jQuery(this).parent().siblings().children('div.answer').is(':visible'));
    if (jQuery(this).parent().siblings().children('div.answer').is(':visible')) {
      jQuery(this).parent().siblings().children('.question').children('button').removeClass('active');
      jQuery(this).parent().siblings().children('div.answer').slideUp(200);
    }
    jQuery(this).children('button').toggleClass('active');
    jQuery(this).siblings('div.answer').slideToggle(200);
  });
});

/***/ }),

/***/ "./gutenberg-styles/meet-our-team-bht.scss":
/*!*************************************************!*\
  !*** ./gutenberg-styles/meet-our-team-bht.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/product-featured-bht.scss":
/*!****************************************************!*\
  !*** ./gutenberg-styles/product-featured-bht.scss ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/quiz-bht.scss":
/*!****************************************!*\
  !*** ./gutenberg-styles/quiz-bht.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/refill-bht.scss":
/*!******************************************!*\
  !*** ./gutenberg-styles/refill-bht.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/tea-best-bht.scss":
/*!********************************************!*\
  !*** ./gutenberg-styles/tea-best-bht.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/tiles-bht.scss":
/*!*****************************************!*\
  !*** ./gutenberg-styles/tiles-bht.scss ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/title-banner-page-bht.scss":
/*!*****************************************************!*\
  !*** ./gutenberg-styles/title-banner-page-bht.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./sass/index.scss":
/*!*************************!*\
  !*** ./sass/index.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/banner-bht.scss":
/*!******************************************!*\
  !*** ./gutenberg-styles/banner-bht.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/image-content-bht.scss":
/*!*************************************************!*\
  !*** ./gutenberg-styles/image-content-bht.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/inspirations-bht.scss":
/*!************************************************!*\
  !*** ./gutenberg-styles/inspirations-bht.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/isnspirations-bht.scss":
/*!*************************************************!*\
  !*** ./gutenberg-styles/isnspirations-bht.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/marquee-bht.scss":
/*!*******************************************!*\
  !*** ./gutenberg-styles/marquee-bht.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/index": 0,
/******/ 			"css-blocks/marquee-bht": 0,
/******/ 			"css-blocks/isnspirations-bht": 0,
/******/ 			"css-blocks/inspirations-bht": 0,
/******/ 			"css-blocks/image-content-bht": 0,
/******/ 			"css-blocks/banner-bht": 0,
/******/ 			"src/index": 0,
/******/ 			"css-blocks/title-banner-page-bht": 0,
/******/ 			"css-blocks/tiles-bht": 0,
/******/ 			"css-blocks/tea-best-bht": 0,
/******/ 			"css-blocks/refill-bht": 0,
/******/ 			"css-blocks/quiz-bht": 0,
/******/ 			"css-blocks/product-featured-bht": 0,
/******/ 			"css-blocks/meet-our-team-bht": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/banner-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/image-content-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/inspirations-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/isnspirations-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/marquee-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/meet-our-team-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/product-featured-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/quiz-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/refill-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/tea-best-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/tiles-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./gutenberg-styles/title-banner-page-bht.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css-blocks/marquee-bht","css-blocks/isnspirations-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/title-banner-page-bht","css-blocks/tiles-bht","css-blocks/tea-best-bht","css-blocks/refill-bht","css-blocks/quiz-bht","css-blocks/product-featured-bht","css-blocks/meet-our-team-bht"], () => (__webpack_require__("./sass/index.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;