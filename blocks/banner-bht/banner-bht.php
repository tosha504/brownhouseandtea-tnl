<?php

/**
 * Banner BHT Block template.
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

$banner_items = get_field('banner_items'); ?>

<section class="banner-bht <?php if (count($banner_items) > 1) echo 'slider' ?>">
  <?php
  if (!empty($banner_items) && count($banner_items) > 0) { ?>
    <?php
    foreach ($banner_items as $key => $item) {
      $content = $item['banner_content'];
      $banner_buttons = $item['banner_buttons'];
      $background_image = !empty($item['background_image']) ? 'style="background-image: url(' . wp_get_attachment_url($item['background_image']) . ')"' : '';
      if (!empty($background_image)) { ?>
        <div class="banner-bht__wrap" <?php echo $background_image; ?>>
          <div class="container">
            <div class="content">
              <?php
              echo $content;
              create_buttons($banner_buttons);
              ?>
            </div>
          </div>
        </div>

  <?php }
    }
  }

  ?>

</section>