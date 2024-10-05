<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 8 );
    $i = 6;
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_the_author_meta' )
    {
        if ( isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_single' )
        {
            global $tdb_state_single;
            $tdcl_query = $tdb_state_single->get_wp_query();
            return $tdcl_query->queried_object_id;
        }
        elseif ( isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_category' )
        {
        }
        elseif ( isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_tag' )
        {
        }
        elseif ( isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_date' )
        {
        }
        elseif ( isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_search' )
        {
        }
    }
    return $post_id;
}, 10, 3 );
add_filter( 'molongui_authorship_dont_filter_the_author_display_name', function( $default, $display_name, $user_id, $original_user_id, $post, $dbt )
{
    $i       = 3;
    $fn      = 'get_the_author_meta';
    $classes = array( 'tdb_state_category', 'tdb_state_tag', 'tdb_state_date', 'tdb_state_search' );
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and isset( $dbt[$i+1]['class'] ) and in_array( $dbt[$i+1]['class'], $classes ) ) return true;
    return $default;
}, 10, 6 );
add_filter( 'molongui_authorship_filter_link_post_id', function( $post_id, $post, $link )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $i = 7;
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_author_posts_url' and isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_single' )
    {
        global $tdb_state_single;
        $tdcl_query = $tdb_state_single->get_wp_query();
        return $tdcl_query->queried_object_id;
    }
    return $post_id;
}, 10, 3 );
add_filter( 'get_the_author_user_email', function( $value, $user_id = null, $original_user_id = null )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
    $i = 3;
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == 'get_the_author_meta' and isset( $dbt[$i+1]['class'] ) and $dbt[$i+1]['class'] == 'tdb_state_single' )
    {
        global $tdb_state_single;
        $tdcl_query = $tdb_state_single->get_wp_query();
        $authors = get_post_authors( $tdcl_query->queried_object_id );
        $author_class = new Molongui\Authorship\Includes\Author( $authors[0]->id, $authors[0]->type );
        add_filter( '_authorship/get_avatar_data/filter/post_id', function() use ( $tdcl_query ){ return $tdcl_query->queried_object_id; } );
        return $author_class->get_mail();
    }
    return $value;
}, 10, 3 );
add_filter( 'authorship/filter_author_link', function( $default, &$args )
{
    $dbt   = $args['dbt'];

    $fn    = 'render';
    $class = 'tdb_header_user';

    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) )
         and
         isset( $dbt[$i]['class'] ) and ( $dbt[$i]['class'] == $class ) )
    {
        return true;
    }
    return $default;
}, 10, 2 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $dbt = $args['dbt'];

    $fn    = 'render';
    $class = 'tdb_header_user';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) )
         and
         isset( $dbt[$i]['class'] ) and ( $dbt[$i]['class'] == $class ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );
add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $value )
{
    global $tdb_state_author;
    if ( $tdb_state_author )
    {
        $r = new ReflectionObject( $tdb_state_author );
        $ao = $r->getProperty( 'author_obj' );
        $ao->setAccessible( true ); // Set the property to public before it can be read
        $aq = $r->getProperty( 'wp_query' );
        $aq->setAccessible( true ); // Set the property to public before it can be read

        $query = $aq->getValue( $tdb_state_author );
        $is_author = $query->is_author;

        if ( $is_author ) return false;
    }

    return $value;
}, 11, 1 );