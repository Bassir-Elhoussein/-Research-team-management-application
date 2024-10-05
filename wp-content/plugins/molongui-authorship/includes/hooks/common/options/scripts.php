<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_common_options_scripts()
{
    $file  = apply_filters( 'authorship/common_options/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/common/options.7b62.min.js' );
    $deps  = array();
    $scope = 'common_options';

    authorship_register_script( $file, $scope, $deps, 'molongui_common_options' );
    add_action( "authorship/{$scope}/pre_enqueue_script", function()
    {
        authorship_enqueue_semantic();
        molongui_enqueue_sweetalert();
    });
}
add_action( 'admin_enqueue_scripts', 'authorship_register_common_options_scripts' );
function authorship_enqueue_common_options_scripts()
{
    $file  = apply_filters( 'authorship/common_options/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/common/options.7b62.min.js' );
    $scope = 'common_options';

    authorship_enqueue_script( $file, $scope, true, 'molongui_common_options' );
}
function authorship_common_options_script_params()
{
    $scope  = 'common_options';
    $params = array
    (
        'plugin_id'      => MOLONGUI_AUTHORSHIP_PREFIX,
        'plugin_version' => MOLONGUI_AUTHORSHIP_VERSION,
        'is_pro'         => did_action( 'authorship_pro/loaded' ),
        'options_page'   => esc_url( admin_url( 'admin.php?page=' . MOLONGUI_AUTHORSHIP_NAME . '&tab=' . MOLONGUI_AUTHORSHIP_PREFIX . '_pro_' . 'license' ) ),
        1 => __( "Premium feature", 'molongui-authorship' ),
        2 => __( "This feature is available only for Premium users. Upgrade to Premium to unlock it!", 'molongui-authorship' ),
        101 => '', // unused?
        102 => __( "Saving", 'molongui-authorship' ),
        103 => __( "You are about to leave this page without saving. All changes will be lost.", 'molongui-authorship' ),
        104 => __( "WARNING: You are about to delete all your settings! Please confirm this action.", 'molongui-authorship' ),
        105 => MOLONGUI_AUTHORSHIP_PREFIX.'_',
        106 => __( "WARNING: You are about to restore your backup. This will overwrite all your settings! Please confirm this action.", 'molongui-authorship' ),
        107 => __( "WARNING: You are about to delete your backup. All unsaved options will be lost. We recommend that you save your options before deleting a backup. Please confirm this action.", 'molongui-authorship' ),
        108 => __( "WARNING: You are about to create a backup. All unsaved options will be lost. We recommend that you save your options before deleting a backup. Please confirm this action.", 'molongui-authorship' ),
        109 => __( "Delete", 'molongui-authorship' ),
        110 => MOLONGUI_AUTHORSHIP_PREFIX,
        111 => wp_create_nonce( 'mfw_import_options_nonce' ),
        112 => __( "File upload failed", 'molongui-authorship' ),
        113 => __( "Failed to load file.", 'molongui-authorship' ),
        114 => __( "Wrong file type", 'molongui-authorship' ),
        115 => __( "Only valid .JSON files are accepted.", 'molongui-authorship' ),
        116 => __( "Warning", 'molongui-authorship' ),
        117 => __( "You are about to restore your settings. This will overwrite all your existing configuration! Please confirm this action.", 'molongui-authorship' ),
        118 => __( "Cancel", 'molongui-authorship' ),
        119 => __( "OK", 'molongui-authorship' ),
        120 => __( "Success!", 'molongui-authorship' ),
        121 => __( "Plugin settings have been imported successfully. Click on the OK button and the page will be reloaded automatically.", 'molongui-authorship' ),
        122 => __( "Error", 'molongui-authorship' ),
        123 => __( "Something went wrong and plugin settings couldn't be restored. Please, make sure uploaded file has content and try uploading the file again.", 'molongui-authorship' ),
        124 => sprintf( __( "Either the uploaded backup file is for another plugin or it is from a newer version of the plugin. Please, make sure you are uploading a file generated with %s version lower or equal to %s.", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE, MOLONGUI_AUTHORSHIP_VERSION ),
        125 => __( "Some settings couldn't be restored. Please, try uploading the file again.", 'molongui-authorship' ),
        126 => __( "You are about to restore plugin default settings. This will overwrite all your existing configuration! Please confirm this action.", 'molongui-authorship' ),
        127 => wp_create_nonce( 'mfw_reset_options_nonce' ),
        128 => __( "Plugin settings have been restored to defaults successfully. Click on the OK button and the page will be reloaded automatically.", 'molongui-authorship' ),
        129 => __( "Something went wrong and plugin defaults couldn't be restored. Please, try again.", 'molongui-authorship' ),
        130 => __( "Something went wrong and couldn't connect to the server. Please, try again.", 'molongui-authorship' ),
        200 => wp_create_nonce( 'mfw_license_nonce' ),
        201 => __( "Something is missing...", 'molongui-authorship' ),
        202 => __( "You need to provide both values, License Key and PIN", 'molongui-authorship' ),
        203 => __( "Activated!", 'molongui-authorship' ),
        204 => __( "Oops... activation failed", 'molongui-authorship' ),
        205 => __( "Oops!", 'molongui-authorship' ),
        206 => __( "Something went wrong and the license has not been activated.", 'molongui-authorship' ),
        207 => __( "Deactivate license", 'molongui-authorship' ),
        208 => __( "Submit to deactivate your license now", 'molongui-authorship' ),
        209 => __( "No, cancel!", 'molongui-authorship' ),
        210 => __( "Yes, deactivate it!", 'molongui-authorship' ),
        211 => __( "Deactivated!", 'molongui-authorship' ),
        212 => __( "Oops... something weird happened!", 'molongui-authorship' ),
        213 => __( "Something went wrong and the license has not been deactivated.", 'molongui-authorship' ),
        214 => __( "Activate", 'molongui-authorship' ),
        215 => __( "Deactivate", 'molongui-authorship' ),
        216 => __( "Error" ),
        217 => __( "License PIN must contain only digits", 'molongui-authorship' ),
    );
    return apply_filters( "authorship/{$scope}/params", $params );
}
function authorship_menu_target_blank()
{
    ob_start();
    ?>
    <script type="text/javascript">
        (function($)
        {
            $( 'a[href="https://www.molongui.com/docs/"]' ).attr( 'target', '_blank' );
            $( 'a[href="https://demos.molongui.com/"]' ).attr( 'target', '_blank' );
        })( jQuery );
    </script>
    <?php
    echo preg_replace( '/\s+/S', ' ', ob_get_clean() );
}
add_action( 'admin_footer', 'authorship_menu_target_blank' );