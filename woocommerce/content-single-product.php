<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$backgroundcolor = get_field('backgroundcolor', get_the_ID()) ?? '';
$tabs = get_field('tabs', get_the_ID());
$brewing_title = !empty(get_field('brewing_title', get_the_ID())) ? get_field('brewing_title', get_the_ID()) : '';
$brewing_items = get_field('brewing_items', get_the_ID());
$posts_by_acf  = get_field('posts', get_the_ID()); ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
	<div class="wrap-roduct-bg" <?php echo 'style="background:' . $backgroundcolor . '"'; ?>>
		<div class="container">
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action('woocommerce_before_single_product_summary');
			?>

			<div class="summary entry-summary">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action('woocommerce_single_product_summary');
				?>
			</div>
			<div class="tabs-wrap">
				<?php if (!empty($tabs) && count($tabs) !== 0) { ?>
					<ul class="tabs__items">
						<?php foreach ($tabs as $key => $tab) { ?>
							<li>
								<div class="question">
									<p>
										<?php echo $tab['title']; ?>
									</p>
									<button aria-label="Toggle Accordion Content">
										<div></div>
									</button>
								</div>
								<div class="answer">
									<?php echo $tab['description']; ?>
								</div>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action('woocommerce_after_single_product_summary');
	?>
	<div class="template">
		<div class="container">
			<?php single_product_acf_templates_left();  ?>
		</div>
	</div>

	<!--brewing start-->
	<?php if (!empty($brewing_title) && !empty($brewing_items)) { ?>
		<div class="brewing">
			<div class="container">
				<?php echo $brewing_title;
				if (!empty($brewing_items) && count($brewing_items) > 0) { ?>
					<div class="brewing__items">
						<?php foreach ($brewing_items as $key => $item) { ?>
							<div class="brewing__items_item">
								<div class="brewing__items_item-img">
									<?php my_custom_image($item['icon']); ?>
								</div>
								<p class="brewing__items_item-title">
									<?php echo $item['brewing_items_title'] ?>
								</p>
								<p class="brewing__items_item-description">
									<?php echo $item['brewing_items_description'] ?>
								</p>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div><!--brewing end-->
	<?php }
	if (!empty($posts_by_acf) && count($posts_by_acf) > 0) { ?>
		<section class="blog-bht">
			<div class="container">
				<ul class="blog-bht__items">
					<li class="blog-bht__items_cta cta">
						<p class="cta__pre-title">
							Brown House & Tea BLOG
						</p>
						<h5 class="cta__title">
							Smak, który
							inspiruje
						</h5>
						<div class="cta__btn">
							<a href="#">Przejdź do bloga </a>
						</div>
					</li>
					<?php foreach ($posts_by_acf as $key => $post_items) {
						$trim_words = 20;
						$excerpt = wp_trim_words($post_items->post_content, $trim_words); ?>
						<li class="blog-bht__items_item item">
							<a href="<?php echo esc_url(get_permalink($post_items->ID)); ?>">
								<?php echo my_custom_image(get_post_thumbnail_id($post_items->ID)) ?>
								<div class="item__wrap">
									<h5><?php echo $post_items->post_title ?></h5>
									<p class="descr"><?php echo $excerpt; ?></p>
									<span>czytaj więcej</span>
								</div>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</section>
	<?php } ?>
</div>


<?php do_action('woocommerce_after_single_product'); ?>