<?php

/**
 * Add WooCommerce support
 *
 * @package bht-tnl
 */
function create_product_custom_taxonomy()
{
  register_taxonomy(
    'collection',  // Taxonomy name
    'product',  // Post type (WooCommerce products are 'product')
    array(
      'label' => __('Collection', 'bht-tnl'),  // Taxonomy label
      'rewrite' => array('slug' => 'collection'),
      'hierarchical' => true,  // True for categories-like, false for tags-like
      'rewrite'           => array('slug' => 'kolekcja'),
    )
  );
}
add_action('init', 'create_product_custom_taxonomy');
// dynamic_sidebar('left-sidebar');
add_action('woocommerce_before_checkout_form', function () {
  echo '<div class="container">';
}, 1);

add_action('woocommerce_after_checkout_form', function () {
  echo '</div>';
}, 1);
add_action('woocommerce_checkout_before_order_review', 'woocommerce_checkout_payment', 20);
add_action('after_setup_theme', 'bht_tnl_add_woocommerce_support', 99);
if (!function_exists('bht_tnl_add_woocommerce_support')) {
  /**
   * Declares WooCommerce theme support.
   */

  function bht_tnl_add_woocommerce_support()
  {
    // add_theme_support('woocommerce');
    add_theme_support('woocommerce');
    // array(
    //   'thumbnail_image_width' => 250,
    //   'single_image_width'    => 170,
    // );
    // Add Product Gallery support.

    // add_theme_support('wc-product-gallery-lightbox');
    // remove_theme_support('wc-product-gallery-zoom');
    // remove_theme_support('wc-product-gallery-lightbox');
    // remove_theme_support('wc-product-gallery-slider');

    // remove_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-slider');
  }
}

//Remove actions bht
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
// Add actions bht
add_action('woocommerce_single_product_summary', 'show_cat_and_attr', 1);
add_action('woocommerce_before_shop_loop', function () { ?>
  <aside class="custom-sidebar-shop">
    <a href="#" id="close-aside-button"><?php _e("Close", 'bht-tnl') ?></a>
    <ul>
      <?php dynamic_sidebar('left-sidebar'); ?>
    </ul>
  </aside>
<?php
}, 40);

add_action('woocommerce_shop_loop_header', function () {
  echo `sdf`;
}, 10);

add_filter('woocommerce_get_image_size_gallery_thumbnail', 'override_woocommerce_image_size_gallery_thumbnail');
function override_woocommerce_image_size_gallery_thumbnail($size)
{
  // Gallery thumbnails: proportional, max width 200px
  return array(
    'width'  => 200,
    'height' => 200,
    'crop'   => 0,
  );
}

function show_cat_and_attr()
{
  $terms = get_the_terms(get_the_ID(), "product_cat");
?>
  <ul class="cat-and-attr">
    <?php if (!is_wp_error($terms)) {
      foreach ($terms as $term) { ?>
        <li><?php echo $term->name; ?></li>
    <?php }
    } ?>
  </ul>
  <?php }

add_action('woocommerce_single_product_summary', 'reassuring_items', 25);
function reassuring_items()
{
  $reassuring = get_field('reassuring', get_the_ID());
  if (!empty($reassuring) && count($reassuring) > 0) { ?>
    <div class="reassuring">
      <?php foreach ($reassuring as $key => $item) {
        if ($item["title"] && $item["description"]) {
      ?>
          <div class="reassuring__wrap">
            <div class="reassuring__wrap-title"><?php echo $item["title"] ?></div>
            <div class="reassuring__wrap-description"><?php echo $item["description"] ?></div>
          </div>
      <?php }
      } ?>
    </div>
  <?php };
}


add_action('woocommerce_before_quantity_input_field', function () {
  echo '<button class="cart-qty minus">-</button>';
});

add_action('woocommerce_after_quantity_input_field', function () {
  echo '<button class="cart-qty plus">+</button>';
});


add_action('woocommerce_before_shop_loop', 'shop_banner');

function shop_banner()
{
  if (is_tax('collection')) {
    $obj_tax = wp_get_object_terms(get_the_ID(), 'collection')[0];
    $bg_shop =  !empty(get_field('image', $obj_tax->taxonomy . '_' . $obj_tax->term_id)) ? 'style="background-image: url(' . wp_get_attachment_url(get_field('image', $obj_tax->taxonomy . '_' . $obj_tax->term_id)) . ');"' : ''; ?>

    <div class="container shop-banner" <?php echo $bg_shop; ?>>
      <?php echo '<h1>' .  $obj_tax->name . '</h1>'; ?>
    </div>
  <?php return;
  }
  $title = get_field('title', 'options');
  $bg_shop =  !empty(get_field('bg_shop', 'options')) ? 'style="background-image: url(' . wp_get_attachment_url(get_field('bg_shop', 'options')) . ');"' : ''; ?>

  <div class="container shop-banner" <?php echo $bg_shop; ?>>
    <?php echo '<h1>' .  $title . '</h1>'; ?>
  </div>
  <?php }


add_action('woocommerce_before_shop_loop_item_title', 'bbloomer_show_sale_percentage_loop', 25);

