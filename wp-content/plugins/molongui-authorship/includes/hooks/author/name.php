<?php
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_filter_author_name( $display_name )
{
    if ( molongui_is_request( 'admin' ) ) return $display_name;
    global $post;
    if ( empty( $post ) or empty( $post->ID ) ) return $display_name;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( empty( $dbt ) ) return $display_name;
    $old_display_name = $display_name;
    $filter = true;
    $args = array( 'post' => $post, 'dbt' => $dbt );
if ( apply_filters( 'molongui_authorship_dont_filter_name', false, $display_name, $post, $dbt ) ) return $display_name;
$args = array( 'display_name' => &$display_name, 'post' => $post, 'dbt' => $dbt );
if ( apply_filters_ref_array( 'molongui_authorship_do_filter_name', array( false, &$args ) ) ) return $display_name;

    /*!
     * PRIVATE FILTER.
     *
     * For internal use only. Not intended to be used by plugin or theme developers.
     * Future compatibility NOT guaranteed.
     *
     * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
     * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
     * or deprecation phase.
     *
     * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
     * and knowing that it could cause code failure.
     */
    list( $filter, $display_name ) = apply_filters( '_authorship/filter/the_author', array( true, $display_name ), $args );
    if ( !$filter ) return is_null( $display_name ) ? $old_display_name : $display_name;
    if ( is_author() or is_guest_author() ) return $display_name;
    return get_byline();
}
add_filter( 'the_author', 'authorship_filter_author_name', 999, 1 );
function authorship_filter_author_display_name( $display_name, $user_id = null, $original_user_id = null )
{
    if ( ( !empty( $original_user_id ) or $original_user_id === 0 ) and !apply_filters( 'molongui_authorship_bypass_original_user_id_if', false ) ) return $display_name;
    if ( molongui_is_request( 'admin' ) ) return $display_name;
    global $post;
    if ( empty( $post ) or !$post->ID ) return $display_name;
    $post_id = apply_filters( 'molongui_authorship_filter_the_author_display_name_post_id', $post->ID, $post, $display_name );
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 100 );
    if ( empty( $dbt ) ) return $display_name;
    if ( apply_filters( 'molongui_authorship_dont_filter_the_author_display_name', false, $display_name, $user_id, $original_user_id, $post, $dbt ) ) return $display_name;
    if ( is_author() or is_guest_author() ) return $display_name;
    return get_byline( $post_id );
}
add_filter( 'get_the_author_display_name', 'authorship_filter_author_display_name', 999, 3 );
function authorship_filter_archive_title( $title )
{
    global $wp_query;
    if ( !is_author() and !is_guest_author() ) return $title;
    $options = authorship_get_options();
    if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
    {
        $prefix  = !empty( $options['guest_archive_title_prefix'] ) ? $options['guest_archive_title_prefix'] : '';
        $suffix  = !empty( $options['guest_archive_title_suffix'] ) ? $options['guest_archive_title_suffix'] : '';

        return $prefix . ' ' . get_post_field( 'post_title', $wp_query->guest_author_id ) . ' ' . $suffix;
    }
    if ( $wp_query->query_vars['author'] )
    {
        add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
        $user = get_user_by( 'id', $wp_query->query_vars['author'] );
        remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );
        $prefix  = !empty( $options['user_archive_title_prefix'] ) ? $options['user_archive_title_prefix'] . ' ' : '';
        $suffix  = !empty( $options['user_archive_title_suffix'] ) ? ' ' . $options['user_archive_title_suffix'] : '';
        return $prefix . $user->display_name . $suffix;
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'authorship_filter_archive_title', 999, 1 );