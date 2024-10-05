<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_user_by/aim', function( $aim, $user, $args )
{
    if ( is_author() or is_guest_author() )
    {
        $dbt   = $args['dbt'];
        $fn    = 'get_author';
        $class = 'td_module';

        if ( $key = array_search( $fn, array_column( $dbt, 'function' ) )
             and
             isset( $dbt[$key]['class'] ) and ( $dbt[$key]['class'] == $class ) )
        {
            $aim = 'byline';
        }
    }

    return $aim;
}, 10, 3 );

add_filter( '_authorship/get_user_by/post_id', function( $post_id, $user, $args )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 10 );
    $fn    = 'get_author';
    $class = 'td_module';

    if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {

        if ( isset( $dbt[$key]['class'] ) and ( $dbt[$key]['class'] == $class )
             and
             isset( $dbt[$key]['object'] ) and isset( $dbt[$key]['object']->post ) and isset( $dbt[$key]['object']->post->ID ) )
        {
            return $dbt[$key]['object']->post->ID;
        }
    }
    return $post_id;
}, 10, 3 );