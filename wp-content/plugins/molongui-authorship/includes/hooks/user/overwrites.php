<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_get_user_by( $user, $field, $value )
{
    global $pagenow;
    if ( is_admin() and ( !defined( 'DOING_AJAX' ) or !DOING_AJAX )
         or $pagenow == 'wp-login.php'
         or $field == 'login'
    )  return $user;
    global $in_comment_loop;
    if ( $in_comment_loop ) return $user;
$dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 12 );
if ( empty( $dbt ) ) return $user;
    global $wp_query;
global $post;
    $old_user = $user;
    $filter = true;
    $args = array( 'field' => $field, 'value' => $value, 'post' => $post, 'query' => $wp_query, 'dbt' => $dbt );

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
    list( $filter, $user ) = apply_filters( '_authorship/filter/get_user_by', array( true, $user ), $args );
    if ( !$filter ) return is_null( $user ) ? $old_user : $user;

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
    if ( apply_filters( '_authorship/cache_delete/get_user_by', true, $user, $args ) )
    {
        if ( !empty( $user->ID )            ) wp_cache_delete( $user->ID, 'users' );
        if ( !empty( $user->user_login )    ) wp_cache_delete( $user->user_login, 'userlogins' );
        if ( !empty( $user->user_email )    ) wp_cache_delete( $user->user_email, 'useremail' );
        if ( !empty( $user->user_nicename ) ) wp_cache_delete( $user->user_nicename, 'userslugs' );
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
    $post_id = apply_filters( '_authorship/get_user_by/post_id', authorship_get_post_id(), $user, $args );
    if ( is_object( $wp_query ) and $wp_query->is_author )
    {
        $author_id   = !empty( $user ) ? $user->ID : 0;
        $author_type = 'user';

        if ( is_guest_author() )
        {
            $author_id   = $wp_query->guest_author_id;
            $author_type = 'guest';
        }

        $author = new Author( $author_id, $author_type );
        $aim = 'info';
        if ( in_the_loop() )
        {
            if ( !empty( $post_id ) )
            {
                $aim = 'byline';
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
        $aim = apply_filters( '_authorship/get_user_by/aim', $aim, $user, $args );

        if ( 'byline' === $aim )
        {
            if ( !empty( $post_id ) )
            {
                $post_main_author = get_main_author( $post_id );
                $main_author      = new Author( $post_main_author->id, $post_main_author->type );

                $display_name  = get_byline( $post_id );
                $user_nicename = $main_author->get_slug();
            }
            else
            {
                return $user;
            }
        }
        if ( is_guest_author() )
        {
            $user = new WP_User();
            $user->guest_id         = $author_id;
            $user->display_name     = ( !empty( $display_name ) ? $display_name : $author->get_name() );
            $user->user_url         = $author->get_meta( 'web' );
            $user->description      = $author->get_bio();
            $user->user_description = $user->description;
            $user->user_nicename    = ( !empty( $user_nicename ) ? $user_nicename : $author->get_slug() );
            $user->nickname         = $user->display_name;
            $user->user_email       = $author->get_mail();
            $user->first_name       = $author->get_meta( 'first_name' );
            $user->last_name        = $author->get_meta( 'last_name'  );
            $user->user_registered  = get_the_date( '', $author_id );
        }
        else
        {
            if ( 'byline' === $aim )
            {
                $user->ID            = ( ( !empty( $post_main_author ) and isset( $post_main_author->id ) ) ? $post_main_author->id : $user->ID ); // We need to restore user ID that might have been altered above.
                $user->display_name  = ( !empty( $display_name ) ? $display_name : $author->get_name() );
                $user->user_nicename = $author->get_slug();
                $user->nickname      = $user->display_name;
            }
            else
            {
                if ( !empty( $wp_query->query_vars['author'] ) )
                {
                    $user = new WP_User( $wp_query->query_vars['author'] );
                }

            }
        }

        return $user;
    }
    elseif ( ( ( is_object( $wp_query ) and $wp_query->is_home ) )
        or ( is_object( $wp_query ) and $wp_query->is_main_query() and get_option( 'page_for_posts' ) == $wp_query->get_queried_object_id() )
        or ( is_object( $wp_query ) and $wp_query->is_singular and authorship_is_post_type_enabled( '', $post_id ) )
        or ( is_object( $wp_query ) and $wp_query->is_search )
        or ( is_object( $wp_query ) and $wp_query->is_category )
        or ( is_object( $wp_query ) and $wp_query->is_tag )
    ){
        if ( empty( $post_id ) ) return $user;
        $main_author  = get_main_author( $post_id );
        $author_class = new Author( $main_author->id, $main_author->type );
        if ( is_multiauthor_post( $post_id ) )
        {
            $user->display_name     = get_byline( $post_id );
            $user->user_url         = authorship_author_link( $user->user_url, $post_id );
            $user->description      = '';
            $user->user_description = $user->description;
            $user->user_nicename    = $author_class->get_slug();
            $user->nickname         = $user->display_name;
            if ( 'guest' === $main_author->type and array_search( 'get_avatar_data', array_column( $dbt, 'function' ) ) === false )
            {
                $user->user_email = $author_class->get_mail();
            }
            return $user;
        }
        elseif ( is_guest_post( $post_id ) )
        {
            $user->guest_id         = $author_class->get_id();
            $user->display_name     = $author_class->get_name();//get_byline( $post_id );
            $user->user_url         = $author_class->get_meta( 'web' );
            $user->description      = $author_class->get_bio();
            $user->user_description = $user->description;
            $user->user_nicename    = $author_class->get_slug();
            $user->nickname         = $user->display_name;
            if ( isset( $dbt[1]['function'] ) and $dbt[1]['function'] != 'get_avatar_data' )
            {
                $user->user_email = $author_class->get_mail();
            }
            return $user;
        }
    }
    return $user;
}
add_filter( '_authorship/get_user_by', 'authorship_get_user_by', 10, 3 );
function authorship_no_userdata( $false, $field, $value )
{
    global $wp_query;
    if ( isset( $wp_query ) and !empty( $wp_query->is_guest_author ) and !empty( $wp_query->guest_author_id ) )
    {
        $user = authorship_get_guest_by( $field, $value );
        $user->ID = $wp_query->guest_author_id;

        return $user;
    }
    else return $false;
}
add_filter( '_authorship/no_userdata', 'authorship_no_userdata', 10, 3 );
function authorship_get_guest_by( $field, $value )
{
    global $wp_query;
    global $post;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 8 );
    $args = array( 'field' => $field, 'value' => $value, 'post' => $post, 'query' => $wp_query, 'dbt' => $dbt );

    $author_id   = $wp_query->guest_author_id;
    $author_type = 'guest';
    $author      = new Author( $author_id, $author_type );
    $post_id = apply_filters( '_authorship/get_user_by/post_id', authorship_get_post_id(), null, $args );
    $aim = 'info';
    if ( in_the_loop() )
    {
        if ( !empty( $post_id ) )
        {
            $aim = 'byline';
        }
    }
    $aim = apply_filters( '_authorship/get_user_by/aim', $aim, null, $args );

    if ( 'byline' === $aim )
    {
        if ( !empty( $post_id ) )
        {
            $post_main_author = get_main_author( $post_id );
            $main_author      = new Author( $post_main_author->id, $post_main_author->type );

            $display_name  = get_byline( $post_id );
            $user_nicename = $main_author->get_slug();
        }
        else
        {
            return null;
        }
    }
    $user = new WP_User();
    $user->guest_id         = $author_id;
    $user->display_name     = ( !empty( $display_name ) ? $display_name : $author->get_name() );
    $user->user_url         = $author->get_meta( 'web' );
    $user->description      = $author->get_bio();
    $user->user_description = $user->description;
    $user->user_nicename    = ( !empty( $user_nicename ) ? $user_nicename : $author->get_slug() );
    $user->nickname         = $user->display_name;
    $user->user_email       = $author->get_mail();
    $user->first_name       = $author->get_meta( 'first_name' );
    $user->last_name        = $author->get_meta( 'last_name'  );
    $user->user_registered  = get_the_date( '', $author_id );

    return $user;
}