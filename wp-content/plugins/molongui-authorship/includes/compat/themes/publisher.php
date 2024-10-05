<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/render_box', function( $default, $post )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( in_the_loop() and isset( $dbt[7]['function'] ) and $dbt[7]['function'] == "publisher_inject_location" ) return false;
    return $default;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    if ( is_guest_author() ) return $default;
    $i     = 4;
    $fn    = 'add_user_archive_items';
    $class = 'BF_Breadcrumb';
    if ( isset( $args['dbt'][$i]['function'] ) and $args['dbt'][$i]['function'] == $fn and isset( $args['dbt'][$i]['class'] ) and $args['dbt'][$i]['class'] == $class ) return true;
    return $default;
}, 10, 2 );
add_filter( 'authorship/byline/dom_tree', function()
{
   $dom_tree = '<i class="post-author author">{%ma_authorName}</i>';

   return $dom_tree;
});
add_filter( 'authorship/get_avatar_data/skip', function( $default, $args, $dbt )
{
    $fn   = 'get_avatar';
    $file = '/publisher/views/general/shortcodes/bs-login.php';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
        {
            return true;
        }
    }
    return $default;
}, 10, 3 );