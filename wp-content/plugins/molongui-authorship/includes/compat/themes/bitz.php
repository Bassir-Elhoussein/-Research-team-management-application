<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    $file = '/themes/bitz/title.php';
    if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
         and isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], $file, strlen( $args['dbt'][3]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'get_the_author_ID', function( $value, $user_id = null, $original_user_id = null )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $file = '/themes/bitz/title.php';
    $i = 3;
    if ( !in_the_loop()
         and ( !isset( $original_user_id ) or empty( $original_user_id ) )
         and ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
         and ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'get_the_author_meta' ) )
    ){
        global $wp_query;
        if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return $wp_query->guest_author_id;
        else return $wp_query->query_vars['author'];
    }
    return $value;
}, 10, 3 );
add_filter( 'get_the_author_description', function( $value, $user_id = null, $original_user_id = null )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $file = '/themes/bitz/title.php';
    $i = 4;
    if ( !in_the_loop()
         and ( !isset( $original_user_id ) or empty( $original_user_id ) )
         and ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
         and ( isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == 'the_author_meta' ) )
    ){
        global $wp_query;
        $author_id = ( is_guest_author() and isset( $wp_query->guest_author_id ) ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
        $author_class = new Molongui\Authorship\Includes\Author();
        return $author_class->get_bio( $author_id, ( isset( $wp_query->is_guest_author ) and $wp_query->is_guest_author ) ? 'guest' : 'user', false, false );
    }
    return $value;
}, 10, 3 );