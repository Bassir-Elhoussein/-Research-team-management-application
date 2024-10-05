<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_author()
{
    check_admin_referer( 'create-author', 'authorship-create-author-nonce' );
    if ( empty( $_REQUEST['user-account'] ) )
    {
        $display_name = $_REQUEST['first-name'] . ' ' . $_REQUEST['last-name'];
        $postarr = array
        (
            'post_type'      => 'guest_author',
            'post_title'     => $display_name,
            'meta_input'     => array
            (
                '_molongui_guest_author_display_name' => $display_name,
                '_molongui_guest_author_first_name'   => $_REQUEST['first-name'],
                '_molongui_guest_author_last_name'    => $_REQUEST['last-name'],
            ),
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        );
        $guest_id = wp_insert_post( $postarr, true );
        if ( is_wp_error( $guest_id ) )
        {
            update_option( 'molongui_authorship_add_author_error_'.get_current_user_id(), $guest_id, 'yes' );
            update_option( 'molongui_authorship_add_author_input_'.get_current_user_id(), $_REQUEST, 'yes' );
            wp_safe_redirect( wp_get_referer() );
            die();
        }
        else
        {
            authorship_guest_clear_object_cache();
            wp_safe_redirect( add_query_arg( array( 'post' => $guest_id, 'action' => 'edit' ), self_admin_url( 'post.php' ) ) );
            die();
        }
    }
    else
    {
        if ( !current_user_can( 'create_users' ) )
        {
            wp_die(
                '<h1>' . __( 'You need a higher level of permission.' ) . '</h1>' .
                '<p>' . __( 'Sorry, you are not allowed to create users.' ) . '</p>',
                403
            );
        }
        $userdata = array
        (
            'first_name' => $_REQUEST['first-name'],
            'last_name'  => $_REQUEST['last-name'],
            'role'       => $_REQUEST['role'],
            'user_login' => $_REQUEST['username'],
            'user_pass'  => $_REQUEST['password'],
            'user_email' => wp_unslash( $_REQUEST['email'] ),
            'locale'     => '',
        );
        $user_id = wp_insert_user( $userdata );
        if ( is_wp_error( $user_id ) )
        {
            update_option( 'molongui_authorship_add_author_error_'.get_current_user_id(), $user_id, 'yes' );
            update_option( 'molongui_authorship_add_author_input_'.get_current_user_id(), $_REQUEST, 'yes' );
            wp_safe_redirect( wp_get_referer() );
            die();
        }
        else
        {
            $notify = !empty( $_REQUEST['user-notify'] ) ? 'both' : 'admin';
            wp_new_user_notification( $user_id, null, $notify );
            authorship_user_clear_object_cache();
            wp_safe_redirect( add_query_arg( 'user_id', $user_id, self_admin_url( 'user-edit.php#molongui-user-fields' ) ) );
            die();
        }
    }
}
add_action( 'admin_post_add_author', 'authorship_add_author' );