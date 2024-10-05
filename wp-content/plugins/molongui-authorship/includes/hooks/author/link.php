<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
if ( !authorship_byline_takeover() ) return;
function authorship_filter_author_link( $link, $author_id, $author_nicename )
{
    if ( molongui_is_request( 'admin' ) ) return $link;
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );
    if ( empty( $dbt ) ) return $link;
    $args = array( 'link' => &$link, 'author_id' => $author_id, 'author_nicename' => $author_nicename, 'dbt' => $dbt );
    if ( apply_filters_ref_array( 'authorship/filter_author_link', array( false, &$args ) ) ) return $link;
    return authorship_author_link( $link );
}
add_filter( 'author_link', 'authorship_filter_author_link', 999, 3 );
function authorship_author_link( $link, $post_id = null )
{
    $options = authorship_get_options();
    if ( empty( $options['byline_name_link'] ) )
    {
        return apply_filters( 'authorship/author_link', '#molongui-disabled-link', array( 'url' => '#molongui-disabled-link', 'link' => $link, 'pid' => $post_id ) );
    }
    if ( empty( $post_id ) )
    {
        global $post;
        if ( empty( $post ) ) return $link;
        $post_id = apply_filters( 'molongui_authorship_filter_link_post_id', isset( $post->ID ) ? $post->ID : null, $post, $link );

        if ( !$post_id ) return $link;
    }
    $authors = get_post_authors( $post_id );
    if ( !$authors ) return $link;
    $modifiers_tag = ( ( !empty( $options['byline_prefix'] ) or !empty( $options['byline_suffix'] ) ) and authorship_has_pro() ) ? '?m_bm=true' : '';
    if ( is_multiauthor_post( $post_id ) and !empty( $options['byline_multiauthor_link'] ) and $options['byline_multiauthor_display'] != 'main' )
    {
        switch ( $options['byline_multiauthor_display'] )
        {
            case 'main':
                $count = 1;

            break;

            case '1':
            case '2':
            case '3':
                $count = min( count( $authors ), (int)$options['byline_multiauthor_display'] );

            break;

            case 'all':
            default:

                $count = count( $authors );

            break;
        }
        $url = '';
        $que = '%3F'; // Encoded into a valid ASCII format: '%3F' = '?'
        $amp = '%26'; // Encoded into a valid ASCII format: '%26' = '&'

        for ( $i = 0; $i < $count; $i++ )
        {
            switch ( $i )
            {
                case 0:
                    $function  = 'get_url';             // 'get_url' must be used so returned $link is a valid URL.
                    $default   = authorship_home_url(); // To ensure we return a valid URL even if main author is a guest.
                    $delimiter = '';                    // Do not append anything at the beginning of the returned $link.
                    $querychar = '';
                break;

                case 1:
                    $function  = 'get_url';                // 'get_slug' could be used to return the author nicename.
                    $default   = 'molongui-disabled-link'; // Do NOT add a leading '#'!!!
                    $disabled  = $authors[0]->type == 'guest' ? apply_filters( '_authorship/filter/link/disable_main', true, $authors[0]->type ) : false;
                    $delimiter = $disabled ? 'molongui_byline=true'.$amp.'m_main_disabled=true'.$amp.'mca=' : 'molongui_byline=true'.$amp.'mca=';
                    $querychar = $que;
                break;

                default:
                    $function  = 'get_url';                // 'get_slug' could be used to return the author nicename.
                    $default   = 'molongui-disabled-link'; // Do NOT add a leading '#'!!!
                    $delimiter = 'mca=';
                    $querychar = $amp;
                break;
            }
            $author_class = new Author( $authors[$i]->id, $authors[$i]->type );
            switch ( $authors[$i]->type )
            {
                case 'guest':
                    $data = $author_class->$function();
                    $data = $data == '#molongui-disabled-link' ? $default : $data;

                break;

                case 'user':
                default:
                    $data = $author_class->$function();
                    $data = $data == '#molongui-disabled-link' ? $default : $data;

                break;
            }
            if ( $i === 1 )
            {
                $tmp = parse_url( $data );
                if ( isset( $tmp['query'] ) ) $querychar = $amp;
            }
            $url .= $querychar . $delimiter . $data;
        }
    }
    elseif ( $authors[0]->type == 'guest' )
    {
        $author_class = new Author( $authors[0]->id, $authors[0]->type );
        $url = $author_class->get_url();
    }
    elseif ( !in_the_loop() and $authors[0]->type == 'user' )
    {
        $author_class = new Author( $authors[0]->id, $authors[0]->type );
        $url = $author_class->get_url();
    }
    else $url = $link;
    return apply_filters( 'authorship/author_link', $url.$modifiers_tag, array( 'url' => $url, 'modifiers' => $modifiers_tag, 'link' => $link, 'pid' => $post_id, 'authors' => $authors ) );
}
function authorship_filter_author_page_link( $link )
{
    global $wp_query;
    if ( !is_author() and !is_guest_author() ) return $link;
    if ( is_guest_author() and isset( $wp_query->guest_author_id ) )
    {
        $author = new Author( $wp_query->guest_author_id, 'guest' );
        return $author->get_url();
    }
    if ( $wp_query->query_vars['author'] )
    {
        $author = new Author( $wp_query->query_vars['author'], 'user' );
        return $author->get_url();
    }
    return $link;
}