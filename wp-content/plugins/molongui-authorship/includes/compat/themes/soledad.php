<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/filter_author_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    $i    = 5;
    $fn   = 'the_author_posts_link';
    $file = '/themes/soledad/inc/templates/about_author.php';
    $dbt  = $args['dbt'];
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'molongui_authorship_do_filter_name', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    $i    = 3;
    $fn   = 'get_the_author';
    $file = '/themes/soledad/author.php';
    $dbt  = $args['dbt'];
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
    {
        $args['display_name'] = authorship_filter_archive_title( $args['display_name'] );
        return true;
    }
    return false;
}, 10, 2 );
add_filter( 'authorship/get_avatar_data/skip', function( $default, $avatar, $dbt )
{
    if ( is_author() and !is_guest_author() ) return true;
    return false;
}, 10, 3 );
/*
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $i    = 4;
    $fn   = 'get_avatar';
    $file = '/inc/templates/about_author.php';
    if ( !is_admin() and
         isset( $dbt[$i]['function'] ) and ( $dbt[$i]['function'] == $fn ) and
         isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
    {
        global $wp_query;
        if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
        {
            $author_id   = $wp_query->guest_author_id;
            $author_type = 'guest';
        }
        elseif ( is_author() )
        {
            $author_id   = $wp_query->query_vars['author'];
            $author_type = 'user';
        }
        if ( !empty( $author_id ) and !empty( $author_type ) )
        {
            $author_class         = new \Molongui\Authorship\Includes\Author( $author_id, $author->type );
            $author               = new stdClass();
            $author->type         = $author_type;
            $author->$author_type = $author_class->get();
        }
    }
    return $author;
}, 10, 3 );*/