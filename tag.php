<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bht-tnl
 */

get_header(); ?>

<main id="primary" class="site-main">
	<div class="container">
		<h1 class="tag-title-tnl">Tag: <?php single_tag_title(); ?></h1>
		<?php
		$max_pages = get_option('posts_per_page');
		$current_category = get_queried_object();
		if (is_category()) {
			$categories = get_categories();
			echo '<ul class="posts-categories">';
			foreach ($categories as $category) {
				$class = ($category->term_id == $current_category->term_id) ? 'active' : '';
				echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '" data-slug="' . $category->slug . '" class="' . $class . '">' . esc_html($category->name) . '</a></li>';
			}
			echo '</ul>';
		}
		global $wp_query;
		$total_pages = $wp_query->max_num_pages;
		if (have_posts()) : ?>
			<ul class="blog-bht__items">
				<?php
				while (have_posts()) :
					the_post();
					$trim_words = 20;
					$excerpt = wp_trim_words(get_the_excerpt(), $trim_words);
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
			endif; ?>
			</ul>
			<?php
			the_posts_pagination(array(
				'mid_size'  => 2,
				'prev_text' => __('Previous', 'bht-tnl'),
				'next_text' => __('Next', 'bht-tnl'),
			)); ?>
	</div>
</main><!-- #main -->

<?php

get_footer();
