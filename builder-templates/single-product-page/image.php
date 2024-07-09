<?php

/**
 * Image
 *
 * @package  bht-tnl
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$image = get_sub_field('image');

echo '<div class="add-info-image">';
echo my_custom_image($image);
echo '</div>';
