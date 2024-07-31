<?php

/**
 * Product Featured BHT Block template.
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

$title = get_field('title'); ?>

<section class="product-featured-bht ">
  <div class="container">

    <div class="product-featured-bht__title">
      <?php echo $title; ?>
    </div>
    <?php
    $args = array(
      'post_type' => 'product',
      'posts_per_page' => 8,
      'tax_query' => array(
        array(
          'taxonomy' => 'product_visibility',
          'field'    => 'name',
          'terms'    => 'featured',
          'operator' => 'IN',
        ),
      ),
    );
    $loop = new WP_Query($args);
    if ($loop->have_posts()) { ?>
      <ul class="product-featured-bht__slider">
        <?php while ($loop->have_posts()) : $loop->the_post();
          get_template_part('woocommerce/content-product');
        endwhile;
        ?>

      </ul>
    <?php } else {
      echo __('No products found', 'bht-tnl');
    }
    wp_reset_postdata();
    ?>
  </div>

</section>