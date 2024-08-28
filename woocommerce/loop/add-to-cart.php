<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
  exit;
}
global $product;
if ($product->get_type() != 'variable') {
  if ($product->get_sale_price()) {
    $saleAttr = 'promotion-btn';
  }

  if ($product->get_availability()['class'] == 'in-stock') {
    echo apply_filters(
      'woocommerce_loop_add_to_cart_link', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      sprintf(
        '<div class="add-to-cart-wrap-single"><div class="single-product-loop"><a href="%s" data-quantity="%s" class="%s %s product_type_%s add_to_cart_button product_type_simple button ajax_add_to_cart d-block %s" %s>%s %s</a></div>',
        esc_url($product->add_to_cart_url()),
        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
        !empty($product->get_sale_price()) ?? $saleAttr,
        esc_attr($product->get_type()),
        $product->get_type() === 'simple' ? 'ajax_add_to_cart' : '',
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        number_format($product->get_price(), 2, ',', ' ') . ' ' . get_woocommerce_currency_symbol() . ' - ',
        esc_html($product->add_to_cart_text())
      ),
      $product,
      $args
    );
  } else {
    echo '<span class="stock-label-loop" style="display: block;">' . __('wracam już 1 kwietnia', 'bht-tnl') . '</span>'; ?>
    <div class="add-to-cart-wrap-single">
      <a href="<?php echo get_permalink($product->get_id()); ?>?outofstock" class="backorder-button loop-not-stock single">Powiadom o dostępności</a>
      <?php
    }
    echo '<a href="' . get_permalink($product->get_id()) . '" class="button">' . __('Dowiedz się więcej', 'bht-tnl') . '</a></div>';
  } else {
    $variation_data = $product->get_variation_attributes();

    if (array_key_exists("pa_opakowanie", $variation_data) && count(array_keys($variation_data)) == 1) {
      $children_ids = $product->get_children();
      if ($children_ids) {
        $start_item = '';
        foreach ($children_ids as $value => $key) {

          if (get_post_meta($key, '_stock_status', true) == 'instock') {
            $start_item = $key;
            $is_available = true;
            break;
          } else {
            $is_available = false;
          }
        }

        if ($start_item) {
          $start_variation = wc_get_product($start_item); ?>
          <div class="add-to-cart-wrap">
            <div class="select-variation">
              <a href="#" class="button toggler-variation" data-id="<?php echo $start_item; ?>">
                <span class="price-variation-toggler"><?php echo str_replace('Opakowanie: ', '', $start_variation->get_attribute_summary()); ?> </span>
                <span class="variation-toggler">
                  <svg version="1.1" id="Warstwa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15 15" style="enable-background:new 0 0 15 15;" xml:space="preserve">
                    <path class="st0" d="M12.1,3.74l-4.35,5.3L2.96,3.7c-0.2-0.22-0.48-0.34-0.77-0.34H0.11L0.08,3.38L7.82,12l7.1-8.65H12.9
										C12.59,3.36,12.3,3.5,12.1,3.74z" />
                  </svg>
                </span>
              </a>
              <ul>
                <?php foreach ($children_ids as $value => $key) {
                  $variation = wc_get_product($key);
                  $sale = $variation->get_sale_price() ? 'yes' : 'no';
                  if ($variation->get_availability()['class'] == 'outofstock') {
                    $href_data = get_permalink($key) . '&outofstock';
                  } else {
                    $href_data = get_permalink($key);
                  }
                  $variation_get_price = !empty($variation->get_price()) ? number_format($variation->get_price(), 2, ',', ' ') : 0;
                  $image_url = !empty(wp_get_attachment_image_src($variation->get_image_id(), 'medium')[0]) ? 'image-url-data="' . wp_get_attachment_image_src($variation->get_image_id(), 'medium')[0] . '"' :   'image-url-data="' . get_site_url() . '/wp-content/uploads/woocommerce-placeholder-300x300.png"';
                  echo '<li data-id="' . $key . '" data-price="' . $variation_get_price . '" stock-data="' . $variation->get_availability()['class'] . '" sale="' . $sale . '" href-data="' . $href_data . '" ' . $image_url . ' >' . str_replace('Opakowanie: ', '', $variation->get_attribute_summary()) . '</li>';
                }
                ?>
              </ul>
              <a href=" <?php echo get_site_url() . '?add-to-cart=' . $start_item; ?> " data-quantity="1" class="add_to_cart_button button ajax_add_to_cart <?php if ($start_variation->get_sale_price()) echo 'promotion-btn'; ?>" data-product_id="<?php echo $start_item; ?>" aria-label="<?php echo __('Add', 'undersptra') . get_the_title($start_item) . ' ' . __('to cart', 'bht-tnl'); ?>" rel="nofollow">
                <?php echo !empty($variation->get_price()) ? '<span class="price-variation">' . number_format($variation->get_price(), 2, ',', ' ') . "</span>" : 0;  ?>
                <?php echo get_woocommerce_currency_symbol(); ?> - <?php echo  __('Do koszyka', 'woocommerce'); ?>
              </a>
              <a href="<?php echo get_permalink($product->get_id()); ?>" class="backorder-button loop-not-stock">Powiadom o dostępności</a>
            </div>

    <?php
        } else {
          // echo '<span class="stock-label-loop" style="display: block;">' . __('Out', 'bht-tnl') . '</span>';
          //<button type="button" class="backorder-button loop-not-stock">Powiadom o dostępności12 12132</button>
        }
      }
      echo '<a href="' . get_permalink($product->get_id()) . '" class="button  mt-loop">' . __('Dowiedz się więcej', 'bht-tnl') . '</a></div>';
    } else {
      echo '<div class="add-to-cart-wrap"><a href="' . get_permalink($product->get_id()) . '" class="button  mt-loop">' . __('Dowiedz się więcej', 'bht-tnl') . '</a></div>';
    }
  }
