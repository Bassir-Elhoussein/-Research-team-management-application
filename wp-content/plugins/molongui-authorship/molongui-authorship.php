<?php
defined( 'ABSPATH' ) or exit;

/*!
 * Plugin Name:       Molongui Authorship
 * Description:       Best Author Box for WordPress! Easy, Beautiful and Responsive. Add authors, co-authors, multiple authors and guest authors to your WordPress posts.
 * Plugin URI:        https://www.molongui.com/authorship/
 * Text Domain:       molongui-authorship
 * Domain Path:       /i18n/
 * Requires PHP:      5.5.0
 * Requires at least: 5.2
 * Tested up to:      6.1
 * Author:            Molongui
 * Author URI:        https://www.molongui.com/
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Version:           4.6.16
 *
 * This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or any later version.
 *
 * This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this plugin. If not, see
 * http://www.gnu.org/licenses/
 */
add_action( 'plugins_loaded', 'molongui_authorship_load_plugin_textdomain' );
if ( version_compare( PHP_VERSION, '5.5', '<' ) )
{
    add_action( 'admin_notices', 'molongui_authorship_fail_php_version' );
}
elseif ( version_compare( get_bloginfo( 'version' ), '5.2', '<' ) )
{
    add_action( 'admin_notices', 'molongui_authorship_fail_wp_version' );
}
else
{
    define( 'MOLONGUI_AUTHORSHIP_VERSION', '4.6.16' );
    define( 'MOLONGUI_AUTHORSHIP_FILE', __FILE__ );
    define( 'MOLONGUI_AUTHORSHIP_DIR', plugin_dir_path( MOLONGUI_AUTHORSHIP_FILE ) );
    require MOLONGUI_AUTHORSHIP_DIR . 'includes/plugin.php';
}
function molongui_authorship_load_plugin_textdomain()
{
    load_plugin_textdomain( 'molongui-authorship', false, plugin_dir_path( __FILE__ ) . 'i18n/' );
}
function molongui_authorship_fail_php_version()
{
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    /*! translators: 1: <strong> 2: </strong> 3: PHP version 4: <strong> 5: </strong> */
    $message  = sprintf( esc_html__( '%1$sMolongui Authorship%2$s requires PHP version %3$s or greater. Because you are using an earlier version, the plugin is currently %4$sNOT RUNNING%5$s.', 'molongui-authorship' ), '<strong>', '</strong>', '5.5', '<strong>', '</strong>' );
    $message .= sprintf( '<p><a href="%s" class="button-primary" target="_blank">%s</a></p>', 'https://www.molongui.com/docs/troubleshooting/how-to-update-my-php-version/', __( "How to update PHP?", 'molongui-authorship' ) );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}
function molongui_authorship_fail_wp_version()
{
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    /*! translators: 1: <strong> 2: </strong> 3: WordPress version 4: <strong> 5: </strong> */
    $message = sprintf( esc_html__( '%1$sMolongui Authorship%2$s requires WordPress version %3$s+. Because you are using an earlier version, the plugin is currently %4$sNOT RUNNING%5$s.', 'molongui-authorship' ), '4.5' );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}