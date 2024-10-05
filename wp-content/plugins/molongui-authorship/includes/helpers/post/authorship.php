<?php

use Molongui\Authorship\Includes\Update_Post_Authors;
defined( 'ABSPATH' ) or exit;
function authorship_update_post_authors( $post_types = 'enabled' )
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
        if ( empty( $pt ) ) $pt = array( 'post' );
    }
    $updater = new Update_Post_Authors();
    $result  = $updater->run( $pt );

    return $result;
}