<?php
/**
 * Filter class.
 *
 * @package Search_On_Custom_Fields
 */

namespace Search_On_Custom_Fields;

/**
 * Filter class.
 *
 * @see http://adambalee.com/search-wordpress-by-custom-fields-without-a-plugin/
 */
class Filter {
	/**
	 * Plugin ID.
	 *
	 * @var string
	 */
	public $id = 'search-on-custom-fields';

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		if ( is_admin() ) {
			\Puc_v4_Factory::buildUpdateChecker(
				"https://wp-plugins.yukiyuriweb.com/{$this->id}/{$this->id}.json",
				__FILE__,
				$this->id
			);
		}

		add_filter( 'posts_join', array( $this, 'posts_join' ) );
		add_filter( 'posts_where', array( $this, 'posts_where' ) );
		add_filter( 'posts_distinct', array( $this, 'posts_distinct' ) );
	}

	/**
	 * Filters the JOIN clause of the query.
	 *
	 * @param string $join The JOIN clause of the query.
	 * @return string
	 */
	public function posts_join( string $join ) {
		global $wpdb;
		if ( is_search() ) {
			$join .= " LEFT JOIN $wpdb->postmeta AS m ON ($wpdb->posts.ID = m.post_id) ";
		}
		return $join;
	}

	/**
	 * Filters the WHERE clause of the query.
	 *
	 * @param string $where The WHERE clause of the query.
	 * @return string
	 */
	public function posts_where( string $where ) {
		global $wpdb;
		if ( is_search() ) {
			$where = preg_replace(
				"/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"({$wpdb->posts}.post_title LIKE $1) OR (m.meta_value LIKE $1)",
				$where
			);
		}
		return $where;
	}

	/**
	 * Filters the DISTINCT clause of the query.
	 *
	 * @param string $distinct The DISTINCT clause of the query.
	 * @return string
	 */
	public function posts_distinct( string $distinct ) {
		global $wpdb;
		if ( is_search() ) {
			return 'DISTINCT';
		}
		return $distinct;
	}
}
