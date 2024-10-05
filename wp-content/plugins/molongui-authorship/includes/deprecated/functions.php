<?php
defined( 'ABSPATH' ) or exit;
function authorship_box_border( $box_border )
{
    switch ( $box_border )
    {
        case 'none':
            return 'molongui-border-none';
        break;

        case 'horizontals':
            return 'molongui-border-right-none molongui-border-left-none';
        break;

        case 'verticals':
            return 'molongui-border-top-none molongui-border-bottom-none';
        break;

        case 'top':
            return 'molongui-border-right-none molongui-border-bottom-none molongui-border-left-none';
        break;

        case 'right':
            return 'molongui-border-top-none molongui-border-bottom-none molongui-border-left-none';
        break;

        case 'bottom':
            return 'molongui-border-top-none molongui-border-right-none molongui-border-left-none';
        break;

        case 'left':
            return 'molongui-border-top-none molongui-border-right-none molongui-border-bottom-none';
        break;

        case 'all':
        default:
            return '';
        break;
    }
}
function authorship_load_customizer()
{
    return false;
}
function authorship_validate_customizer_options( $options, $current )
{
    $customizer_settings = array
    (
        'box_margin',
        'box_width',
        'box_border',
        'box_border_style',
        'box_border_width',
        'box_border_color',
        'box_background',
        'box_shadow',
        'headline_text_size',
        'headline_text_style',
        'headline_text_case',
        'headline_text_align',
        'headline_text_color',
        'tabs_position',
        'tabs_background',
        'tabs_color',
        'tabs_active_color',
        'tabs_border',
        'tabs_border_style',
        'tabs_border_width',
        'tabs_border_color',
        'tabs_text_color',
        'profile_layout',
        'profile_valign',
        'profile_title',
        'bottom_background_color',
        'bottom_border_style',
        'bottom_border_width',
        'bottom_border_color',
        'avatar_style',
        'avatar_border_style',
        'avatar_border_width',
        'avatar_border_color',
        'avatar_text_color',
        'avatar_bg_color',
        'name_text_size',
        'name_text_style',
        'name_text_case',
        'name_text_align',
        'name_inherited_underline',
        'name_text_color',
        'meta_text_size',
        'meta_text_style',
        'meta_text_case',
        'meta_text_align',
        'meta_text_color',
        'meta_separator',
        'bio_text_size',
        'bio_line_height',
        'bio_text_style',
        'bio_text_align',
        'bio_text_color',
        'icons_style',
        'icons_size',
        'icons_color',
        'related_layout',
        'related_title',
        'related_text_size',
        'related_text_style',
        'related_text_case',
        'related_text_color',
    );
    foreach ( $customizer_settings as $customizer_setting )
    {
        if ( !isset( $options[$customizer_setting] ) and isset( $current[$customizer_setting] ) )
        {
            $options[$customizer_setting] = $current[$customizer_setting];
        }
    }

    return $options;
}
function authorship_validate_refresh_options( $value, $old_value, $option )
{
    $refresh_premium_settings = array
    (
        'profile_layout' => array
        (
            'accepted' => array( 'layout-1' ),
            'default'  => 'layout-1',
        ),
        'related_layout' => array
        (
            'accepted' => array( 'layout-1', 'layout-2' ),
            'default'  => 'layout-1',
        ),
        'avatar_default_gravatar' => array
        (
            'accepted' => array( 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank' ),
            'default'  => 'mp',
        ),
        'bio_field' => array
        (
            'accepted' => array( 'full' ),
            'default'  => 'full',
        ),
    );
    foreach ( $refresh_premium_settings as $setting => $params )
    {
        if ( !isset( $value[$setting] ) )
        {
            $value[$setting] = $params['default'];
        }
        elseif ( !in_array( $value[$setting], $params['accepted'] ) )
        {
            if ( !empty( $old_value[$setting] ) and in_array( $old_value[$setting], $params['accepted'] ) ) $value[$setting] = $old_value[$setting];
            else $value[$setting] = $params['default'];
        }
    }

    return $value;
}
function authorship_validate_customize_changeset( $data, $filter_context )
{
    if ( 'publish' !== $filter_context['status'] ) return $data;
    $refresh_premium_settings = array
    (
        'profile_layout' => array
        (
            'accepted' => array( 'layout-1' ),
            'default'  => 'layout-1',
        ),
        'related_layout' => array
        (
            'accepted' => array( 'layout-1', 'layout-2' ),
            'default'  => 'layout-1',
        ),
        'avatar_default_gravatar' => array
        (
            'accepted' => array( 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank' ),
            'default'  => 'mp',
        ),
        'bio_field' => array
        (
            'accepted' => array( 'full' ),
            'default'  => 'full',
        ),
    );
    $current = authorship_get_options();

    foreach ( $data as $changed_option => $item )
    {
        $option = strtr( $changed_option, array( 'molongui_authorship_options[' => '', ']' => '' ) );
        if ( !in_array( $option, array_keys( $refresh_premium_settings ) ) ) continue;
        if ( !in_array( $item['value'], $refresh_premium_settings[$option]['accepted'] ) )
        {
            if ( !empty( $current[$option] ) and in_array( $current[$option], $refresh_premium_settings[$option]['accepted'] ) ) $data[$changed_option]['value'] = $current[$option];
            else $data[$changed_option]['value'] = $refresh_premium_settings[$option]['default'];
        }
    }

    return $data;
}
function authorship_get_customizer()
{
    $customizer_panel = MOLONGUI_AUTHORSHIP_NAME;
    $latest_post_url  = wp_get_recent_posts( array( 'numberposts' => 1, 'meta_key' => '_molongui_author_box_display', 'meta_value' =>'show', ) );
    if ( empty( $latest_post_url ) )
    {
        $latest_post_url = wp_get_recent_posts( array( 'numberposts' => 1 ) );
    }
    if ( empty( $latest_post_url ) ) return admin_url( 'customize.php?autofocus[panel]='.$customizer_panel );
    return admin_url( 'customize.php?autofocus[panel]='.$customizer_panel.'&url='.get_permalink( $latest_post_url[0]['ID'] ) );

    return authorship_editor_url();
}
if ( !function_exists( 'authorship_guess_post_type' ) )
{
    function authorship_guess_post_type()
    {
        return authorship_get_post_type();
    }
}
if ( !function_exists( 'isAuthor' ) )
{
    function isAuthor()
    {
        global $wp_query;

        if ( !isset( $wp_query ) ) return;

        return is_author();
    }
}