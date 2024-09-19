<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package bht-tnl
 */

get_header();


get_header('shop'); // WooCommerce shop header

// Detect if it's a search query
if (is_search()) {
	// Customize the heading for search results
	echo '<h1>' . sprintf(__('Search Results for: %s', 'woocommerce'), get_search_query()) . '</h1>';

	// Optional: Add custom search form for additional filtering
	get_product_search_form();

	// Modify query arguments for WooCommerce products based on search
	$args = array(
		'post_type' => 'product',
		's'         => get_search_query(),
		'posts_per_page' => 12, // Customize as needed
	);
	var_dump($args);

	// Run the query
	$search_query = new WP_Query($args);

	if ($search_query->have_posts()) :
		woocommerce_product_loop_start();

		while ($search_query->have_posts()) : $search_query->the_post();
			wc_get_template_part('content', 'product');
		endwhile;

		woocommerce_product_loop_end();

	else :
		echo '<p>' . __('No products found matching your search.', 'woocommerce') . '</p>';
	endif;

	wp_reset_postdata();
}

get_footer('shop'); // WooCommerce shop footer
?>

<main id="primary" class="site-main">

	<?php if (have_posts()) : ?>
		<div class="container">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf(esc_html__('Search Results for: %s', 'bht-tnl'), '<span>' . get_search_query() . '</span>');
				?>
			</h1>
			<ul class="products columns-3">
			<?php
			/* Start the Loop */

			while (have_posts()) :
				the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				// get_template_part('template-parts/content', 'search');
				get_template_part('woocommerce/content-product');
			endwhile;


		else :

			get_template_part('template-parts/content', 'none');

		endif;
			?>
			</ul>
		</div>
</main><!-- #main -->

<?php
get_footer();
