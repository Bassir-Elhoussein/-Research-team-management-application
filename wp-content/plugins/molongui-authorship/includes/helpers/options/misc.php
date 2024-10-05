<?php
defined( 'ABSPATH' ) or exit;
function authorship_options_url( $tab = '' )
{
    $url = 'admin.php?page=molongui-authorship';
    $tab = empty( $tab ) ? '' : '&tab='.$tab;

    return admin_url( $url.$tab );
}
function authorship_get_post_types()
{
    $options    = array();
    $post_types = molongui_get_post_types( 'all', 'objects', false );

    foreach( $post_types as $post_type )
    {
        $options[] = array
        (
            'id'       => $post_type->name,
            'label'    => $post_type->labels->name,
            'disabled' => apply_filters( '_authorship/options/post_type/disabled', in_array( $post_type->name, array( 'post', 'page' ) ) ? false : true, $post_type ),
        );
    }

    return $options;
}
function authorship_box_post_types( $display = 'all', $type = 'all', $select = false )
{
    $options = authorship_get_options();

    switch ( $display )
    {
        case 'auto':
            $post_types = empty( $options['box_post_types_auto'] ) ? array() : explode( ",", $options['box_post_types_auto'] );
        break;

        case 'manual':
            $post_types = empty( $options['box_post_types_manual'] ) ? array() : explode( ",", $options['box_post_types_manual'] );
        break;

        case 'all':
            $post_types = empty( $options['box_post_types_auto'] ) ? array() : explode( ",", $options['box_post_types_auto'] );
            $post_types = array_unique( array_merge( $post_types, empty( $options['box_post_types_manual'] ) ? array() : explode( ",", $options['box_post_types_manual'] ) ) );
        break;
    }

    if ( empty( $post_types ) ) return array();

    $array = $opts = array();

    foreach ( molongui_get_post_types( $type, 'objects', false ) as $post_type_name => $post_type_object )
    {
        if ( in_array( $post_type_name, $post_types ) )
        {
            $array[] = $post_type_name;
            $opts[]  = array( 'id' => $post_type_name, 'label' => $post_type_object->labels->name, 'singular' => $post_type_object->labels->singular_name );
        }
    }

    return ( $select ? $opts : $array );
}