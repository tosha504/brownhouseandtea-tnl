<?php

/**
 * The template for displaying home(archive)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bht-tnl
 */
get_header(); ?>
<main id="primary" class="site-main">
  <div class="popular-new">
    <div class="container">
      <?php get_most_popular_posts(3);

      $args = array(
        'posts_per_page' => 3,
        'order' => 'DESC',
        'post_type' => 'post',
        'post_status' => 'publish',
      );
      $last_posts_bht = new WP_Query($args);
      if ($last_posts_bht->have_posts()) {
        echo '<h2 class="small">Najnowsze wpisy</h2>';
        echo '<ul class="new-posts">';
        while ($last_posts_bht->have_posts()) {
          $last_posts_bht->the_post();  ?>
          <li>
            <a href="<?php echo get_the_permalink(); ?>">
              <?php echo my_custom_image(get_post_thumbnail_id()); ?>
              <h5><?php echo get_the_title(); ?></h5>
            </a>
          </li>
      <?php  }
        echo '</ul>';
      }
      wp_reset_postdata(); ?>
    </div>
  </div>
  <div class="container">
    <?php
    $max_pages = get_option('posts_per_page');

    $categories = get_categories();
    echo '<ul class="posts-categories">';
    foreach ($categories as $category) {
      echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
    }
    echo '</ul>';
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    if (have_posts()) : ?>
      <ul class="blog-bht__items">
        <?php
        while (have_posts()) :
          the_post();
          $trim_words = 20;
          $excerpt = wp_trim_words(get_the_excerpt(), $trim_words); ?>
          <li class="blog-bht__items_item item">
            <a href="<?php echo get_permalink(); ?>">
              <?php echo get_the_post_thumbnail(); ?>
              <div class="item__wrap">
                <h5><?php echo  get_the_title(); ?></h5>
                <p class="descr"><?php echo $excerpt; ?></p>
                <span>czytaj więcej</span>
              </div>
            </a>
          </li>
      <?php
        endwhile;
      else :
        get_template_part('template-parts/content', 'none');
      endif; ?>
      </ul>
      <?php if ($total_pages > 2) { ?>
        <div class="loadmore-wrap">
          <button id="loadmore" data-page="2">Załaduj więcej</button>
          <span class="loader" style="display:none;"></span>
        </div>
      <?php } ?>
  </div>
  <script>
    jQuery(function() {
      jQuery('#loadmore').click(function() {
        var button = jQuery(this),
          currentPage = button.data('page'),
          loader = jQuery('.loader');
        var data = {
          'action': 'load_more',
          'nonce': localizedObject.nonce,
          'page': currentPage
        };
        loader.show();
        button.prop('disabled', true).hide();

        jQuery.post(localizedObject.ajaxurl, data, function(response) {


          if (response.success) {
            loader.hide();
            button.prop('disabled', false).show();
            jQuery('.blog-bht__items').append(response.data.posts); // Append new posts
            currentPage++;
            button.data('page', currentPage); // Update the current page
            console.log(currentPage == response.data.max_pages, currentPage, response.data.max_pages);

            if (currentPage == response.data.max_pages + 1) {
              button.remove(); // Remove the button if we're at the last page
            }
          } else {
            button.remove(); // Remove the button if no more posts or error
          }
        });
      });
    });
  </script>
</main><!-- #main -->

<?php
get_footer();
