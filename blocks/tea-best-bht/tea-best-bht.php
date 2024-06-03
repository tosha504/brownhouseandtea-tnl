<?php

/**
 * Tea Best BHT Block template.
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

$tea_best_bht_titles = !empty(get_field('tea_best_bht_titles')) ? '<div class="best-bht__titles">' . get_field('tea_best_bht_titles') . '</div>' : '';
$tea_best_bht_sldier_items = get_field('tea_best_bht_sldier_items');
$tea_best_bht_content = get_field('tea_best_bht_content');
$tea_best_bht_content_iteresting = get_field('tea_best_bht_content_iteresting');
$tea_best_bht_content_iteresting_image = get_field('tea_best_bht_content_iteresting_image');
$buttons = get_field('banner_buttons');  ?>

<section class="best-bht">
  <div class="container">
    <?php echo $tea_best_bht_titles; ?>
    <div class="best-bht__left">
      <?php if (!empty($tea_best_bht_sldier_items) && count($tea_best_bht_sldier_items) > 0) { ?>
        <div class="best-bht__left_slider">
          <?php
          foreach ($tea_best_bht_sldier_items as $key => $item) {
            if (!empty($item['tea_best_bht_sldier_image'])) { ?>
              <div class="best-bht__left_slider-slide">
                <?php my_custom_image($item['tea_best_bht_sldier_image']);
                echo '<p class="slider-badge">' . $item['tea_best_bht_sldier_name'] . '</p>' ?>
              </div>
          <?php }
          } ?>
        </div>
      <?php  } ?>
    </div>
    <div class="best-bht__right">
      <div class="best-bht__right_top">
        <?php echo $tea_best_bht_content; ?>
      </div>
      <div class="best-bht__right_bottom">
        <?php
        echo $tea_best_bht_content_iteresting;
        create_buttons($buttons);
        if (!empty($tea_best_bht_content_iteresting_image)) echo my_custom_image($tea_best_bht_content_iteresting_image);
        ?>
      </div>
    </div>
  </div>
</section>