function bbloomer_show_sale_percentage_loop()
{
  global $product;
  if (!$product->is_on_sale()) return;
  if ($product->is_type('simple')) {
    $max_percentage = (($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100;
  } elseif ($product->is_type('variable')) {
    $max_percentage = 0;
    foreach ($product->get_children() as $child_id) {
      $variation = wc_get_product($child_id);
      $price = $variation->get_regular_price();
      $sale = $variation->get_sale_price();
      if ($price != 0 && !empty($sale)) $percentage = ($price - $sale) / $price * 100;
      if ($percentage > $max_percentage) {
        $max_percentage = $percentage;
      }
    }
  }
  if ($max_percentage > 0) echo "<span class='custom-onsale'>-" . round($max_percentage) . "%</span>";
}

add_filter('woocommerce_sale_flash', '__return_null');


//
// function display_specific_variation_dropdown_on_shop_page()
// {
//   global $product;

//   // Check if the product is a variable product
//   if ($product->is_type('variable')) {
//     // Get the attributes used for variations
//     $attributes = $product->get_variation_attributes();

//     // Loop through each attribute and display a select box
//     foreach ($attributes as $attribute_name => $options) {
//       // Only display if options are available
//       if (!empty($options)) {
//         $cleaned_attribute_name = str_replace('attribute_', '', $attribute_name);
//         echo '<select name="' . esc_attr($attribute_name) . '">';
//         foreach ($options as $option) {
//           // The option value needs to be sanitized to ensure it's safe for output
//           echo '<option value="' . esc_attr($option) . '">' . esc_html(apply_filters('woocommerce_variation_option_name', $option)) . '</option>';
//         }
//         echo '</select>';
//       }
//     }
//   }
// }

// add_action('woocommerce_after_shop_loop_item', 'custom_variation_buttons_on_shop_page', 30);

// function custom_variation_buttons_on_shop_page()
// {
//   global $product;

//   if ($product->is_type('variable')) {
//     $variations = $product->get_available_variations();

//     foreach ($variations as $variation) {
//       $variation_obj = new WC_Product_Variation($variation['variation_id']);

//       // Check if variation is in stock
//       if ($variation_obj->is_in_stock()) {
//         echo sprintf('<a href="%s" class="button add_to_cart_button">Add to Cart</a>', $variation_obj->add_to_cart_url());
//       } else {
//         // Assuming you have a mailto or a link to a contact form
//         echo '<a href="mailto:example@example.com?subject=Product Inquiry: ' . $product->get_title() . '" class="button">Mail to Me</a>';
//       }
//     }
//   }
// }

function check_variation_stock_status()
{
  if (isset($_POST['product_id']) && isset($_POST['variation_id'])) {
    $variation_id = $_POST['variation_id'];
    $variation = new WC_Product_Variation($variation_id);

    if ($variation->is_in_stock()) {
      wp_send_json(['in_stock' => true]);
    } else {
      wp_send_json(['in_stock' => false]);
    }
  }
  wp_die();
}
add_action('wp_ajax_check_variation_stock_status', 'check_variation_stock_status');
add_action('wp_ajax_nopriv_check_variation_stock_status', 'check_variation_stock_status');

add_action('woocommerce_before_shop_loop_item_title', function () {
  echo '<div class="thumbnail-wrap">';
}, 9);
add_action('woocommerce_before_shop_loop_item_title', function () {
  echo '</div>';
}, 11);;



/**
 * Show cart contents / total Ajax
 */

// add_action('woocommerce_update_cart_action_cart_updated', function ($cart_updated) {
//   var_dump($cart_updated);
//   // if ($cart_updated) {
//   //   WC()->session->set('refresh_cart_totals', true);
//   //   WC_AJAX::get_refreshed_fragments();
//   // }
//   // return $cart_updated;
// });

add_action('wp_footer', 'cart_update_qty_script');
function cart_update_qty_script()
{
  if (is_cart()) :
  ?>
    <script>
      let timeout;
      jQuery('.woocommerce').on('change', 'input.qty', function() {
        if (timeout !== undefined) {
          clearTimeout(timeout);
        }
        timeout = setTimeout(function() {
          jQuery("[name='update_cart']").trigger("click"); // trigger cart update
        }, 100); // 1 second delay, half a second (500) seems comfortable too
      });
    </script>
  <?php
  endif;
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');


function woocommerce_header_add_to_cart_fragment($fragments)
{
  global $woocommerce;
  ob_start(); ?>
  <a href="<?php echo wc_get_cart_url(); ?>">
    <span class="count">
      <?php echo sprintf($woocommerce->cart->cart_contents_count); ?>
    </span></a>
  <?php
  $fragments['li.cart-link a'] = ob_get_clean();
  ob_start();  ?>
  <div>
    <?php
    $min_amount = get_free_shipping_amount_for_zone() - WC()->cart->cart_contents_total <= 0 ?   0 : get_free_shipping_amount_for_zone() - WC()->cart->cart_contents_total;

    echo "Brakuje Ci jeszcze <b>" . $min_amount . "zł</b> aby cieszyć się <b>darmową wysyłką!</b>"; ?>
  </div>
<?php
  $fragments['.free-shippinge'] = ob_get_clean();

  return $fragments;
}



add_filter('woocommerce_available_variation', function ($data, $product, $variation) {
  if (!$variation->is_in_stock()) {
    $data['is_purchasable'] = false;
    $data['is_in_stock'] = false;
  }
  return $data;
}, 10, 3);;
