<?php
defined( 'ABSPATH' ) or exit;
function authorship_home_url()
{
    if ( function_exists( 'pll_home_url' ) and ( !defined( 'PLL_FILTER_HOME_URL' ) or !PLL_FILTER_HOME_URL ) )
    {
        $lang = apply_filters( 'authorship/pll/lang', '' );
        return pll_home_url( $lang );
    }
    return home_url();
}