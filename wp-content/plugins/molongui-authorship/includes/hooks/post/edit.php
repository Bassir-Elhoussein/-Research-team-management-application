<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_post_quick_add_guest()
{
    if ( !wp_verify_nonce( $_POST['nonce'], 'molongui_authorship_quick_add_nonce' ) ) die();
    if ( empty( $_POST['display_name'] ) )
    {
        echo json_encode( array( 'error' => __( "No display name provided", 'molongui-authorship' ) ) );
        die();
    }
    $postarr = array
    (
        'post_type'      => 'guest_author',
        'post_name'      => $_POST['display_name'],
        'post_title'     => $_POST['display_name'],
        'post_excerpt'   => '',
        'post_content'   => '',
        'thumbnail'      => '',
        'meta_input'     => array
        (
            '_molongui_guest_author_display_name' => $_POST['display_name'],
        ),
        'post_status'    => 'publish',
        'comment_status' => 'closed',
        'ping_status'    => 'closed',
        'post_author'    => get_current_user_id(),
    );
    $guest_id = wp_insert_post( $postarr, true );

    if ( is_wp_error( $guest_id ) )
    {
        echo json_encode( array( 'error' => $guest_id->get_error_message() ) );
    }
    else
    {
        authorship_guest_clear_object_cache();

        echo json_encode( array( 'guest_id' => $guest_id, 'guest_ref' => 'guest-'.$guest_id, 'guest_name' => $_POST['display_name'] ) );
    }

    die();
}
add_action( 'wp_ajax_quick_add_guest_author', 'authorship_post_quick_add_guest' );
function authorship_post_trash( $post_id )
{
    if ( is_customize_preview() ) return;
    $post_type = authorship_get_post_type( $post_id );
    if ( !authorship_is_post_type_enabled( $post_type, $post_id ) ) return;
    authorship_post_clear_object_cache();
    $post_status = authorship_post_status( $post_type );
    if ( in_array( get_post_meta( $post_id, '_wp_trash_meta_status', true ), $post_status ) )
    {
        authorship_decrement_post_counter( get_post_type( $post_id ), get_post_authors( $post_id, 'ref' ) );
    }
}
add_action( 'trashed_post', 'authorship_post_trash' );
function authorship_post_untrash( $post_id )
{
    $post_type = authorship_get_post_type( $post_id );
    if ( !authorship_is_post_type_enabled( $post_type, $post_id ) ) return;
    authorship_post_clear_object_cache();
    $post_status = authorship_post_status( $post_type );
    if ( in_array( get_post_meta( $post_id, '_wp_trash_meta_status', true ), $post_status ) )
    {
        authorship_increment_post_counter( get_post_type( $post_id ), get_post_authors( $post_id, 'ref' ) );
    }
}
add_action( 'untrashed_post', 'authorship_post_untrash' );
function authorship_post_remove_author_metabox()
{
    $post_types = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );
    foreach ( $post_types as $post_type ) remove_meta_box( 'authordiv', $post_type, 'normal' );
}
add_action( 'admin_menu', 'authorship_post_remove_author_metabox' );
function authorship_post_add_meta_boxes( $post_type )
{
    $editor_caps = apply_filters( 'authorship/editor_caps', current_user_can( 'edit_others_pages' ) or current_user_can( 'edit_others_posts' ), $post_type );
    if ( !$editor_caps ) return;
    $post_types = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all' );
    if ( in_array( $post_type, $post_types ) )
    {
        add_meta_box
        (
            'authorboxdiv'
            , __( "Authors", 'molongui-authorship' )
            , 'authorship_post_render_author_metabox'
            , $post_type
            , 'side'
            , 'high'
        );
    }
    if ( authorship_is_feature_enabled( 'box' ) and in_array( $post_type, authorship_box_post_types() ) )
    {
        add_meta_box
        (
            'showboxdiv'
            ,__( "Author Box", 'molongui-authorship' )
            ,'authorship_post_render_box_metabox'
            ,$post_type
            ,'side'
            ,'high'
        );
    }
}
add_action( 'add_meta_boxes', 'authorship_post_add_meta_boxes' );
function authorship_post_render_author_metabox( $post )
{
    wp_nonce_field( 'molongui_authorship_post', 'molongui_authorship_post_nonce' );
    if ( authorship_is_feature_enabled( 'multi' ) )
    {
        if ( authorship_is_feature_enabled( 'guest' ) )
        {
            $desc    = __( "Add as many authors as needed by selecting them from the dropdown below. Drag to change their order and click on trash icon to remove them. First listed author will be the main author.", 'molongui-authorship' );
            $select  = authorship_dropdown_authors( 'authors', array( 'mutli' => true, 'selected' => '' ) );
            $add_new = __( "+ Add new guest", 'molongui-authorship' );
        }
        else
        {
            $desc   = __( "Add as many authors as needed by selecting them from the dropdown below. Drag to change their order and click on trash icon to remove them. First listed author will be the main author.", 'molongui-authorship' );
            $select = authorship_dropdown_authors( 'users', array( 'mutli' => true, 'selected' => '' ) );
        }
    }
    else
    {
        if ( authorship_is_feature_enabled( 'guest' ) )
        {
            $desc    = sprintf( __( "Select an author for this post. Or enable the %sMulti-Author%s feature to add as many authors as needed.", 'molongui-authorship' ), '<strong><a href="'.authorship_options_url( 'co-authors' ).'" target="_blank">', '</a></strong>' );
            $author  = get_main_author( $post->ID );
            $select  = authorship_dropdown_authors( 'authors', array( 'mutli' => false, 'selected' => $author->ref ) );
            $add_new = __( "+ Add new guest", 'molongui-authorship' );
        }
        else
        {
            $desc   = sprintf( __( "Select a user as author for this post. Or enable the %sMulti-Author%s feature to add as many authors as needed or the %sGuest Author%s feature to add contributors without adding new real users.", 'molongui-authorship' ), '<strong><a href="'.authorship_options_url( 'co-authors' ).'" target="_blank">', '</a></strong>', '<strong><a href="" target="_blank">', '</a></strong>' );
            $author = $post->post_author ? $post->post_author : get_current_user_id();
            $select = authorship_dropdown_authors( 'users', array( 'mutli' => false, 'selected' => 'user-'.$author ) );
        }
    }
    include MOLONGUI_AUTHORSHIP_DIR . 'views/post/html-admin-author-metabox.php';
}
function authorship_post_render_box_metabox( $post )
{
    wp_nonce_field( 'molongui_authorship_post', 'molongui_authorship_post_nonce' );
    $screen = get_current_screen();
    $author_box_display  = get_post_meta( $post->ID, '_molongui_author_box_display', true );
    $author_box_position = get_post_meta( $post->ID, '_molongui_author_box_position', true );
    if ( empty( $author_box_display ) )  $author_box_display  = 'default';
    if ( empty( $author_box_position ) ) $author_box_position = 'default';
    include MOLONGUI_AUTHORSHIP_DIR . 'views/post/html-admin-box-metabox.php';
}
function authorship_dropdown_authors( $type = 'authors', $args = array() )
{
    global $post;
    extract( array_merge( array
    (
        'multi'    => authorship_is_feature_enabled( 'multi' ),
        'guest'    => authorship_is_feature_enabled( 'guest' ),
        'selected' => '',
    ), $args ) );
    $archived_users  = apply_filters( 'authorship/authors_dropdown/exclude_users' , authorship_get_archived_users()  );
    $archived_guests = apply_filters( 'authorship/authors_dropdown/exclude_guests', authorship_get_archived_guests() );
    $authors = molongui_get_authors( $type, array(), $archived_users, array(), $archived_guests );
    $html = '';
    if ( empty( $authors ) )
    {
        $html .= '<div><p>'.__( "No authors found.", 'molongui-authorship' ).'</p></div>';
    }
    else
    {
        if ( $multi )
        {
            $html .= '<select id="_molongui_author" name="_molongui_author" class="searchable" data-placeholder="'.__( 'Add an(other) author...', 'molongui-authorship' ).'">';
            foreach ( $authors as $author ) $html .= '<option value="'.$author['ref'].'" data-type="['.$author['type'].']">' . $author['name'] . '</option>';
        }
        else
        {
            $html .= '<select id="_molongui_author" name="_molongui_author" class="searchable" data-placeholder="'.__( 'Add an author...', 'molongui-authorship' ).'">';
            if ( !$selected )
            {
                $main_author = get_main_author( $post->ID );
                $selected    = $main_author->ref;
            }
            foreach ( $authors as $author ) $html .= '<option value="'.$author['ref'].'" data-type="['.$author['type'].']"'.selected( $author['type'].'-'.$author['id'], $selected, false ).'>' . $author['name'] . '</option>';
        }
        $html .= '</select>';
    }
    if ( !$multi ) return $html;

    $html .= '<div class="block__list block__list_words"><ul id="molongui_authors">';
    $post_authors = get_post_authors( $post->ID );

    if ( $post_authors )
    {
        foreach ( $post_authors as $author )
        {
            if ( $type == 'users' and $author->type == 'guest' ) continue;
            $author_class = new Author( $author->id, $author->type );
            $html .= '<li data-post="'.$post->ID.'" data-value="'.$author->ref.'">';
            $html .= $author_class->get_name();
            $html .= '<input type="hidden" name="molongui_authors[]" value="'.$author->ref.'" />';
            $html .= '<div class="m-tooltip">';
            $html .= '<span class="dashicons dashicons-trash js-remove"></span>';
            $html .= '<span class="m-tooltip__text m-tooltip__left">'.__( "Remove author from selection", 'molongui-authorship' ).'</span>';
            $html .= '</div>';
            $html .= '</li>';
        }
    }

    $html .= '</ul></div>';
    return $html;
}
function authorship_post_update_author( $data, $postarr, $unsanitized_postarr = array() )
{
    if ( !isset( $data['post_type'] ) or !authorship_is_post_type_enabled( $data['post_type'] ) ) return $data;
    if ( !authorship_byline_takeover() ) return $data;
    $current_author  = !empty( $postarr['post_author'] ) ? $postarr['post_author'] : false;
    $new_post_author = false;
    if ( !empty( $postarr['molongui_authors'] ) ) foreach ( $postarr['molongui_authors'] as $author )
    {
        $split = explode( '-', $author );
        if ( $split[0] == 'user' )
        {
            $new_post_author = $split[1];
            break;
        }
    }
    elseif ( !empty( $postarr['_molongui_author'] ) )
    {
        $split = explode( '-', $postarr['_molongui_author'] );
        if ( $split[0] == 'user' )
        {
            $new_post_author = $split[1];
        }
    }
    if ( !$new_post_author )
    {
        if ( $current_author ) $new_post_author = $current_author;
        else $new_post_author = get_current_user_id();
    }
    $data['post_author'] = $new_post_author;
    return $data;
}
add_filter( 'wp_insert_post_data', 'authorship_post_update_author', 10, 3 );
function authorship_post_previous_status( $post_id )
{
    $status = get_post_status( $post_id );

    add_filter( 'authorship/post/save/previous/status', function() use ( $status )
    {

        return $status;
    });
}
add_action( 'pre_post_update', 'authorship_post_previous_status' );
function authorship_post_save_authors( $data, $post_id, $class = '', $fn = '' )
{
    $post_status      = authorship_post_status( get_post_type( $post_id ) );
    $old_post_status  = apply_filters( 'authorship/post/save/previous/status', 'publish' );
    $new_post_status  = get_post_status( $post_id );
    $old_post_authors = get_post_meta( $post_id, '_molongui_author', false );
    $new_post_authors = authorship_is_feature_enabled( 'multi' ) ? $data['molongui_authors'] : array( $data['_molongui_author'] );
    $did_author_change = isset( $new_post_authors ) ? !molongui_are_arrays_equal( $old_post_authors, $new_post_authors ) : true;
    $did_status_change = ( ( $new_post_status !== $old_post_status ) and !( in_array( $old_post_status, $post_status ) and in_array( $new_post_status, $post_status ) ) );
    if ( !$did_author_change and !$did_status_change ) return;
    if ( !$did_author_change and $did_status_change ) goto update_authorship_counters;
    if ( empty( $new_post_authors ) and in_array( $data['post_type'], molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX ) ) )
    {
        $current_user        = wp_get_current_user();
        $new_post_authors[0] = 'user-'.$current_user->ID;
    }
    elseif ( empty( $new_post_authors ) )
    {
        $new_post_authors[0] = 'user-'.$data['post_author'];
    }
    delete_post_meta( $post_id, '_molongui_author' );
    foreach ( $new_post_authors as $author )
    {
        add_post_meta( $post_id, '_molongui_author', $author, false );
    }
    update_post_meta( $post_id, '_molongui_main_author', $new_post_authors[0] );
    update_authorship_counters:
    if ( $did_status_change )
    {
        if ( in_array( $new_post_status, $post_status ) )
        {
            authorship_increment_post_counter( $data['post_type'], $new_post_authors );
        }
        elseif ( in_array( $old_post_status, $post_status ) )
        {
            authorship_decrement_post_counter( $data['post_type'], $old_post_authors );
        }
    }
    else
    {
        $removed = array_diff( $old_post_authors, $new_post_authors );
        if ( !empty( $removed ) ) authorship_decrement_post_counter( $data['post_type'], $removed );
        $added = array_diff( $new_post_authors, $old_post_authors );
        if ( !empty( $added ) ) authorship_increment_post_counter( $data['post_type'], $added );
    }
}
function authorship_post_save( $post_id, $post )
{
    if ( is_null( $post_id ) or empty( $_POST ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) !== false ) return;
    if ( !isset( $_POST['post_type'] ) ) return;
    if ( 'page' == $_POST['post_type'] ) if ( !current_user_can( 'edit_page', $post_id ) ) return;
    elseif ( !current_user_can( 'edit_post', $post_id ) ) return;
    if ( !isset( $_POST['molongui_authorship_post_nonce'] ) or !wp_verify_nonce( $_POST['molongui_authorship_post_nonce'], 'molongui_authorship_post' ) ) return;
    if ( (int)$_POST['post_ID'] !== (int)$post_id ) return;

    global $current_screen;
    if ( MOLONGUI_AUTHORSHIP_CPT == $current_screen->post_type ) return $post_id;
    authorship_post_save_authors( $_POST, $post_id );
    if ( isset( $_POST['_molongui_author_box_display'] ) ) update_post_meta( $post_id, '_molongui_author_box_display', $_POST['_molongui_author_box_display'] );
    if ( isset( $_POST['_molongui_author_box_position'] ) ) update_post_meta( $post_id, '_molongui_author_box_position', $_POST['_molongui_author_box_position'] );
    authorship_post_clear_object_cache();

    return $post_id;
} // save
add_action( 'save_post'         , 'authorship_post_save', 10, 2 );
add_action( 'attachment_updated', 'authorship_post_save', 10, 2 );