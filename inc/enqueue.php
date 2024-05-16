<?php
/**
 * Theme enqueue scripts and styles.
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
if (!function_exists('start_scripts')) {
	function start_scripts()
	{
		$theme_uri = get_template_directory_uri();
		// Custom JS
		wp_enqueue_script('start_functions', $theme_uri . '/src/index.js', ['jquery'], time(), true);

		wp_localize_script('start_functions', 'localizedObject', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax_nonce'),
		]);

		// Custom css
		wp_enqueue_style('start_style', $theme_uri . '/src/index.css', [], time());

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

	}
}
add_action('wp_enqueue_scripts', 'start_scripts', );



function custom_block_theme_acf_enqueue_scripts()
{
	$theme_uri = get_template_directory_uri();
	//if slick 
	// wp_register_script('slick_theme_functions', $theme_uri . '/libery/slick.min.js', [], false, true);
	if (has_block('acf/example-name', get_queried_object_id())) {
		wp_enqueue_script('example-name', get_template_directory_uri() . "/blocks/example-name/example-name.js", array(), '1.0.0', true);
	}



}
add_action('wp_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');
add_action('admin_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');