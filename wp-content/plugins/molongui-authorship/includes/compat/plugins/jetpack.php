<?php
defined( 'ABSPATH' ) or exit;
if ( defined( JETPACK__VERSION ) and version_compare( JETPACK__VERSION, '9.1.0', '>=' ) )
{
    add_filter( 'jetpack_content_options_featured_image_exclude_cpt', function( $excluded_post_types )
    {
        $excluded_post_types[] = 'guest_author';
        return $excluded_post_types;
    });
}
else
{
    add_action( 'init', function()
    {
        remove_filter( 'get_post_metadata', 'jetpack_featured_images_remove_post_thumbnail', true );
    }, 999 );
}
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;

    $fn    = 'widget';
    $class = 'Jetpack_Widget_Authors';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$i]['class'] ) and ( $args['dbt'][$i]['class'] == $class ) )
    {
        $filter = false;
    }

    return array( $filter, $user );
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, &$args )
{
    $fn    = 'widget';
    $class = 'Jetpack_Widget_Authors';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$i]['class'] ) and ( $args['dbt'][$i]['class'] == $class ) )
    {
        return true;
    }
    return $default;
}, 10, 2 );