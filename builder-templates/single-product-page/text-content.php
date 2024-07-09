<?php

/**
 * Text Content
 *
 * @package  bht-tnl
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
$content = get_sub_field('content');
$style = 'style="';
$background_color  = !empty(get_sub_field('background_color')) ? $style .= 'background:' . get_sub_field('background_color') . ';' : "";
$border  = !empty(get_sub_field('border')) ?  $style .= 'border:1px solid var(--black);' : "";
$border_radius = !empty(get_sub_field('border-radius')) ? $style .= 'border-radius: 20px;' : "";
$style .= '"';

echo '<div class="add-info-content" ' . $style . '>';
echo $content;
echo '</div>';
