<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_script( $file, $scope, $deps = array( 'jquery' ), $handle = null, $version = null )
{
    if ( empty( $file ) or empty( $scope ) ) return;
    if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . $file ) )
    {
        do_action( "authorship/{$scope}/pre_register_script", $scope );

        $handle   = !empty( $handle )  ? $handle  : MOLONGUI_AUTHORSHIP_NAME . '-' . str_replace( '_', '-', $scope );
        $version  = !empty( $version ) ? $version : MOLONGUI_AUTHORSHIP_VERSION;
        $function = 'authorship_'.$scope.'_script_params';
        if ( function_exists( $function ) ) $params = call_user_func( $function );

        wp_register_script( $handle, plugins_url( '/' ).$file, $deps, $version, true );
        if ( !empty( $params ) ) wp_localize_script( $handle, str_replace( '-', '_', $handle ).'_params', $params );
        do_action( "authorship/{$scope}/script_registered", $scope );
    }
}
function authorship_enqueue_script( $file, $scope, $admin = false, $handle = null, $version = null )
{
    if ( empty( $file ) or empty( $scope ) ) return;

    $filepath = trailingslashit( WP_PLUGIN_DIR ) . $file;

    if ( file_exists( $filepath ) )
    {
        $filesize = filesize( $filepath );
        if ( !$filesize ) return;

        $handle  = !empty( $handle  ) ? $handle  : MOLONGUI_AUTHORSHIP_NAME . '-' . str_replace( '_', '-', $scope );
        $version = !empty( $version ) ? $version : MOLONGUI_AUTHORSHIP_VERSION;
        $inline = apply_filters( "authorship/{$scope}/inline_script", $filesize < 4096 );
        do_action( "authorship/{$scope}/pre_enqueue_script", $scope, $inline );
        if ( $inline )
        {
            /*! This action is documented in includes/helpers/assets/scripts.php */
            if ( !did_action( "_authorship/{$scope}/script_inlined" ) )
            {
                $hook = $admin ? 'admin_print_footer_scripts' : 'wp_print_footer_scripts';

                add_action( $hook, function() use ( $scope, $filepath, $handle, $version )
                {
                    do_action( "authorship/{$scope}/pre_inline_script", $scope, $filepath, $handle );

                    $contents = file_get_contents( $filepath );
                    $function = 'authorship_'.$scope.'_script_params';
                    if ( function_exists( $function ) ) $params = call_user_func( $function );

                    if ( !empty( $params ) ) echo '<script id="'.$handle.'-inline-js-extra">' . 'var '.str_replace( '-', '_', $handle ).'_params'.' = '.json_encode( $params ).';' . '</script>';
                    echo '<script id="'.$handle.'-inline-js" type="text/javascript" data-file="'.basename( $filepath ).'" data-version="'.$version.'">' . $contents . '</script>';
                });

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
                do_action( "_authorship/{$scope}/script_inlined" );
            }
        }
        else
        {
            wp_enqueue_script( $handle );
        }
        do_action( "authorship/{$scope}/script_loaded", $scope );
    }
}