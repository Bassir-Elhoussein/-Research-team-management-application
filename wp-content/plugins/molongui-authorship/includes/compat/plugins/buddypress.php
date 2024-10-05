<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $fns = array( 'xprofile_filter_comments', 'bp_core_get_user_displaynames' );
    if ( array_intersect( $fns, array_column( $args['dbt'], 'function' ) ) ) $filter = false;
    return array( $filter, $user );
}, 10, 2 );
add_filter( 'molongui_authorship_dont_filter_the_author_display_name', function( $leave, $display_name, $user_id, $original_user_id, $post, $dbt )
{
    $fn = 'xprofile_filter_comments';
    if ( array_search( $fn, array_column( $dbt, 'function' ) ) ) return true;
    return false;
}, 10, 6 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $fns = array( 'get_the_author_meta', 'bp_core_get_username', 'bp_core_get_user_domain' );
    if ( !array_search( 'comment_form', array_column( $args['dbt'], 'function' ) ) ) return array( true, $user );
    if ( array_intersect( $fns, array_column( $args['dbt'], 'function' ) ) ) $filter = false;
    return array( $filter, $user );
}, 10, 2 );