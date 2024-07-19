jQuery(function (jQuery) {
  jQuery("form.checkout").on("change", ".input-text.qty.text", function (e) {
    var data = {
      action: 'update_order_review',
      security: wc_checkout_params.update_order_review_nonce,
      post_data: jQuery('form.checkout').serialize()
    };


    jQuery.post(add_quantity.ajax_url, data, function (response) {
      jQuery(document.body).trigger('update_checkout');
    });
  });
});