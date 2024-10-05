<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $fn     = 'get_avatar';
    $file_1 = '/template-parts/header-aside.php';
    $file_2 = '/template-parts/header-mobile.php';
    $file_3 = '/themes/buddyboss-theme/comments.php';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_1, strlen( $dbt[$i]['file'] )-strlen( $file_1 ), strlen( $file_1 ) ) === 0 ) or
             ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_2, strlen( $dbt[$i]['file'] )-strlen( $file_2 ), strlen( $file_2 ) ) === 0 ) or
             ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file_3, strlen( $dbt[$i]['file'] )-strlen( $file_3 ), strlen( $file_3 ) ) === 0 )
        ) {
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
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    global $is_related_posts;
    $fn     = 'get_avatar';
    $file_1 = '/template-parts/entry-meta.php';
    $file_2 = '/template-parts/author-box.php';
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
add_filter( 'bp_core_get_user_domain', function( $domain, $user_id, $user_nicename, $user_login )
{
    if ( apply_filters( 'authorship/buddyboss_author_link', false ) ) return $domain;

    $options = authorship_get_options();

    if ( $options['guest_authors'] or $options['enable_multi_authors'] )
    {
        $fn   = 'bp_core_get_user_domain';
        $file = '/template-parts/entry-meta.php';
        $dbt  = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
        if ( empty( $dbt ) ) return $domain;
        if ( $i = array_search( $fn, array_column( $dbt, 'function' ) )
            and
            ( isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0 )
        )
        {
            $domain = get_author_posts_url( $user_id, $user_nicename );
        }
    }

    return $domain;
}, 10, 4 );
add_filter( 'authorship/get_avatar_data/skip', function( $default, $args, $dbt )
{
    global $is_related_posts;
    $fn   = 'get_avatar';
    $file = '/template-parts/entry-meta.php';
    if ( $is_related_posts and
         !is_admin() and
         $i = array_search( $fn, array_column( $dbt, 'function' ) ) and
         isset( $dbt[$i]['file'] ) and substr_compare( $dbt[$i]['file'], $file, strlen( $dbt[$i]['file'] )-strlen( $file ), strlen( $file ) ) === 0
    )
    {
        return true;
    }
    return $default;//$author;
}, 10, 3 );