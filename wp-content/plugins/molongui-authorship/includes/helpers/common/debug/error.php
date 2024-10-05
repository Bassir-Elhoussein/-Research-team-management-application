<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'molongui_display_errors' ) )
{
    function molongui_display_errors()
    {
        ini_set( 'display_errors', 1 );
        ini_set( 'display_startup_errors', 1 );
        error_reporting( E_ALL );
    }
}