<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bht-tnl
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<?php
		$categories = get_the_category();
		echo '<ul class="post-categories">';
		foreach ($categories as $category) {
			echo '<li>' . $category->name . '</li>';
		}
		echo '</ul>';
		if (is_singular()) :
			the_title('<h1 class="entry-title">', '</h1>');
		else :
			the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
		endif;
		echo get_the_post_thumbnail(); ?>
		<div class="text-container">
			<?php the_content(); ?>
		</div>
		<div class="container featured-posts">
			<h4>Polecane wpisy</h4>
			<?php
			$args = array(
				'posts_per_page' => 3,
				'order' => 'DESC',
				'post_type' => 'post',
				'post_status' => 'publish',
				'post__not_in' => array(get_the_ID())
			);
			$last_posts = new WP_Query($args);
			if ($last_posts->have_posts()) {
				echo '<ul class="blog-bht__items">';
				while ($last_posts->have_posts()) {
					$last_posts->the_post();
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
			<?php  }
				echo '</ul>';
			}
			wp_reset_postdata() ?>
		</div>

	</div>
</article><!-- #post-<?php the_ID(); ?> -->