<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/editor_caps', function( $default, $post_type )
{
    if ( 'event' === $post_type )
    {
        return current_user_can( 'edit_events' ) or current_user_can( 'edit_others_events' );
    }

    return $default;
}, 10, 2 );