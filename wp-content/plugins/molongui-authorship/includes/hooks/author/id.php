<?php
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_filter_the_author_ID( $id, $user_id = null, $original_user_id = null )
{
    if ( ( is_author() or is_guest_author() ) and !in_the_loop() )
    {
        global $wp_query;

        $author_id = isset( $wp_query->guest_author_id ) ? $wp_query->guest_author_id : $wp_query->query_vars['author'];
        return $author_id;
    }
    return $id;
}
add_filter( 'get_the_author_ID', 'authorship_filter_the_author_ID', 999, 3 );