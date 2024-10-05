<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'authorship_get_post' ) )
{
    function authorship_get_post()
    {
        $post = get_post();
        if ( !$post or empty( $post->ID ) )
        {
            global $wp_query;

            if ( empty( $wp_query ) )
            {
                return null;
            }

            if ( isset( $wp_query->queried_object ) )
            {
                $post = $wp_query->queried_object;
            }
            elseif ( !empty( $wp_query->is_singular ) and !empty( $wp_query->post ) )
            {
                $post = $wp_query->post;
            }
        }

        if ( !$post )
        {
            return null;
        }

        return $post;
    }
}
if ( !function_exists( 'authorship_get_post_id' ) )
{
    function authorship_get_post_id()
    {
        $post = authorship_get_post();

        if ( !$post or !$post->ID or $post->ID == 0 )
        {
            return null;
        }

        return $post->ID;
    }
}
if ( !function_exists( 'authorship_get_post_type' ) )
{
    function authorship_get_post_type( $post_or_id = null )
    {
        if ( isset( $post_or_id ) )
        {
            return _authorship_get_post_type( $post_or_id );
        }
        global $post, $typenow, $pagenow, $current_screen, $wp_query;

        $post_id   = isset( $_REQUEST['post'] ) ? (int)$_REQUEST['post'] : false;
        $post_type = null;

        if ( is_object( $post ) and $post instanceof WP_Post and $post->post_type )
        {
            $post_type = $post->post_type;
        }
        elseif ( $typenow )
        {
            $post_type = $typenow;
        }
        elseif ( $current_screen and !empty( $current_screen->post_type ) )
        {
            $post_type = $current_screen->post_type;
        }
        elseif ( isset( $_REQUEST['post_type'] ) and !empty( $_REQUEST['post_type'] ) and is_string( $_REQUEST['post_type'] ) )
        {
            $post_type = sanitize_key( $_REQUEST['post_type'] );
        }
        elseif ( 'post.php' == $pagenow and !empty( $post_id ) )
        {
            $post_type = _authorship_get_post_type( $post_id );
        }
        elseif ( 'edit.php' == $pagenow and empty( $_REQUEST['post_type'] ) )
        {
            $post_type = 'post';
        }
        elseif ( isset( $wp_query ) and is_author() )
        {
            $post_type = 'post';
        }

        return $post_type;
    }
}
if ( !function_exists( '_authorship_get_post_type' ) )
{
    function _authorship_get_post_type( $post_or_id )
    {
        $post = null;

        if ( is_numeric( $post_or_id ) )
        {
            $post_or_id = (int)$post_or_id;

            if ( !empty( $post_or_id ) )
            {
                $post = get_post( $post_or_id );
            }
        }
        else
        {
            $post = $post_or_id;
        }

        if ( !$post instanceof WP_Post )
        {
            return null;
        }

        return $post->post_type;
    }
}