<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'get_the_author_user_url', function( $value )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( is_author() and in_the_loop() and isset( $dbt[5]['function'] ) and $dbt[5]['function'] == "the_author_link" ) return '#molongui-disabled-link';
    return $value;
}, 10, 1 );