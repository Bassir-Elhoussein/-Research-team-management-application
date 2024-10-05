<?php
defined('ABSPATH') or exit;
add_action( 'init', function()
{
    if ( is_admin() ) return;
    if ( class_exists( 'AAM_Core_Config' ) and method_exists( AAM_Core_Config::class, 'get' ) )
    {
        if ( AAM_Core_Config::get('core.service.user-level-filter.enabled', false ) )
        {
            if ( class_exists( 'AAM_Service_UserLevelFilter' ) and method_exists( AAM_Service_UserLevelFilter::class, 'getInstance' ) )
            {
                $class = AAM_Service_UserLevelFilter::getInstance();
                $r = remove_action( 'pre_get_users', array( $class, 'filterUserQuery' ), 999 );
            }
        }
    }
}, PHP_INT_MAX );