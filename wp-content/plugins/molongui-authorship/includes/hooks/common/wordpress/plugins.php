<?php
defined( 'ABSPATH' ) or exit;
function authorship_add_go_pro_link( $links )
{
    $more_links = array
    (
        'settings' => '<a href="' . admin_url( 'admin.php?page=' . MOLONGUI_AUTHORSHIP_NAME ) . '">' . __( "Settings" ) . '</a>',
        'docs'     => '<a href="' . 'https://www.molongui.com/docs/' . '" target="blank" >' . __( "Docs", 'molongui-authorship' ) . '</a>'
    );

    if ( apply_filters( 'authorship/action_links/go_pro', true ) )
    {
        $more_links['gopro'] = '<a href="' . MOLONGUI_AUTHORSHIP_WEB . '/" target="blank" style="font-weight:bold;color:orange">' . __( "Go Pro", 'molongui-authorship' ) . '</a>';
    }

    return array_merge( $more_links, $links );
}
add_filter( 'plugin_action_links_'.MOLONGUI_AUTHORSHIP_BASENAME, 'authorship_add_go_pro_link' );