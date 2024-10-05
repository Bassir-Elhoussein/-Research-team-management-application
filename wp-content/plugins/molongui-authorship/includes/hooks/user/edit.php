<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_user_add_profile_fields( $user )
{
    if ( is_object( $user ) )
    {
        if ( !current_user_can( 'edit_user', $user->ID ) ) return;
        $match = array_intersect( $user->roles, apply_filters( 'authorship/user/roles', array( 'administrator', 'editor', 'author', 'contributor' ) ) );
        if ( empty( $match ) ) return;
    }
    else
    {
        if ( 'add-new-user' !== $user ) return;

        $user     = new stdClass();
        $user->ID = 0;
    }
    authorship_enqueue_edit_user_scripts();
    if ( authorship_is_feature_enabled( 'user_profile' ) ) include MOLONGUI_AUTHORSHIP_DIR . 'views/user/html-admin-plugin-fields.php';
    elseif ( authorship_is_feature_enabled( 'avatar' ) ) include MOLONGUI_AUTHORSHIP_DIR . 'views/user/html-admin-profile-picture.php';
}

add_action( 'edit_user_profile', 'authorship_user_add_profile_fields', 0 ); // Edit user screen
add_action( 'show_user_profile', 'authorship_user_add_profile_fields', 0 ); // Profile screen
function authorship_user_filter_profile_picture_description( $description, $profileuser )
{
    $add          = ' ';
    $user_profile = authorship_is_feature_enabled( 'user_profile' );
    $local_avatar = authorship_is_feature_enabled( 'avatar' );
    if ( $user_profile and $local_avatar )
    {
        $add .= sprintf( __( 'Or you can upload a custom profile picture using %sMolongui Authorship field%s.', 'molongui-authorship' ), '<a href="#molongui-user-fields">', '</a>' );
    }
    elseif ( !$user_profile and $local_avatar )
    {
        $add .= __( 'Or you can upload a custom profile using the "Local Avatar" field below.', 'molongui-authorship' );
    }
    else
    {
        $add .= sprintf( __( 'Or you can upload a custom profile picture enabling Molongui Authorship "Local Avatar" feature %shere%s.', 'molongui-authorship' ), '<a href="' . authorship_options_url( 'users' ) . '" target="_blank">', '</a>' );
    }

    return $description . $add;
}
add_filter( 'user_profile_picture_description', 'authorship_user_filter_profile_picture_description', 10, 2 );
function authorship_user_save_profile_fields( $user_id )
{
    if ( !current_user_can( 'edit_user', $user_id ) ) return;
    if ( authorship_is_feature_enabled( 'user_profile' ) )
    {
        update_user_meta( $user_id, 'molongui_author_phone', $_POST['molongui_author_phone'] );
        update_user_meta( $user_id, 'molongui_author_job', $_POST['molongui_author_job'] );
        update_user_meta( $user_id, 'molongui_author_company', $_POST['molongui_author_company'] );
        update_user_meta( $user_id, 'molongui_author_company_link', $_POST['molongui_author_company_link'] );

        foreach ( authorship_get_social_networks( 'enabled' ) as $id => $network )
        {
            if ( !empty( $_POST['molongui_author_' . $id] ) ) update_user_meta( $user_id, 'molongui_author_' . $id, sanitize_text_field( $_POST['molongui_author_' . $id] ) );
            else delete_user_meta( $user_id, 'molongui_author_' . $id );
        }
        $checkboxes = array
        (
            'molongui_author_show_meta_mail',
            'molongui_author_show_meta_phone',
            'molongui_author_show_icon_mail',
            'molongui_author_show_icon_web',
            'molongui_author_show_icon_phone',
            'molongui_author_archived',
        );
        foreach ( $checkboxes as $checkbox )
        {
            if ( isset( $_POST[$checkbox] ) ) update_user_meta( $user_id, $checkbox, sanitize_text_field( $_POST[$checkbox] ) );
            else delete_user_meta( $user_id, $checkbox );
        }
        update_post_meta( $user_id, 'molongui_author_box_display', 'default' );
        do_action( 'authorship/user/save', $user_id, $_POST );
    }
    if ( authorship_is_feature_enabled( 'avatar' ) )
    {
        if ( current_user_can( 'upload_files', $user_id ) )
        {
            if ( isset( $_POST['molongui_author_image_id']   ) ) update_user_meta( $user_id, 'molongui_author_image_id'  , $_POST['molongui_author_image_id']   );
            if ( isset( $_POST['molongui_author_image_url']  ) ) update_user_meta( $user_id, 'molongui_author_image_url' , $_POST['molongui_author_image_url']  );
            if ( isset( $_POST['molongui_author_image_edit'] ) ) update_user_meta( $user_id, 'molongui_author_image_edit', $_POST['molongui_author_image_edit'] );
        }
    }
}
add_action( 'profile_update', 'authorship_user_save_profile_fields' ); // Fires immediately after an existing user is updated.
function authorship_user_delete( $user_id, $reassign )
{
    if ( $reassign === null ) return;

    $author     = new Author( $user_id, 'user' );
    $user_posts = $author->get_posts( array( 'fields' => 'ids', 'post_type' => 'all' ) );

    add_filter( 'authorship/admin/user/delete', function() use ( $user_posts )
    {
        return $user_posts;
    } );
}
add_action( 'delete_user', 'authorship_user_delete', 10, 2 );
function authorship_user_deleted( $user_id, $reassign )
{
    if ( $reassign === null ) return;
    $post_ids = apply_filters( 'authorship/admin/user/delete', array() );
    if ( empty( $post_ids ) ) return;
    $old_usr = 'user-' . $user_id;
    $new_usr = 'user-' . $reassign;
    foreach ( $post_ids as $post_id )
    {
        delete_post_meta( $post_id, '_molongui_author', $old_usr );
        if ( get_post_meta( $post_id, '_molongui_main_author', true ) === $old_usr )
        {
            update_post_meta( $post_id, '_molongui_main_author', $new_usr, $old_usr );
            update_post_meta( $post_id, '_molongui_author', $new_usr );
        }
    }
    authorship_update_post_counters( 'all', $new_usr );
}
add_action( 'deleted_user', 'authorship_user_deleted', 10, 2 );