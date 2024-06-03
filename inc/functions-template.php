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

function my_custom_image($attachment_id)
{
  echo wp_get_attachment_image($attachment_id, 'full', false, ['alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true), 'loading' => 'lazy', 'title' => get_the_title($attachment_id)]);
}

function create_buttons($banner_buttons)
{
  if (!empty($banner_buttons) && count($banner_buttons) > 0) { ?>
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
