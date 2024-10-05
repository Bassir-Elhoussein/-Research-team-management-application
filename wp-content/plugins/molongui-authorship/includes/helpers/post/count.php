<?php

use Molongui\Authorship\Includes\Update_Post_Counters;
defined( 'ABSPATH' ) or exit;
function authorship_update_post_counters( $post_types = 'enabled', $authors = null )
{
    if ( is_array( $post_types ) )
    {
        $pt = $post_types;
    }
    elseif ( is_string( $post_types ) and !in_array( $post_types, array( 'all', 'enabled' ) ) )
    {
        $pt = array( $post_types );
    }
    else
    {
        switch ( $post_types )
        {
            case 'all':

                $pt = molongui_get_post_types();

            break;

            case 'enabled':
            default:

                $pt = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );

            break;
        }
        if ( empty( $pt ) ) $pt = array( 'post', 'page' );
        else $pt = array_unique( array_merge( $pt, array( 'post', 'page' ) ) );
    }
    if ( !empty( $authors ) )
    {
        $updater = new Update_Post_Counters();
        $result  = $updater->handle_some( $pt, (array)$authors );
    }
    else
    {
        $updater = new Update_Post_Counters();
        $result  = $updater->handle_all( $pt );
    }

    return $result;
}
function authorship_increment_post_counter( $post_types = null, $authors = null )
{
    $updater = new Update_Post_Counters();
    $updater->increment_counter( $post_types, $authors );
}
function authorship_decrement_post_counter( $post_types = null, $authors = null )
{
    $updater = new Update_Post_Counters();
    $updater->decrement_counter( $post_types, $authors );
}