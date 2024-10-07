<?php

/**
 * Tiles BHT Block template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

// Load values and assign defaults.

$anchor = '';
if (!empty($block['anchor'])) {
  $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}
$title = get_field('title');
$items = get_field('items');
$button_tile = get_field('button'); ?>

<section class="tiles-bht">
  <div class="container">
    <?php echo '<div class="container__wrap">' . $title . '</div>';
    if (!empty($items) && count($items) > 0) { ?>
      <div class="tiles-bht__items">
        <?php foreach ($items as $key => $item) {
          $bg_color = !empty($item['bg_color']) ? 'style="background:' . $item['bg_color'] . ';"' : '';
          $show_title = !empty($item['title']) ?  "<p class='title-tile'>{$item['title']}</p>" : ""; ?>
          <div class="tiles-bht__items_item" <?php echo $bg_color; ?>>
            <?php
            echo wp_get_attachment_image($item['icon'], 'thumbnail');
            echo $show_title;
            echo $item['descr'];
            ?>
          </div>
        <?php } ?>
      </div>
    <?php }
    if ($button_tile) {
      $link_url = $button_tile['url'];
      $link_title = $button_tile['title'];
      $link_target = $button_tile['target'] ? $button_tile['target'] : '_self'; ?>
      <div class="content-buttons">
        <a class="button" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
      </div>
    <?php } ?>
  </div>
</section>