<?php
defined( 'ABSPATH' ) or exit;
function authorship_set_defaults()
{
    return array
    (
        'author_box'               => true,
        'box_post_types_auto'      => "post", // Data stored as a string with comma-separated items. No array!
        'box_post_types_manual'    => '',     // Data stored as a string with comma-separated items. No array!
        'box_position'             => 'below',
        'hide_if_no_bio'           => false,
        'box_hook_priority'        => 11,
        'box_layout_multiauthor'   => 'default',
        'encode_email'             => false,
        'encode_phone'             => false,
        'box_schema'               => true,
        'enable_cdn_compat'        => false,
        'enable_author_box_styles' => true,
        'hide_elements'            => '',
        'author_box_header_title'            => '', // none. Author box header disabled.
        'author_box_header_url'              => '', // none
        'author_box_header_bottom_space'     => 20,
        'author_box_header_font_size'        => '', // inherit
        'author_box_header_line_height'      => '', // inherit
        'author_box_header_font_weight'      => '', // default = inherit
        'author_box_header_text_transform'   => '', // default = inherit
        'author_box_header_font_style'       => '', // default = inherit
        'author_box_header_text_decoration'  => '', // default = inherit
        'author_box_header_text_align'       => '', // default = inherit
        'author_box_header_color'            => '', // inherit
        'author_box_header_tag'              => 'h3',
        'author_box_avatar_show'                     => 1, // show
        'author_box_avatar_link'                     => true,
        'author_box_avatar_source'                   => 'local',
        'author_box_avatar_fallback'                 => 'gravatar',
        'author_box_avatar_default_gravatar'         => 'mp',
        'author_box_avatar_width'                    => 150,
        'author_box_avatar_height'                   => 150,
        'author_box_avatar_border_style'             => 'solid',
        'author_box_avatar_border_width'             => '2',
        'author_box_avatar_border_color'             => '#bfbfbf',
        'author_box_avatar_border_radius'            => '', // inherit
        'author_box_avatar_acronym_color'            => '#dd9933', // goldish
        'author_box_avatar_acronym_background_color' => '#1d2327', // dark gray
        'author_box_name_font_size'       => 22,
        'author_box_name_line_height'     => '', // inherit
        'author_box_name_font_weight'     => '', // default = inherit
        'author_box_name_text_transform'  => '', // default = inherit
        'author_box_name_font_style'      => '', // default = inherit
        'author_box_name_text_decoration' => '', // default = inherit
        'author_box_name_text_align'      => '', // default = inherit
        'author_box_name_color'           => '', // inherit
        'author_box_name_link'            => 'archive',
        'author_box_name_underline'       => 'keep',
        'author_box_name_tag'             => 'h5',
        'author_box_meta_show'            => true,
        'author_box_meta_font_size'       => 12,
        'author_box_meta_line_height'     => '', // inherit
        'author_box_meta_font_weight'     => '', // default = inherit
        'author_box_meta_text_transform'  => '', // default = inherit
        'author_box_meta_font_style'      => '', // default = inherit
        'author_box_meta_text_decoration' => '', // default = inherit
        'author_box_meta_text_align'      => '', // default = inherit
        'author_box_meta_color'           => '', // inherit
        'author_box_meta_divider'         => '|',
        'author_box_meta_divider_spacing' => '0.2',
        'author_box_meta_at'              => __( "at", 'molongui-authorship' ),
        'author_box_meta_web'             => __( "Website", 'molongui-authorship' ),
        'author_box_meta_posts'           => __( "+ posts", 'molongui-authorship' ),
        'author_box_meta_bio'             => __( "Bio", 'molongui-authorship' ),
        'author_box_bio_source'          => 'full',
        'author_box_bio_font_size'       => 14,
        'author_box_bio_line_height'     => '', // inherit
        'author_box_bio_font_weight'     => '', // default = inherit
        'author_box_bio_text_transform'  => '', // default = inherit
        'author_box_bio_font_style'      => '', // default = inherit
        'author_box_bio_text_decoration' => '', // default = inherit
        'author_box_bio_text_align'      => '', // default = inherit
        'author_box_bio_color'           => '', // inherit
        'author_box_social_show'      => true,
        'author_box_social_style'     => 'default',
        'author_box_social_font_size' => 20,
        'author_box_social_color'     => '#999999',
        'author_box_social_target'    => '_blank',
        'author_box_related_show'            => true,
        'author_box_related_layout'          => 'layout-1',
        'author_box_related_show_empty'      => true,
        'author_box_related_none'            => __( "This author does not have any more posts.", 'molongui-authorship' ),
        'author_box_related_orderby'         => 'date',
        'author_box_related_order'           => 'DESC',
        'author_box_related_count'           => 4,
        'author_box_related_post_types'      => "post", // Data stored as a string with comma-separated items. No array!
        'author_box_related_font_size'       => 14,
        'author_box_related_line_height'     => '', // inherit
        'author_box_related_font_weight'     => '', // default = inherit
        'author_box_related_text_transform'  => '', // default = inherit
        'author_box_related_font_style'      => '', // default = inherit
        'author_box_related_text_decoration' => '', // default = inherit
        'author_box_related_text_align'      => '', // default = inherit
        'author_box_related_color'           => '', // inherit
        'author_box_margin_top'    => '20px',
        'author_box_margin_right'  => '0',
        'author_box_margin_bottom' => '20px',
        'author_box_margin_left'   => '0',

        'author_box_border_top'    => '1px',
        'author_box_border_right'  => '0',
        'author_box_border_bottom' => '1px',
        'author_box_border_left'   => '0',
        'author_box_border_style'  => 'solid',
        'author_box_border_color'  => '#e8e8e8',
        'author_box_border_radius' => 0,

        'author_box_padding_top'    => '0',
        'author_box_padding_right'  => '0',
        'author_box_padding_bottom' => '0',
        'author_box_padding_left'   => '0',

        'author_box_width'            => 100,
        'author_box_background_color' => '#f7f8f9',

        'author_box_layout'                  => 'slim',
        'author_box_profile_title'           => __( "Author Profile", 'molongui-authorship' ),
        'author_box_related_title'           => __( "Related Posts", 'molongui-authorship' ),
        'author_box_profile_layout'          => 'layout-1',
        'author_box_profile_valign'          => 'center',
        'author_box_bottom_background_color' => '#e0e0e0',
        'author_box_bottom_border_style'     => 'solid',
        'author_box_bottom_border_width'     => '1',
        'author_box_bottom_border_color'     => '#b6b6b6',

        'author_box_shadow_color'    => '#ababab',
        'author_box_shadow_h_offset' => 10,
        'author_box_shadow_v_offset' => 10,
        'author_box_shadow_blur'     => 10,
        'author_box_shadow_spread'   => '',
        'author_box_shadow_inset'    => 0,

        'author_box_tabs_position'                => 'top-full',
        'author_box_tabs_color'                   => '#f4f4f4',
        'author_box_tabs_background_color'        => 'transparent',
        'author_box_tabs_text_color'              => 'inherit',
        'author_box_tabs_active_background_color' => '#efefef',
        'author_box_tabs_active_text_color'       => 'inherit',
        'author_box_tabs_active_border'           => 'top',
        'author_box_tabs_active_border_style'     => 'solid',
        'author_box_tabs_active_border_width'     => '4',
        'author_box_tabs_active_border_color'     => 'orange',
        'author_box_custom_css'       => '',
        'author_box_custom_css_class' => '',

        'guest_authors'               => true,

        'guest_pages'                 => false,
        'guest_archive_include_pages' => false,
        'guest_archive_include_cpts'  => false,
        'guest_archive_permalink'     => '',
        'guest_archive_base'          => 'author',
        'guest_archive_tmpl'          => '',

        'enable_guests_in_search' => false,
        'enable_guests_in_api'    => false,
        'guests_menu_level' => 'top',

        'enable_multi_authors' => true,

        'byline_multiauthor_display'        => 'all',
        'byline_multiauthor_separator'      => '',
        'byline_multiauthor_last_separator' => '',
        'byline_multiauthor_link'           => true,

        'enable_authors_in_api' => false,
        'user_roles' => "administrator,editor,author,contributor", // Data stored as a string with comma-separated items. No array!

        'enable_local_avatars'    => true,
        'enable_user_profiles'    => true,
        'enable_search_by_author' => false,

        'user_archive_enabled'       => true,
        'user_archive_include_pages' => false,
        'user_archive_include_cpts'  => false,
        'user_archive_tmpl'          => '',
        'user_archive_base'          => 'author',
        'user_archive_slug'          => false,
        'post_types' => "post", // Data stored as a string with comma-separated items. No array!
        'social_networks' => "facebook,twitter,youtube,pinterest,tiktok,instagram,soundcloud,spotify,skype,medium,whatsapp", // Data stored as a string with comma-separated items. No array!
        'add_nofollow'    => false,
        'byline_name_link' => true,
        'byline_prefix'    => '',
        'byline_suffix'    => '',
        'keep_config' => true,
        'keep_data'   => true,
        'add_html_meta'      => true,
        'add_opengraph_meta' => true,
        'add_facebook_meta'  => true,
        'add_twitter_meta'   => true,
        'multi_author_meta'  => 'many',
        'authors_menu'       => true,
        'guests_menu'        => false,
        'molongui_menu'      => false,
        'posts_submenu'      => true,
        'appearance_submenu' => true,
        'settings_submenu'   => true,
        'author_name_action' => 'filter',
        'enable_cache' => true,
        'assets_cdn'   => true,
        'enable_theme_compat'  => true,
        'enable_plugin_compat' => true,
    );
}
add_filter( 'authorship/default_options', 'authorship_set_defaults' );