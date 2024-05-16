<?php

/**
 * start functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package start
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
	 * to change 'start' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('start', get_template_directory() . '/languages');

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
			'menu-header' => esc_html__('Header menu', 'start'),
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
			'name' => esc_html__('Sidebar', 'start'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'start'),
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
$realestate_inc_dir = 'inc';

// Array of files to include.
$realestate_includes = array(
	'/functions-template.php',  // 	Theme custom functions
	'/enqueue.php',				//	Enqueue scripts and styles.
	'/custom-header.php',		//	Implement the Custom Header feature.
	'/customizer.php',			//	Customizer additions.
	'/template-tags.php',		// 	Custom template tags for this theme.
	'/template-functions.php',	//	Functions which enhance the theme by hooking into WordPress.
	'/acf-block-register.php',
	'/install-plugin-formthis-theme.php'
);

// Load WooCommerce functions if WooCommerce is activated.
if (class_exists('WooCommerce')) {
	$realestate_includes[] = '/woocommerce.php';
}

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Include files.
foreach ($realestate_includes as $file) {
	require_once get_theme_file_path($realestate_inc_dir . $file);
}

require_once dirname(__FILE__) . '/inc/class-tgm-plugin-activation.php';

/**
 * Make ACF Options
 */
if (function_exists('acf_add_options_page')) {
	$option_page = acf_add_options_page([
		'page_title' => 'General settings',
		'menu_title' => 'General settings',
		'menu_slug' => 'theme-general-settings',
		'post_id' => 'options',
		'capability' => 'edit_posts',
		'redirect' => false
	]);

	$option_page_header = acf_add_options_page([
		'page_title' => 'Header settings',
		'menu_title' => 'Header settings',
		'menu_slug' => 'theme-header-settings',
		'post_id' => 'options_header',
		'capability' => 'edit_posts',
		'icon_url' => 'dashicons-admin-settings',
		'redirect' => false
	]);

	$option_page_footer = acf_add_options_page([
		'page_title' => 'Footer settings',
		'menu_title' => 'Footer settings',
		'menu_slug' => 'theme-footer-settings',
		'post_id' => 'options_footer',
		'capability' => 'edit_posts',
		'icon_url' => 'dashicons-admin-settings',
		'redirect' => false
	]);
}
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
