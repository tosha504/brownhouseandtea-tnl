<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bht-tnl
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="wrapper">

		<header id="masthead" class="header">
			<?php
			$top_bar_text = !empty(get_field('top_bar_text', 'options')) ? '<p>' . get_field('top_bar_text', 'options') . '</p>' : '';
			$top_bar_link = !empty(get_field('top_bar_link', 'options')) ? '<a href=' . esc_url(get_field('top_bar_link', 'options')['link']) . '>' . get_field('top_bar_link', 'options')['title'] . '</a>' : '';
			$top_bar_background = !empty(get_field('top_bar_background', 'options')) ? 'style="background: ' . get_field('top_bar_background', 'options') . ';"' : 'style="background: #31241b;"'; ?>
			<div class="header__top-bar" <?php echo $top_bar_background; ?>>
				<div class="container">
					<?php echo $top_bar_text . $top_bar_link; ?>
				</div>
			</div>
			<div class="header__main">
				<div class="container">
					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-header',
								'container' => false,
								'menu_id' => 'primary-menu1',
								'menu_class' => 'header__nav',
							),
						);
						?>
					</nav><!-- #site-navigation -->

					<?php
					$logo = get_field('logo', 'options');
					if ($logo) { ?>
						<div class="header__logo">
							<a href="<?php echo esc_url(home_url('/')) ?>">
								<?php
								echo wp_get_attachment_image($logo, 'full');
								?>
							</a>
						</div>
					<?php } ?>

					<div class="header__shop-items">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-header-search',
								'container' => false,
								'menu_id' => 'header-nav-search',
								'menu_class' => 'header__nav_search',
							),
						);
						?>

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-header-shop',
								'container' => false,
								'menu_id' => 'header-nav-shop',
								'menu_class' => 'header__nav_shop',
							),
						);
						?>
					</div>

					<button class="burger" aria-label="Open the menu"><span></span><span></span><span></span></button><!-- burger -->
				</div>
			</div>
		</header><!-- #masthead -->