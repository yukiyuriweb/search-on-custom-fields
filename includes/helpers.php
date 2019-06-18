<?php
/**
 * Helper functions.
 *
 * @package Search_On_Custom_Fields
 */

if ( ! function_exists( 'socf_app' ) ) {
	/**
	 * Get the instance of plugin.
	 *
	 * @return Search_On_Custom_Fields\Filter
	 */
	function socf_app() {
		global $socf_app;
		return $socf_app;
	}
}
