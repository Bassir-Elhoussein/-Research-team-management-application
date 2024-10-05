<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'is_guest_author' ) )
{
    function is_guest_author()
    {
        global $wp_query;

        if ( !isset( $wp_query ) )
        {
            _doing_it_wrong( __FUNCTION__, __( "Conditional query tags do not work before the query is run. Before then, they always return false." ), '3.1.0' );
            return false;
        }

        return isset( $wp_query->is_guest_author ) ? $wp_query->is_guest_author : false;
    }
}
if ( !function_exists( 'molongui_is_guest' ) )
{
    function molongui_is_guest( $author = null )
    {
        if ( empty( $author ) ) return false;
        if ( $author instanceof \WP_User ) return false;
        if ( $author instanceof \WP_Post ) return true;
        if ( is_object( $author ) ) return ( ( !empty( $author->type ) and $author->type == 'guest' ) ? true : false );
        if ( is_string( $author ) ) if ( strncmp( $author, 'guest', strlen( 'guest' ) ) === 0 ) return true;
        return false;
    }
}
if ( !function_exists( 'has_local_avatar' ) )
{
    function has_local_avatar( $author_id = null, $author_type = 'user' )
    {
        if ( empty( $author_id ) ) return false;

        switch( $author_type )
        {
            case 'user':
                $img = get_user_meta( $author_id, 'molongui_author_image_url', true );
                return ( !empty( $img ) ? true : false );

            case 'guest':
                return ( has_post_thumbnail( $author_id ) ? true : false );
        }

        return false;
    }
}
if ( !function_exists( 'authorship_author_has_posts' ) )
{
    function authorship_author_has_posts( $author, $post_types )
    {
        $has_posts = false;
        foreach ( $post_types as $post_type )
        {
            if ( !empty( $author['post_count'][$post_type] ) )
            {
                $has_posts = true;
                break;
            }
        }

        return $has_posts;
    }
}
if ( !function_exists( 'authorship_author_name_exists' ) )
{
    function authorship_author_name_exists( $id, $type )
    {
        global $wpdb;
        $user_displayname_check  = false;
        $guest_displayname_check = false;
        $author = new Author( $id, $type );
        $name   = $author->get_name();
        if ( $type == 'user' )
        {
            $user_displayname_check  = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->users WHERE display_name = %s AND ID != '{$id}' LIMIT 1", $name ) );
            $guest_displayname_check = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = '".MOLONGUI_AUTHORSHIP_CPT."' LIMIT 1", $name ) );
        }
        else
        {
            $user_displayname_check  = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->users WHERE display_name = %s LIMIT 1", $name ) );
            $guest_displayname_check = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = '".MOLONGUI_AUTHORSHIP_CPT."' AND ID != '{$id}' LIMIT 1", $name ) );
        }
        if ( !$user_displayname_check and !$guest_displayname_check ) return false;
        if (  $user_displayname_check and !$guest_displayname_check ) return 'user';
        if ( !$user_displayname_check and  $guest_displayname_check ) return 'guest';
        if (  $user_displayname_check and  $guest_displayname_check ) return 'both';
    }
}
function authorship_is_author_archived( $id = null, $type = 'user' )
{
    if ( empty( $id ) )
    {
        if ( !$authors = molongui_find_authors() )
        {
            return false;
        }
        $id   = $authors[0]->id;
        $type = $authors[0]->type;
    }

    $author   = new Author( $id, $type );
    $archived = $author->get_meta( 'archived' );

    return $archived ? true : false;
}
if ( !function_exists( 'is_author_archived' ) )
{
    function is_author_archived( $id, $type )
    {
        authorship_is_author_archived( $id, $type );
    }
}