<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'molongui_get_language' ) )
{
    function molongui_get_language()
    {
        $language = '';
        if ( false )
        {

        }
        elseif ( function_exists( 'pll_current_language' ) )
        {
            $language = pll_current_language();
        }
        elseif ( defined( 'ICL_LANGUAGE_CODE' ) )
        {
            $language = ICL_LANGUAGE_CODE;
        }
        elseif ( has_filter( 'wpml_current_language' ) )
        {
            $language = apply_filters( 'wpml_current_language', NULL );
        }
        elseif ( array_key_exists( 'TRP_LANGUAGE', $GLOBALS ) )
        {
            $language = $GLOBALS['TRP_LANGUAGE'];
        }
        elseif ( function_exists( 'qtrans_getLanguage' ) )
        {
            $language = qtrans_getLanguage();
        }
        elseif ( array_key_exists( 'q_config', $GLOBALS ) )
        {
            if ( isset( $GLOBALS['q_config']['language'] ) ) $language = $GLOBALS['q_config']['language'];
        }
        elseif ( function_exists( 'weglot_get_current_language' ) )
        {
            $language = weglot_get_current_language();
        }
        elseif ( has_filter( 'mlp_language_api' ) )
        {
            $language = apply_filters( 'mlp_language_api', NULL );
        }

        return $language;
    }
}