<?php

namespace WeglotWP\Third\WPRentals;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Weglot\Client\Api\LanguageEntry;
use WeglotWP\Helpers\Helper_Is_Admin;
use WeglotWP\Models\Hooks_Interface_Weglot;
use WeglotWP\Services\Generate_Switcher_Service_Weglot;
use WeglotWP\Services\Language_Service_Weglot;
use WeglotWP\Services\Request_Url_Service_Weglot;


/**
 * Wprentals_translate_calendar
 *
 * @since 3.1.4
 */
class Wprentals_translate_calendar implements Hooks_Interface_Weglot {
	/**
	 * @var Wprentals_Active
	 */
	private $wprentals_active;

	/**
	 * @since 3.1.4
	 * @return void
	 */
	public function __construct() {
		$this->wprentals_active      = weglot_get_service( 'Wprentals_Active' );
	}

	/**
	 * @since 3.1.4
	 * @see Hooks_Interface_Weglot
	 * @return void
	 */
	public function hooks() {

		if ( ! $this->wprentals_active->is_theme_active() ) {
			return;
		}
		add_filter( 'wpestate_datepicker_language', array( $this, 'wg_wpestate_datepicker_language' ), 99, 0 );
	}

	/**
	 * @return string
	 * @since 3.1.4
	 */
	public function wg_wpestate_datepicker_language( ) {

		/** @var $request_url_services Request_Url_Service_Weglot */
		$request_url_services = weglot_get_service( 'Request_Url_Service_Weglot' );
		return $request_url_services->get_current_language()->getInternalCode();

	}

}
