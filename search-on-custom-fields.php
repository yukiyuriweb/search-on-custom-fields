<?php
/**
 * Plugin Name:     Search On Custom Fields
 * Plugin URI:      https://yukiyuriweb.com/wp-plugins/search-on-custom-fields
 * Description:     Add functionality to search on custom fields
 * Author:          YUKiYURi WEB
 * Author URI:      https://yukiyuriweb.com
 * Text Domain:     search-on-custom-fields
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Search_On_Custom_Fields
 */
namespace SearchOnCustomField;

if (!defined('ABSPATH')) {
    exit;
}

require_once(__DIR__ . '/plugins/plugin-update-checker/plugin-update-checker.php');

/**
 * @see http://adambalee.com/search-wordpress-by-custom-fields-without-a-plugin/
 */
class App
{
    /**
     * The plugin ID
     *
     * @var array
     */
    var $id = 'search-on-custom-fields';

    public function __construct()
    {
        if (is_admin()) {
            \Puc_v4_Factory::buildUpdateChecker(
                'https://yukiyuriweb.com/wp-plugins/' . $this->id . '/' . $this->id . '.json',
                __FILE__,
                $this->id
            );
        }

        add_filter('posts_join', array($this, 'posts_join'));
        add_filter('posts_where', array($this, 'posts_where'));
        add_filter('posts_distinct', array($this, 'posts_distinct'));
    }

    public function posts_join($join)
    {
        global $wpdb;

        if (is_search()) {
            $join .= " LEFT JOIN $wpdb->postmeta AS m ON ($wpdb->posts.ID = m.post_id) ";
        }

        return $join;
    }

    public function posts_where($where)
    {
        global $wpdb;

        if (is_search()) {
            $where = preg_replace(
                "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "({$wpdb->posts}.post_title LIKE $1) OR (m.meta_value LIKE $1)",
                $where
            );
        }

        return $where;
    }

    public function posts_distinct($where)
    {
        global $wpdb;

        if (is_search()) {
            return 'DISTINCT';
        }

        return $where;
    }
}

$app = new App();
