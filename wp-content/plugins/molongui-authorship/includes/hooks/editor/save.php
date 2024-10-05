<?php
defined( 'ABSPATH' ) or exit;
function authorship_save_editor_options()
{
    if ( !isset( $_POST['nonce'] ) ) return;
    if ( !wp_verify_nonce( $_POST['nonce'], 'authorship_box_editor_nonce' ) ) return;
    $options = wp_unslash( $_POST['data'] );

    if ( !empty( $options ) and is_array( $options ) )
    {
        $options['plugin_version'] = MOLONGUI_AUTHORSHIP_VERSION;
        $current = (array) get_option( MOLONGUI_AUTHORSHIP_PREFIX.'_options', array() );
        $options = array_merge( $current, $options );
        $options = apply_filters( 'authorship/validate_editor_options', $options, $current );
        update_option( MOLONGUI_AUTHORSHIP_PREFIX.'_options', $options );

        $old = $current;
        do_action( 'authorship/editor_options', $options, $old );
    }
    wp_die();
}
add_action( 'wp_ajax_authorship_save_editor_options', 'authorship_save_editor_options' );
function authorship_validate_editor_spacing_options( $options, $current )
{
    $size = array
    (
        'author_box_margin_top',
        'author_box_margin_right',
        'author_box_margin_bottom',
        'author_box_margin_left',
        'author_box_padding_top',
        'author_box_padding_right',
        'author_box_padding_bottom',
        'author_box_padding_left',
        'author_box_border_top',
        'author_box_border_right',
        'author_box_border_bottom',
        'author_box_border_left',
    );
    foreach ( $size as $key )
    {
        if ( empty( $options[$key] ) or authorship_input_has_units( $options[$key] ) ) continue;
        $options[$key] = $options[$key] . 'px';
    }

    return $options;
}
add_filter( 'authorship/validate_editor_options', 'authorship_validate_editor_spacing_options', 10, 2 );
function authorship_validate_editor_premium_options( $options, $current = array() )
{
    $defaults = authorship_get_defaults();
    $premium  = array
    (
        'author_box_bio_source' => array( 'full' ),
        'author_box_related_layout'  => array( 'layout-1', 'layout-2' ),
        'author_box_related_orderby' => array( 'date' ),
        'author_box_related_count'   => array( 4 ),
        'author_box_profile_layout' => array( 'layout-1' ),
    );
    foreach ( $premium as $key => $accepted )
    {
        if ( empty( $options[$key] ) ) continue;

        if ( !in_array( $options[$key], $accepted ) ) $options[$key] = $defaults[$key];
    }

    return $options;
}
add_filter( 'authorship/validate_editor_options', 'authorship_validate_editor_premium_options', 10, 2 );
function authorship_validate_saved_options( $options )
{
    if ( authorship_is_editor() ) return $options;

    return authorship_validate_editor_premium_options( $options, $options );
}
add_filter( 'authorship/get_options', 'authorship_validate_saved_options', 10, 1 );