<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/the_author', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $i    = 3;
    $file = '/themes/smart-mag/partials/author.php';
    if ( isset( $args['dbt'][$i]['function'] ) and $args['dbt'][$i]['function'] == 'get_the_author' and
         isset( $args['dbt'][$i+2]['function'] ) and $args['dbt'][$i+2]['function'] == 'the_author_posts_link' and
         isset( $args['dbt'][$i+2]['file'] ) and substr_compare( $args['dbt'][$i+2]['file'], $file, strlen( $args['dbt'][$i+2]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
        $filter = false;
    return array( $filter, $user );
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    $i    = 3;
    $file = '/themes/smart-mag/partials/author.php';
    if ( isset( $args['dbt'][$i]['function'] ) and $args['dbt'][$i]['function'] == 'get_author_posts_url' and
         isset( $args['dbt'][$i+2]['function'] ) and $args['dbt'][$i+2]['function'] == 'the_author_posts_link' and
         isset( $args['dbt'][$i+2]['file'] ) and substr_compare( $args['dbt'][$i+2]['file'], $file, strlen( $args['dbt'][$i+2]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
        return true;
    return $default;
}, 10, 2 );
add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    $i    = 3;
    $file = '/themes/smart-mag/page-templates/authors.php';
    if ( isset( $args['dbt'][$i]['function'] ) and $args['dbt'][$i]['function'] == 'get_author_posts_url' and
         isset( $args['dbt'][$i]['file'] ) and substr_compare( $args['dbt'][$i]['file'], $file, strlen( $args['dbt'][$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
        return true;
    return $default;
}, 10, 2 );

add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    $fn   = 'get_author_posts_url';
    $file = '/themes/smart-mag/page-templates/authors.php';
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['file'] ) and substr_compare( $args['dbt'][$key]['file'], $file, strlen( $args['dbt'][$key]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );