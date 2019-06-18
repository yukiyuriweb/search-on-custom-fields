<?php
/**
 * Plugin Name:     Search On Custom Fields
 * Plugin URI:      https://wp-plugins.yukiyuriweb.com/search-on-custom-fields
 * Description:     Add functionality to search on custom fields.
 * Author:          YUKiYURi WEB
 * Author URI:      https://yukiyuriweb.com
 * Text Domain:     search-on-custom-fields
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Search_On_Custom_Fields
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$socf_plugin_name = 'Search On Custom Fields';

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	wp_die( '<h2>Autoload file not found.</h2><p>プラグインが不正です。{$socf_plugin_name} を再ダウンロードしてください。</p>' );
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

$socf_app = new Search_On_Custom_Fields\Filter();
