<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $i  = 5;
    $j  = 6;
    $fn = 'bp_wp_admin_bar_my_account_menu';
    if ( ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn ) or
		 ( isset( $dbt[$j]['function'] ) and $dbt[$j]['function'] == $fn ) )

    {
        $author         = new stdClass();
        $author->object = wp_get_current_user();
        $author->id     = $author->object->ID;
        $author->type   = 'user';
    }
    return $author;
}, 10, 3 );
function authorship_prevent_bbp_filter_avatar( $data, $id_or_email, $args )
{
    global $is_related_posts;

    $dbt    = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $fn     = 'get_avatar';
    $file_1 = '/template-parts/entry-meta.php';
    $file_2 = '/template-parts/author-box.php';

    if ( !$is_related_posts and
         !is_admin() and
         $i = array_search( $fn, array_column( $dbt, 'function' ) ) and
         ( ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_1, strlen( $dbt[$i]['file'] )-strlen( $file_1 ), strlen( $file_1 ) ) === 0 ) or
           ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_2, strlen( $dbt[$i]['file'] )-strlen( $file_2 ), strlen( $file_2 ) ) === 0 ) )
    )
    {
        remove_filter( 'pre_get_avatar', 'bp_core_pre_get_avatar_filter', 10 );
    }
    return $data;
}
add_filter( 'pre_get_avatar', 'authorship_prevent_bbp_filter_avatar', 0, 3 );