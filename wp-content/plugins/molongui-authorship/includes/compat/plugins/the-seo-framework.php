<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    $fn    = 'get_author_canonical_url';
    $class = 'The_SEO_Framework\Generate_Url';
    list( $filter, $user ) = $data;
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == $class ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );

add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    $fn    = 'get_author_canonical_url';
    $class = 'The_SEO_Framework\Generate_Url';
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == $class ) )
        return true;
    return $default;
}, 10, 2 );
add_filter( 'the_seo_framework_title_from_generation', function ( $generated, $args )
{
    global $wp_query;

    if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
    {
        if ( 'Untitled' === $generated )
        {
            $author = new Molongui\Authorship\Includes\Author( $wp_query->guest_author_id, 'guest' );
            $display_name = $author->get_name();

            $prefix = __( 'Author:' );
            $prefix = apply_filters_ref_array( 'the_seo_framework_generated_archive_title_prefix', array( $prefix, get_queried_object() ) );

            $generated = $prefix . ' ' . $display_name;
        }
    }

    return $generated;
}, 10, 2 );