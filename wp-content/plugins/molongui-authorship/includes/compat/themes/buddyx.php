<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    global $is_related_posts;
    $fn     = 'get_avatar';
    $file_1 = '/template-parts/content/entry_meta.php';
    $file_2 = '/template-parts/content/author-box.php';
    if ( !$is_related_posts and
         !is_admin() and
         $i = array_search( $fn, array_column( $dbt, 'function' ) ) and
         ( ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_1, strlen( $dbt[$i]['file'] )-strlen( $file_1 ), strlen( $file_1 ) ) === 0 ) or
           ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_2, strlen( $dbt[$i]['file'] )-strlen( $file_2 ), strlen( $file_2 ) ) === 0 ) )
    )
    {
        global $post;
        if ( is_guest_post( $post->ID ) )
        {
            $main = get_main_author( $post->ID );
            $author->id   = $main->id;
            $author->type = 'guest';
        }
    }
    return $author;
}, 10, 3 );
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $fn   = 'get_avatar';
    $file = '/template-parts/header/navigation.php';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 ) )
        {
            if ( !is_admin() )
            {
                $author         = new stdClass();
                $author->object = wp_get_current_user();
                $author->id     = $author->object->ID;
                $author->type   = 'user';
            }
        }
    }
    return $author;
}, 10, 3 );