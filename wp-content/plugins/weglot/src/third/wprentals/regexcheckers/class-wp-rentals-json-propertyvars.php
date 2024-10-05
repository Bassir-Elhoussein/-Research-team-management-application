<?php

namespace WeglotWP\Third\Wprentals\Regexcheckers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Weglot\Util\SourceType;



/**
 * @since 2.0.7
 */
class Wp_Rentals_Json_Propertyvars {

	const REGEX = '#property_vars = (.*?);#';

	const TYPE = SourceType::SOURCE_JSON;

	const VAR_NUMBER = 1;

	public static $KEYS = array( 'plsfill', 'sending', 'logged_in', 'notlog', 'viewless', 'viewmore', 'nostart', 'noguest', 'guestoverload', 'use_gdpr', 'gdpr_terms', 'guests', 'allDayText', 'clickandragtext', 'reserved', 'processing', 'book_now', 'instant_booking', 'send_mess' );
}
