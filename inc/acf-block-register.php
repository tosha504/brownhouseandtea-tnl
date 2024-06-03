<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

if (class_exists('ACF')) {
  function register_acf_blocks()
  {
    $dir = get_template_directory() . '/blocks/';
    $blocks = scandir($dir);
    $fiels = array_diff($blocks, array('.', '..'));
    if (!empty($fiels)) {
      foreach ($fiels as $key => $block) {
        register_block_type(dirname(__DIR__) . "/blocks/{$block}/block.json");
      }
    }
  }

  //   <?php
  // // Exit if accessed directly.
  // defined('ABSPATH') || exit;

  // if (class_exists('ACF')) {
  //   function register_acf_blocks()
  //   {
  //     $dir = get_template_directory() . '/blocks/';
  //     $blocks = scandir($dir);
  //     $fiels = array_diff($blocks, array('.', '..'));
  //     if (!empty($fiels)) {
  //       foreach ($fiels as $key => $block) {
  //         register_block_type(dirname(__DIR__) . "/blocks/{$block}/block.json");
  //       }
  //     }
  //   }
  //   add_action('init', 'register_acf_blocks');
  // }
  add_action('init', 'register_acf_blocks');


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
}
