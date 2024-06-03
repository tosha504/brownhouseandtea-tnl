<?php

/**
 * Refill BHT Block template.
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

//left
$refill_bht_image = get_field('refill_bht_image');
$refill_bht_content = !empty(get_field('refill_bht_content')) ?   get_field('refill_bht_content') : '';
$buttons = get_field('banner_buttons');

//right
$refill_bht_title = !empty(get_field('refill_bht_title')) ?  '<div class="refill-bht__right_content">' . get_field('refill_bht_title') . '</div>' : '';
$refill_bht_image_right = get_field('refill_bht_image_right'); ?>

<section class="refill-bht">
  <div class="container">
    <div class="refill-bht__left">
      <?php
      echo '<div class="refill-bht__left_content">';
      my_custom_image($refill_bht_image);
      echo   $refill_bht_content;
      create_buttons($buttons);
      echo '</div>'; ?>
    </div>
    <div class="refill-bht__right">
      <?php echo $refill_bht_title;
      my_custom_image($refill_bht_image_right); ?>
    </div>
  </div>
</section>