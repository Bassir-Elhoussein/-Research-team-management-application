<?php
defined( 'ABSPATH' ) or exit;
if ( version_compare( get_bloginfo( 'version' ),'4.6.0', '<' ) )
{
    if ( !function_exists( 'do_action_deprecated' ) )
    {
        function do_action_deprecated( $tag, $args, $version, $replacement = '', $message = '' )
        {
            if ( !has_action( $tag ) )
            {
                return;
            }
            if ( WP_DEBUG  )
            {
                $message = empty( $message ) ? '' : ' ' . $message;

                if ( $replacement )
                {
                    trigger_error(
                        sprintf(
                            __( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.' ),
                            $tag,
                            $version,
                            $replacement
                        ) . $message,
                        E_USER_DEPRECATED
                    );
                }
                else
                {
                    trigger_error(
                        sprintf(
                            __( '%1$s is <strong>deprecated</strong> since version %2$s with no alternative available.' ),
                            $tag,
                            $version
                        ) . $message,
                        E_USER_DEPRECATED
                    );
                }
            }

            return do_action_ref_array( $tag, $args );
        }
    }
}
add_action( 'authorship/author/guest/before_get_data', 'authorship_deprecated_action_get_data_1', 0, 1 );
add_action( 'authorship/author/guest/after_get_data' , 'authorship_deprecated_action_get_data_2', 0, 1 );

function authorship_deprecated_action_get_data_1( $author_id )
{
    do_action_deprecated( 'molongui_authorship_before_get_guest_author_data', array( $author_id ), '4.2.0', 'authorship/author/guest/before_get_data' );
}
function authorship_deprecated_action_get_data_2( $author_id )
{
    do_action_deprecated( 'molongui_authorship_after_get_guest_author_data', array( $author_id ), '4.2.0', 'authorship/author/guest/after_get_data' );
}

