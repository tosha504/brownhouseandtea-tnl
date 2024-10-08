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
  $title_for_chekout_page = !empty(get_field('title_for_chekout_page', 'options')) ? "<h1>" . get_field('title_for_chekout_page', 'options') . "</h1>" : "";
  $link_chekout = get_field('link', 'options');
  $dsplay_link_chekout = '';
  if ($link_chekout) {
    $link_url = $link_chekout['url'];
    $link_title = $link_chekout['title'];
    $link_target = $link_chekout['target'] ? $link_chekout['target'] : '_self';

    $dsplay_link_chekout .= '<div class="checkout-banner__btn" ><a href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '">' .  esc_html($link_title) . '</a></div>';
  }

  echo '<div class="container">';
  echo '<div class="checkout-banner">' . $title_for_chekout_page . $dsplay_link_chekout . '</div>';
}, 1);

add_action('woocommerce_after_checkout_form', function () {
  echo '</div>';
}, 1);



// add_action('woocommerce_checkout_before_order_review', 'woocommerce_checkout_payment', 20);

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('custom_payment_position', 'woocommerce_checkout_payment', 20);
add_filter('woocommerce_checkout_fields', 'remove_billing_address_2');

function remove_billing_address_2($fields)
{
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_state']);
  return $fields;
}
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
add_action('woocommerce_single_product_summary', function () {
  global $product;
  echo '<div class="woocommerce-single-price"><span class="price">' . $product->get_price_html() . '</span></div>';
}, 20);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
// remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'product_featured_bht');



add_action('woocommerce_after_checkout_form', 'product_featured_bht_checkout');

function product_featured_bht()
{
  $upsell_ids = get_post_meta(get_the_ID(), '_upsell_ids', true);
  if (empty($upsell_ids)) {
    return []; // Return an empty array if there are no upsell products
  } ?>
  <section class="product-featured-bht">
    <div class="container">
      <div class="product-featured-bht__title">
        <h4 style="font-size: clamp(40px, 3vw, 60px);text-align: center;">Podobne produkty</h4>
      </div>
      <?php

      $args = array(
        'post_type' => ['product', 'product_variation'],
        'posts_per_page' => 8,
        'post__in' => $upsell_ids, // Use the upsell IDs in the query
        // 'post_status'    => 'publish', // Only show published products
        'orderby'        => 'title',   // Optional: order by title (you can change this)
        'order'          => 'ASC',
      );

      $loop = new WP_Query($args);

      if ($loop->have_posts()) { ?>
        <ul class="product-featured-bht__slider">
          <?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <li class="product">
              <a href="<?php echo get_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <div class="thumbnail-wrap">
                  <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="  <?php echo get_post(get_post_thumbnail_id())->post_title; ?>" loading="lazy">
                </div>
                <?php bbloomer_show_sale_percentage_loop() ?>
                <h5 class="woocommerce-loop-product__title"><?php echo  get_the_title(); ?></h5>
                <span class="price">
                  <?php $_product = wc_get_product(get_the_ID());
                  echo $_product->get_price_html(); ?>
                </span>
              </a>
            </li>
          <?php
          endwhile;
          ?>

        </ul>
      <?php
        wp_reset_postdata();
      } else {
        echo __('No products found', 'bht-tnl');
      }

      ?>
    </div>

  </section>
<?php }


function product_featured_bht_checkout()
{
?>
  <section class="product-featured-bht">
    <div class="container">
      <div class="product-featured-bht__title">
        <h4 style="font-size: clamp(40px, 3vw, 60px);text-align: center;">Podobne produkty</h4>
      </div>
      <?php

      $args = array(
        'post_type' => 'product',
        'posts_per_page' => 8,
        'tax_query' => array(
          array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN',
          ),
        ),
      );

      $loop = new WP_Query($args);

      if ($loop->have_posts()) { ?>
        <ul class="product-featured-bht__slider">
          <?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <li class="product">
              <a href="<?php echo get_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <div class="thumbnail-wrap">
                  <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="  <?php echo get_post(get_post_thumbnail_id())->post_title; ?>" loading="lazy">
                </div>
                <?php bbloomer_show_sale_percentage_loop() ?>
                <h5 class="woocommerce-loop-product__title"><?php echo  get_the_title(); ?></h5>
                <span class="price">
                  <?php $_product = wc_get_product(get_the_ID());
                  echo $_product->get_price_html(); ?>
                </span>
              </a>
            </li>
          <?php
          endwhile;
          ?>

        </ul>
      <?php
        wp_reset_postdata();
      } else {
        echo __('No products found', 'bht-tnl');
      }

      ?>
    </div>

  </section>
<?php }

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

// add_action('woocommerce_single_product_summary', 'reassuring_items_', 26);
function reassuring_items_()
{
  if (wc_get_product(get_the_id())->get_type() !== 'simple') {
    echo '<p>Wybierz opcję:</p>';
  }
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
  if ($max_percentage > 0 && $product->get_availability()['class'] == 'in-stock') echo "<span class='custom-onsale'>-" . round($max_percentage) . "%</span>";
}

add_filter('woocommerce_sale_flash', '__return_null');

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
}, 11);

