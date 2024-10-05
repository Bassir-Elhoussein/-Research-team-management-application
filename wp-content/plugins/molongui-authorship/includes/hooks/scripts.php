<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_front_scripts()
{
    $file = apply_filters( 'authorship/front/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/front.16cd.min.js' );

    authorship_register_script( $file, 'front' );
}
add_action( 'wp_enqueue_scripts', 'authorship_register_front_scripts' );
function authorship_enqueue_front_scripts()
{
    $file = apply_filters( 'authorship/front/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/front.16cd.min.js' );

    authorship_enqueue_script( $file, 'front' );
}
add_action( 'wp_enqueue_scripts', 'authorship_enqueue_front_scripts' );
function authorship_front_script_params()
{
    $options = authorship_get_options();
    $params   = array
    (
        'byline_prefix'         => ( !empty( $options['byline_prefix'] ) ? $options['byline_prefix'] : '' ),
        'byline_suffix'         => ( !empty( $options['byline_suffix'] ) ? $options['byline_suffix'] : '' ),
        'byline_separator'      => ( !empty( $options['byline_multiauthor_separator'] ) ? $options['byline_multiauthor_separator'].' ' : ', ' ),
        'byline_last_separator' => ( !empty( $options['byline_multiauthor_last_separator'] ) ? ' '.$options['byline_multiauthor_last_separator'].' ' : ' '.__( "and", 'molongui-authorship' )." " ),
        'byline_link_title'     => __( "View all posts by", 'molongui-authorship' ),
        'byline_dom_tree'       => apply_filters( 'authorship/byline/dom_tree', '' ),
    );
    return apply_filters( 'authorship/front/script_params', $params );
}