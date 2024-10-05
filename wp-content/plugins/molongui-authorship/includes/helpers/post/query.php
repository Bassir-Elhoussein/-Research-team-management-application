<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_author_meta_query( &$wp_query, $author_type = 'user', $author_id = 0 )
{
    $author_type = in_array( $author_type, array( 'user', 'guest' ) ) ? $author_type : 'user';
    $author_id   = !empty( $author_id ) ? $author_id : ( is_admin() ? get_current_user_id() : ( !empty( $wp_query->query_vars['author'] ) ? $wp_query->query_vars['author'] : 0 ) );
    $meta_query = $wp_query->get( 'meta_query' );
    $meta_query = ( !empty( $meta_query ) and is_array( $meta_query ) ) ? $meta_query : array();
    $meta_query[] = array
    (
        array
        (
            'key'     => '_molongui_author',
            'value'   => $author_type.'-'.$author_id,
            'compare' => '==',
        ),
    );
    $wp_query->set( 'meta_query', $meta_query );
}