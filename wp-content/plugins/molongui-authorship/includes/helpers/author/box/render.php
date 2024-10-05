<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
function authorship_render_box( $content )
{
    $post = authorship_get_post();

    $post_id = !empty( $post->ID ) ? $post->ID : null;
    if ( empty( $post_id ) ) return $content;
    if ( !apply_filters( 'authorship/render_box', true, $post ) ) return $content;
    $post_authors = get_post_authors( $post_id );
    if ( empty( $post_authors ) or $post_authors[0]->id == 0 ) return $content;
    $options = authorship_get_options();
    $html = authorship_box_markup( $post, $post_authors, $options );
    if ( empty( $html ) ) return $content;
    global $multipage, $page, $numpages;
    $box_position = get_post_meta( $post_id, '_molongui_author_box_position', true );
    if ( empty( $box_position ) or $box_position == 'default' )
    {
        $box_position = !empty( $options['box_position'] ) ? $options['box_position'] : 'below';
    }
    switch ( $box_position )
    {
        case "both":

            if ( !$multipage )
            {
                $html_2  = authorship_box_markup( $post, $post_authors, $options );
                $content = $html . $content . $html_2;
            }
            elseif ( $page == 1 )
            {
                $content = $html . $content;
            }
            elseif ( $page == $numpages )
            {
                $content .= $html;
            }

        break;

        case "above":

            if ( !$multipage or ( $multipage and $page == 1 ) ) $content = $html . $content;

        break;

        case "below":
        case "default":
        default:

            if ( !$multipage or ( $multipage and $page == $numpages ) ) $content .= $html;

        break;
    }
    return $content;
}
function authorship_box_markup( $post, $post_authors, $options = array(), $check = true )
{
    if ( empty( $post_authors ) ) return;
    if ( empty( $options ) ) $options = authorship_get_options();
    $html           = '';
    $box_ids        = array();
    $is_multiauthor = empty( $post->ID ) ? false : is_multiauthor_post( $post->ID );
    $show_headline  = true;
    $add_microdata  = !empty( $options['box_schema'] );//authorship_is_feature_enabled( 'microdata' );
    foreach ( $post_authors as $post_author )
    {
        if ( $check and authorship_hide_box( $post, $post_author, $options ) )
        {
            $authors[$post_author->ref]['hide'] = true;
            continue;
        }
        $author                     = new Author( $post_author->id, $post_author->type );
        $authors[$post_author->ref] = $author->get_data();
        if ( $options['author_box_related_show'] or $options['author_box_layout'] == 'tabbed' )
        {
            $authors[$post_author->ref]['posts'] = $author->get_posts( array( 'fields' => 'all', 'post_type' => 'related', 'post_status' => 'publish', 'order' => $options['author_box_related_order'], 'orderby' => $options['author_box_related_orderby'], 'posts_per_page' => $options['author_box_related_count'], 'post__not_in' => ( is_object( $post ) and !empty( $post->ID ) ) ? array( $post->ID ) : '' ) );
        }
        if ( !$is_multiauthor or ( $is_multiauthor and $options['box_layout_multiauthor'] == 'individual' ) )
        {
            $author = $authors[$post_author->ref];
            $random_id = molongui_rand();
            $box_ids[] = $random_id;
            molongui_enqueue_element_queries();
            authorship_enqueue_box_styles();
            ob_start();
            include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/html-layout.php';
            $html .= ob_get_clean();
            $show_headline = false;
        }
    }
    if ( $is_multiauthor                                            // It is a multi-authored post
         and $options['box_layout_multiauthor'] != 'individual'     // author boxes are not displayed individually
         and 0 < count( array_filter( $authors, function( $a )
         {
            return ( !isset( $a['hide'] ) or $a['hide'] == false );
         } ) ) // there is at least one author to show.
    )
    {
        $random_id = molongui_rand();
        $box_ids[] = $random_id;
        $common_posts = get_coauthored_posts( $post_authors, false, array(), 'selected' );
        $show_related = ( $options['author_box_layout'] != 'slim' and !empty( $options['author_box_related_show'] ) and ( !empty( $common_posts ) or !empty( $options['author_box_related_show_empty'] ) ) );
        molongui_enqueue_element_queries();
        authorship_enqueue_box_styles();
        ob_start();
        include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/html-multiauthor-layout.php';
        $html .= ob_get_clean();
    }
    return apply_filters( 'authorship/author_box_markup', $html, $post, $post_authors, $options, $check, $box_ids );
}
function authorship_hide_box( $post, $author, $options )
{
    $post_type       = get_post_type( $post );
    $post_types_auto = authorship_box_post_types( 'auto' );
    $post_types_man  = authorship_box_post_types( 'manual' );
    $post_types      = array_unique( array_merge( $post_types_auto, $post_types_man ) );
    if ( !in_array( $post_type, $post_types ) )
    {
        if ( !( authorship_has_pro() and get_option( MOLONGUI_AUTHORSHIP_PRO_CONTRIB_ID, 0 ) == $post->ID ) ) return true;
    }
    $author_class = new Author( $author->id, $author->type );
    switch ( $author_class->get_meta( 'box_display' ) )
    {
        case 'show': return false; break;
        case 'hide': return true; break;
        case 'default': break;
    }
    switch ( get_post_meta( $post->ID, '_molongui_author_box_display', true ) )
    {
        case 'show': return false; break;
        case 'hide': return true; break;
        case 'default': break;
    }
    if ( is_single() and !empty( $options['hide_on_categories'] ) and in_array( 'post', $post_types_auto ) )
    {
        $hide_on_categories = explode( ",", $options['hide_on_categories'] );
        $post_categories    = wp_get_post_categories( $post->ID );
        if ( is_array( $post_categories ) ) foreach ( $post_categories as $post_category )
        {
            if ( in_array( $post_category, $hide_on_categories ) ) return true;
        }
    }
    if ( !empty( $options['hide_if_no_bio'] ) and !$author_class->get_bio() ) return true; // Hide author box.
    if ( authorship_has_pro() and get_option( MOLONGUI_AUTHORSHIP_PRO_CONTRIB_ID, 0 ) == $post->ID ) return false; // Don't hide author box.
    if ( in_array( $post_type, $post_types_man ) )
    {
        if ( !in_array( $post_type, $post_types_auto ) ) return true;
    }
    global $multipage;
    if ( $multipage )
    {
        global $page, $numpages;
        $box_position = get_post_meta( $post->ID, '_molongui_author_box_position', true );
        if ( $box_position == 'default' ) $box_position = $options['box_position'];

        switch ( $box_position )
        {
            case 'above':
                if ( $page != 1 ) return true;
            break;

            case 'below':
                if ( $page != $numpages ) return true;
            break;

            case 'both':
                if ( $page != 1 and $page != $numpages ) return true;
            break;
        }
    }
    return false;
}