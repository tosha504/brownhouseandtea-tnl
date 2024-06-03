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
$content = get_field('quiz-bht_content');
$banner_buttons = get_field('banner_buttons');
$background_image = !empty(get_field('background_image')) ? 'style="background-image: url(' . wp_get_attachment_url(get_field('background_image')) . ')"' : '';
$quiz_bht_image = get_field('quiz-bht_image');
$quiz_bht_bgcolor = !empty(get_field('quiz-bht_bgcolor')) ? 'style="background: ' . get_field('quiz-bht_bgcolor') . ';"' : ''; ?>


<section class="quiz-bht" <?php echo  $background_image; ?>>
  <div class="container" <?php echo $quiz_bht_bgcolor; ?>>
    <div class="quiz-bht__left">
      <?php echo $content;
      create_buttons($banner_buttons);
      ?>
    </div>
    <div class="quiz-bht__right"><?php my_custom_image($quiz_bht_image)  ?></div>
  </div>
</section>