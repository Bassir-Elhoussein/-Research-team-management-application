<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'post_grid_query_args', function( $query_args, $args )
{
    if ( !is_author() ) return $query_args;

    global $wp_query;
    if ( !empty( $wp_query->query_vars['author'] ) )
    {
        $author_id = $wp_query->query_vars['author'];
    }
    else
    {
        $author = get_users( array( 'nicename' => $wp_query->query_vars['author_name'] ) );
        if ( !$author ) return $query_args;

        $author_id = $author[0]->ID;
    }
    $meta_query = $wp_query->get( 'meta_query' );
    if ( empty( $meta_query ) or !is_array( $meta_query ) )
    {
        $type = is_guest_author() ? 'guest' : 'user';

        $meta_query = array
        (
            array
            (
                'key'     => '_molongui_author',
                'value'   => $type.'-'.$author_id,
                'compare' => '==',
            ),
        );
    }
    $query_args['meta_query'] = $meta_query;

    return $query_args;
}, 10, 2 );