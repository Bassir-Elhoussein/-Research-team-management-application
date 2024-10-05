<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_image_sizes()
{
    if ( apply_filters( 'authorship/add_image_size/skip', false ) ) return;
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'authorship-box-avatar', 150, 150, true );
    add_image_size( 'authorship-box-related', 70, 70, true );
    $options = authorship_get_options();
    if ( ( !empty( $options['author_box_avatar_width'] ) and $options['author_box_avatar_width'] != 150 ) or ( !empty( $options['author_box_avatar_height'] ) and $options['author_box_avatar_height'] != 150 ) )
    {
        add_image_size( 'authorship-custom-avatar', $options['author_box_avatar_width'], $options['author_box_avatar_height'], true );
    }
    do_action( 'authorship/add_image_size' );
}
add_action( 'after_setup_theme', 'authorship_add_image_sizes' );
function authorship_filter_avatar( $args, $id_or_email )
{
    if ( !authorship_is_feature_enabled( 'avatar' ) ) return $args;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( empty( $dbt ) ) return $args;

    /*!
     * PRIVATE FILTER.
     *
     * For internal use only. Not intended to be used by plugin or theme developers.
     * Future compatibility NOT guaranteed.
     *
     * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
     * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
     * or deprecation phase.
     *
     * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
     * and knowing that it could cause code failure.
     */
    if ( apply_filters( 'authorship/get_avatar_data/skip', false, $args, $dbt ) ) return $args;

    $email        = false;
    $author       = new stdClass();
    $local_avatar = false;
    if ( is_object( $id_or_email ) and isset( $id_or_email->comment_ID ) )
    {
        $id_or_email = get_comment( $id_or_email );
    }
    if ( is_numeric( $id_or_email ) )
    {
        $author->id     = absint( $id_or_email );
        $author->type   = 'user';
        $author->object = get_user_by( 'id', $author->id );
        if ( isset( $author->object->guest_id ) )
        {
            $author->id   = $author->object->guest_id;
            $author->type = 'guest';
        }

        if ( isset( $author->object->user_email ) )
        {
            $email = $author->object->user_email;
        }
        else
        {
            return $args;
        }
    }
    elseif ( is_string( $id_or_email ) )
    {
        if ( !$id_or_email )
        {
            if ( is_guest_author() )
            {
                global $wp_query;
                $author->id   = $wp_query->guest_author_id;
                $author->type = 'guest';
            }
            else
            {
                /*!
                 * PRIVATE FILTER.
                 *
                 * For internal use only. Not intended to be used by plugin or theme developers.
                 * Future compatibility NOT guaranteed.
                 *
                 * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
                 * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
                 * or deprecation phase.
                 *
                 * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
                 * and knowing that it could cause code failure.
                 */
                $post_id = apply_filters( '_authorship/get_avatar_data/filter/post_id', null );

                $authors = get_post_authors( $post_id, 'id' );
                if ( $authors )
                {
                    $author->id   = $authors[0];
                    $author->type = 'guest';
                }
            }
        }
        elseif ( strpos( $id_or_email, '@md5.gravatar.com' ) )
        {
            return $args;
        }
        else
        {
            $email = $id_or_email;
        }
    }
    elseif ( $id_or_email instanceof WP_User )
    {
        $author->id     = $id_or_email->ID;
        $author->type   = 'user';
        $author->object = $id_or_email;

        $email = $author->object->user_email;
    }
    elseif ( $id_or_email instanceof WP_Post )
    {
        $author->object = get_user_by( 'id', (int) $id_or_email->post_author );
        $author->id     = $author->object->ID;
        $author->type   = isset( $author->object->guest_id ) ? 'guest' : 'user';

        $email = $author->object->user_email;
    }
    elseif ( $id_or_email instanceof WP_Comment )
    {
        if ( !empty( $id_or_email->comment_author_email ) )
        {
            $email = $id_or_email->comment_author_email;
        }
        elseif ( !empty( $id_or_email->user_id ) )
        {
            add_filter( '_authorship/filter/get_user_by', '__return_list_false' );
            $author->id     = (int) $id_or_email->user_id;
            $author->type   = 'user';
            $author->object = get_user_by( 'id', $author->id );
            remove_filter( '_authorship/filter/get_user_by', '__return_list_false' );

            $email = $author->object->user_email;
        }
    }
    if ( empty( $author->type ) )
    {
        if ( empty( $email ) ) return $args;

        if ( $author->object = molongui_get_author_by( 'user_email', $email, 'user' ) )
        {
            $author->id   = $author->object->ID;
            $author->type = 'user';
        }
        elseif ( $author->object = molongui_get_author_by( '_molongui_guest_author_mail', $email, 'guest' ) )
        {
            $author->id   = $author->object->ID;
            $author->type = 'guest';
        }
        else
        {
            return $args;
        }
    }

    /*!
     * PRIVATE FILTER.
     *
     * For internal use only. Not intended to be used by plugin or theme developers.
     * Future compatibility NOT guaranteed.
     *
     * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
     * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
     * or deprecation phase.
     *
     * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
     * and knowing that it could cause code failure.
     */
    $author = apply_filters( '_authorship/get_avatar_data/filter/author', $author, $id_or_email, $dbt );
    switch ( $author->type )
    {
        case 'user':

            $user_local_avatar = get_user_meta( $author->id, 'molongui_author_image_url', true );
            $local_avatar      = $user_local_avatar ? $user_local_avatar : '';

        break;

        case 'guest':

            $local_avatar = has_post_thumbnail( $author->id ) ? get_the_post_thumbnail_url( $author->id, $args['size'] ) : '';
            add_filter( 'authorship/get_avatar_data/skip', '__return_true' );
            if ( !$local_avatar ) $local_avatar = get_avatar_url( $email, $args );
            remove_filter( 'authorship/get_avatar_data/skip', '__return_true' );

        break;
    }
    if ( $local_avatar )
    {
        $args['found_avatar'] = true;
        $args['url'] = apply_filters( 'authorship/get_avatar_data/filter/url', $local_avatar, $id_or_email, $args );
    }
    return $args;
}
add_filter( 'pre_get_avatar_data', 'authorship_filter_avatar', 999, 2 );