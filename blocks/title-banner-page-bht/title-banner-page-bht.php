<?php

/**
 * Title Banner Page BHT Block template.
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
$color_bg = !empty(get_field('color_bg')) ? 'style="background:' . get_field('color_bg') . '"' : ''; ?>

<section class="title-banner-page-bht">
  <div class="container" <?php echo $color_bg; ?>>
    <?php echo $title; ?>
  </div>
</section>