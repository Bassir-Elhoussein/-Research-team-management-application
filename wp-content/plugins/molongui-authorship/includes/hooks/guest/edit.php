<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_guest_save( $post_id )
{
    if ( !isset( $_POST['molongui_authorship_guest_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_guest_nonce'], 'molongui_authorship_guest' ) ) return $post_id;
    if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return $post_id;
    if ( wp_is_post_revision( $post_id ) ) return $post_id;
    if ( 'page' == $_POST['post_type'] ) if ( !current_user_can( 'edit_page', $post_id ) ) return $post_id;
    elseif ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;
    $networks = authorship_get_social_networks( 'enabled' );
    $inputs = array
    (
        '_molongui_guest_author_first_name',
        '_molongui_guest_author_last_name',
        '_molongui_guest_author_display_name',
        '_molongui_guest_author_mail',
        '_molongui_guest_author_phone',
        '_molongui_guest_author_web',
        '_molongui_guest_author_job',
        '_molongui_guest_author_company',
        '_molongui_guest_author_company_link',
    );
    foreach ( $inputs as $input )
    {
        if ( !empty( $_POST[$input] ) ) update_post_meta( $post_id, $input, sanitize_text_field( $_POST[$input] ) );
        else delete_post_meta( $post_id, $input );
    }
    foreach ( $networks as $id => $network )
    {
        if ( !empty( $_POST['_molongui_guest_author_'.$id] ) ) update_post_meta( $post_id, '_molongui_guest_author_'.$id, sanitize_text_field( $_POST['_molongui_guest_author_'.$id] ) );
        else delete_post_meta( $post_id, '_molongui_guest_author_'.$id );
    }
    $checkboxes = array
    (
        '_molongui_guest_author_show_meta_mail',
        '_molongui_guest_author_show_meta_phone',
        '_molongui_guest_author_show_icon_mail',
        '_molongui_guest_author_show_icon_web',
        '_molongui_guest_author_show_icon_phone',
        '_molongui_guest_author_archived',
    );
    foreach ( $checkboxes as $checkbox )
    {
        if ( isset( $_POST[$checkbox] ) ) update_post_meta( $post_id, $checkbox, sanitize_text_field( $_POST[$checkbox] ) );
        else delete_post_meta( $post_id, $checkbox );
    }
    update_post_meta( $post_id, '_molongui_guest_author_box_display', 'default' );
    authorship_guest_clear_object_cache();
    add_filter( 'redirect_post_location', 'authorship_guest_add_notice_query_var', 99, 2 );
    do_action( 'authorship/guest/save', $post_id, $_POST );
}
add_action( 'save_post_'.MOLONGUI_AUTHORSHIP_CPT, 'authorship_guest_save' );
function authorship_guest_add_notice_query_var( $location, $post_id )
{
    remove_filter( 'redirect_post_location', 'authorship_guest_add_notice_query_var', 99 );

    $name_exists = authorship_author_name_exists( $post_id, 'guest' );
    if ( $name_exists )
    {
        switch ( $name_exists )
        {
            case 'user' : return add_query_arg( array( 'authorship_guest_save' => 'user_alert'  ), $location ); break;
            case 'guest': return add_query_arg( array( 'authorship_guest_save' => 'guest_alert' ), $location ); break;
            case 'both' : return add_query_arg( array( 'authorship_guest_save' => 'both_alert'  ), $location ); break;
        }
    }

    return $location;
}
function authorship_guest_add_removable_arg( $args )
{
    array_push( $args, 'authorship_guest_save' );
    return $args;
}
add_filter( 'removable_query_args', 'authorship_guest_add_removable_arg' );
function authorship_guest_admin_notices()
{
    if ( !isset( $_GET['authorship_guest_save'] ) ) return;

    switch ( $_GET['authorship_guest_save'] )
    {
        case 'user_alert':
            $message = esc_html__( 'There is a registered WordPress user with the same display name. You might want to address that.', 'molongui-authorship' );
        break;

        case 'guest_alert':
            $message = esc_html__( 'There is another guest author with the same display name. You might want to address that.', 'molongui-authorship' );
        break;

        case 'both_alert':
            $message = esc_html__( 'There is a registered WordPress user and another guest author with the same display name. You might want to address that.', 'molongui-authorship' );
        break;

        default:
            $message = '';
        break;
    }

    if ( empty( $message ) ) return;
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php echo $message; ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'authorship_guest_admin_notices' );
add_action( 'trashed_post'  , 'authorship_guest_clear_object_cache' );
add_action( 'untrashed_post', 'authorship_guest_clear_object_cache' );
function authorship_guest_delete( $guest_id )
{
    $author      = new Author( $guest_id, 'guest' );
    $guest_posts = $author->get_posts( array( 'fields' => 'ids', 'post_type' => 'all' ) );

    add_filter( 'authorship/admin/guest/delete', function() use ( $guest_posts ) { return $guest_posts; } );
}
add_action( 'delete_post', 'authorship_guest_delete' );
function authorship_guest_deleted( $guest_id, $guest = null )
{
    $post_ids = apply_filters( 'authorship/admin/guest/delete', array() );
    if ( !empty( $post_ids ) )
    {
        foreach ( $post_ids as $post_id )
        {
            delete_post_meta( $post_id, '_molongui_author', 'guest-'.$guest_id );
            if ( get_post_meta( $post_id, '_molongui_main_author', true ) === 'guest-'.$guest_id )
            {
                $post_authors = get_post_meta( $post_id, '_molongui_author', false );
                if ( empty( $post_authors ) )
                {
                    $post_author = get_post_field ('post_author', $post_id );
                    update_post_meta( $post_id, '_molongui_main_author', 'user-'.$post_author, 'guest-'.$guest_id );
                    update_post_meta( $post_id, '_molongui_author', 'user-'.$post_author );
                }
                else
                {
                    update_post_meta( $post_id, '_molongui_main_author', $post_authors[0], 'guest-'.$guest_id );
                    if ( strpos( $post_authors[0], 'user-' ) !== false )
                    {
                        $id = str_replace ( 'user-', '', $post_authors[0] );
                        wp_update_post( array( 'ID' => $post_id, 'post_author' => $id ) );
                    }
                }
            }
        }
    }
    authorship_guest_clear_object_cache();
    do_action( 'authorship/admin/guest/deleted', $guest_id, $guest );
}
add_action( 'deleted_post', 'authorship_guest_deleted', 10, 2 );
function authorship_guest_remove_media_buttons()
{
    global $current_screen;

    if ( MOLONGUI_AUTHORSHIP_CPT == $current_screen->post_type ) remove_action( 'media_buttons', 'media_buttons' );
}
add_action( 'admin_head', 'authorship_guest_remove_media_buttons' );
function authorship_guest_remove_preview_button()
{
    $current_screen = get_current_screen();
    if ( $current_screen->post_type != MOLONGUI_AUTHORSHIP_CPT ) return;
    if ( apply_filters( 'authorship/admin/guest/show_preview_button', false, $current_screen ) ) return;
    echo '<style>#post-preview{ display:none !important; }</style>';
}
add_action( 'admin_head', 'authorship_guest_remove_preview_button' );
function authorship_guest_add_top_section_after_title()
{
    global $post;
    if ( $post->post_type !== MOLONGUI_AUTHORSHIP_CPT ) return;
    do_meta_boxes( get_current_screen(), 'top', $post );
}
add_action( 'edit_form_after_title', 'authorship_guest_add_top_section_after_title' );
function authorship_guest_add_meta_boxes( $post_type )
{
    if ( !current_user_can( 'edit_others_pages' ) and !current_user_can( 'edit_others_posts' ) ) return;
    if ( in_array( $post_type, array( MOLONGUI_AUTHORSHIP_CPT ) ) )
    {
        add_meta_box(
            'authorprofilediv'
            ,__( "Profile", 'molongui-authorship' )
            ,'authorship_guest_render_profile_metabox'
            ,$post_type
            ,'top'
            ,'high'
        );
        add_meta_box(
            'authorbiodiv'
            ,__( "Biography", 'molongui-authorship' )
            ,'authorship_guest_render_bio_metabox'
            ,$post_type
            ,'top'
            ,'high'
        );
        if ( apply_filters( 'authorship/admin/guest/shortbio/metabox', '__return_true' ) )
        {
            add_meta_box(
                'authorshortbiodiv'
                ,__( "Short Biography", 'molongui-authorship' )
                ,'authorship_guest_render_short_bio_metabox'
                ,$post_type
                ,'top'
                ,'default'
            );
        }
        add_meta_box(
            'authorsocialdiv'
            ,__( "Social Media", 'molongui-authorship' )
            ,'authorship_guest_render_social_metabox'
            ,$post_type
            ,'normal'
            ,'high'
        );
        if ( !authorship_is_feature_enabled( 'avatar' ) )
        {
            add_meta_box(
                'authoravatardiv'
                ,__( "Profile Image", 'molongui-authorship' )
                ,'authorship_guest_render_avatar_metabox'
                ,$post_type
                ,'side'
                ,'low'
            );
        }
        add_meta_box(
            'authorarchivediv'
            ,__( "Archive", 'molongui-authorship' )
            ,'authorship_guest_render_archive_metabox'
            ,$post_type
            ,'side'
            ,'high'
        );
        if ( authorship_is_feature_enabled( 'box' ) )
        {
            add_meta_box(
                'authorboxdiv'
                ,__( "Author Box", 'molongui-authorship' )
                ,'authorship_guest_render_box_metabox'
                ,$post_type
                ,'side'
                ,'low'
            );
        }
        if ( apply_filters( 'authorship/admin/guest/convert/metabox', '__return_true' ) )
        {
            add_meta_box(
                'authorconversiondiv'
                ,__( "Role" )
                ,'authorship_guest_render_conversion_metabox'
                ,$post_type
                ,'side'
                ,'low'
            );
        }
        do_action( 'authorship/admin/guest/metaboxes', $post_type );
    }
}
add_action( 'add_meta_boxes', 'authorship_guest_add_meta_boxes' );
function authorship_guest_render_profile_metabox( $post )
{
    wp_nonce_field( 'molongui_authorship_guest', 'molongui_authorship_guest_nonce' );
    $guest_author_first_name   = get_post_meta( $post->ID, '_molongui_guest_author_first_name', true );
    $guest_author_last_name    = get_post_meta( $post->ID, '_molongui_guest_author_last_name', true );
    $guest_author_display_name = get_post_meta( $post->ID, '_molongui_guest_author_display_name', true ); //get_the_title( $post->ID );
    $guest_author_mail         = get_post_meta( $post->ID, '_molongui_guest_author_mail', true );
    $guest_author_phone        = get_post_meta( $post->ID, '_molongui_guest_author_phone', true );
    $guest_author_web          = get_post_meta( $post->ID, '_molongui_guest_author_web', true );
    $guest_author_job          = get_post_meta( $post->ID, '_molongui_guest_author_job', true );
    $guest_author_company      = get_post_meta( $post->ID, '_molongui_guest_author_company', true );
    $guest_author_company_link = get_post_meta( $post->ID, '_molongui_guest_author_company_link', true );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-profile-metabox.php';
}
function authorship_guest_render_bio_metabox( $post )
{
    $guest_author_bio = get_post_field( 'post_content', $post->ID );
    wp_editor( $guest_author_bio, 'content', array( 'media_buttons' => false, /*'editor_height' => 100,*/ 'textarea_rows' => 10, 'editor_css' => '<style>#wp-content-editor-tools{background:none;padding-top:0;}</style>' ) );
}
function authorship_guest_render_short_bio_metabox( $post )
{
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-short-bio-metabox.php';
}
function authorship_guest_render_social_metabox( $post )
{
    $networks = authorship_get_social_networks( 'enabled' );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-social-metabox.php';
}
function authorship_guest_render_archive_metabox( $post )
{
    $guest_author_archived = get_post_meta( $post->ID, '_molongui_guest_author_archived', true );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-archive-metabox.php';
}
function authorship_guest_render_box_metabox( $post )
{
    $guest_author_hide_box   = get_post_meta( $post->ID, '_molongui_guest_author_box_display', true );
    $guest_author_mail_icon  = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_mail', true );
    $guest_author_phone_icon = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_phone', true );
    $guest_author_web_icon   = get_post_meta( $post->ID, '_molongui_guest_author_show_icon_web', true );
    $guest_author_mail_meta  = get_post_meta( $post->ID, '_molongui_guest_author_show_meta_mail', true );
    $guest_author_phone_meta = get_post_meta( $post->ID, '_molongui_guest_author_show_meta_phone', true );
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-box-metabox.php';
}
function authorship_guest_render_avatar_metabox( $post )
{
    $options = authorship_get_options();
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-avatar-metabox.php';
}
function authorship_guest_render_conversion_metabox( $post )
{
    include MOLONGUI_AUTHORSHIP_DIR . 'views/guest-author/html-admin-convert-metabox.php';
}
function authorship_guest_add_conversion_metabox_class( $classes )
{
    if ( apply_filters( 'authorship/admin/guest/convert/metabox', '__return_true' ) ) array_push( $classes, 'free' );
    return $classes;
}
add_filter( 'postbox_classes_'.MOLONGUI_AUTHORSHIP_CPT.'_authorconversiondiv', 'authorship_guest_add_conversion_metabox_class' );
function authorship_guest_add_short_bio_metabox_class( $classes )
{
    if ( apply_filters( 'authorship/admin/guest/shortbio/metabox', '__return_true' ) ) array_push( $classes, 'free' );
    return $classes;
}
add_filter( 'postbox_classes_'.MOLONGUI_AUTHORSHIP_CPT.'_authorshortbiodiv', 'authorship_guest_add_short_bio_metabox_class' );
function authorship_guest_filter_cpt_title( $data , $postarr )
{
    if ( $data['post_type'] != MOLONGUI_AUTHORSHIP_CPT ) return $data;
    if ( $postarr['ID'] == null or empty( $_POST ) ) return $data;
    if ( !isset( $_POST['molongui_authorship_guest_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_guest_nonce'], 'molongui_authorship_guest' ) ) return $data;
    $first_name   = !empty( $_POST['_molongui_guest_author_first_name'] )   ? $_POST['_molongui_guest_author_first_name']   : '';
    $last_name    = !empty( $_POST['_molongui_guest_author_last_name'] )    ? $_POST['_molongui_guest_author_last_name']    : '';
    $display_name = !empty( $_POST['_molongui_guest_author_display_name'] ) ? $_POST['_molongui_guest_author_display_name'] : '';
    if ( $display_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_display_name'] );
    elseif (  $first_name and  $last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_first_name'] ) . ' ' . sanitize_text_field( $_POST['_molongui_guest_author_last_name'] );
    elseif (  $first_name and !$last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_first_name'] );
    elseif ( !$first_name and  $last_name ) $post_title = sanitize_text_field( $_POST['_molongui_guest_author_last_name'] );

    if ( !empty( $post_title ) ) $data['post_title'] = $post_title;
    $data['post_name'] = '';
    return $data;
}
add_filter( 'wp_insert_post_data', 'authorship_guest_filter_cpt_title', 99, 2 );