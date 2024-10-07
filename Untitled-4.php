<?php


?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>
  <div id="page" class="wrapper">

    <header id="masthead" class="header">
      <?php
      $top_bar_text = !empty(get_field('top_bar_text', 'options')) ? '<p>' . get_field('top_bar_text', 'options') . '</p>' : '';
      $top_bar_link = !empty(get_field('top_bar_link', 'options')) ? '<a href=' . esc_url(get_field('top_bar_link', 'options')['link']) . '>' . get_field('top_bar_link', 'options')['title'] . '</a>' : '';
      $top_bar_background = !empty(get_field('top_bar_background', 'options')) ? 'style="background: ' . get_field('top_bar_background', 'options') . ';"' : 'style="background: #31241b;"'; ?>
      <div class="header__top-bar" <?php echo $top_bar_background; ?>>
        <div class="container">
          <?php
          echo  $top_bar_text . $top_bar_link; ?>
        </div>
      </div>
      <div class="header__main">
        <div class="container">
          <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'menu-header',
                'container' => false,
                'menu_id' => 'primary-menu1',
                'menu_class' => 'header__nav',
              ),
            );
            ?>
          </nav><!-- #site-navigation -->

          <?php
          $logo = get_field('logo', 'options');
          if ($logo) { ?>
            <div class="header__logo">
              <a href="<?php echo esc_url(home_url('/')) ?>">
                <?php
                echo wp_get_attachment_image($logo, 'full');
                ?>
              </a>
            </div>
          <?php } ?>

          <div class="header__shop-items">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'menu-header-search',
                'container' => false,
                'menu_id' => 'header-nav-search',
                'menu_class' => 'header__nav_search',
              ),
            );
            ?>


            <?php
            $shop_items = get_field('shop_items', 'options');
            if (!empty($shop_items) && count($shop_items) > 0) {
            ?>
              <ul class="header__nav_shop">
                <?php
                foreach ($shop_items as $key => $shop_item) {
                ?>
                  <li class="<?php echo $shop_item['class']; ?>"><a href="<?php echo $shop_item['link']['url']; ?>">
                      <?php if ($shop_item['class'] === 'cart-link') { ?>
                        <span class="count">
                          <?php
                          global $woocommerce;
                          echo sprintf($woocommerce->cart->cart_contents_count);
                          ?>
                        </span>
                      <?php } ?></a></li>
                <?php }
                ?>
              </ul>
            <?php };
            ?>
          </div>


          <button class="burger" aria-label="Open the menu"><span></span><span></span><span></span></button><!-- burger -->
        </div>
      </div>
    </header>
    <!-- #masthead -->

    <?php

    function get_free_shipping_minimums()
    {
      $shipping_zones = WC_Shipping_Zones::get_zones();
      $free_shipping_minimums = array();

      foreach ($shipping_zones as $zone_id => $zone) {
        // Get all shipping methods for the current zone
        $shipping_methods = $zone['shipping_methods'];

        foreach ($shipping_methods as $method) {
          if ($method->id === 'free_shipping') {
            // Check if free shipping has a minimum amount condition
            if (isset($method->instance_settings['requires']) && $method->instance_settings['requires'] === 'min_amount') {
              $minimum_amount = $method->instance_settings['min_amount'];
              $free_shipping_minimums[$zone['zone_name']] = $minimum_amount;
            }
          }
        }
      }
      // var_dump($shipping_zones);

      return $free_shipping_minimums;
    }

    // Use this function to get the free shipping minimums
    get_free_shipping_minimums();


    $footer_socials = get_field('footer_socials', 'options_footer');
    $footer_logo = !empty(get_field('footer_logo', 'options_footer')) ? '<a href="' . esc_url(home_url('/')) . '">' . wp_get_attachment_image(get_field('footer_logo', 'options_footer'), 'full') . '</a>' : '';
    $footer_menus = get_field('footer_menus', 'options_footer');
    $footer_botom_left = get_field('footer_botom_left', 'options_footer');
    $footer_bottom_right = !empty(get_field('footer_bottom_right_', 'options_footer')) ? get_field('footer_bottom_right_', 'options_footer') : '';
    $footer_menus_newsletter = !empty(get_field('footer_menus_newsletter', 'options_footer')) ? get_field('footer_menus_newsletter', 'options_footer') : '';
    $footer_after_mage = !empty(get_field('footer_after_mage', 'options_footer')) ? get_field('footer_after_mage', 'options_footer') : ''; ?>

    <footer id="colophon" class="footer">
      <div class="container">
        <div class="footer__left">
          <div class="footer__left_top">
            <div class="footer__left_top-logo">
              <?php echo $footer_logo; ?>
            </div>
            <?php if (!empty($footer_socials) && count($footer_socials) > 0) { ?>
              <div class="footer__left_top-socials">
                <?php foreach ($footer_socials as $key => $social) {
                  $link = $social['footer_social_links'];
                  if ($link) {
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>"><?php echo wp_get_attachment_image($social['icon'], 'full') ?></a>
                <?php }
                } ?>
              </div>
            <?php } ?>
          </div>
          <?php
          if (!empty($footer_menus) && count($footer_menus) > 0) { ?>
            <div class="footer__left_menus">
              <?php footer_templates(); ?>
            </div>
          <?php } ?>
        </div>
        <div class="footer__right">
          <?php echo $footer_menus_newsletter; ?>
        </div>
        <div class="footer__bottom">
          <?php if (!empty($footer_botom_left) && count($footer_botom_left) > 0) { ?>
            <div class="footer__bottom_left">
              <?php foreach ($footer_botom_left as $key => $links) {
                $link = $links['footer_bottom_left_links'];
                if ($link) {
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                  <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>"><?php echo esc_html($link_title); ?></a>
              <?php }
              } ?>
            </div>
            <div class="footer__bottom_right"><?php echo $footer_bottom_right; ?> |
              <?php _e('wykonanie: ', 'bht-tnl');
              echo '<a href="https://thenewlook.pl/" title="Strony internetowe WordPress Sklepy internetowe WooCommerce" target="_blank"> THENEWLOOK</a>'; ?></div>
          <?php } ?>
        </div>

      </div>
    </footer><!-- #colophon -->
    <div class="footer__after">
      <?php my_custom_image($footer_after_mage) ?>
    </div>

    <div class="search-form-tnl">
      <div class="container close-btn">
        <button id="closeSeachForm" aria-label="Close search form"><span></span><span></span></button>
      </div>
      <div class="container">
        <form role="search" method="get" class="search-form" action="/">
          <label>
            <span class="screen-reader-text">Search for:</span>
            <input type="search" class="search-field" placeholder="<?php _e("Search …", "bht-tnl"); ?>" name="s"
              data-rlvlive="true" data-rlvparentel="#rlvlive" data-rlvconfig="default">
          </label>
          <input type="hidden" name="post_type" value="product">
          <div id="rlvlive"></div>
        </form>
      </div>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        // When the variation is selected, this event is triggered
        $("form.variations_form").on("show_variation", function(event, variation) {
          if (variation.price_per_serving) {
            console.log(variation.price_per_serving)
            $("#price_per_serving_value").text(variation.price_per_serving);
          } else {
            $(".price-per-serving-wrapper").hide();
          }
        });

        // When no variation is selected or reset
        $("form.variations_form").on("reset_data", function() {
          $("#price_per_serving_value").text("");
        });
      });
    </script>


    <div class="overlay"></div>
  </div><!-- #page -->

  <?php wp_footer(); ?>
  </script>
</body>

</html>