<?php
defined( 'ABSPATH' ) or exit;
function authorship_user_edit_columns( $column_headers )
{
    unset( $column_headers['posts'] );
    $column_headers['molongui-entries'] = __( "Entries", 'molongui-authorship' );
    if ( authorship_is_feature_enabled( 'box' ) )
    {
        $column_headers['molongui-box'] = __( "Author Box", 'molongui-authorship' );
    }
    $column_headers['user-id'] = __( 'ID' );

    return $column_headers;
}
add_filter( 'manage_users_columns', 'authorship_user_edit_columns' );
function authorship_user_fill_columns( $value, $column, $ID )
{
    if ( $column == 'user-id' ) return $ID;
    elseif ( $column == 'molongui-entries' )
    {
        $html = '';
        $post_types = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', true );
        $post_types_id = array_column( $post_types, 'id' );
        foreach ( array( 'post', 'page' ) as $post_type )
        {
            if ( !in_array( $post_type, $post_types_id ) )
            {
                $post_type_obj = get_post_type_object( $post_type );
                $post_types    = array_merge( $post_types, array( array( 'id' => $post_type, 'label' => $post_type_obj->label, 'singular' => $post_type_obj->labels->singular_name ) ) );
            }
        }
        foreach ( $post_types as $post_type )
        {
            $count = get_user_meta( $ID, 'molongui_author_' . $post_type['id'] . '_count', true );
            $link  = admin_url( 'edit.php?post_type=' . $post_type['id'] . '&author=' . $ID );
            if ( $count > 0 )
            {
                $html .= '<div><a href="' . $link . '">' . $count . ' ' . ( $count == 1 ? $post_type['singular'] : $post_type['label'] ) . '</a></div>';
            }
        }
        if ( !$html ) $html = __( "None" );

        return $html;
    }
    elseif ( $column == 'molongui-box' )
    {
        switch ( get_user_meta( $ID, 'molongui_author_box_display', true ) )
        {
            case 'show':
                $icon = 'visibility';
                $tip  = __( "Visible", 'molongui-authorship' );
            break;

            case 'hide':
                $icon = 'hidden';
                $tip  = __( "Hidden", 'molongui-authorship' );
            break;

            default:
                $icon = 'admin-generic';
                $tip  = __( "Visibility depends on global plugin settings", 'molongui-authorship' );
            break;
        }

        $html  = '<div class="m-tooltip">';
        $html .= '<span class="dashicons dashicons-'.$icon.'"></span>';
        $html .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w100">'.$tip.'</span>';
        $html .= '</div>';

        return $html;
    }

    return $value;
}
add_action( 'manage_users_custom_column', 'authorship_user_fill_columns', 10, 3 );