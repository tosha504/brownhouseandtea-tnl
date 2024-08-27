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

</div><!-- #page -->
<div class="overlay"></div>

<?php wp_footer(); ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		$(document).ready(function() {
			$('#searchbarInput').keypress(function(event) {
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if (keycode == '13') {
					var searchValue = $(this).val();
					window.location.href = "<?php echo get_home_url(); ?>?s=" + searchValue;
				}
			});
		});


		$('#searchbarInput').keyup(function() {
			$('.delete').click(function() {
				$('#searchbarInput').val('');
				$('.search__results').removeClass('opened');
				$('.delete').removeClass('on');
			});
			var searchText = $(this).val();
			$('.all-results').attr('href', '<?php echo get_home_url(); ?>?s=' + $(this).val());
			if (searchText.length >= 3) {
				$('.delete').addClass('on');
				$('.search__results').addClass('opened');
				$.ajax({
					url: '<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php', // Zwróć uwagę, że potrzebujesz poprawnej ścieżki do tego pliku w twoim systemie
					method: 'POST',
					data: {
						action: 'my_ajax_request',
						text: searchText
					},
					success: function(response) {
						$(".products-list--searchbar").html(response);
					}
				});
			} else {
				$('.search__results').removeClass('opened');
				$('.delete').removeClass('on');
			}

		});
	});
</script>
</body>

</html>