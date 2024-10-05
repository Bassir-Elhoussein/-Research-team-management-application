<?php
defined( 'ABSPATH' ) or exit;
function authorship_is_options_page()
{
    $current_screen = get_current_screen();
    return ( strpos( $current_screen->id, MOLONGUI_AUTHORSHIP_NAME ) );
}