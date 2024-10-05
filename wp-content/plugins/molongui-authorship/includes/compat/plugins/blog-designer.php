<?php
defined( 'ABSPATH' ) or exit;

/**
 * AUTHOR BOX
 * Fix author box display.
 *
 * Issue   : Author box displayed on frontpage even when configured to not be displayed.
 * Cause   : Blog Designer overwrites the main query setting the current post to the first listed post. If that post is configured to display the author box, an author box is displayed on current page.
 * Fix     : None found!!! See below...
 * User    : MyungHwan Hong (geniusminds777@gmail.com) on Jun 16, 2022 (Support Ticket HR22-0616053508: dislocation/malfunction of the author box placement)
 * Version : 3.0.8
 *
 * The Blog Designer plugin overwrites the main query:
 *
 *    $wp_query = $loop; //phpcs:ignore
 *
 * Why it does that? Don't know. But it is probably unnecessary. As there is no way for us to retrieve the ID of the
 * current post, we decide to open a support ticket (support@solwininfotech.com) with the team behind the Blog Designer
 * plugin. This is our email:
 *
 *    I'm John, member of the support team at Molongui. One of users reported an issue between our plugins. We are
 *    reaching you out in hopes we can make them compatible.
 *
 *    In short: our plugin check global $post variable to determine whether it has to add an author box to the post
 *    content. The issue is that if anyone uses your "wp_blog_designer" shortcode in a page, the main WP_Query gets
 *    overwritten (blog-designer/public/class-blog-designer-lite-public.php file, bd_views function, line #216), so
 *    global $post is replaced by the first post listed by that shortcode.
 *
 *    Is that overwrite ($wp_query = $loop;) really needed at all? Couldn't you just remove that line? You have there
 *    an "phpcs:ignore", so probably you know that is not the best thing to do...
 *
 * @see     blog-designer/public/class-blog-designer-lite-public.php
 *
 * @since   4.6.7
 * @version 4.6.7
 *//*
add_filter( 'authorship/render_box', function( $default, $post )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    $fn  = 'bd_views';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        return false;
    }

    return $default;
}, 10, 2 );*/