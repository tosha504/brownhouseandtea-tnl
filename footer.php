<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bht-tnl
 */


$footer_socials = get_field('footer_socials', 'options_footer');
$footer_logo = !empty(get_field('footer_logo', 'options_footer')) ? '<a href="' . esc_url(home_url('/')) . '">' . wp_get_attachment_image(get_field('footer_logo', 'options_footer'), 'full') . '</a>' : '';
$footer_menus = get_field('footer_menus', 'options_footer');
$footer_botom_left = get_field('footer_botom_left', 'options_footer');
$footer_bottom_right = !empty(get_field('footer_bottom_right_', 'options_footer')) ? get_field('footer_bottom_right_', 'options_footer') : '';
$footer_menus_newsletter = !empty(get_field('footer_menus_newsletter', 'options_footer')) ? get_field('footer_menus_newsletter', 'options_footer') : '';
$footer_after_mage = !empty(get_field('footer_after_mage', 'options_footer')) ? get_field('footer_after_mage', 'options_footer') : ''; ?>

<footer id="colophon" class="footer">
	<div class="container">
		<div class="footer__left">
			<div class="footer__left_top">
				<div class="footer__left_top-logo">
					<?php echo $footer_logo; ?>
				</div>
				<?php if (!empty($footer_socials) && count($footer_socials) > 0) { ?>
					<div class="footer__left_top-socials">
						<?php foreach ($footer_socials as $key => $social) {
							$link = $social['footer_social_links'];
							if ($link) {
								$link_url = $link['url'];
								$link_title = $link['title'];
								$link_target = $link['target'] ? $link['target'] : '_self'; ?>
								<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>"><?php echo wp_get_attachment_image($social['icon'], 'full') ?></a>
						<?php }
						} ?>
					</div>
				<?php } ?>
			</div>
			<?php
			if (!empty($footer_menus) && count($footer_menus) > 0) { ?>
				<div class="footer__left_menus">
					<?php footer_templates(); ?>
				</div>
			<?php } ?>
		</div>
		<div class="footer__right">
			<?php echo $footer_menus_newsletter; ?>
		</div>
		<div class="footer__bottom">
			<?php if (!empty($footer_botom_left) && count($footer_botom_left) > 0) { ?>
				<div class="footer__bottom_left">
					<?php foreach ($footer_botom_left as $key => $links) {
						$link = $links['footer_bottom_left_links'];
						if ($link) {
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self'; ?>
							<a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" title="<?php echo esc_html($link_title); ?>"><?php echo esc_html($link_title); ?></a>
					<?php }
					} ?>
				</div>
				<div class="footer__bottom_right"><?php echo $footer_bottom_right; ?> |
					<?php _e('wykonanie: ', 'bht-tnl');
					echo '<a href="https://thenewlook.pl/" title="Strony internetowe WordPress Sklepy internetowe WooCommerce" target="_blank"> THENEWLOOK</a>'; ?></div>
			<?php } ?>
		</div>

	</div>
</footer><!-- #colophon -->
<div class="footer__after">
	<?php my_custom_image($footer_after_mage) ?>
</div>

<div class="search-form-tnl">
	<div class="container close-btn">
		<button id="closeSeachForm" aria-label="Close search form"><span></span><span></span></button>
	</div>
	<div class="container">
		<form role="search" method="get" class="search-form" action="/">
			<label>
				<span class="screen-reader-text">Search for:</span>
				<input type="search" class="search-field" placeholder="Search …" name="s"
					data-rlvlive="true" data-rlvparentel="#rlvlive" data-rlvconfig="default">
			</label>
			<input type="hidden" name="post_type" value="product">
			<div id="rlvlive"></div>
		</form>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		// When the variation is selected, this event is triggered
		$("form.variations_form").on("show_variation", function(event, variation) {
			if (variation.price_per_serving) {
				console.log(variation.price_per_serving)
				$("#price_per_serving_value").text(variation.price_per_serving);
			} else {
				$(".price-per-serving-wrapper").hide();
			}
		});

		// When no variation is selected or reset
		$("form.variations_form").on("reset_data", function() {
			$("#price_per_serving_value").text("");
		});
	});
</script>

<script>
	// document.querySelector('.search-form').addEventListener('keydown', function(event) {
	// 	// Check if the key pressed is "Enter" or mobile equivalent
	// 	if (event.key === 'Enter' || event.key === 'Go' || event.key === 'Done') {
	// 		event.preventDefault(); // Block form submission
	// 	}
	// });
</script>
<div class="overlay"></div>
</div><!-- #page -->

<?php wp_footer(); ?>
</script>
</body>

</html>