jQuery(document).ready(function () {
  console.log('ready');
  const burger = jQuery(".burger"),
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
    e.preventDefault()
    seachFormPopup.addClass('active')
    body.addClass("fixed-page");
  })

  closeSeachForm.on('click', function (e) {
    e.preventDefault()
    seachFormPopup.removeClass('active')
    body.removeClass("fixed-page");
  })

  jQuery('.variations_form').on('submit', function (e) {
    e.preventDefault();
    var form = jQuery(this);
    var variation_id = form.find('select[name="product_variation"]').val();
    var product_id = form.find('input[name="product_id"]').val();

    var data = {
      action: 'woocommerce_ajax_add_to_cart',
      product_id: product_id,
      variation_id: variation_id,
    };

    jQuery.ajax({
      type: 'post',
      url: wc_add_to_cart_params.ajax_url,
      data: data,
      success: function (response) {
        if (response.error & response.product_url) {
          window.location = response.product_url;
          return;
        }
        // Trigger event so the page updates
        jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, form]);
      },
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
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  if (getCookie('ageVerification') !== 'submited') {
    jQuery('.age-verefication').css('display', 'block')
  }
  jQuery('div.woocommerce').on('change', 'input.qty', function () {

  });

  jQuery(window).on('click', function (e) {
    if (body.hasClass('single-product')) {
      console.log(body.hasClass('single-product'));
      if (jQuery(e.target).attr('class') === 'backorder-button') {
        alert('You are now on the waitlist for this product!');
      }
    }
  })


  jQuery(".product-featured-bht__slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: true,
    arrows: false,
    infinite: false,
    swipe: true,
    responsive: [
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });

  jQuery(window).on("load", function () {


    jQuery(".flex-control-nav.flex-control-thumbs").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      infinite: false,
      swipe: true,
    });

  })
    .on('click', function () {
      jQuery('.woocommerce-product-gallery__image.flex-active-slide img').css({ 'height': jQuery('.woocommerce-product-gallery__image.flex-active-slide img').innerWidth(), "border-radius": "20px" })
    })

  //shop-page
  jQuery('.overlay').on('click', function (e) {
    if (sidebar.hasClass('active')) {
      sidebar.removeClass('active')
      jQuery(this).removeClass('active')
    }

  })


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
    })
  });

  //shop-page
  jQuery('.filter-call').on('click', function (e) {
    e.preventDefault()
    sidebar.addClass('active')
    jQuery('.overlay').addClass('active')
  })
  jQuery('#close-aside-button').on('click', function (e) {
    e.preventDefault()
    sidebar.removeClass('active')
    jQuery('.overlay').removeClass('active')
  })

  if (jQuery(window).width() < 990) {
    jQuery('.woocommerce-LoopProduct-link.woocommerce-loop-product__link').on('click', function (e) {
      e.preventDefault()
      const siblingsChildren = jQuery(this).parent().siblings().children('.add-to-cart-wrap ,.add-to-cart-wrap-single');
      const curerentChildren = jQuery(this).parent().children('.add-to-cart-wrap ,.add-to-cart-wrap-single');
      if (siblingsChildren.hasClass('active')) {
        siblingsChildren.removeClass('active')
      }
      console.log(curerentChildren.hasClass('active'));
      if (curerentChildren.hasClass('active')) {
        curerentChildren.removeClass('active');
      } else {
        curerentChildren.addClass('active');
      }
    })
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
    jQuery('.toggler-variation').click(function (e) {
      e.preventDefault();
      var parent = jQuery(this).parent();
      jQuery(this).toggleClass('active');
      jQuery(parent).find('ul').toggleClass('active');
    });

    jQuery('.select-variation ul li').click(function (e) {
      e.preventDefault();
      var btn = jQuery(this).parent().parent().find('.add_to_cart_button'),
        btn_stock = jQuery(this).parent().parent().find('.loop-not-stock'),
        parent = jQuery(this).parent(),
        parent_parent = jQuery(this).parent().parent(),
        id = jQuery(this).attr('data-id'),
        price = jQuery(this).attr('data-price'),
        stock = jQuery(this).parent().parent().parent().find('.stock-label-loop');
      console.log(price);
      btn.closest('.product.type-product').find('a.woocommerce-LoopProduct-link.woocommerce-loop-product__link div.thumbnail-wrap img').attr('srcset', jQuery(this).attr('image-url-data'));
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

      if (jQuery(this).attr('sale') == 'yes') {
        jQuery(btn).addClass('promotion-btn');
      } else {
        jQuery(btn).removeClass('promotion-btn');
      }

      jQuery(btn).attr('data-product_id', id).attr('href', '/?add-to-cart=' + id);
      jQuery(btn).find('.price-variation').text(price);
      jQuery(parent_parent).find('.price-variation-toggler').text(jQuery(this).text());
      jQuery(parent).toggleClass('active');
      jQuery(parent_parent).find('.toggler-variation').toggleClass('active');
    });
  }


  //single-page woo
  jQuery(document).on("click", '.cart-qty.plus, .cart-qty.minus', function (e) {
    e.preventDefault();
    const input = jQuery(this).parent().find('.input-text.qty.text');
    const input_val = parseInt(input.val());
    if (jQuery(this).hasClass('plus')) {
      input.val(input_val + 1);
      input.attr('value', input_val + 1)
    }
    else {
      const new_val = input_val - 1;
      if (new_val > 0) {
        input.val(input_val - 1);
        input.attr('value', input_val - 1)
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
      jQuery(this).parent().siblings().children('.question').children('button').removeClass('active')
      jQuery(this).parent().siblings().children('div.answer').slideUp(200);
    }
    jQuery(this).children('button').toggleClass('active')
    jQuery(this).siblings('div.answer').slideToggle(200)
  })

});
