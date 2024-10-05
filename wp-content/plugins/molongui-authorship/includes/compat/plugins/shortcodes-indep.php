<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/render_box', function( $default )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( in_the_loop() and isset( $dbt[6]['function'] ) and $dbt[6]['function'] == "shortcode_tab" ) return false;
    return $default;
});