add_action('wp_footer', 'cart_update_qty_script');
function cart_update_qty_script()
{
  if (is_checkout()) :
  ?>
    <script>
      let timeout;
      jQuery('.checkout.woocommerce-checkout').on('change', 'input.qty', function() {
        if (timeout !== undefined) {
          clearTimeout(timeout);
        }
        timeout = setTimeout(function() {
          jQuery('.cart-qty.plus, .minus').attr('disabled', true) // trigger cart update



        }, 100); // 1 second delay, half a second (500) seems comfortable too
        // jQuery(document.body).trigger('wc_fragment_refresh');
        setTimeout(function() {
          jQuery(document.body).trigger('wc_fragment_refresh'); // Refresh the cart fragments

        }, 1000);
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
    $min_amount = get_free_shipping_amount_for_zone() - WC()->cart->get_displayed_subtotal() <= 0 ?   0 : get_free_shipping_amount_for_zone() - WC()->cart->get_displayed_subtotal();
    $min_amount = wc_price($min_amount);
    echo "Brakuje Ci jeszcze " . $min_amount . " aby cieszyć się <b>darmową wysyłką!</b>"; ?>
  </div>
<?php
  $fragments['div.free-shippinge'] = ob_get_clean();

  return $fragments;
}

// add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment2', 1);

function woocommerce_header_add_to_cart_fragment2($fragments)
{
  ob_start();  ?>
  <div>
    <?php
    $min_amount = get_free_shipping_amount_for_zone() - WC()->cart->cart_contents_total <= 0 ?   0 : get_free_shipping_amount_for_zone() - WC()->cart->cart_contents_total;
    // var_dump(get_free_shipping_amount_for_zone() - WC()->cart->get_cart_subtotal());
    $min_amount = wc_price($min_amount);
    echo "Brakuje Ci jeszcze " . $min_amount . " aby cieszyć się <b>darmową wysyłką!</b>";
    ?>
  </div>
  <?php
  $fragments['div.free-shippinge1'] = ob_get_clean();

  return $fragments;
}

add_filter('woocommerce_available_variation', function ($data, $product, $variation) {
  if (!$variation->is_in_stock()) {
    $data['is_purchasable'] = false;
    $data['is_in_stock'] = false;
  }
  return $data;
}, 10, 3);;


add_action('woocommerce_variation_options_pricing', 'bbloomer_add_custom_field_to_variations', 10, 3);

function bbloomer_add_custom_field_to_variations($loop, $variation_data, $variation)
{
  echo '<div class="custom-text-input-wrapper">'; // Open your custom div
  woocommerce_wp_text_input(array(
    'id' => 'gtin_variable[' . $loop . ']',
    'class' => 'short',
    'label' => __('Cena za porcje', 'woocommerce'),
    'value' => get_post_meta($variation->ID, 'price_per_serving', true)
  ));
  echo '</div>'; // Close your custom div
}

// -----------------------------------------
// 2. Save custom field on product variation save

add_action('woocommerce_save_product_variation', 'bbloomer_save_custom_field_variations', 10, 2);

function bbloomer_save_custom_field_variations($variation_id, $i)
{
  $custom_field = $_POST['gtin_variable'][$i];
  //    if ( isset( $custom_field ) ) {
  //    update_post_meta( $variation_id, 'var_gtin', esc_attr( $custom_field ) );
  $variation = wc_get_product($variation_id);

  if ($variation) {
    $variation->update_meta_data('price_per_serving', $custom_field);
    $variation->save();
  }
  //    }
}

// add_action('woocommerce_single_variation', 'bbloomer_display_custom_field_on_product_page', 20);

function bbloomer_display_custom_field_on_product_page()
{
  global $product;

  if ($product->is_type('variable')) {
  ?>
    <div class="price-per-serving-wrapper">
      <span id="price_per_serving_label"><?php _e('Price per Serving:', 'woocommerce'); ?></span>
      <span id="price_per_serving_value"></span>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        // When the variation is selected, this event is triggered
        $('form.variations_form').on('show_variation', function(event, variation) {
          if (variation.price_per_serving) {


            $('#price_per_serving_value').text(variation.price_per_serving);
          } else {
            $('#price_per_serving_value').text('<?php _e('N/A', 'woocommerce'); ?>');
          }
        });

        // When no variation is selected or reset
        $('form.variations_form').on('reset_data', function() {
          $('#price_per_serving_value').text('');
        });
      });
    </script>
<?php
  }
}
add_filter('woocommerce_available_variation', 'bbloomer_add_custom_field_to_variation_data');

function cw_change_product_price_display($price)
{
  global $product;
  // Ensure $product is set and is a WC_Product object
  if ($product && $product instanceof WC_Product) {
    // Check if it's a variable product and we're on a single product page
    if ($product->is_type('variable') && is_product()) {
      $price .=
        '<div class="price-per-serving-wrapper">
              <span id="price_per_serving_label">' . __("Cena za porcje:", "woocommerce") . '</span>
              <span id="price_per_serving_value"></span>  ' . get_woocommerce_currency_symbol() . '
          </div>';
    }
  }

  return $price;
}
add_filter('woocommerce_get_price_html', 'cw_change_product_price_display', 10, 1);

function bbloomer_add_custom_field_to_variation_data($variation_data)
{
  $price_per_serving = get_post_meta($variation_data['variation_id'], 'price_per_serving', true);
  $variation_data['price_per_serving'] = $price_per_serving ? esc_attr($price_per_serving) : '';

  return $variation_data;
}
