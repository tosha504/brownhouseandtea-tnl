<?php

/**
 * Footer Links Menu
 *
 * @package  bht-tnl
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$name_menu = !empty(get_sub_field('name_menu')) ? '<h5>' . get_sub_field('name_menu') . '</h5>' : '';
$links = get_sub_field('links'); ?>
<ul class="menu">
  <?php echo $name_menu;
  if (!empty($links) && count($links) > 0) {
    foreach ($links as $key => $link) {
      $link = $link["link"];
      if ($link) {
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self'; ?>
        <li>
          <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
            <?php echo esc_html($link_title); ?>
          </a>
        </li>
  <?php }
    }
  } ?>
</ul>