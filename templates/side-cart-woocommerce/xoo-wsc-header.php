<?php

/**
 * Side Cart Header
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-header.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.4.4
 */


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

extract(Xoo_Wsc_Template_Args::cart_header());

?>

<div class="xoo-wsch-top">

	<?php if ($showNotifications) : ?>
		<?php xoo_wsc_cart()->print_notices_html('cart'); ?>
	<?php endif; ?>

	<?php if ($showBasket) : ?>
		<div class="xoo-wsch-basket">
		</div>
	<?php endif; ?>

	<?php if ($heading) : ?>
		<span class="xoo-wsch-text"><?php echo $heading ?></span>
		<div class="free-shippinge"></div>
	<?php endif; ?>

	<?php if ($showCloseIcon) : ?>
		<span class="xoo-wsch-close <?php echo $close_icon ?>"></span>
	<?php endif; ?>

</div>