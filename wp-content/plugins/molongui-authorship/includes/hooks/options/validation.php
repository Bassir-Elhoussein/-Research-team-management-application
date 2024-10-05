<?php
defined( 'ABSPATH' ) or exit;
function authorship_validate_freemium_options( $options, $current )
{
    $post_types = explode( ",", $options['post_types'] );
    $options['post_types'] = "";
    if ( in_array( 'post', $post_types ) ) $options['post_types'] .= "post,";
    if ( in_array( 'page', $post_types ) ) $options['post_types'] .= "page,";
    $options['post_types'] = rtrim( $options['post_types'], ',' );

    return $options;
}
add_filter( 'authorship/validate_options', 'authorship_validate_freemium_options', 10, 2 );
function authorship_validate_options( $options, $current )
{
    if ( empty( $options['author_box_related_show'] ) ) $options['author_box_related_show'] = '0';
    if ( isset( $options['byline_multiauthor_separator']      ) ) $options['byline_multiauthor_separator']      = str_replace( array( "*", "?", "/" ), "", trim( $options['byline_multiauthor_separator'] ) );
    if ( isset( $options['byline_multiauthor_last_separator'] ) ) $options['byline_multiauthor_last_separator'] = str_replace( array( "*", "?", "/" ), "", trim( $options['byline_multiauthor_last_separator'] ) );

    return $options;
}
add_filter( 'authorship/validate_options', 'authorship_validate_options', 10, 2 );
add_action( 'authorship/options', 'authorship_add_defaults' );
function authorship_keep_db_19_keys( $options, $current )
{
    $needed = array
    (
        'author_box_meta_color'              => 'meta_text_color',
        'author_box_meta_at'                 => 'at',
        'author_box_bio_source'              => 'bio_field',
        'author_box_related_show'            => 'show_related',
        'author_box_related_layout'          => 'related_layout',
        'author_box_related_none'            => 'no_related_posts',
        'author_box_related_font_size'       => 'related_text_size',
        'author_box_related_font_style'      => 'related_text_style',
        'author_box_layout'                  => 'box_layout',
        'author_box_profile_valign'          => 'profile_valign',
        'author_box_bottom_background_color' => 'bottom_background_color',
        'author_box_bottom_border_style'     => 'bottom_border_style',
        'author_box_bottom_border_width'     => 'bottom_border_width',
        'author_box_bottom_border_color'     => 'bottom_border_color',
    );
    foreach ( $needed as $new_key => $old_key )
    {
        if ( isset( $options[$new_key] ) )
        {
            $options[$old_key] = $options[$new_key];
        }
        elseif ( isset( $current[$new_key] ) )
        {
            $options[$old_key] = $current[$new_key];
        }
    }

    return $options;
}
add_filter( 'authorship/validate_options', 'authorship_keep_db_19_keys', 20, 2 );
add_filter( 'authorship/validate_editor_options', 'authorship_keep_db_19_keys', 20, 2 );