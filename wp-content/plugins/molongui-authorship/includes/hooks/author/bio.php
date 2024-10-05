<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_filter_the_author_description( $description, $user_id = null, $original_user_id = null )
{
    global $wp_query;
    if ( apply_filters( 'authorship/get_the_author_description/skip', false, $description, $user_id, $original_user_id ) ) return $description;
    if ( !is_author() and !is_guest_author() ) return $description;
    if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return get_post_field( 'post_content', $wp_query->guest_author_id );
    if ( $wp_query->query_vars['author'] )
    {
        $user = new Author( $wp_query->query_vars['author'], 'user', false, false );
        return $user->get_bio();
    }
    return $description;
}
add_filter( 'get_the_author_description', 'authorship_filter_the_author_description', 999, 3 );
function authorship_filter_archive_description( $description )
{
    global $wp_query;
    if ( !is_author() and !is_guest_author() ) return $description;
    if ( is_guest_author() and isset( $wp_query->guest_author_id ) ) return get_post_field( 'post_content', $wp_query->guest_author_id );
    if ( $wp_query->query_vars['author'] )
    {
        $user = new Author( $wp_query->query_vars['author'], 'user', false, false );

        return $user->get_bio();
    }
    return $description;
}
add_filter( 'get_the_archive_description', 'authorship_filter_archive_description', 999, 1 );