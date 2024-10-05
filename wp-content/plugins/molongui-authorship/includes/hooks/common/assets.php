<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'molongui_register_media_uploader' ) )
{
    function molongui_register_media_uploader()
    {
        $file     = MOLONGUI_AUTHORSHIP_FOLDER . ( is_rtl() ? '/assets/css/common/media-upload-rtl.min.css' : '/assets/css/common/media-upload.min.css' );
        $filepath = trailingslashit( WP_PLUGIN_DIR ) . $file;

        if ( file_exists( $filepath ) )
        {
            wp_register_style( MOLONGUI_AUTHORSHIP_NAME . '-media-uploader', plugins_url( '/' ) . $file, array(), MOLONGUI_AUTHORSHIP_VERSION, 'all' );
        }
    }
    add_action( 'admin_enqueue_scripts', 'molongui_register_media_uploader' );
}
if ( !function_exists( 'molongui_register_sweetalert' ) )
{
    function molongui_register_sweetalert()
    {
        $version = '2.1.2';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $sweetalert_js_url = 'https://cdn.jsdelivr.net/npm/sweetalert@'.$version.'/dist/sweetalert.min.js';
        }
        else
        {
            $sweetalert_js_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/sweetalert/sweetalert.min.js';
        }
        wp_register_script( 'molongui-sweetalert', $sweetalert_js_url, array( 'jquery' ), $version, true );
    }
    add_action( 'admin_enqueue_scripts', 'molongui_register_sweetalert' );
}
if ( !function_exists( 'molongui_register_selectr' ) )
{
    function molongui_register_selectr()
    {
        $version = '2.4.13';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $selectr_js_url  = 'https://cdn.jsdelivr.net/npm/mobius1-selectr@'.$version.'/dist/selectr.min.js';
            $selectr_css_url = 'https://cdn.jsdelivr.net/npm/mobius1-selectr@'.$version.'/dist/selectr.min.css';
        }
        else
        {
            $selectr_js_url  = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/selectr/selectr.min.js';
            $selectr_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/selectr/selectr.min.css';
        }
        wp_register_script( 'molongui-selectr', $selectr_js_url, array(), $version, true );
        wp_register_style( 'molongui-selectr', $selectr_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_selectr' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_sortable' ) )
{
    function molongui_register_sortable()
    {
        $version = '1.10.2'; //'1.14.0';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $sortable_js_url = 'https://cdn.jsdelivr.net/npm/sortablejs@'.$version.'/Sortable.min.js';
        }
        else
        {
            $sortable_js_url  = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/sortable/Sortable.min.js';
        }
        wp_register_script( 'molongui-sortable', $sortable_js_url, array( 'jquery' ), $version, true );
    }
    add_action( 'admin_init', 'molongui_register_sortable' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_element_queries' ) )
{
    function molongui_register_element_queries()
    {
        $version = '1.2.2'; //'1.2.3';

        if ( apply_filters( 'authorship/load_element_queries', true ) )
        {
            if ( apply_filters( 'authorship/assets/load_remote', true ) )
            {
                $resizesensor_js_url   = 'https://cdn.jsdelivr.net/npm/css-element-queries@'.$version.'/src/ResizeSensor.min.js';
                $elementqueries_js_url = 'https://cdn.jsdelivr.net/npm/css-element-queries@'.$version.'/src/ElementQueries.min.js';
            }
            else
            {
                $resizesensor_js_url   = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/element-queries/ResizeSensor.min.js';
                $elementqueries_js_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/element-queries/ElementQueries.min.js';
            }
            wp_register_script( 'molongui-resizesensor',   $resizesensor_js_url,   array( 'jquery' ), $version, true );
            wp_register_script( 'molongui-elementqueries', $elementqueries_js_url, array( 'jquery' ), $version, true );
        }
    }
    add_action( 'init', 'molongui_register_element_queries' );
}
if ( !function_exists( 'molongui_register_semantic_ui_dropdown' ) )
{
    function molongui_register_semantic_ui_dropdown()
    {
        $version = '2.4.1';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $dropdown_js_url  = 'https://cdn.jsdelivr.net/npm/semantic-ui-dropdown@'.$version.'/dropdown.min.js';
            $dropdown_css_url = 'https://cdn.jsdelivr.net/npm/semantic-ui-dropdown@'.$version.'/dropdown.min.css';
        }
        else
        {
            $dropdown_js_url  = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/dropdown.'.$version.'.min.js';
            $dropdown_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/dropdown.'.$version.'.min.css';
        }
        wp_register_script( 'molongui-dropdown', $dropdown_js_url , array( 'jquery' ), $version, true );
        wp_register_style( 'molongui-dropdown' , $dropdown_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_semantic_ui_dropdown' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_semantic_ui_transition' ) )
{
    function molongui_register_semantic_ui_transition()
    {
        $version = '2.3.1';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $transition_js_url  = 'https://cdn.jsdelivr.net/npm/semantic-ui-transition@'.$version.'/transition.min.js';
            $transition_css_url = 'https://cdn.jsdelivr.net/npm/semantic-ui-transition@'.$version.'/transition.min.css';
        }
        else
        {
            $transition_js_url  = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/transition.'.$version.'.min.js';
            $transition_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/transition.'.$version.'.min.css';
        }
        wp_register_script( 'molongui-transition', $transition_js_url , array( 'jquery' ), $version, true );
        wp_register_style( 'molongui-transition' , $transition_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_semantic_ui_transition' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_semantic_ui_icon' ) )
{
    function molongui_register_semantic_ui_icon()
    {
        $version = '2.3.3';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $icon_css_url = 'https://cdn.jsdelivr.net/npm/semantic-ui-icon@'.$version.'/icon.min.css';
        }
        else
        {
            $icon_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/icon.'.$version.'.min.css';
        }
        wp_register_style( 'molongui-icon', $icon_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_semantic_ui_icon' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_semantic_ui_label' ) )
{
    function molongui_register_semantic_ui_label()
    {
        $version = '2.3.2';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $label_css_url = 'https://cdn.jsdelivr.net/npm/semantic-ui-label@'.$version.'/label.min.css';
        }
        else
        {
            $label_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/label.'.$version.'.min.css';
        }
        wp_register_style( 'molongui-label', $label_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_semantic_ui_label' ); // Can't use the 'admin_enqueue_scripts' hook!
}
if ( !function_exists( 'molongui_register_semantic_ui_popup' ) )
{
    function molongui_register_semantic_ui_popup()
    {
        $version = '2.3.1';

        if ( apply_filters( 'authorship/assets/load_remote', true ) )
        {
            $popup_js_url  = 'https://cdn.jsdelivr.net/npm/semantic-ui-popup@'.$version.'/popup.min.js';
            $popup_css_url = 'https://cdn.jsdelivr.net/npm/semantic-ui-popup@'.$version.'/popup.min.css';
        }
        else
        {
            $popup_js_url  = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/popup.'.$version.'.min.js';
            $popup_css_url = MOLONGUI_AUTHORSHIP_URL . 'assets/vendor/semantic/popup.'.$version.'.min.css';
        }
        wp_register_script( 'molongui-popup', $popup_js_url , array( 'jquery' ), $version, true );
        wp_register_style( 'molongui-popup' , $popup_css_url, array(), $version, 'screen' );
    }
    add_action( 'admin_init', 'molongui_register_semantic_ui_popup' ); // Can't use the 'admin_enqueue_scripts' hook!
}