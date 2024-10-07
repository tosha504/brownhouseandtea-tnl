<?php

/**
 * Custom functions
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
function footer_templates()
{
  if (have_rows('footer_menus', 'options_footer')) {
    while (have_rows('footer_menus', 'options_footer')) {
      the_row();
      if (get_row_layout() == 'footer_links_menu') {
        get_template_part('builder-templates/footer-links-menu');
      } elseif (get_row_layout() == 'footer_content_menu') {
        get_template_part('builder-templates/footer-content-menu');
      }
    }
  }
}

function single_product_acf_templates_left()
{
  if (have_rows('additional_info_left_column', get_the_ID())) {
    while (have_rows('additional_info_left_column',  get_the_ID())) {
      the_row();
      if (get_row_layout() == 'text_content') {
        get_template_part('builder-templates/single-product-page/text-content');
      } elseif (get_row_layout() == 'image') {
        get_template_part('builder-templates/single-product-page/image');
      }
    }
  }
}

function single_product_acf_templates_right()
{
  if (have_rows('additional_info_right_column', get_the_ID())) {
    while (have_rows('additional_info_right_column',  get_the_ID())) {
      the_row();
      if (get_row_layout() == 'text_content') {
        get_template_part('builder-templates/single-product-page/text-content');
      } elseif (get_row_layout() == 'image') {
        get_template_part('builder-templates/single-product-page/image');
      }
    }
  }
}

function my_custom_image($attachment_id)
{
  echo wp_get_attachment_image($attachment_id, 'full', false, ['alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true), 'loading' => 'lazy', 'title' => get_the_title($attachment_id)]);
}

function create_buttons($banner_buttons)
{
  if (!empty($banner_buttons) && count($banner_buttons, COUNT_RECURSIVE) > 2) { ?>
    <div class="content-buttons">
      <?php
      foreach ($banner_buttons as $key => $button) {
        $link = $button['banner_buttons_link'];
        if ($link) {
          $link_url = $link['url'];
          $link_title = $link['title'];
          $link_target = $link['target'] ? $link['target'] : '_self'; ?>
          <a class="button" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
      <?php }
      } ?>
    </div>
<?php }
}


function getGeoIP($ip)
{
  $url = "http://ip-api.com/json/" . $ip;
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($curlHandle);
  curl_close($curlHandle);
  $data = json_decode($response, true);

  return $data;
}
function get_current_IP()
{
  // $ip = $_SERVER['REMOTE_ADDR']; // Replace this with the IP address you want to query
  $ip = '94.23.175.16';
  $geoData = getGeoIP($ip);
  return $geoData;
}
