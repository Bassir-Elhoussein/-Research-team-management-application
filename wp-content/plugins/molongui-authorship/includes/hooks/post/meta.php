<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_post_add_author_meta()
{
    global $post;
    $options = authorship_get_options();
    if ( empty( $post ) or empty( $post->ID ) ) return;
    if ( !$options['add_html_meta'] and !$options['add_opengraph_meta'] and !$options['add_facebook_meta'] and !$options['add_twitter_meta'] ) return;
    $authors = get_post_authors( $post->ID );
    if ( empty( $authors ) ) return;
    if ( apply_filters( 'authorship/add_html_comments', true ) )
    {
        if ( authorship_has_pro() )
        {
            $meta = "\n<!-- Author Meta Tags by Molongui Authorship Pro, visit: " . MOLONGUI_AUTHORSHIP_WEB . " -->\n";
        }
        else
        {
            $meta = "\n<!-- Author Meta Tags by Molongui Authorship, visit: https://wordpress.org/plugins/molongui-authorship/ -->\n";
        }
    }
    else
    {
        $meta = "";
    }
    if ( is_author() or is_guest_author() )
    {
        global $wp_query;
        if ( is_guest_author() )
        {
            $author_id = isset( $wp_query->guest_author_id ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
            $author    = new Author( $author_id, 'guest' );
        }
        else
        {
            $author = new Author( $wp_query->get( 'author' ), 'user' );
        }
        if ( !empty( $options['add_html_meta'] ) ) $meta .= '<meta name="author" content="'.$author->get_name().'">'."\n";
        if ( !empty( $options['add_opengraph_meta'] ) ) $meta .= authorship_post_add_opengraph_archive_meta();
    }
    elseif ( is_singular() )
    {
        switch ( $options['multi_author_meta'] )
        {
            case 'main':
                if ( !$main_author = get_main_author( $post->ID ) ) return;
                $author = new Author( $main_author->id, $main_author->type );
                if ( !empty( $options['add_html_meta'] ) ) $meta .= '<meta name="author" content="'.$author->get_name().'">'."\n";
                if ( !empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_facebook_author_meta( $author );
                if ( !empty( $options['add_twitter_meta'] ) ) $meta .= authorship_post_add_twitter_author_meta( $author );
                if ( !empty( $options['add_opengraph_meta'] ) and empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_opengraph_author_meta( $author );

            break;

            case 'aio':
                if ( !empty( $options['add_html_meta'] ) ) $meta .= '<meta name="author" content="'.mount_byline( $authors, count( $authors ) ).'">'."\n";

                foreach ( $authors as $auth )
                {
                    $author = new Author( $auth->id, $auth->type );
                    if ( !empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_facebook_author_meta( $author );
                    if ( !empty( $options['add_twitter_meta'] ) ) $meta .= authorship_post_add_twitter_author_meta( $author );
                    if ( !empty( $options['add_opengraph_meta'] ) and empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_opengraph_author_meta( $author );
                }

            break;

            case 'many':
            default:

                foreach ( $authors as $auth )
                {
                    $author = new Author( $auth->id, $auth->type );
                    if ( !empty( $options['add_html_meta'] ) ) $meta .= '<meta name="author" content="'.$author->get_name().'">'."\n";
                    if ( !empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_facebook_author_meta( $author );
                    if ( !empty( $options['add_twitter_meta'] ) ) $meta .= authorship_post_add_twitter_author_meta( $author );
                    if ( !empty( $options['add_opengraph_meta'] ) and empty( $options['add_facebook_meta'] ) ) $meta .= authorship_post_add_opengraph_author_meta( $author );
                }

            break;
        }
    }

    $meta .= "<!-- /Molongui Authorship -->\n\n";

    echo $meta;
}
add_action( 'wp_head', 'authorship_post_add_author_meta', -1 );
function authorship_post_add_facebook_author_meta( $author )
{
    $meta = '';
    $fb = $author->get_meta( 'facebook' );
    if ( !empty( $fb ) ) $meta .= '<meta property="article:author" content="' . ( ( \strpos( $fb, 'http' ) === false ) ? 'https://www.facebook.com/' : '' ) . $fb . '" />' . "\n";

    return $meta;
}
function authorship_post_add_twitter_author_meta( $author )
{
    $meta = '';
    $tw = $author->get_meta( 'twitter' );
    if ( !empty( $tw ) ) $meta .= '<meta name="twitter:creator" content="' . $tw . '" />' . "\n";

    return $meta;
}
function authorship_post_add_opengraph_author_meta( $author )
{
    $meta = '';
    $meta .= '<meta property="article:author" content="' . $author->get_name() . '" />' . "\n";

    return $meta;
}
function authorship_post_add_opengraph_archive_meta()
{
    global $wp_query;
    $author_id   = null;
    $author_type = null;
    if ( !isset( $wp_query ) ) return;
    if ( \is_guest_author() )
    {
        $author_id   = isset( $wp_query->guest_author_id ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
        $author_type = 'guest';
    }
    else
    {
        $author_id   = $wp_query->get( 'author' );
        $author_type = 'user';
    }
    if ( empty( $author_id ) and empty( $author_type ) ) return;
    $author = new Author( $author_id, $author_type );
    $author_name   = $author->get_name();
    $author_first  = $author->get_meta( 'first_name' );
    $author_last   = $author->get_meta( 'last_name' );
    $author_bio    = \esc_html( $author->get_bio() );
    $author_link   = $author->get_url();
    $author_avatar = $author->get_avatar( 'full', 'url', 'local' );

    $og  = '';
    $og .= '<meta property="og:type" content="profile" />' . "\n";
    $og .= ( $author_link   ? '<meta property="og:url" content="'.$author_link.'" />'."\n" : '' );
    $og .= ( $author_avatar ? '<meta property="og:image" content="'.$author_avatar.'" />'."\n" : '' );
    $og .= ( $author_bio    ? '<meta property="og:description" content="'.$author_bio.'" />'."\n" : '' );
    $og .= ( $author_first  ? '<meta property="profile:first_name" content="'.$author_first.'" />'."\n" : '' );
    $og .= ( $author_last   ? '<meta property="profile:last_name" content="'.$author_last.'" />'."\n" : '' );
    $og .= ( $author_name   ? '<meta property="profile:username" content="'.$author_name.'" />'."\n" : '' );

    return $og;
}