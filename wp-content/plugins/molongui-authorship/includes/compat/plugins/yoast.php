<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
if ( molongui_is_request( 'admin' ) ) return;
$options = authorship_get_options();
if ( !empty( $options['add_opengraph_meta'] ) )
{
    add_filter( 'wpseo_opengraph_type' , 'authorship_wpseo_remove_opengraph', 999, 1 );
    add_filter( 'wpseo_opengraph_desc' , 'authorship_wpseo_remove_opengraph', 999, 1 );
    add_filter( 'wpseo_opengraph_url'  , 'authorship_wpseo_remove_opengraph', 999, 1 );
    add_filter( 'wpseo_opengraph_image', 'authorship_wpseo_remove_opengraph', 999, 1 );
    if ( !function_exists( 'authorship_wpseo_remove_opengraph' ) )
    {
        function authorship_wpseo_remove_opengraph( $value )
        {
            if ( is_author() or is_guest_author() ) return false;
            return $value;
        }
    }
}
add_filter( 'wpseo_schema_author'      , 'molongui_authorship_wpseo_schema_author'   , 999, 2 );
add_filter( 'wpseo_replacements'       , 'molongui_authorship_wpseo_replacements'    , 999, 2 );
add_filter( 'wpseo_canonical'          , 'molongui_authorship_wpseo_canonical'       , 999, 1 );
add_filter( 'wpseo_adjacent_rel_url'   , 'molongui_authorship_wpseo_adjacent_rel_url', 999, 2 );
add_filter( 'wpseo_opengraph_url'      , 'molongui_authorship_wpseo_opengraph_url'   , 999, 1 );
function molongui_authorship_wpseo_schema_author( $graph_piece, $context = null )
{
    if ( is_null( $context ) )
    {
        global $post;
        $pid = $post->ID;
    }
    else
    {
        $pid = $context->indexable->object_id;
    }
    $post_authors = get_post_authors( $pid );
    if ( !$post_authors or !is_array( $post_authors ) ) return $graph_piece;
    if ( is_array( $post_authors ) and count( $post_authors ) <= 1 ) return $graph_piece;
    $authors = array();
    $i = 0;
    foreach ( $post_authors as $post_author )
    {
        $author = new Author( $post_author->id, $post_author->type );

        $authors[$i]['@type'] = array( 'Person' );
        $authors[$i]['@id']   = $graph_piece['@id']; //'https://evistaging.wpengine.com/#/schema/person/682e44182a7c6f403c727e43c0b612a5';
        $authors[$i]['name']  = $author->get_name();
        $authors[$i]['image'] = array
        (
            '@type'      => 'ImageObject',
            '@id'        => $graph_piece['image']['@id'], //'https://evistaging.wpengine.com/#personlogo',
            'inLanguage' => get_locale(),
            'url'        => $author->get_avatar( 'full', 'url' ),
            'caption'    => $author->get_name(),
        );

        ++$i;
    }

    return $authors;
}
function molongui_authorship_wpseo_replacements( $replacements, $args = null )
{
    if ( !is_author() ) return $replacements;
    if ( is_guest_author() ) return $replacements;
    if ( isset( $replacements['%%name%%'] ) )
    {
        $author = new Molongui\Authorship\Includes\Author( get_query_var( 'author', 0 ), 'user' );
        $replacements['%%name%%'] = $author->get_name();
    }
    return $replacements;
}
function molongui_authorship_wpseo_canonical( $canonical )
{
    if ( !is_author() and !is_guest_author() ) return $canonical;
    $canonical = molongui_authorship_get_actual_author_data( 'url', $canonical );
    return $canonical;
}
add_filter( 'authorship/filter_author_link', function( $leave, &$args )
{
    if ( $leave ) return $leave;
    if ( ( is_author() or is_guest_author() ) and isset( $args['dbt'][4]['function'] ) and ( $args['dbt'][4]['function'] == 'generate_canonical' ) )
    {
        $args['link'] = authorship_filter_author_page_link( $args['link'] );
        return true;
    }
    return false;
}, 10, 2 );
function molongui_authorship_wpseo_adjacent_rel_url( $url, $rel )
{
    if ( !is_author() and !is_guest_author() ) return $url;
    if ( !is_multiauthor_link( $url ) ) return $url;
    if ( substr( $url, -1 ) == '/' )
    {
        $parts = explode( "/", substr( $url, 0, -1 ) );
        $trailing = '/';
    }
    else
    {
        $parts = explode( "/", $url );
        $trailing = '';
    }
    $page = array_pop( $parts );
    $query_arg = array_pop( $parts );
    $url = molongui_authorship_get_actual_author_data( 'url', $url );
    $url = $url.( substr( $url, -1 ) == '/' ? '' : '/' ).$query_arg.'/'.$page.$trailing;
    return $url;
}
function molongui_authorship_wpseo_opengraph_url( $url )
{
    if ( !is_author() and !is_guest_author() ) return $url;
    $url = molongui_authorship_get_actual_author_data( 'url', $url );
    return $url;
}
function molongui_authorship_get_actual_author_data( $key, $default )
{
    if ( is_guest_author() )
    {
        if ( $author = get_query_var( 'guest-author-name', 0 ) )
        {
            $guest = molongui_get_author_by( 'name', $author, 'guest', false );
            if ( $guest )
            {
                $author = new Molongui\Authorship\Includes\Author( $guest->ID, 'guest', $guest );

                switch ( $key )
                {
                    case 'url':
                        $url = $author->get_url();
                        return $url;

                    break;

                    case 'img':
                        $img = $author->get_avatar();
                        return $img;

                    break;
                }
            }
        }
    }
    elseif ( $key == 'url' )
    {
        if ( is_multiauthor_link( ( $default ) ) )
        {
            $author = new Molongui\Authorship\Includes\Author( get_query_var( 'author', 0 ), 'user' );
            return $author->get_url();
        }
    }
    return $default;
}
add_filter( 'wpseo_breadcrumb_links', function( $crumbs )
{

    if ( is_author() or is_guest_author() )
    {
        $prefix = WPSEO_Options::get( 'breadcrumbs-archiveprefix' );
        $prefix = empty( $prefix ) ? '' : $prefix . ' ';
        $last = key( array_slice( $crumbs, -1, 1, true ) ); //$last = array_key_last( $crumbs );

        if ( is_guest_author() and !in_the_loop() )
        {
            if ( $author = get_query_var( 'guest-author-name', 0 ) )
            {
                $guest = molongui_get_author_by( 'name', $author, 'guest', false );
                if ( $guest ) $crumbs[$last]['text'] = $prefix . esc_html( $guest->post_title );
            }
        }
        else
        {
            $author = new Molongui\Authorship\Includes\Author( get_query_var( 'author', 0 ), 'user' );
            $crumbs[$last]['text'] = $prefix . esc_html( $author->get_name() );
        }
    }

    return $crumbs;
});
add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    $i     = 4;
    $fn    = 'get_sitemap_links';
    $class = 'WPSEO_Author_Sitemap_Provider';
    if ( isset( $args['dbt'][$i]['function'] ) and $args['dbt'][$i]['function'] == $fn and isset( $args['dbt'][$i]['class'] ) and $args['dbt'][$i]['class'] == $class ) return true;
    return $default;
}, 10, 2 );
if ( !function_exists( 'authorship_wpseo_schema_graph_pieces' ) )
{
    function authorship_wpseo_schema_graph_pieces( $pieces, $context )
    {
        return $pieces;
    }
}
if ( !function_exists( 'authorship_wpseo_opengraph_img' ) )
{
    function authorship_wpseo_opengraph_img( $url )
    {
        if ( !is_author() and !is_guest_author() ) return $url;
        $url = molongui_authorship_get_actual_author_data( 'img', $url );
        return $url;
    }
}