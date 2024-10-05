<?php
defined( 'ABSPATH' ) or exit;
function authorship_template_tags()
{
    if ( apply_filters( 'authorship/template_tags', true ) )
    {
        function get_the_molongui_author( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
        {
            if ( ( is_null( $pid ) or !is_integer( $pid ) ) and !in_the_loop() ) return '';
            $options = authorship_get_options();
            $output  = '';
            $output .= apply_filters( 'molongui_byline_prefix', ( !empty( $before ) ? $before : $options['byline_prefix'] ) );
            $output .= get_byline( $pid, $separator, $last_separator, false );
            $output .= apply_filters( 'molongui_byline_suffix', ( !empty( $after ) ? $after : $options['byline_suffix'] ) );
            return $output;
        }
        function the_molongui_author( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
        {
            echo get_the_molongui_author( $pid, $separator, $last_separator, $before, $after );
        }
        function get_the_molongui_author_posts_link( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
        {
            if ( ( is_null( $pid ) or !is_integer( $pid ) ) and !in_the_loop() ) return '';
            $options = authorship_get_options();
            $output  = '';
            $output .= apply_filters( 'molongui_byline_prefix', ( !empty( $before ) ? $before : $options['byline_prefix'] ) );
            $linked  = apply_filters( 'molongui_author_byline_linked', true );
            $output .= get_byline( $pid, $separator, $last_separator, $linked );
            $output .= apply_filters( 'molongui_byline_suffix', ( !empty( $after ) ? $after : $options['byline_suffix'] ) );
            return $output;
        }
        function the_molongui_author_posts_link( $pid = null, $separator = '', $last_separator = '', $before = '', $after = '' )
        {
            echo get_the_molongui_author_posts_link( $pid, $separator, $last_separator, $before, $after );
        }
    }
}
add_action( 'authorship/init', 'authorship_template_tags' );