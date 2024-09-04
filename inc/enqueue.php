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
		if (!wp_script_is("wc-cart-fragments", "enqueued") && wp_script_is("wc-cart-fragments", "registered")) {
			// Enqueue the wc-cart-fragments script

			wp_enqueue_script("wc-cart-fragments");
		}

		if (is_checkout()) {
			wp_enqueue_script('checkout_script', get_template_directory_uri() . ('/src/add_quantity.js'), array(), false, true);
			$localize_script = array(
				'ajax_url' => admin_url('admin-ajax.php')
			);
			wp_localize_script('checkout_script', 'add_quantity', $localize_script);
		}

		$theme_uri = get_template_directory_uri();
		// Custom JS
		wp_register_script('slick_theme_functions', $theme_uri . '/libery/slick.min.js', ['jquery'], false, true);
		wp_enqueue_script('slick_theme_functions');
		// wp_enqueue_script('custom-product-js', get_template_directory_uri() . '/src/js/custom-product.js', array('jquery'), '', true);

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

function add_typekit_preconnect($hints, $relation_type)
{
	if ('preconnect' === $relation_type) {
		// Add preconnect for Typekit fonts.
		$hints[] = 'https://use.typekit.net';
	}
	return $hints;
}
add_filter('wp_resource_hints', 'add_typekit_preconnect', 10, 2);

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

	if (has_block('acf/isnspirations-bht', get_queried_object_id())) {
		wp_enqueue_script('isnspirations-bht', get_template_directory_uri() . "/blocks/isnspirations-bht/isnspirations-bht.js", array('jquery', 'slick_theme_functions'), '1.0.0', true);
	}
}
add_action('wp_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');
add_action('admin_enqueue_scripts', 'custom_block_theme_acf_enqueue_scripts');


add_action('wp_ajax_update_order_review', 'update_order_review');
add_action('wp_ajax_nopriv_update_order_review', 'update_order_review');

function update_order_review()
{
	// $values = array();
	// parse_str($_POST['post_data'], $values);
	// $cart = $values['cart'];

	// foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
	// 	WC()->cart->set_quantity($cart_item_key, $cart_item['qty'],);
	// }



	// print_r($_POST);
	WC()->cart->cart_contents[$_POST['key']]['quantity'] = $_POST['qty'];
	WC()->cart->calculate_totals();

	$cart_fragments = apply_filters('woocommerce_add_to_cart_fragments', false);
	echo json_encode($cart_fragments);
	// woocommerce_cart_totals();

	wp_die();
}
function remove_product_ajax()
{
	$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
	WC()->cart->remove_cart_item($product_id);

	wp_send_json_success();
}

add_action('wp_ajax_remove_product_ajax', 'remove_product_ajax');
add_action('wp_ajax_nopriv_remove_product_ajax', 'remove_product_ajax');

function implement_ajax_apply_coupon()
{
	global $woocommerce;
	$code = filter_input(INPUT_POST, 'coupon_code', FILTER_DEFAULT);

	if (empty($code) || !isset($code)) {
		$response = array(
			'result'    => 'error',
			'message'   => 'Code text field can not be empty.'
		);

		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

	$coupon = new WC_Coupon($code);

	if (!$coupon->id && !isset($coupon->id)) {
		$response = array(
			'result'    => 'error',
			'message'   => 'Invalid code entered. Please try again.'
		);

		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	} else {
		if (!empty($code) && !WC()->cart->has_discount($code)) {
			WC()->cart->add_discount($code);
			$response = array(
				'result'    => 'success',
				'message'   => 'successfully added coupon code'
			);

			header('Content-Type: application/json');
			echo json_encode($response);
			exit();
		}
	}
}
add_action('wp_ajax_ajaxapplucoupon', 'implement_ajax_apply_coupon');
add_action('wp_ajax_nopriv_ajaxapplucoupon', 'implement_ajax_apply_coupon');


add_action('wp_ajax_load_more', 'load_more_ajax_handler');
add_action('wp_ajax_nopriv_load_more', 'load_more_ajax_handler');

function load_more_ajax_handler()
{
	check_ajax_referer('ajax_nonce', 'nonce'); // Check nonce for security

	$posts_per_page = get_option('posts_per_page'); // Set how many posts per page you want
	$paged = isset($_POST['page']) ? intval($_POST['page']) : 1;


	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,

	);
	if (isset($_POST['cat'])) {
		$args['tax_query'] =  array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $_POST['cat']
			)
		);
	};

	$query = new WP_Query($args);
	$max_pages = $query->max_num_pages; // Get the maximum number of pages

	if ($query->have_posts()) :
		ob_start(); // Start output buffering to capture the template part

		while ($query->have_posts()): $query->the_post();
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
<?php endwhile;

		$posts_html = ob_get_clean(); // Get the post HTML and clear the buffer

		// Return both posts HTML and the max pages info
		wp_send_json_success(array('posts' => $posts_html, 'max_pages' => $max_pages, 'current_page' => $paged));

	else:
		wp_send_json_error(array('message' => 'No more posts to load.'));
	endif;

	die; // Stop execution further to return a proper response
}
