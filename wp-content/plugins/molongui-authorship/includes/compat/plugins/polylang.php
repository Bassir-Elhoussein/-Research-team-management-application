<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'pll_get_archive_url', function( $url, $language )
{
    global $wp_query;
    if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
    {
        if ( !function_exists( 'pll_get_post_translations' ) ) return $url;
        $translations = pll_get_post_translations( $wp_query->guest_author_id );
        if ( empty( $translations[$language->slug] ) )
        {
            if ( apply_filters( 'authorship/pll/hide_if_no_translation', true ) )
            {
                return '';
            }
            else
            {
                return $url;
            }
        }
        $author = new Molongui\Authorship\Includes\Author( $translations[$language->slug], 'guest' );
        add_filter( 'authorship/pll/lang', function() use ( $language ) { return $language->slug; } );
        $url = $author->get_url();
    }

    return $url;
}, 10, 2 );
add_filter( 'pll_the_languages_args', function( $args )
{
    if ( is_guest_author() )
    {
        if ( apply_filters( 'authorship/pll/hide_if_no_translation', true ) )
        {
            $args['hide_if_no_translation'] = 1;
        }
    }

    return $args;
});