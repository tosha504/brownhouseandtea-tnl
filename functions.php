<?php

/**
 * start functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bht-tnl
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function start_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on start, use a find and replace
	 * to change 'bht-tnl' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('bht-tnl', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-header' => esc_html__('Header menu', 'bht-tnl'),
			'menu-header-search' => esc_html__('Header menu search', 'bht-tnl'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'start_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'start_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function start_content_width()
{
	$GLOBALS['content_width'] = apply_filters('start_content_width', 640);
}
add_action('after_setup_theme', 'start_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function start_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'bht-tnl'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'bht-tnl'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'start_widgets_init');

/**
 * Disable Gutenberg
 */
// add_filter('use_block_editor_for_post', '__return_false');

// Theme includes directory.
$bht_tnl_inc_dir = 'inc';

// Array of files to include.
$bht_tnl_includes = array(
	'/functions-template.php',  // 	Theme custom functions
	'/enqueue.php',				//	Enqueue scripts and styles.
	'/custom-header.php',		//	Implement the Custom Header feature.
	'/customizer.php',			//	Customizer additions.
	'/template-tags.php',		// 	Custom template tags for this theme.
	'/template-functions.php',	//	Functions which enhance the theme by hooking into WordPress.
	'/acf-block-register.php',
	'/install-plugin-formthis-theme.php',

);

// Load WooCommerce functions if WooCommerce is activated.
if (class_exists('WooCommerce')) {
	$bht_tnl_includes[] = '/woocommerce.php';
}

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Include files.
foreach ($bht_tnl_includes as $file) {
	require_once get_theme_file_path($bht_tnl_inc_dir . $file);
}

require_once dirname(__FILE__) . '/inc/class-tgm-plugin-activation.php';


function acf_json_save_point()
{
	return get_template_directory() . '/acf-json';
}

function acf_json_load_point($paths)
{
	unset($paths[0]);
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
function acf_json_change_field_group($group)
{
	$groups = array(
		'group_64dcb34c9db9a',
		'group_64dcb34c9db9a__trashed',
		'group_64dc8b9fc1e74',
		'group_64dc8b9fc1e74__trashed',
		'group_64e30cbb90836',
		'group_64e30cbb90836__trashed',

	);
	if (in_array($group['key'], $groups)) {
		add_filter('acf/settings/save_json', array('acf_json_save_point'));
	}
	return $group;
}

add_action('acf/update_field_group', 'acf_json_change_field_group');
add_action('acf/trash_field_group', 'acf_json_change_field_group');
add_action('acf/untrash_field_group', 'acf_json_change_field_group');
add_filter('acf/settings/load_json', 'acf_json_load_point');
//svg
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

define('ALLOW_UNFILTERED_UPLOADS', true);

function fix_svg_thumb_display()
{
	echo
	'<style>
		td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
			width: 100% !important;
			height: auto !important;
		}
	</style>';
}


add_filter('woocommerce_single_product_carousel_options', 'filter_single_product_carousel_options');
function filter_single_product_carousel_options($options)
{
	// if (wp_is_mobile()) {
	$options['smoothHeight'] = true; // Already "true" by default
	$options['controlNav'] = 'thumbnails'; // Option 'thumbnails' by default
	$options['animation'] = "slide"; // Already "slide" by default
	$options['slideshow'] = true; // Already "false" by default
	$options['smoothHeight']  = false;
	// $options['randomize']  = false;
	$options['easing']  = "swing";
	// $options["directionNav"] = true;
	$options["manualControls"] = ".flex-control-nav";
	// }randomize: false,
	return $options;
}


function get_min_amount_shipping($country_name = null)
{
	$shipping_zones = WC_Shipping_Zones::get_zones();
	foreach ($shipping_zones as $zone_id => $zone) {
		// Check if the current zone matches the specified zone name
		$shipping_methods = $zone['shipping_methods'];

		// Loop through shipping methods to find free shipping
		foreach ($shipping_methods as $method) {
			if ($method->id === 'free_shipping' && $method->enabled === "yes") {
				// Return the minimum amount for free shipping
				return $method->min_amount;
			}
		}
	}
}

