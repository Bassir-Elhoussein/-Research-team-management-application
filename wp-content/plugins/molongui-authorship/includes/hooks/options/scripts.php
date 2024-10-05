<?php
defined( 'ABSPATH' ) or exit;
function authorship_register_options_scripts()
{
    $file  = apply_filters( 'authorship/options/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/options.542e.min.js' );
    $scope = 'options';

    authorship_register_script( $file, $scope );
}
add_action( 'admin_enqueue_scripts', 'authorship_register_options_scripts' );
function authorship_enqueue_options_scripts()
{
    $file  = apply_filters( 'authorship/options/script', MOLONGUI_AUTHORSHIP_FOLDER . '/assets/js/options.542e.min.js' );
    $scope = 'options';
    authorship_enqueue_script( $file, $scope, true );
}
add_action( 'authorship/options/after_footer', 'authorship_enqueue_options_scripts' );
function authorship_options_script_params()
{
    $scope  = 'options';
    $params = array
    (
        'is_premium' => false,
        100 => __( "Are you sure?", 'molongui-authorship' ),
        101 => __( "Disabling author box styles requires you to provide your own CSS rules. If you are not an skilled developer, we strongly advise you not to proceed.", 'molongui-authorship' ),
        102 => __( "Disabled", 'molongui-authorship' ),
        103 => __( "Remember to provide your own styles. To do so you can use the 'Additional CSS' setting available on the WordPress Customizer or a child theme.", 'molongui-authorship' ),
        200 => wp_create_nonce( 'authorship_clear_cache_nonce' ),
        201 => __( "Clear Cache", 'molongui-authorship' ),
        202 => __( "WordPress object cache is used to speed things up. Please confirm you want to go ahead and clear it.", 'molongui-authorship' ),
        203 => __( "Cancel", 'molongui-authorship' ),
        204 => __( "OK", 'molongui-authorship' ),
        205 => __( "Cleared!", 'molongui-authorship' ),
        206 => __( "Object cache used by Molongui Authorship has been cleared successfully", 'molongui-authorship' ),
        207 => __( "Error", 'molongui-authorship' ),
        208 => __( "Something went wrong and cache clean up failed. Please refresh this page and try again.", 'molongui-authorship' ),
        209 => __( "Something went wrong and couldn't connect to the server. Please, try again.", 'molongui-authorship' ),
        300 => wp_create_nonce( 'authorship_update_counters_nonce' ),
        301 => __( "Count Update", 'molongui-authorship' ),
        302 => __( "Forcing an update on post counters is a task that runs in the background and might take a (long) while to complete. Please confirm you want to go ahead.", 'molongui-authorship' ),
        303 => __( "Cancel", 'molongui-authorship' ),
        304 => __( "OK", 'molongui-authorship' ),
        305 => __( "Error", 'molongui-authorship' ),
        306 => __( "You have the WP_Cron disabled, so counters update failed. Please enable the WP_Cron in your wp-config.php file.", 'molongui-authorship' ),
        307 => __( "Something went wrong and counters update failed. Please refresh this page and try again.", 'molongui-authorship' ),
        308 => __( "Running...", 'molongui-authorship' ),
        309 => __( "Post count update is running in the background. A notice will let you know the update status. You can close this window now.", 'molongui-authorship' ),
        310 => __( "Something went wrong and couldn't connect to the server. Please, try again.", 'molongui-authorship' ),
        400 => __( "Doing it wrong!", 'molongui-authorship' ),
        401 => __( "You cannot disable both 'Authors' and 'Molongui' menus. One of them must be displayed so you have access to the plugin settings page.", 'molongui-authorship' ),
    );
    return apply_filters( "authorship/{$scope}/script_params", $params );
}
