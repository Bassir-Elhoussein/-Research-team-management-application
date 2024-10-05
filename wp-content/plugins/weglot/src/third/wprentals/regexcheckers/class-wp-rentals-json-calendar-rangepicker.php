<?php

namespace WeglotWP\Third\Wprentals\Regexcheckers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Weglot\Util\SourceType;



/**
 * @since 2.0.7
 */
class Wp_Rentals_Json_Calendar_Rangepicker {

	const REGEX = '#daterangepicker_vars = (.*?);#';

	const TYPE = SourceType::SOURCE_JSON;

	const VAR_NUMBER = 1;

	public static $KEYS = array( 'pls_select', 'start_date', 'end_date', 'to' );
}
