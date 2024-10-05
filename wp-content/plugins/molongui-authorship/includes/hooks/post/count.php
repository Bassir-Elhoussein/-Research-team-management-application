<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_enable_post_count_update()
{
    new \Molongui\Authorship\Includes\Update_Post_Counters();
}
add_action( 'authorship/init', 'authorship_enable_post_count_update' );
function authorship_post_counters_update()
{
    if ( apply_filters( 'authorship/check_wp_cron', true ) and ( defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) ) return false;

    if ( get_option( 'molongui_authorship_update_post_counters' ) )
    {
        if ( get_option( 'molongui_authorship_update_post_authors', false ) or get_option( 'm_update_post_authors_running', false ) )
        {
            add_action( 'admin_notices', function()
            {
                $message = '<p>' . sprintf( __( '%sAuthorship Data Updater%s - Post counters update will run once the post authorship update process finishes.', 'molongui-authorship' ), '<strong>', '</strong>' ) . '</p>';
                echo '<div class="notice notice-warning is-dismissible">' . $message . '</div>';
            });
        }
        else
        {
            delete_option( 'molongui_authorship_update_post_counters' );
            authorship_update_post_counters();
        }
    }
}
add_action( 'admin_init', 'authorship_post_counters_update', 11 );
function authorship_post_counters_update_completed()
{
    if ( get_option( 'm_update_post_counters_complete' ) )
    {
        delete_option( 'm_update_post_counters_complete' );
        delete_option( 'm_update_post_counters_running' );

        $message = '<p>' . sprintf( __( '%sAuthorship Data Updater%s - The update process is now complete. All posts counters are updated now.', 'molongui-authorship' ), '<strong>', '</strong>' ) . '</p>';
        echo '<div class="notice notice-success is-dismissible">' . $message . '</div>';
    }
    elseif ( get_option( 'm_update_post_counters_running' ) )
    {
        $message = '<p>' . sprintf( __( '%sAuthorship Data Updater%s - Posts counters update process is running in the background. It could take quite a long time to complete. Please be patient.', 'molongui-authorship' ), '<strong>', '</strong>' ) . '</p>';
        echo '<div class="notice notice-warning is-dismissible">' . $message . '</div>';
    }
}
add_action( 'admin_notices', 'authorship_post_counters_update_completed' );
function authorship_post_filter_count( $count, $userid, $post_type, $public_only )
{
    $author_type = ( is_guest_author() and !in_the_loop() ) ? 'guest' : 'user';

    /*!
     * PRIVATE FILTERS.
     *
     * For internal use only. Not intended to be used by plugin or theme developers.
     * Future compatibility NOT guaranteed.
     *
     * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
     * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
     * or deprecation phase.
     *
     * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
     * and knowing that it could cause code failure.
     */
    $author_id   = apply_filters( '_authorship/filter/count/author_id', $userid );
    $author_type = apply_filters( '_authorship/filter/count/author_type', $author_type );
    $author      = new Author( $author_id, $author_type );
    $post_counts = $author->get_post_count( $post_type );
    return array_sum( $post_counts );
}
add_filter( 'get_usernumposts', 'authorship_post_filter_count', 999, 4 );