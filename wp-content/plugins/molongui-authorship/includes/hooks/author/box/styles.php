<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_box_styles()
{
    $file = apply_filters( 'authorship/box/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/author-box-rtl.1795.min.css' : '/assets/css/author-box.0a47.min.css' ) );

    authorship_register_style( $file, 'box' );
}
add_action( 'wp_enqueue_scripts'   , 'authorship_register_box_styles' );
add_action( 'admin_enqueue_scripts', 'authorship_register_box_styles' );
function authorship_enqueue_box_styles()
{
    if ( !authorship_is_feature_enabled( 'box' ) or !authorship_is_feature_enabled( 'box_styles' ) ) return;
    $file = apply_filters( 'authorship/box/styles', MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/author-box-rtl.1795.min.css' : '/assets/css/author-box.0a47.min.css' ) );

    authorship_enqueue_style( $file, 'box' );
}
function authorship_box_extra_styles()
{
    $options = authorship_get_options();
    $css = '';
    $bp  = empty( $options['breakpoint'] ) ? '600' : $options['breakpoint'];
    $bp_low_limit = $bp - 1;
    $css .= ":root{ --m-a-box-bp: " . $bp . "px; --m-a-box-bp-l: " . $bp_low_limit . "px; }";
    if ( $options['enable_cdn_compat'] )
    {
        $item_spacing = '20';
        $eqcss        = '';
        $eqcss .= '.m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content .m-a-box-content-top,
                   .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content .m-a-box-content-middle,
                   .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content .m-a-box-content-bottom { flex-direction: row; flex-wrap: nowrap; }
                  ';
        $eqcss .= '.m-a-box-container[max-width~="'.$bp_low_limit.'px"] .m-a-box-name > :first-child { text-align: center !important; }
                   .m-a-box-container[max-width~="'.$bp_low_limit.'px"] .m-a-box-meta { text-align: center !important; }
                  ';

        $eqcss .= '.m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-data { flex: 1 0; margin-top: 0; }
                   .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-data .m-a-box-name * { text-align: '.$options['author_box_name_text_align'].'; }
                   .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-data .m-a-box-meta { text-align: '.$options['author_box_meta_text_align'].'; }
                  ';

        if ( is_rtl() )
        {
            $eqcss .= '.rtl .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-avatar { flex: 0 0 auto; align-self: center; padding: 0 0 0 '.$item_spacing.'px; min-width: auto; }
                       .rtl .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-social { display: flex; flex-direction: column; margin-top: 0; padding: 0 0 0 '.$item_spacing.'px; }
                       .rtl .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content[data-profile-layout="layout-7"].m-a-box-profile .m-a-box-social,
                       .rtl .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content[data-profile-layout="layout-8"].m-a-box-profile .m-a-box-social { display: flex; flex-direction: row; margin: 10px 0; padding: 0 '.$item_spacing.'px; }
                      ';
        }
        else
        {
            $eqcss .= '.m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-avatar { flex: 0 0 auto; align-self: center; padding: 0 '.$item_spacing.'px 0 0; min-width: auto; }
                       .m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content.m-a-box-profile .m-a-box-social { display: flex; flex-direction: column; margin-top: 0; padding: 0 '.$item_spacing.'px 0 0; }
                      ';
        }
        $eqcss .= '.m-a-box-container[min-width~="'.$bp.'px"] .m-a-box-content .m-a-box-social .m-a-box-social-icon { margin: 0.4em 0; }';
        $eqcss = apply_filters( 'authorship/eqcss/fallback', $eqcss, $bp, $item_spacing );

        $css .= $eqcss;
    }
    $css .= authorship_get_box_styles();
    return apply_filters( 'authorship/box/extra_styles', $css, $options );
}
function authorship_get_box_styles( $options = array(), $box_id = '' )
{
    if ( empty( $options ) )
    {
        $options = apply_filters( 'authorship/box/options', authorship_get_options() );
    }

    if ( !empty( $box_id ) )
    {
        $box_id = '#mab-' . trim( $box_id );
    }

    $css = '';
    $styles  = '';
    $styles .= !empty( $options['author_box_width'] ) ? 'width:'.$options['author_box_width'].'%;' : '';
    $styles .=  isset( $options['author_box_margin_top'] ) ? 'margin-top:'.$options['author_box_margin_top'].' !important;' : '';
    $styles .=  isset( $options['author_box_margin_right'] ) ? 'margin-right:'.$options['author_box_margin_right'].' !important;' : '';
    $styles .=  isset( $options['author_box_margin_bottom'] ) ? 'margin-bottom:'.$options['author_box_margin_bottom'].' !important;' : '';
    $styles .=  isset( $options['author_box_margin_left'] ) ? 'margin-left:'.$options['author_box_margin_left'].' !important;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.'.m-a-box {' . $styles . '}';
    $styles  = '';
    $styles .= !empty( $options['author_box_header_background_color'] ) ? 'background-color:'.$options['author_box_header_background_color'].';' : '';
    $styles .= !empty( $options['author_box_header_bottom_space'] ) ? 'margin-bottom:'.$options['author_box_header_bottom_space'].'px;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-header {' . $styles . '}';

    $styles  = '';
    $styles .=  isset( $options['author_box_header_font_size'] ) ? 'font-size:'.$options['author_box_header_font_size'].'px;' : '';
    $styles .=  isset( $options['author_box_header_line_height'] ) ? 'line-height:'.$options['author_box_header_line_height'].'px;' : '';
    $styles .= !empty( $options['author_box_header_font_weight'] ) ? 'font-weight:'.$options['author_box_header_font_weight'].';' : '';
    $styles .= !empty( $options['author_box_header_text_transform'] ) ? 'text-transform:'.$options['author_box_header_text_transform'].';' : '';
    $styles .= !empty( $options['author_box_header_font_style'] ) ? 'font-style:'.$options['author_box_header_font_style'].';' : '';
    $styles .= !empty( $options['author_box_header_text_decoration'] ) ? 'text-decoration:'.$options['author_box_header_text_decoration'].';' : '';
    $styles .= !empty( $options['author_box_header_text_align'] ) ? 'text-align:'.$options['author_box_header_text_align'].';' : '';
    $styles .= !empty( $options['author_box_header_color'] ) ? 'color:'.$options['author_box_header_color'].';' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-header > :first-child, '.$box_id.' .m-a-box-header a.m-a-box-header-url {' . $styles . '}';
    if ( 'tabbed' === $options['author_box_layout'] )
    {
        $styles  = '';
        switch ( $options['author_box_tabs_position'] )
        {
            case 'top-left':
                $styles .= '.m-a-box .m-a-box-tabs nav {-webkit-justify-content: flex-start; -ms-justify-content: flex-start; justify-content: flex-start;}';
            break;

            case 'top-center':
                $styles .= '.m-a-box .m-a-box-tabs nav {-webkit-justify-content: center; -ms-justify-content: center; justify-content: center;}';
            break;

            case 'top-right':
                $styles .= '.m-a-box .m-a-box-tabs nav {-webkit-justify-content: flex-end; -ms-justify-content: flex-end; justify-content: flex-end;}';
            break;

            case 'top-full':
            default:
                $styles .= '.m-a-box .m-a-box-tabs nav {-webkit-justify-content: space-between; -ms-justify-content: space-between; justify-content: space-between;}';
                $styles .= '.m-a-box .m-a-box-tabs nav label {-webkit-flex-grow: 1; -ms-flex-grow: 1; flex-grow: 1;}';
            break;
        }
        if ( !empty( $styles ) ) $css .= $styles;

        $styles  = '';
        $styles .= !empty( $options['author_box_tabs_background_color'] ) ? 'background-color:'.$options['author_box_tabs_background_color'].';' : '';
        if ( !empty( $styles ) ) $css .= $box_id.'.m-a-box .m-a-box-tabs nav {' . $styles . '}';

        $styles  = '';
        $styles .= !empty( $options['author_box_tabs_color'] ) ? 'background-color:'.$options['author_box_tabs_color'].';' : '';
        $styles .= !empty( $options['author_box_tabs_text_color'] ) ? 'color:'.$options['author_box_tabs_text_color'].';' : '';
        if ( !empty( $styles ) ) $css .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {' . $styles . '}';

        $styles  = '';
        $styles .= !empty( $options['author_box_tabs_active_background_color'] ) ? 'background-color:'.$options['author_box_tabs_active_background_color'].';' : '';
        $styles .= !empty( $options['author_box_tabs_active_text_color'] ) ? 'color:'.$options['author_box_tabs_active_text_color'].';' : '';
        if ( !empty( $styles ) ) $css .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {' . $styles . '}';

        $styles  = '';
        switch( $options['author_box_tabs_active_border'] )
        {
            case 'around':
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {border:'.$options['author_box_tabs_active_border_width'].'px '.$options['author_box_tabs_active_border_style'].' '.$options['author_box_tabs_active_border_color'].'; border-bottom-style:none;}';
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-bottom-style:'.$options['author_box_tabs_active_border_style'].';}';

                if ( 'top-full' != $options['author_box_tabs_position'] )
                {
                    $styles .= $box_id.'.m-a-box .m-a-box-tabs nav {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-bottom-style:'.$options['author_box_tabs_active_border_style'].';}';
                    $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab { margin-bottom: -'.$options['author_box_tabs_active_border_width'].'px; }';
                }
            break;

            case 'top':
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {border:'.$options['author_box_tabs_active_border_width'].'px '.$options['author_box_tabs_active_border_style'].' '.$options['author_box_tabs_active_border_color'].'; border-left-style:none; border-right-style:none; border-bottom-style:none;}';
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-bottom-style:none;}';
            break;

            case 'topline':
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {border:'.$options['author_box_tabs_active_border_width'].'px '.$options['author_box_tabs_active_border_style'].' '.$options['author_box_tabs_active_border_color'].'; border-left-style:none; border-right-style:none; border-bottom-style:none;}';
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-bottom-style:'.$options['author_box_tabs_active_border_style'].';}';
            break;

            case 'bottom':
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {border:'.$options['author_box_tabs_active_border_width'].'px '.$options['author_box_tabs_active_border_style'].' '.$options['author_box_tabs_active_border_color'].'; border-left-style:none; border-top-style:none; border-right-style:none;}';
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-bottom-style:none;}';
            break;

            case 'none':
            default:
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab.m-a-box-tab-active {border:'.$options['author_box_tabs_active_border_width'].'px none '.$options['author_box_tabs_active_border_color'].';}';
                $styles .= $box_id.'.m-a-box .m-a-box-tabs nav label.m-a-box-tab {border-width:'.$options['author_box_tabs_active_border_width'].'px; border-color:'.$options['author_box_tabs_active_border_color'].'; border-style:none;}';
            break;
        }
        if ( !empty( $styles ) ) $css .= $styles;
    }
    $styles  = '';
    $styles .= 'padding-top:' . ( empty( $options['author_box_padding_top'] ) ? '0' : $options['author_box_padding_top'] ) . ';';
    $styles .= 'padding-right:' . ( empty( $options['author_box_padding_right'] ) ? '0' : $options['author_box_padding_right'] ) . ';';
    $styles .= 'padding-bottom:' . ( empty( $options['author_box_padding_bottom'] ) ? '0' : $options['author_box_padding_bottom'] ) . ';';
    $styles .= 'padding-left:' . ( empty( $options['author_box_padding_left'] ) ? '0' : $options['author_box_padding_left'] ) . ';';
    $styles .= !empty( $options['author_box_border_style'] ) ? 'border-style:'.$options['author_box_border_style'].';' : '';
    $styles .= 'border-top-width:' . ( empty( $options['author_box_border_top'] ) ? '0' : $options['author_box_border_top'] ) . ';';
    $styles .= 'border-right-width:' . ( empty( $options['author_box_border_right'] ) ? '0' : $options['author_box_border_right'] ) . ';';
    $styles .= 'border-bottom-width:' . ( empty( $options['author_box_border_bottom'] ) ? '0' : $options['author_box_border_bottom'] ) . ';';
    $styles .= 'border-left-width:' . ( empty( $options['author_box_border_left'] ) ? '0' : $options['author_box_border_left'] ) . ';';
    $styles .= !empty( $options['author_box_border_color'] ) ? 'border-color:'.$options['author_box_border_color'].';' : ''; // '' = inherit
    $styles .= !empty( $options['author_box_border_radius'] ) ? 'border-radius:'.$options['author_box_border_radius'].'px;' : '';
    $styles .= !empty( $options['author_box_background_color'] ) ? 'background-color:'.$options['author_box_background_color'].';' : ''; // '' = inherit
    $styles .= 'box-shadow:' . ( $options['author_box_shadow_h_offset'] ? $options['author_box_shadow_h_offset'].'px ' : '' ) . ( $options['author_box_shadow_v_offset'] ? $options['author_box_shadow_v_offset'].'px ' : '' ) . ( $options['author_box_shadow_blur'] ? $options['author_box_shadow_blur'].'px ' : '' ) . ( $options['author_box_shadow_spread'] ? $options['author_box_shadow_spread'].'px ' : '' ) . $options['author_box_shadow_color'] . ' ' . ( $options['author_box_shadow_inset'] ? 'inset' : '' ) . ';';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-container {' . $styles . '}';
    $styles  = '';
    $styles .= ( !empty( $options['author_box_profile_valign'] ) and $options['author_box_profile_valign'] != 'center' ) ? 'align-self:'.$options['author_box_profile_valign'].' !important;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-avatar {' . $styles . '}';

    $styles  = '';
    $styles .= !empty( $options['author_box_avatar_border_style'] ) ? 'border-style:'.$options['author_box_avatar_border_style'].';' : '';
    $styles .=  isset( $options['author_box_avatar_border_width'] ) ? 'border-width:'.$options['author_box_avatar_border_width'].'px;' : '';
    $styles .= !empty( $options['author_box_avatar_border_color'] ) ? 'border-color:'.$options['author_box_avatar_border_color'].';' : ''; // '' = inherit
    $styles .=  isset( $options['author_box_avatar_border_radius'] ) ? 'border-radius:'.$options['author_box_avatar_border_radius'].'%;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-avatar img, '.$box_id.' .m-a-box-avatar div[data-avatar-type="acronym"] {' . $styles . '}';

    if ( 'acronym' === $options['author_box_avatar_source'] )
    {
        $styles  = '';
        $styles .= !empty( $options['author_box_avatar_background_color'] ) ? 'background-color:'.$options['author_box_avatar_background_color'].';' : ''; // '' = inherit
        $styles .= !empty( $options['author_box_avatar_color'] ) ? 'color:'.$options['author_box_avatar_color'].';' : ''; // '' = inherit
        if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-avatar img, '.$box_id.' .m-a-box-avatar div[data-avatar-type="acronym"] {' . $styles . '}';
    }
    $styles  = '';
    $styles .=  isset( $options['author_box_name_font_size'] ) ? 'font-size:'.$options['author_box_name_font_size'].'px;' : '';
    $styles .=  isset( $options['author_box_name_line_height'] ) ? 'line-height:'.$options['author_box_name_line_height'].'px;' : '';
    $styles .= !empty( $options['author_box_name_font_weight'] ) ? 'font-weight:'.$options['author_box_name_font_weight'].';' : '';
    $styles .= !empty( $options['author_box_name_text_transform'] ) ? 'text-transform:'.$options['author_box_name_text_transform'].';' : '';
    $styles .= !empty( $options['author_box_name_font_style'] ) ? 'font-style:'.$options['author_box_name_font_style'].';' : '';
    $styles .= !empty( $options['author_box_name_text_decoration'] ) ? 'text-decoration:'.$options['author_box_name_text_decoration'].' !important;' : '';
    $styles .= !empty( $options['author_box_name_text_align'] ) ? 'text-align:'.$options['author_box_name_text_align'].';' : '';
    $styles .= !empty( $options['author_box_name_color'] ) ? 'color:'.$options['author_box_name_color'].' !important;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-name *  {' . $styles . '}';

    $styles  = '';
    if ( !empty( $options['author_box_name_text_align'] ) )
    {
        $styles .= 'text-align:'.$options['author_box_name_text_align'].';';
        $styles .= 'span' === $options['author_box_name_tag'] ? 'display:block;' : '';
    }
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-container[min-width~="600px"] .m-a-box-content.m-a-box-profile .m-a-box-data .m-a-box-name * {' . $styles . '}';
    $styles  = '';
    $styles .= !empty( $options['author_box_meta_text_align'] ) ? 'text-align:'.$options['author_box_meta_text_align'].';' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-content.m-a-box-profile .m-a-box-data .m-a-box-meta {' . $styles . '}';

    $styles  = '';
    $styles .=  isset( $options['author_box_meta_font_size'] ) ? 'font-size:'.$options['author_box_meta_font_size'].'px;' : '';
    $styles .=  isset( $options['author_box_meta_line_height'] ) ? 'line-height:'.$options['author_box_meta_line_height'].'px;' : '';
    $styles .= !empty( $options['author_box_meta_font_weight'] ) ? 'font-weight:'.$options['author_box_meta_font_weight'].';' : '';
    $styles .= !empty( $options['author_box_meta_text_transform'] ) ? 'text-transform:'.$options['author_box_meta_text_transform'].';' : '';
    $styles .= !empty( $options['author_box_meta_font_style'] ) ? 'font-style:'.$options['author_box_meta_font_style'].';' : '';
    $styles .= !empty( $options['author_box_meta_text_decoration'] ) ? 'text-decoration:'.$options['author_box_meta_text_decoration'].';' : '';
    $styles .= !empty( $options['author_box_meta_color'] ) ? 'color:'.$options['author_box_meta_color'].';' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-content.m-a-box-profile .m-a-box-data .m-a-box-meta * {' . $styles . '}';

    $styles  = '';
    $styles .= !empty( $options['author_box_meta_divider_spacing'] ) ? 'padding:0 '.$options['author_box_meta_divider_spacing'].'em;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-meta-divider {' . $styles . '}';
    $styles  = '';
    $styles .=  isset( $options['author_box_bio_font_size'] ) ? 'font-size:'.$options['author_box_bio_font_size'].'px;' : '';
    $styles .=  isset( $options['author_box_bio_line_height'] ) ? 'line-height:'.$options['author_box_bio_line_height'].'px;' : '';
    $styles .= !empty( $options['author_box_bio_font_weight'] ) ? 'font-weight:'.$options['author_box_bio_font_weight'].';' : '';
    $styles .= !empty( $options['author_box_bio_text_transform'] ) ? 'text-transform:'.$options['author_box_bio_text_transform'].';' : '';
    $styles .= !empty( $options['author_box_bio_font_style'] ) ? 'font-style:'.$options['author_box_bio_font_style'].';' : '';
    $styles .= !empty( $options['author_box_bio_text_decoration'] ) ? 'text-decoration:'.$options['author_box_bio_text_decoration'].';' : '';
    $styles .= !empty( $options['author_box_bio_text_align'] ) ? 'text-align:'.$options['author_box_bio_text_align'].';' : '';
    $styles .= !empty( $options['author_box_bio_color'] ) ? 'color:'.$options['author_box_bio_color'].';' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-bio > * {' . $styles . '}';
    $styles = '';
    if ( isset( $options['author_box_social_color'] ) and $options['author_box_social_color'] != 'inherit' )
    {
        switch ( $options['author_box_social_style'] )
        {
            case 'squared':
            case 'circled':
            case 'branded-squared':
            case 'branded-circled':

                $styles .= 'background-color: ' . $options['author_box_social_color'] . ' !important; border-color: ' . $options['author_box_social_color'] .' !important; color: inherit;';

            break;

            case 'boxed':

                $styles .= 'background-color: inherit; border-color: ' . $options['author_box_social_color'] .' !important; color: ' . $options['author_box_social_color'] . ' !important;';

            break;

            case 'branded':

                $styles .= 'background-color: inherit; border-color: inherit; color: inherit;';

            break;

            case 'branded-boxed':

                $styles .= 'background-color: inherit; border-color: ' . $options['author_box_social_color'] .' !important; color: inherit;';

            break;

            case 'branded-squared-reverse':
            case 'branded-circled-reverse':
            case 'default':
            default:

                $styles .= 'background-color: inherit; border-color: inherit; color: ' . $options['author_box_social_color'] . ' !important;';

            break;
        }
    }
    $styles .=  isset( $options['author_box_social_font_size'] ) ? 'font-size:'.$options['author_box_social_font_size'].'px;' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-icon-container {' . $styles . '}';
    $styles  = '';
    $styles .=  isset( $options['author_box_related_font_size'] ) ? 'font-size:'.$options['author_box_related_font_size'].'px;' : '';
    $styles .= !empty( $options['author_box_related_font_weight'] ) ? 'font-weight:'.$options['author_box_related_font_weight'].';' : '';
    $styles .= !empty( $options['author_box_related_text_transform'] ) ? 'text-transform:'.$options['author_box_related_text_transform'].';' : '';
    $styles .= !empty( $options['author_box_related_font_style'] ) ? 'font-style:'.$options['author_box_related_font_style'].';' : '';
    $styles .= !empty( $options['author_box_related_text_decoration'] ) ? 'text-decoration:'.$options['author_box_related_text_decoration'].';' : '';
    $styles .= !empty( $options['author_box_related_text_align'] ) ? 'text-align:'.$options['author_box_related_text_align'].';' : '';
    $styles .= !empty( $options['author_box_related_color'] ) ? 'color:'.$options['author_box_related_color'].';' : '';
    if ( !empty( $styles ) ) $css .= $box_id.' .m-a-box-related-entry-title, '.$box_id.' .m-a-box-related-entry-title a {' . $styles . '}';
    if ( !empty( $options['author_box_custom_css'] ) ) $css .= $options['author_box_custom_css'];
    return apply_filters( 'authorship/get_box_styles', $css, $options, $box_id );
}
function authorship_box_update_font_path( $contents )
{
    return str_replace( "url('../font/molongui-authorship-font.", "url('".MOLONGUI_AUTHORSHIP_URL."assets/font/molongui-authorship-font.", $contents );
}
add_filter( '_authorship/box/styles_contents', 'authorship_box_update_font_path' );