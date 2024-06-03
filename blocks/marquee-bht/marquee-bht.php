<?php

/**
 * Quiz BHT Block template.
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

$marquee_bht_background = !empty(get_field('marquee-bht_background')) ? 'style="background-color:' . get_field('marquee-bht_background') . '"' : '';
$marquee_bht_text = get_field('marquee_bht_text_'); ?>

<section class="marquee-bht">
  <div class="marquee" <?php echo  $marquee_bht_background; ?>>
    <span><?php echo $marquee_bht_text; ?></span>
  </div>
</section>