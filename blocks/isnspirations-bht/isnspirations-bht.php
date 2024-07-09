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

$title = get_field('title');
$items = get_field('items'); ?>

<section class="isnspirations-bht">
  <div class="container">
    <?php echo $title;
    if (!empty($items) && count($items) > 0) { ?>
      <div class="isnspirations-bht__items <?php if (count($items) > 1) echo 'slider' ?>">
        <?php foreach ($items as $key => $item) {
          $image =  get_field('image', $item->taxonomy . '_' . $item->term_id); ?>
          <div class="isnspirations-bht__items_item">
            <a href="<?php echo get_term_link($item->term_id) ?>">
              <div class="isnspirations-bht__items_item-image">
                <?php my_custom_image($image); ?>
              </div>
              <?php echo '<p class="isnspirations-bht__items_item-title">' . $item->name . '</p>';
              ?>
            </a>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</section>