function get_free_shipping_amount_for_zone()
{
	$custom_user_meta = get_user_meta(get_current_user_id(), 'billing_country', true);
	// if (count(WC()->cart->get_cart()) === 0) {
	// 	echo 'Darmowa wysyłka za zakupy za minimum 199 zł';
	// 	var_dump(!$custom_user_meta);
	// 	return;
	// }
	if (!$custom_user_meta) {
		return get_min_amount_shipping();
	};

	$country_name = WC()->countries->countries[$custom_user_meta];
	// Get all shipping zones

	return get_min_amount_shipping($country_name);

	// Return false if no free shipping is found or if it does not apply
	return false;
}
add_action('widgets_init', 'register_my_widgets');

function register_my_widgets()
{

	register_sidebar([
		'name' => 'The left sidebar of the shop',
		'id' => 'left-sidebar',
		'description' => 'These widgets will be shown in the right column of the site',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	]);
}


add_filter('woocommerce_update_order_review_fragments', 'filter_update_order_review_fragments');
function filter_update_order_review_fragments($fradments)
{
	ob_start();
	if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) :
?>
		<div class="ajax-shipp-method">
			<?php do_action('woocommerce_review_order_before_shipping'); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action('woocommerce_review_order_after_shipping'); ?>
		</div>
		<?php
	endif;

	$fradments['.ajax-shipp-method'] = ob_get_clean();

	return $fradments;
}

function hide_shipping_when_free_is_available($rates, $package)
{
	// Initialize variables
	$free_shipping_available = false;
	$min_amount = null;

	// Loop through the rates to find free shipping
	foreach ($rates as $rate_id => $rate) {
		if ('free_shipping' === $rate->method_id) {
			// Get the settings for the free shipping rate
			$free_shipping = new WC_Shipping_Free_Shipping($rate->instance_id);
			$min_amount = $free_shipping->min_amount;
			// Check if cart total meets or exceeds the minimum amount for free shipping
			if (intval(WC()->cart->cart_contents_total) >= intval($min_amount)) {
				$free_shipping_available = true;
				break;
			}
		}
	}

	// Modify rates if free shipping is available
	if ($free_shipping_available) {
		$new_rates = [];

		// Include free shipping in the new rates
		foreach ($rates as $rate_id => $rate) {
			if ('free_shipping' === $rate->method_id) {
				$new_rates[$rate_id] = $rate;
			} elseif ('local_pickup' === $rate->method_id) {
				// Optionally include local pickup
				$new_rates[$rate_id] = $rate;
			}
		}

		return $new_rates; // Return modified rates
	}
	error_log(print_r($rates, true));
	return $rates; // Return all rates if free shipping isn't available
}

add_filter('woocommerce_package_rates', 'hide_shipping_when_free_is_available', 10, 2);


// Function to track post views
function set_post_views($postID)
{
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);

	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

// To prevent post views from being counted every time a post is retrieved
function count_post_views($post_id)
{
	if (!is_single()) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	set_post_views($post_id);
}
add_action('wp_head', 'count_post_views');

// Prevent the post views from being cached
function track_post_views($query)
{
	if (!is_single()) return;

	global $post;
	$postID = $post->ID;
	set_post_views($postID);
}
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Function to get the most popular posts
function get_most_popular_posts($num_posts = 3)
{
	$args = array(
		'posts_per_page' => $num_posts,
		'meta_key' => 'post_views_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
	);

	$popular_posts_query = new WP_Query($args);

	if ($popular_posts_query->have_posts()) {
		echo '<h1 class="small">Popularne wpisy</h1>';
		echo '<ul class="popular-posts">';
		while ($popular_posts_query->have_posts()) {
			$popular_posts_query->the_post();	?>
			<li>
				<a href="<?php echo get_the_permalink(); ?>">
					<?php echo my_custom_image(get_post_thumbnail_id()); ?>
					<h5><?php echo get_the_title(); ?></h5>
				</a>
			</li>
<?php	}
		echo '</ul>';
	}

	wp_reset_postdata();
}
