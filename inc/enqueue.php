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
		wp_register_script('slick_theme_functions', $theme_uri . '/libery/slick.min.js', ['jquery'], false, true);
		wp_enqueue_script('slick_theme_functions');


		wp_enqueue_script('start_functions', $theme_uri . '/src/index.js', ['jquery'], time(), true);
		wp_localize_script('start_functions', 'localizedObject', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajax_nonce'),
		]);

		// Custom css
		wp_enqueue_style('custom-fonts', 'https://use.typekit.net/aew3inv.css', [], null);
		wp_enqueue_style('start_style', $theme_uri . '/src/index.css', [], time());

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'start_scripts',);



function custom_block_theme_acf_enqueue_scripts()
{
	$theme_uri = get_template_directory_uri();
	//if slick
	wp_register_script('slick_theme_functions', $theme_uri . '/libery/slick.min.js', [], false, true);
	wp_enqueue_script('slick_theme_functions');

	if (has_block('acf/banner-bht', get_queried_object_id())) {
		wp_enqueue_script('banner-bht', get_template_directory_uri() . "/blocks/banner-bht/banner-bht.js", array('jquery', 'slick_theme_functions'), '1.0.0', true);
	}

	if (has_block('acf/tea-best-bht', get_queried_object_id())) {
		wp_enqueue_script('tea-best-bht', get_template_directory_uri() . "/blocks/tea-best-bht/tea-best-bht.js", array('jquery', 'slick_theme_functions'), '1.0.0', true);
	}
}
add_action('wp_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');
add_action('admin_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');
