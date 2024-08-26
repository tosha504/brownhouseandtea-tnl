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
    // Get the total number of pages
    $total_pages = $wp_query->max_num_pages;
    if (have_posts()) : ?>
      <ul class="blog-bht__items">
        <?php

        /* Start the Loop */
        while (have_posts()) :
          the_post();

          $trim_words = 20;
          $excerpt = wp_trim_words(get_the_excerpt(), $trim_words);
          /*
            * Include the Post-Type-specific template for the content.
            * If you want to override this in a child theme, then include a file
            * called content-___.php (where ___ is the Post Type name) and that will be used instead.
            */
          // echo '<article><a href="' . esc_url(get_permalink($id)) . '">';
          // echo '<div class="categories"><p>' .  get_the_category()[0]->name . '</p><p>News</p></div>';
          // echo '<h4>' . get_the_title($id) . '</h4>';
          // echo '<p class="date">' . get_the_date("d/m/y") . '</p>';
          // echo '<p>' . $excerpt . '</p>';
          // echo '</a></article>';
        ?>
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
      endif;

      ?>
      </ul>
      <?php if ($total_pages > 2) { ?>
        <button id="loadmore" data-page="2">Load More<span class="loader" style="display:none;">Loading...</span></button>
      <?php } ?>

      <style>
        .loader {
          border: 5px solid red;
          /* Light grey */
          border-top: 5px solid blue;
          /* Blue */
          border-radius: 50%;
          width: 12px;
          height: 12px;
          animation: spin 2s linear infinite;
          display: inline-block;
          vertical-align: middle;
          margin-left: 10px;
        }

        @keyframes spin {
          0% {
            transform: rotate(0deg);
          }

          100% {
            transform: rotate(360deg);
          }
        }
      </style>
  </div>
  <script>
    jQuery(function() {
      jQuery('#loadmore').click(function() {
        var button = jQuery(this),
          currentPage = button.data('page'),
          loader = button.find('.loader');
        var data = {
          'action': 'load_more',
          'nonce': localizedObject.nonce,
          'page': currentPage
        };
        loader.show();
        button.prop('disabled', true);

        jQuery.post(localizedObject.ajaxurl, data, function(response) {


          if (response.success) {
            loader.hide();
            button.prop('disabled', false);
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
