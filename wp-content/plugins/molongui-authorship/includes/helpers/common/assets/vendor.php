<?php
defined( 'ABSPATH' ) or exit;
function authorship_enqueue_media_uploader_styles()
{
    $file     = MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/media-upload-rtl.min.css' : '/assets/css/common/media-upload.min.css' );
    $filepath = trailingslashit( WP_PLUGIN_DIR ) . $file;

    if ( file_exists( $filepath ) )
    {
        $filesize = filesize( $filepath );
        if ( !$filesize ) return;
        $inline = apply_filters( 'authorship/media_uploader/inline_styles', $filesize < 4096 );
        $handle = MOLONGUI_AUTHORSHIP_NAME . '-media-uploader';

        if ( $inline )
        {
            if ( !did_action( '_authorship/media_uploader/styles_loaded' ) )
            {
                $contents = file_get_contents( trailingslashit( WP_PLUGIN_DIR ) . $file );
                echo '<style id="'.$handle.'-inline-css" type="text/css" data-file="' . basename( $file ) . '">' . $contents . '</style>';

                /*!
                 * PRIVATE ACTION HOOK.
                 *
                 * For internal use only. Not intended to be used by plugin or theme developers.
                 * Future compatibility NOT guaranteed.
                 *
                 * Please do not rely on this hook for your custom code to work. As a private hook it is meant to be
                 * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice
                 * or deprecation phase.
                 *
                 * If you choose to ignore this notice and use this filter, please note that you do so at on your own
                 * risk and knowing that it could cause code failure.
                 */
                do_action( '_authorship/media_uploader/styles_loaded' );
            }
        }
        else
        {
            wp_enqueue_style( $handle );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_sweetalert' ) )
{
    function molongui_enqueue_sweetalert()
    {
        $handle = 'molongui-sweetalert';
        if ( !wp_script_is( $handle, 'registered' ) ) molongui_register_sweetalert();
        if ( wp_script_is( $handle, 'registered' ) and !wp_script_is( $handle, 'enqueued' ) )
        {
            wp_enqueue_script( $handle );
            wp_add_inline_script( $handle, 'var molongui_swal = swal;' );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_selectr' ) )
{
    function molongui_enqueue_selectr()
    {
        $handle = 'molongui-selectr';
        if ( !wp_script_is( $handle, 'registered' ) ) molongui_register_selectr();
        if ( wp_script_is( $handle, 'registered' ) and !wp_script_is( $handle, 'enqueued' ) )
        {
            wp_enqueue_script( $handle );
            wp_enqueue_style( $handle );
            wp_add_inline_script( $handle, 'var MolonguiSelectr = Selectr; Selectr = undefined;' );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_sortable' ) )
{
    function molongui_enqueue_sortable()
    {
        $handle = 'molongui-sortable';
        if ( !wp_script_is( $handle, 'registered' ) ) molongui_register_sortable();
        if ( wp_script_is( $handle, 'registered' ) and !wp_script_is( $handle, 'enqueued' ) )
        {
            wp_enqueue_script( $handle );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_element_queries' ) )
{
    function molongui_enqueue_element_queries()
    {
        $handle = 'molongui-resizesensor';
        if ( !wp_script_is( $handle, 'registered' ) ) molongui_register_element_queries();
        if ( wp_script_is( $handle, 'registered' ) and !wp_script_is( $handle, 'enqueued' ) )
        {
            wp_enqueue_script( $handle );
        }
        $handle = 'molongui-elementqueries';
        if ( !wp_script_is( $handle, 'registered' ) ) molongui_register_element_queries();
        if ( wp_script_is( $handle, 'registered' ) and !wp_script_is( $handle, 'enqueued' ) )
        {
            wp_enqueue_script( $handle );
        }
    }
}
if ( !function_exists( 'molongui_enqueue_semantic_ui_dropdown' ) )
{
    function molongui_enqueue_semantic_ui_dropdown()
    {
        wp_enqueue_script( 'molongui-dropdown' );
        wp_enqueue_style( 'molongui-dropdown'  );
    }
}
if ( !function_exists( 'molongui_enqueue_semantic_ui_transition' ) )
{
    function molongui_enqueue_semantic_ui_transition()
    {
        wp_enqueue_script( 'molongui-transition' );
        wp_enqueue_style( 'molongui-transition'  );
    }
}
if ( !function_exists( 'molongui_enqueue_semantic_ui_icon' ) )
{
    function molongui_enqueue_semantic_ui_icon()
    {
        wp_enqueue_style( 'molongui-icon' );
    }
}
if ( !function_exists( 'molongui_enqueue_semantic_ui_label' ) )
{
    function molongui_enqueue_semantic_ui_label()
    {
        wp_enqueue_style( 'molongui-label' );
    }
}
if ( !function_exists( 'molongui_enqueue_semantic_ui_popup' ) )
{
    function molongui_enqueue_semantic_ui_popup()
    {
        wp_enqueue_script( 'molongui-popup' );
        wp_enqueue_style( 'molongui-popup'  );
    }
}
function authorship_enqueue_semantic()
{
    molongui_enqueue_semantic_ui_transition(); // Dependency. Required by Semantic UI Dropdown
    molongui_enqueue_semantic_ui_icon();       // Used by Semantic UI Dropdown. Not a hard dependency
    molongui_enqueue_semantic_ui_label();      // Used by Semantic UI Dropdown. Not a hard dependency
    molongui_enqueue_semantic_ui_dropdown();
    molongui_enqueue_semantic_ui_popup();
}
if ( !function_exists( 'molongui_enqueue_select2' ) )
{
    function molongui_enqueue_select2()
    {
        if ( !wp_script_is( 'molongui-select2', 'enqueued' ) )
        {
            $version = '4.0.5';
            $select2_js_url  = 'https://cdnjs.cloudflare.com/ajax/libs/select2/'.$version.'/js/select2.min.js';
            $select2_css_url = 'https://cdnjs.cloudflare.com/ajax/libs/select2/'.$version.'/css/select2.min.css';
            wp_enqueue_script( 'molongui-select2', $select2_js_url, array(), $version, true );
            wp_enqueue_style( 'molongui-select2', $select2_css_url, array(), $version, 'all' );
            wp_add_inline_script( 'molongui-select2',
                'var molongui_select2 = jQuery.fn.select2; delete jQuery.fn.select2;' .
                "
                    jQuery(document).ready(function($)
                    {
                        if ( typeof molongui_select2 !== 'undefined' )
                        {
                            molongui_select2.call( $('#molongui-settings select'), { dropdownAutoWidth: true, minimumResultsForSearch: Infinity } );
                            molongui_select2.call( $('.molongui-metabox select'),  { dropdownAutoWidth: true, minimumResultsForSearch: Infinity } );
                            molongui_select2.call( $('#molongui-settings select.searchable'), { dropdownAutoWidth: true } );
                            molongui_select2.call( $('.molongui-metabox select.searchable'),  { dropdownAutoWidth: true } );
                            molongui_select2.call( $('#molongui-settings select.multiple'), { dropdownAutoWidth: true, multiple: true, allowClear: true } );
                            molongui_select2.call( $('.molongui-metabox select.multiple'),  { dropdownAutoWidth: true, multiple: true, allowClear: true } );
                        }
                    });
                "
            );
        }
    }
}