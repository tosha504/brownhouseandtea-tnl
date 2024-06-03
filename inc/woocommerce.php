<?php
function create_product_custom_taxonomy()
{
  register_taxonomy(
    'collection',  // Taxonomy name
    'product',  // Post type (WooCommerce products are 'product')
    array(
      'label' => __('Collection', 'bht-tnl'),  // Taxonomy label
      'rewrite' => array('slug' => 'collection'),
      'hierarchical' => true,  // True for categories-like, false for tags-like
    )
  );
}
add_action('init', 'create_product_custom_taxonomy');
