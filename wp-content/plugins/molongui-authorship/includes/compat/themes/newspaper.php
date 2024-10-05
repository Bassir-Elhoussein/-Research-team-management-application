<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_user_by/post_id', function( $post_id, $user, $args )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 7 );
    $fn    = 'get_author';
    $class = 'td_module';
    if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) and
         isset( $dbt[$key]['class']  ) and ( $dbt[$key]['class'] == $class )  and
         isset( $dbt[$key]['object'] ) and isset( $dbt[$key]['object']->post ) and isset( $dbt[$key]['object']->post->ID ) )
    {
        return $dbt[$key]['object']->post->ID;
    }
    return $post_id;
}, 10, 3 );
add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 8 );
    $i = 7;
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_author' and isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == 'td_module' and isset( $dbt[$i]['object'] ) and isset( $dbt[$i]['object']->post ) and isset( $dbt[$i]['object']->post->ID ) ) return $dbt[$i]['object']->post->ID;
    return $post_id;
}, 10, 3 );
add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $false )
{
    return true;
}, 10, 1 );
add_filter( 'molongui_authorship_filter_link_post_id', function( $post_id, $post, $link )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 10 );
    $fns   = array( 'get_author', 'get_author_photo' );
    $class = 'td_module';
    if ( array_intersect( $fns, array_column( $dbt, 'function' ) ) )
    {
        if ( $key = array_search( $fns[0], array_column( $dbt, 'function' ) ) and
             isset( $dbt[$key]['class']  ) and ( $dbt[$key]['class'] == $class )  and
             isset( $dbt[$key]['object'] ) and isset( $dbt[$key]['object']->post ) and isset( $dbt[$key]['object']->post->ID ) )
        {

            return $dbt[$key]['object']->post->ID;
        }
        elseif ( $key = array_search( $fns[1], array_column( $dbt, 'function' ) ) and
                 isset( $dbt[$key]['class']  ) and ( $dbt[$key]['class'] == $class )  and
                 isset( $dbt[$key]['object'] ) and isset( $dbt[$key]['object']->post ) and isset( $dbt[$key]['object']->post->ID ) )
        {

            return $dbt[$key]['object']->post->ID;
        }
    }
    return $post_id;
}, 10, 3 );
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 10 );
    $fn    = 'get_author_photo';
    $class = 'td_module';

    if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) and
        isset( $dbt[$key]['class']  ) and ( $dbt[$key]['class'] == $class )  and
        isset( $dbt[$key]['object'] ) and isset( $dbt[$key]['object']->post ) and isset( $dbt[$key]['object']->post->ID ) )
    {
        $post_id = $dbt[$key]['object']->post->ID;

        if ( is_guest_post( $post_id ) )
        {
            $main = get_main_author( $post_id );
            $author->id   = $main->id;
            $author->type = 'guest';
        }
    }
    return $author;
}, 10, 3 );
add_filter( 'authorship/render_box', function( $default )
{
    if ( doing_action( 'tdc_footer' ) ) return false;
    return $default;
});
/*
add_filter( '_authorship/filter/count/author_type', function( $type )
{
    if ( is_guest_author() ) return 'guest';
    return $type;
});*/