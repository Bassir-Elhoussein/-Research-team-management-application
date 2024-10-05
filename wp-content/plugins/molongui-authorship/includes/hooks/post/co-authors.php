<?php
defined( 'ABSPATH' ) or exit;
if ( !authorship_is_feature_enabled( 'multi' ) ) return;
function authorship_post_allow_coauthors_edit( $allcaps, $caps, $args, $user )
{
    global $in_comment_loop;
    if ( $in_comment_loop ) return $allcaps;

    $cap     = $args[0];
    $post_id = isset( $args[2] ) ? $args[2] : 0;

    $postType = empty( $post_id ) ? authorship_get_post_type() : authorship_get_post_type( $post_id );
    $obj      = get_post_type_object( $postType );

    if ( !$obj or 'revision' == $obj->name ) return $allcaps;

    $caps_to_modify = array
    (
        $obj->cap->edit_post,
        'edit_post',
        $obj->cap->edit_others_posts,
    );
    if ( !in_array( $cap, $caps_to_modify ) ) return $allcaps;

    if ( !is_user_logged_in() ) return $allcaps;

    $post_authors = get_post_authors( $post_id, 'id' );
    $allowEdit    = is_array( $post_authors ) ? in_array( $user->ID, $post_authors ) : false;

    if ( $allowEdit )
    {
        $post_status = get_post_status( $post_id );

        if ( 'publish' == $post_status and isset( $obj->cap->edit_published_posts ) and !empty( $user->allcaps[$obj->cap->edit_published_posts] ) )
        {
            $allcaps[$obj->cap->edit_published_posts] = true;
        }
        elseif ( 'private' == $post_status and isset( $obj->cap->edit_private_posts ) and !empty( $user->allcaps[$obj->cap->edit_private_posts] ) )
        {
            $allcaps[$obj->cap->edit_private_posts] = true;
        }

        $allcaps[$obj->cap->edit_others_posts] = true;
    }

    return $allcaps;
}
add_filter( 'user_has_cap', 'authorship_post_allow_coauthors_edit', 999, 4 );
function authorship_post_filter_map_meta_cap( $caps, $cap, $user_id, $args )
{
    if ( in_array( $cap, array( 'edit_post', 'edit_others_posts' ) ) and in_array('edit_others_posts', $caps, true ) )
    {
        if ( isset( $args[0] ) )
        {
            $post_id = (int)$args[0];
            $post_authors = get_post_authors( $post_id, 'id' );
            $allowEdit    = is_array( $post_authors ) ? in_array( $user_id, $post_authors ) : false;

            if ( $allowEdit )
            {
                foreach ( $caps as &$item )
                {
                    if ( $item === 'edit_others_posts' )
                    {
                        $item = 'edit_posts';
                    }
                }
            }

            $caps = apply_filters( 'authorship/post/filter_map_meta_cap', $caps, $cap, $user_id, $post_id );
        }
    }

    return $caps;
}
add_filter( 'map_meta_cap', 'authorship_post_filter_map_meta_cap', 10, 4 );