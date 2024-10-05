<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    if ( empty( $args['post'] ) or !$args['post']->ID ) return array( $filter, $user );
    $function = 'get_the_author_meta';
    $classes  = array( 'TWP_widget_style_1', 'TWP_widget_style_2', 'TWP_widget_style_3' );
    $post_id  = $args['post']->ID;
    if ( array_intersect( $classes, array_column( $args['dbt'], 'class' ) ) )
    {
        if ( !is_multiauthor_post( $post_id ) and !is_guest_post( $post_id ) )
        {
            $main_author = get_main_author( $post_id );
            $author_class = new Author( $main_author->id, $main_author->type );
            $user->guest_id         = $author_class->get_id();
            $user->display_name     = $author_class->get_name();//$post_class->filter_name( $post_id );
            $user->user_url         = $author_class->get_meta( 'web' );
            $user->description      = $author_class->get_bio();
            $user->user_description = $user->description;
            $user->user_nicename    = $author_class->get_slug();
            $user->nickname         = $user->display_name;
            $filter = true;
        }
    }
    return array( $filter, $user );
}, 10, 2 );