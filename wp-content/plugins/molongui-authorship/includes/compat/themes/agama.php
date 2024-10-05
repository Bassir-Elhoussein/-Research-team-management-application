<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_the_author' )
         and
         isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/agama/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/agama/author.php' ), strlen( '/themes/agama/author.php' ) ) === 0
    )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( isset( $args['dbt'][3]['function'] ) and ( $args['dbt'][3]['function'] == 'get_author_posts_url' )
         and
         isset( $args['dbt'][3]['file'] ) and substr_compare( $args['dbt'][3]['file'], '/themes/agama/author.php', strlen( $args['dbt'][3]['file'] )-strlen( '/themes/agama/author.php' ), strlen( '/themes/agama/author' ) ) === 0
    )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'get_the_author_user_url', function( $value )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 6 );
    if ( is_author() and in_the_loop() and isset( $dbt[5]['function'] ) and $dbt[5]['function'] == "agama_render_blog_post_meta" ) return '#molongui-disabled-link';
    return $value;
}, 10, 1 );