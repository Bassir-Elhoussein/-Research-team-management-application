<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_enable_post_authors_update()
{
    new \Molongui\Authorship\Includes\Update_Post_Authors();
}
add_action( 'authorship/init', 'authorship_enable_post_authors_update' );
function authorship_post_authors_update()
{
    if ( apply_filters( 'authorship/check_wp_cron', true ) and ( defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) ) return false;

    if ( get_option( 'molongui_authorship_update_post_authors' ) )
    {
        delete_option( 'molongui_authorship_update_post_authors' );
        authorship_update_post_authors();
    }
}
add_action( 'admin_init', 'authorship_post_authors_update', 10 );
function authorship_post_authors_update_completed()
{
    if ( get_option( 'm_update_post_authors_complete' ) )
    {
        delete_option( 'm_update_post_authors_complete' );
        delete_option( 'm_update_post_authors_running' );

        $message = '<p>' . sprintf( __( '%sAuthorship Data Updater%s - The update process is now complete. All posts have authorship information now.', 'molongui-authorship' ), '<strong>', '</strong>' ) . '</p>';
        echo '<div class="notice notice-success is-dismissible">' . $message . '</div>';
    }
    elseif ( get_option( 'm_update_post_authors_running' ) )
    {
        $message = '<p>' . sprintf( __( '%sAuthorship Data Updater%s - Post authorship update process is running in the background. It should not take long.', 'molongui-authorship' ), '<strong>', '</strong>' ) . '</p>';
        echo '<div class="notice notice-warning is-dismissible">' . $message . '</div>';
    }
}
add_action( 'admin_notices', 'authorship_post_authors_update_completed' );