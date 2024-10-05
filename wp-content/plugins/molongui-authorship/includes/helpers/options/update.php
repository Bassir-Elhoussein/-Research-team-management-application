<?php
defined( 'ABSPATH' ) or exit;
function authorship_options_update_20( $options )
{
    if ( empty( $options ) or !is_array( $options ) ) return $options;
    if ( isset( $options['headline'] ) and !empty( $options['show_headline'] ) ) $options['author_box_header_title'] = $options['headline'];
    $options['author_box_header_bottom_space'] = 20;
    if ( isset( $options['headline_text_size'] ) ) $options['author_box_header_font_size'] = $options['headline_text_size'];
    if ( !empty( $options['headline_text_style'] ) )
    {
        foreach ( explode( ',', $options['headline_text_style'] ) as $style )
        {
            $options['author_box_header_font_weight'] = in_array( $style, array( 'normal', 'bold' ) ) ? $style : '';
            $options['author_box_header_font_style'] = in_array( $style, array( 'normal', 'italic' ) ) ? $style : '';
            $options['author_box_header_text_decoration'] = in_array( $style, array( 'underline', 'overline' ) ) ? $style : '';
        }
    }
    if ( isset( $options['headline_text_case'] ) ) $options['author_box_header_text_transform'] = $options['headline_text_case'];
    if ( isset( $options['headline_text_align'] ) ) $options['author_box_header_text_align'] = $options['headline_text_align'];
    if ( isset( $options['headline_text_color'] ) ) $options['author_box_header_color'] = $options['headline_text_color'];
    if ( isset( $options['box_headline_tag'] ) ) $options['author_box_header_tag'] = $options['box_headline_tag'];
    if ( isset( $options['show_avatar'] ) )
    {
        if ( empty( $options['show_avatar'] ) ) $options['author_box_avatar_show'] = '0';
        else $options['author_box_avatar_show'] = $options['show_avatar'];
    }
    if ( isset( $options['avatar_link_to_archive'] ) )
    {
        $options['author_box_avatar_link'] = 'archive';
    }
    else
    {
        $options['author_box_avatar_link'] = 'none';
    }
    if ( isset( $options['avatar_width'] ) ) $options['author_box_avatar_width'] = $options['avatar_width'];
    if ( isset( $options['avatar_height'] ) ) $options['author_box_avatar_height'] = $options['avatar_height'];
    if ( isset( $options['avatar_src'] ) ) $options['author_box_avatar_source'] = $options['avatar_src'];
    if ( isset( $options['avatar_local_fallback'] ) ) $options['author_box_avatar_fallback'] = $options['avatar_local_fallback'];
    if ( isset( $options['avatar_default_gravatar'] ) ) $options['author_box_avatar_default_gravatar'] = $options['avatar_default_gravatar'];
    if ( isset( $options['avatar_style'] ) )
    {
        switch ( $options['avatar_style'] )
        {
            case 'none'   : $options['author_box_avatar_border_radius'] =  0; break;
            case 'squared': $options['author_box_avatar_border_radius'] = 12; break;
            case 'circled': $options['author_box_avatar_border_radius'] = 50; break;
        }
    }
    if ( isset( $options['avatar_border_style'] ) ) $options['author_box_avatar_border_style'] = $options['avatar_border_style'];
    if ( isset( $options['avatar_border_width'] ) ) $options['author_box_avatar_border_width'] = $options['avatar_border_width'];
    if ( isset( $options['avatar_border_color'] ) ) $options['author_box_avatar_border_color'] = $options['avatar_border_color'];
    if ( isset( $options['avatar_text_color'] ) ) $options['author_box_avatar_acronym_color'] = $options['avatar_text_color'];
    if ( isset( $options['avatar_bg_color'] ) ) $options['author_box_avatar_acronym_background_color'] = $options['avatar_border_color'];
    if ( isset( $options['name_text_size'] ) ) $options['author_box_name_font_size'] = $options['name_text_size'];
    if ( isset( $options['name_text_case'] ) ) $options['author_box_name_text_transform'] = $options['name_text_case'];
    if ( isset( $options['name_text_style'] ) )
    {
        foreach ( explode( ',', $options['name_text_style'] ) as $style )
        {
            $options['author_box_name_font_weight'] = in_array( $style, array( 'normal', 'bold' ) ) ? $style : '';
            $options['author_box_name_font_style'] = in_array( $style, array( 'normal', 'italic' ) ) ? $style : '';
            $options['author_box_name_text_decoration'] = in_array( $style, array( 'underline', 'overline' ) ) ? $style : '';
        }
    }
    if ( isset( $options['name_text_align'] ) ) $options['author_box_name_text_align'] = $options['name_text_align'];
    if ( isset( $options['name_text_color'] ) ) $options['author_box_name_color'] = $options['name_text_color'];
    if ( isset( $options['name_link_to_archive'] ) )
    {
        $options['author_box_name_link'] = 'archive';
    }
    else
    {
        $options['author_box_name_link'] = 'none';
    }
    if ( isset( $options['name_inherited_underline'] ) ) $options['author_box_name_underline'] = $options['name_inherited_underline'];
    if ( isset( $options['box_author_name_tag'] ) ) $options['author_box_name_tag'] = $options['box_author_name_tag'];
    if ( isset( $options['show_meta'] ) )
    {
        if ( empty( $options['show_meta'] ) ) $options['author_box_meta_show'] = '0';
        else $options['author_box_meta_show'] = $options['show_meta'];
    }
    if ( isset( $options['meta_text_size'] ) ) $options['author_box_meta_font_size'] = $options['meta_text_size'];
    if ( isset( $options['meta_text_case'] ) ) $options['author_box_meta_text_transform'] = $options['meta_text_case'];
    if ( isset( $options['meta_text_style'] ) )
    {
        foreach ( explode( ',', $options['meta_text_style'] ) as $style )
        {
            $options['author_box_meta_font_weight'] = in_array( $style, array( 'normal', 'bold' ) ) ? $style : '';
            $options['author_box_meta_font_style'] = in_array( $style, array( 'normal', 'italic' ) ) ? $style : '';
            $options['author_box_meta_text_decoration'] = in_array( $style, array( 'underline', 'overline' ) ) ? $style : '';
        }
    }
    if ( isset( $options['meta_text_align'] ) ) $options['author_box_meta_text_align'] = $options['meta_text_align'];
    if ( isset( $options['meta_text_color'] ) ) $options['author_box_meta_color'] = $options['meta_text_color'];
    if ( isset( $options['meta_separator'] ) ) $options['author_box_meta_divider'] = $options['meta_separator'];
    if ( isset( $options['at'] ) ) $options['author_box_meta_at'] = $options['at'];
    if ( isset( $options['web'] ) ) $options['author_box_meta_web'] = $options['web'];
    if ( isset( $options['more_posts'] ) ) $options['author_box_meta_posts'] = $options['more_posts'];
    if ( isset( $options['bio'] ) ) $options['author_box_meta_bio'] = $options['bio'];
    if ( isset( $options['bio_field'] ) ) $options['author_box_bio_source'] = $options['bio_field'];
    if ( isset( $options['bio_text_size'] ) )
    {
        $options['author_box_bio_font_size'] = $options['bio_text_size'];

        if ( isset( $options['bio_line_height'] ) )
        {
            $options['author_box_bio_line_height'] = $options['bio_text_size'] * $options['bio_line_height'];
        }
    }
    if ( isset( $options['bio_text_case'] ) ) $options['author_box_bio_text_transform'] = $options['bio_text_case'];
    if ( isset( $options['bio_text_style'] ) )
    {
        foreach ( explode( ',', $options['meta_text_style'] ) as $style )
        {
            $options['author_box_bio_font_weight'] = in_array( $style, array( 'normal', 'bold' ) ) ? $style : '';
            $options['author_box_bio_font_style'] = in_array( $style, array( 'normal', 'italic' ) ) ? $style : '';
            $options['author_box_bio_text_decoration'] = in_array( $style, array( 'underline', 'overline' ) ) ? $style : '';
        }
    }
    if ( isset( $options['bio_text_align'] ) ) $options['author_box_bio_text_align'] = $options['bio_text_align'];
    if ( isset( $options['bio_text_color'] ) ) $options['author_box_bio_color'] = $options['bio_text_color'];
    if ( isset( $options['show_icons'] ) )
    {
        if ( empty( $options['show_icons'] ) ) $options['author_box_social_show'] = '0';
        else $options['author_box_social_show'] = $options['show_icons'];
    }
    if ( isset( $options['icons_style'] ) ) $options['author_box_social_style'] = $options['icons_style'];
    if ( isset( $options['icons_size'] ) ) $options['author_box_social_font_size'] = $options['icons_size'];
    if ( isset( $options['icons_color'] ) ) $options['author_box_social_color'] = $options['icons_color'];
    if ( isset( $options['social_link_target'] ) ) $options['author_box_social_target'] = '_self' === $options['social_link_target'] ? false : true;
    if ( isset( $options['show_related'] ) )
    {
        if ( empty( $options['show_related'] ) ) $options['author_box_related_show'] = '0';
        else $options['author_box_related_show'] = $options['show_related'];
    }
    if ( isset( $options['related_layout'] ) ) $options['author_box_related_layout'] = $options['related_layout'];
    if ( isset( $options['show_empty_related'] ) )
    {
        if ( empty( $options['show_empty_related'] ) ) $options['author_box_related_show_empty'] = '0';
        else $options['author_box_related_show_empty'] = $options['show_empty_related'];
    }
    if ( isset( $options['no_related_posts'] ) ) $options['author_box_related_none'] = $options['no_related_posts'];
    if ( isset( $options['related_orderby'] ) ) $options['author_box_related_orderby'] = $options['related_orderby'];
    if ( isset( $options['related_order'] ) ) $options['author_box_related_order'] = $options['related_order'];
    if ( isset( $options['related_items'] ) ) $options['author_box_related_count'] = $options['related_items'];
    if ( isset( $options['related_post_types'] ) ) $options['author_box_related_post_types'] = $options['related_post_types'];
    if ( isset( $options['related_text_size'] ) ) $options['author_box_related_font_size'] = $options['related_text_size'];
    if ( isset( $options['related_text_case'] ) ) $options['author_box_related_text_transform'] = $options['related_text_case'];
    if ( isset( $options['related_text_style'] ) )
    {
        foreach ( explode( ',', $options['related_text_style'] ) as $style )
        {
            $options['author_box_related_font_weight'] = in_array( $style, array( 'normal', 'bold' ) ) ? $style : '';
            $options['author_box_related_font_style'] = in_array( $style, array( 'normal', 'italic' ) ) ? $style : '';
            $options['author_box_related_text_decoration'] = in_array( $style, array( 'underline', 'overline' ) ) ? $style : '';
        }
    }
    if ( isset( $options['related_text_color'] ) ) $options['author_box_related_font_style'] = $options['related_text_color'];
    if ( isset( $options['author_box_width'] ) ) $options['author_box_width'] = $options['box_width'];

    if ( isset( $options['box_background'] ) ) $options['author_box_background_color'] = $options['box_background'];

    if ( isset( $options['box_margin'] ) )
    {
        $options['author_box_margin_top']    = $options['box_margin'].'px';
        $options['author_box_margin_right']  = 0;
        $options['author_box_margin_bottom'] = $options['box_margin'].'px';
        $options['author_box_margin_left']   = 0;
    }

    if ( isset( $options['box_border'] ) )
    {
        if ( !isset( $options['box_border_width'] ) ) $options['box_border_width'] = 0;

        switch ( $options['box_border'] )
        {
            case 'none':

                $options['author_box_border_top']    = '0';
                $options['author_box_border_right']  = '0';
                $options['author_box_border_bottom'] = '0';
                $options['author_box_border_left']   = '0';

            break;

            case 'horizontals':

                $options['author_box_border_top']    = $options['box_border_width'].'px';
                $options['author_box_border_right']  = '0';
                $options['author_box_border_bottom'] = $options['box_border_width'].'px';
                $options['author_box_border_left']   = '0';

            break;

            case 'verticals':

                $options['author_box_border_top']    = '0';
                $options['author_box_border_right']  = $options['box_border_width'].'px';
                $options['author_box_border_bottom'] = '0';
                $options['author_box_border_left']   = $options['box_border_width'].'px';

            break;

            case 'left':

                $options['author_box_border_top']    = '0';
                $options['author_box_border_right']  = '0';
                $options['author_box_border_bottom'] = '0';
                $options['author_box_border_left']   = $options['box_border_width'].'px';

            break;

            case 'top':

                $options['author_box_border_top']    = $options['box_border_width'].'px';
                $options['author_box_border_right']  = '0';
                $options['author_box_border_bottom'] = '0';
                $options['author_box_border_left']   = '0';

            break;

            case 'right':

                $options['author_box_border_top']    = '0';
                $options['author_box_border_right']  = $options['box_border_width'].'px';
                $options['author_box_border_bottom'] = '0';
                $options['author_box_border_left']   = '0';

            break;

            case 'bottom':

                $options['author_box_border_top']    = '0';
                $options['author_box_border_right']  = '0';
                $options['author_box_border_bottom'] = $options['box_border_width'].'px';
                $options['author_box_border_left']   = '0';

            break;

            case 'all':
            default:

                $options['author_box_border_top']    = $options['box_border_width'].'px';
                $options['author_box_border_right']  = $options['box_border_width'].'px';
                $options['author_box_border_bottom'] = $options['box_border_width'].'px';
                $options['author_box_border_left']   = $options['box_border_width'].'px';

            break;
        }
    }

    if ( isset( $options['box_border_style'] ) ) $options['author_box_border_style']  = $options['box_border_style'];
    if ( isset( $options['box_border_color'] ) ) $options['author_box_border_color']  = $options['box_border_color'];

    if ( isset( $options['box_shadow'] ) )
    {
        switch ( $options['box_shadow'] )
        {
            case 'left': // box-shadow: -10px 10px 10px #ababab;

                $options['author_box_shadow_h_offset'] = '-10';
                $options['author_box_shadow_v_offset'] = '10';
                $options['author_box_shadow_blur']     = '10';
                $options['author_box_shadow_spread']   = '0';
                $options['author_box_shadow_color']    = '#ababab';
                $options['author_box_shadow_inset']    = 0;

            break;

            case 'right': // box-shadow: 10px 10px 10px #ababab;

                $options['author_box_shadow_h_offset'] = '10';
                $options['author_box_shadow_v_offset'] = '10';
                $options['author_box_shadow_blur']     = '10';
                $options['author_box_shadow_spread']   = '0';
                $options['author_box_shadow_color']    = '#ababab';
                $options['author_box_shadow_inset']    = 0;

            break;

            default:
            case 'none': // box-shadow: none;

                $options['author_box_shadow_h_offset'] = '';
                $options['author_box_shadow_v_offset'] = '';
                $options['author_box_shadow_blur']     = '';
                $options['author_box_shadow_spread']   = '';
                $options['author_box_shadow_color']    = '';
                $options['author_box_shadow_inset']    = '';

            break;
        }
    }

    if ( isset( $options['box_layout'] ) )
    {
        $options['author_box_layout'] = $options['box_layout'];

        if ( 'tabbed' === $options['box_layout'] )
        {
            if ( isset( $options['about_the_author'] ) ) $options['author_box_profile_title'] = $options['about_the_author'];
            if ( isset( $options['related_posts'] ) ) $options['author_box_related_title'] = $options['related_posts'];
        }
        else
        {
            if ( isset( $options['profile_title'] ) ) $options['author_box_profile_title'] = $options['profile_title'];
            if ( isset( $options['related_title'] ) ) $options['author_box_related_title'] = $options['related_title'];
        }
    }
    if ( isset( $options['profile_layout'] ) ) $options['author_box_profile_layout'] = $options['profile_layout'];
    if ( isset( $options['profile_valign'] ) ) $options['author_box_profile_valign'] = $options['profile_valign'];
    if ( isset( $options['bottom_background_color'] ) ) $options['author_box_bottom_background_color'] = $options['bottom_background_color'];
    if ( isset( $options['bottom_border_style'] ) ) $options['author_box_bottom_border_style'] = $options['bottom_border_style'];
    if ( isset( $options['bottom_border_width'] ) ) $options['author_box_bottom_border_width'] = $options['bottom_border_width'];
    if ( isset( $options['bottom_border_color'] ) ) $options['author_box_bottom_border_color'] = $options['bottom_border_color'];

    if ( isset( $options['tabs_position'] ) ) $options['author_box_tabs_position'] = $options['tabs_position'];
    if ( isset( $options['tabs_background'] ) ) $options['author_box_tabs_background_color'] = $options['tabs_background'];
    if ( isset( $options['tabs_color'] ) ) $options['author_box_tabs_color'] = $options['tabs_color'];
    if ( isset( $options['tabs_active_color'] ) ) $options['author_box_tabs_active_background_color'] = $options['tabs_active_color'];
    if ( isset( $options['tabs_text_color'] ) )
    {
        $options['author_box_tabs_text_color'] = $options['tabs_text_color'];
        $options['author_box_tabs_active_text_color'] = $options['tabs_text_color'].'80'; // Add 50% opacity removed from CSS rules
    }
    if ( isset( $options['tabs_border'] ) ) $options['author_box_tabs_active_border'] = $options['tabs_border'];
    if ( isset( $options['tabs_border_style'] ) ) $options['author_box_tabs_active_border_style'] = $options['tabs_border_style'];
    if ( isset( $options['tabs_border_width'] ) ) $options['author_box_tabs_active_border_width'] = $options['tabs_border_width'];
    if ( isset( $options['tabs_border_color'] ) ) $options['author_box_tabs_active_border_color'] = $options['tabs_border_color'];

    if ( isset( $options['box_class'] ) ) $options['author_box_custom_css_class'] = $options['box_class'];

    return $options;
}