<?php
defined( 'ABSPATH' ) or exit;
function authorship_render_author_box( $content )
{
    _deprecated_function( __FUNCTION__, '4.5.0', 'authorship_render_box()' );
    return authorship_render_box( $content );
}
function authorship_get_author_box_markup( $post, $post_authors, $options = array(), $check = true )
{
    _deprecated_function( __FUNCTION__, '4.5.0', 'authorship_box_markup()' );
    return authorship_box_markup( $post, $post_authors, $options, $check );
}
function authorship_hide_author_box( $post, $author, $options )
{
    _deprecated_function( __FUNCTION__, '4.5.0', 'authorship_hide_box()' );
    return authorship_hide_box( $post, $author, $options );
}
function authorship_get_author_box_border( $box_border )
{
    _deprecated_function( __FUNCTION__, '4.5.0', 'authorship_box_border()' );
    return authorship_box_border( $box_border );
}
function authorship_get_settings()
{
    _deprecated_function( __FUNCTION__, '4.5.0', 'authorship_get_options()' );
    return authorship_get_options();
}
function authorship_get_default_settings()
{
    _deprecated_function( __FUNCTION__, '4.4.3', 'authorship_get_defaults()' );
    return authorship_get_defaults();
}
function authorship_add_default_settings()
{
    _deprecated_function( __FUNCTION__, '4.4.3', 'authorship_add_defaults()' );
    authorship_add_defaults();
}