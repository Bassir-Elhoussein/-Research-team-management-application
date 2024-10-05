<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( '__return_list_true' ) )
{
    function __return_list_true()
    {
        return array( true, null );
    }
}
if ( !function_exists( '__return_list_false' ) )
{
    function __return_list_false()
    {
        return array( false, null );
    }
}