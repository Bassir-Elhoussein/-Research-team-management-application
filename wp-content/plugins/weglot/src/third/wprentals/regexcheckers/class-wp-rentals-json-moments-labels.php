<?php

namespace WeglotWP\Third\Wprentals\Regexcheckers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Weglot\Util\SourceType;



/**
 * @since 2.0.7
 */
class Wp_Rentals_Json_Moments_Labels {

	const REGEX = '#moment.updateLocale\( \'en_US\', (.*?) \);#';

	const TYPE = SourceType::SOURCE_JSON;

	const VAR_NUMBER = 1;

	public static $KEYS = array( 'months', 'monthsShort', 'weekdays', 'weekdaysShort' );
}
