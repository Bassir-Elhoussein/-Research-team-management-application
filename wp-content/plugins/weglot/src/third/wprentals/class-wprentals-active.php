<?php

namespace WeglotWP\Third\WPRentals;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WeglotWP\Models\Third_Active_Interface_Weglot;


/**
 * Wprentals_Active
 *
 * @since 3.0.5
 */
class Wprentals_Active implements Third_Active_Interface_Weglot {

	/**
	 * @since 3.0.5
	 * @return boolean
	 */
	public function is_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$active = true;

		if ( ! is_plugin_active( 'wprentals-core/wprentals-core.php' ) ) {
			$active = false;
		}

		return apply_filters( 'weglot_wprentals_is_active', $active );
	}

	/**
	 * @since 3.0.5
	 * @return boolean
	 */
	public function is_theme_active() {
		if ( ! function_exists( 'wp_get_theme' ) ) {
			include_once ABSPATH . 'wp-admin/includes/theme.php';
		}
		$theme = wp_get_theme(); // gets the current theme.
		$active = false;
		if ( 'WpRentals' == $theme->name || 'WpRentals' == $theme->parent_theme ) {
			$active = true;
		}

		return apply_filters( 'weglot_wprentals_is_theme_active', $active );
	}
}
