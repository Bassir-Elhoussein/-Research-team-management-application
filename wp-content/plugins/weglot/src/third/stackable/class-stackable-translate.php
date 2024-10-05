<?php

namespace WeglotWP\Third\Stackable;

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
 * Stackable_Translate
 *
 * @since 3.1.4
 */
class Stackable_Translate implements Hooks_Interface_Weglot {
	/**
	 * @var Stackable_Active
	 */
	private $stackable_active;

	/**
	 * @since 3.1.4
	 * @return void
	 */
	public function __construct() {
		$this->stackable_active      = weglot_get_service( 'Stackable_Active' );
	}

	/**
	 * @since 3.1.4
	 * @see Hooks_Interface_Weglot
	 * @return void
	 */
	public function hooks() {

		if ( ! $this->stackable_active->is_active() ) {
			return;
		}
		add_filter( 'weglot_html_treat_page', array( $this, 'wg_stackable_see_more' ));
	}

	/**
	 * @param string $translated_content
	 * @return string
	 * @since 3.1.4
	 */
	public function wg_stackable_see_more( $translated_content ) {
		$translated_content = str_replace('\""', '\"', $translated_content);
		return str_replace('"\"', '\"', $translated_content);
	}

}
