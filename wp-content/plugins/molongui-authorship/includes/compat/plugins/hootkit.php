<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'the_author_posts_link', function( $link )
{
    if ( is_author() )
    {
        $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 11 );
        $fn = 'hootkit_display_meta_info';
        if ( $key = array_search( $fn, array_column( $dbt, 'function' ) ) )
        {
            if ( function_exists( 'get_byline' ) )
            {
                global $post;

                $options        = authorship_get_options();
                $separator      = !empty( $options['byline_multiauthor_separator'] ) ? $options['byline_multiauthor_separator'] : ',';
                $last_separator = !empty( $options['byline_multiauthor_last_separator'] ) ? $options['byline_multiauthor_last_separator'] : __( "and", 'molongui-authorship' );

                return get_byline( $post->ID, $separator, $last_separator, true );
            }
        }
    }

    return $link;
});