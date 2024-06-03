<?php

/**
 * Image Content BHT Block template.
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
$content = get_field('content');
$banner_buttons = get_field('banner_buttons');
$image_leftright = get_field('image_leftright') !== 'right' ? 'style="flex-direction: row-reverse;"' : '';
$image = !empty(get_field('image')) ? get_field('image') : ''; ?>

<section class="image-content-bht">
  <div class="container" <?php echo $image_leftright; ?>>
    <div class="image-content-bht__left">
      <?php
      echo $content;
      create_buttons($banner_buttons); ?>
    </div>
    <div class="image-content-bht__right">
      <?php
      my_custom_image($image); ?>
    </div>

  </div>
</section>