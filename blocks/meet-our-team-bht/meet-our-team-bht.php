<?php

/**
 * Meet Our Team BHT Block template.
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
$items = get_field('items'); ?>

<section class="meet-our-team-bht">
  <div class="container">
    <?php echo $title;
    if (!empty($items)) {
      $class_items = count($items) > 3 ? '__slider' : '__card'; ?>
      <div class="meet-our-team-bht<?php echo $class_items; ?>">
        <?php
        foreach ($items as $key => $item) { ?>
          <div class="image-card">
            <?php echo my_custom_image($item['image']); ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</section>