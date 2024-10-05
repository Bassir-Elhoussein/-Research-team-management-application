<?php

use Molongui\Authorship\Includes\Libraries\Common\PointerPlus;
$pointerplus = new PointerPlus( array( 'prefix' => 'molongui-authorship' ) );
function authorship_admin_pointers( $pointers, $prefix )
{
    $options = authorship_get_options();
    $box     = ( !empty( $options['author_box'] ) and !empty( $options['appearance_submenu'] ) );
    if ( apply_filters( 'authorship/global_pointers', true ) )
    {
        $pointers = array_merge( $pointers, array
        (
            $prefix . '_settings' => array
            (
                'selector'   => '#toplevel_page_authors',
                'title'      => __( "Molongui Authorship", 'molongui-authorship' ),
                'text'       => sprintf( __( "Now you can %smanage all your authors%s from this menu. Add new ones and configure the plugin to make it work like you want it to.", 'molongui-authorship' ), '<strong>', '</strong>' ),
                'icon_class' => 'dashicons-admin-settings',
                'width'      => 300,
                'next'       => ( $box ? $prefix . '_box' : $prefix . '_users' ),
            ),
        ));

        if ( authorship_is_feature_enabled( 'box' ) )
        {
            $pointers = array_merge( $pointers, array
            (
                $prefix . '_box' => array
                (
                    'selector'   => '#menu-appearance',
                    'title'      => __( "Author Box Customization", 'molongui-authorship' ),
                    'text'       => sprintf( __( "Go to %sAppearance > Author Box%s. There you will find all the settings you need to customize your author boxes.", 'molongui-authorship' ), '<strong>', '</strong>'),
                    'icon_class' => 'dashicons-admin-customizer',
                    'width'      => 300,
                    'next'       => $prefix . '_users',
                ),
            ));
        }

        $pointers = array_merge( $pointers, array
        (
            $prefix . '_users' => array
            (
                'selector'   => '#menu-users',
                'title'      => __( "Additional Profile Fields", 'molongui-authorship' ),
                'text'       => sprintf( __( "Additional profile fields (like %scustom avatar%s, %scompany%s, %sphone%s and many more) have been added to the user-edit screen", 'molongui-authorship' ), '<code>', '</code>', '<code>', '</code>', '<code>', '</code>' ),
                'icon_class' => 'dashicons-admin-users',
                'width'      => 300,
                'next'       => '',
            ),
        ));
        if ( authorship_is_feature_enabled( 'guest' ) )
        {
            $pointers = array_merge( $pointers, array
            (
                $prefix . '_guests' => array
                (
                    'selector'   => '#menu-posts-guest_author',
                    'title'      => __( "Guest Authors", 'molongui-authorship' ),
                    'text'       => __( "Here you can add guest authors so you can credit guest contributions without creating a WordPress user account for them.", 'molongui-authorship' ),
                    'icon_class' => 'dashicons-admin-users',
                    'width'      => 300,
                    'next'       => '',
                ),
            ));
        }
    }
    if ( apply_filters( 'authorship/options_pointers', true ) )
    {
        $pointers = array_merge( $pointers, array
        (
            $prefix . '_advanced_button' => array
            (
                'selector'   => '#box_display_header .m-button-advanced',
                'title'      => __( "Advanced Settings", 'molongui-authorship' ),
                'text'       => sprintf( __( "Click the %sShow Advanced%s button to configure advanced settings. They are hidden to avoid cluttering the page.", 'molongui-authorship' ), '<code><strong>', '</strong></code>' ),
                'icon_class' => 'dashicons-bell',
                'width'      => 300,
                'edge'       => 'bottom',
                'align'      => 'left',
                'next'       => '',
            ),
        ));

        $pointers = array_merge( $pointers, array
        (
            $prefix . '_more_advanced' => array
            (
                'selector'   => '#author_box_unveil span',
                'title'      => __( "More Advanced Settings", 'molongui-authorship' ),
                'text'       => sprintf( __( "Click on %sShow More Advanced Settings%s to unveil more advanced settings. They are hidden to avoid cluttering the page.", 'molongui-authorship' ), '<code><strong>', '</strong></code>' ),
                'icon_class' => 'dashicons-bell',
                'width'      => 300,
                'edge'       => 'top',
                'align'      => 'left',
                'next'       => '',
            ),
        ));
    }
    if ( apply_filters( 'authorship/edit_post_pointers', true ) )
    {
        $pointers = array_merge( $pointers, array
        (
            $prefix . '_old_author' => array
            (
                'selector'   => '.post-author-selector',
                'post_type'  => explode( ",", $options['post_types'] ),
                'title'      => __( "Molongui Authorship Settings", 'molongui-authorship' ),
                'text'       => __( "Here you can handle your authors, add new ones and configure the plugin to make it work like you want it to.", 'molongui-authorship' ),
                'icon_class' => 'dashicons-admin-users',
                'width'      => 300,
                'next'       => '',
            ),
        ));
    }
    if ( apply_filters( 'authorship/edit_user_pointers', true ) )
    {
        $pointers = array_merge( $pointers, array
        (
            $prefix . '_additional_fields' => array
            (
                'selector'   => '#molongui-user-fields h2',
                'pages'      => array( 'profile.php', 'user-edit.php' ),
                'title'      => __( "Additional Profile Fields", 'molongui-authorship' ),
                'text'       => __( "In this section you can provide additional profile information to display in the author box. You can also disable the author box to be displayed for this user.", 'molongui-authorship' ),
                'icon_class' => 'dashicons-id',
                'width'      => 300,
                'edge'       => 'bottom',
                'align'      => 'left',
                'next'       => '',
            ),
        ));
    }
    if ( apply_filters( 'authorship/edit_guest_pointers', true ) )
    {
    }

    return $pointers;
}
add_filter( 'molongui-authorship-pointerplus_list', 'authorship_admin_pointers', 10, 2 );