<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_remove_mine_filter( $views )
{
    unset( $views['mine'] );

    return $views;
}
add_filter( 'views_edit-'.MOLONGUI_AUTHORSHIP_CPT, 'authorship_remove_mine_filter' );
function authorship_guest_add_list_columns( $columns )
{
    unset( $columns['title'] );
    unset( $columns['date'] );
    unset( $columns['thumbnail'] );
    $new_cols = array
    (
        'guestAuthorPic'     => __( "Photo", 'molongui-authorship' ),
        'title'		         => __( "Name", 'molongui-authorship' ),
        'guestDisplayBox'    => __( "Box", 'molongui-authorship' ),
        'guestAuthorBio'     => __( "Bio", 'molongui-authorship' ),
        'guestAuthorMail'    => __( "Email", 'molongui-authorship' ),
        'guestAuthorPhone'   => __( "Phone", 'molongui-authorship' ),
        'guestAuthorUrl'     => __( "URL", 'molongui-authorship' ),
        'guestAuthorJob'     => __( "Job", 'molongui-authorship' ),
        'guestAuthorCia'     => __( "Co.", 'molongui-authorship' ),
        'guestAuthorCiaUrl'  => __( "Co. URL", 'molongui-authorship' ),
        'guestAuthorSocial'  => __( "Social", 'molongui-authorship' ),
        'guestAuthorEntries' => __( "Entries", 'molongui-authorship' ),
        'guestAuthorId'      => __( "ID", 'molongui-authorship' ),
    );
    if ( !authorship_is_feature_enabled( 'box' ) )
    {
        unset( $new_cols['guestDisplayBox'] );
    }
    if ( 'trash' == get_query_var( 'post_status' ) ) unset( $new_cols['guestAuthorEntries'] );
    return array_merge( $columns, $new_cols );
}
add_filter( 'manage_'.MOLONGUI_AUTHORSHIP_CPT.'_posts_columns', 'authorship_guest_add_list_columns' );
function authorship_guest_fill_list_columns( $column, $ID )
{
    $value = '';
    $author = new Author ( $ID, 'guest' );
    if ( $column == 'guestAuthorPic' )
    {
        echo get_the_post_thumbnail( $ID, array( 60, 60 ) );
        return;
    }
    elseif ( $column == 'guestDisplayBox' )
    {
        $value = $author->get_meta( 'box_display' );

        switch ( $value )
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

        $html  = '<div id="box_display_'.$ID.'" data-display-box="'.$value.'">';
        $html .= '<div class="m-tooltip">';
        $html .= '<span class="dashicons dashicons-'.$icon.'"></span>';
        $html .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w100">'.$tip.'</span>';
        $html .= '</div>';
        $html .= '</div>';

        echo $html;
        return;
    }
    elseif ( $column == 'guestAuthorEntries' )
    {
        $html   = '';
        $values = $author->get_post_count();
        foreach ( molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', true ) as $post_type )
        {
            $link = admin_url( 'edit.php?post_type='.$post_type['id'].'&guest='.$ID );
            if ( isset( $values[$post_type['id']] ) and $values[$post_type['id']] > 0 ) $html .= '<div><a href="'.$link.'">'.$values[$post_type['id']].' '.$post_type['label'].'</a></div>';
        }
        if ( !$html ) $html = __( 'None' );

        echo $html;
        return;
    }
    elseif ( $column == 'guestAuthorSocial' )
    {
        $networks = authorship_get_social_networks( 'enabled' );
        foreach ( $networks as $name => $network )
        {
            if ( $sn = $author->get_meta( $name ) )
            {
                $html  = '<div class="m-tooltip">';
                $html .= '<a href="'.esc_url( $sn ).'" target="_blank">';
                $html .= '<i class="m-a-icon-'.$name.'"></i>';
                $html .= '</a>';
                $html .= '<span class="m-tooltip__text m-tooltip__top">'.esc_url( $sn ).'</span>';
                $html .= '</div>';

                echo $html;
            }
        }
        return;
    }
    elseif ( $column == 'guestAuthorId' )
    {
        echo $ID;
        return;
    }
    elseif ( $column == 'guestAuthorBio'   ) $value = $author->get_bio();
    elseif ( $column == 'guestAuthorMail'  ) $value = $author->get_meta( 'mail' );
    elseif ( $column == 'guestAuthorPhone' ) $value = $author->get_meta( 'phone' );
    elseif ( $column == 'guestAuthorJob'   ) $value = $author->get_meta( 'job' );
    elseif ( $column == 'guestAuthorCia'   ) $value = $author->get_meta( 'company' );

    if ( !empty( $value ) )
    {
        $html  = '<div class="m-tooltip">';
        $html .= '<i class="m-a-icon-ok"></i>';
        $html .= '<span class="m-tooltip__text m-tooltip__top'.( 'guestAuthorBio' === $column ? ' m-tooltip__w400' : ' m-tooltip__w100' ).'">'.esc_html( $value ).'</span>';
        $html .= '</div>';

        echo $html;
        return;
    }
    elseif ( $column == 'guestAuthorUrl'    ) $value = $author->get_meta( 'web' );
    elseif ( $column == 'guestAuthorCiaUrl' ) $value = $author->get_meta( 'company_link' );

    if ( !empty( $value ) )
    {
        $html  = '<div class="m-tooltip">';
        $html .= '<a href="'.esc_url( $value ).'" target="_blank">';
        $html .= '<i class="m-a-icon-ok"></i>';
        $html .= '</a>';
        $html .= '<span class="m-tooltip__text m-tooltip__top m-tooltip__w100">'.esc_url( $value ).'</span>';
        $html .= '</div>';

        echo $html;
        return;
    }
    else
    {
        echo '-';
        return;
    }
}
add_action( 'manage_'.MOLONGUI_AUTHORSHIP_CPT.'_posts_custom_column', 'authorship_guest_fill_list_columns', 5, 2 );
function authorship_guest_remove_view_link( $actions )
{
    if ( !apply_filters( 'authorship/guest/row_actions/remove_view_link', true ) ) return $actions;

    if ( MOLONGUI_AUTHORSHIP_CPT == get_post_type() ) unset( $actions['view'] );

    return $actions;
}
add_filter( 'post_row_actions', 'authorship_guest_remove_view_link', 10, 1 );
function authorship_guest_remove_bulk_edit_action( $actions )
{
    if ( !apply_filters( 'authorship/guest/bulk_actions/remove_edit', true ) ) return $actions;

    unset( $actions['edit'] );
    return $actions;
}
add_filter( 'bulk_actions-'.'edit-'.MOLONGUI_AUTHORSHIP_CPT, 'authorship_guest_remove_bulk_edit_action' );