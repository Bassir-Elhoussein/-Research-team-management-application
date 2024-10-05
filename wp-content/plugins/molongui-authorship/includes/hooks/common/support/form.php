<?php
defined( 'ABSPATH' ) or exit;
function authorship_send_mail()
{
    if ( !is_admin() and !isset( $_POST['form'] ) and $_POST['type'] == 'ticket' )
    {
        echo 'error';
        wp_die();
    }
    check_ajax_referer( 'molongui-support-nonce', 'security', true );
    switch( $_POST['type'] )
    {
        case 'ticket':
            $params = array();
            parse_str( $_POST['form'], $params );
            $subject = sprintf( __( "Support Ticket %s: %s", 'molongui-authorship' ), sanitize_text_field( $params['ticket-id'] ), sanitize_text_field( $params['your-subject'] ) );
            $message = esc_html( sanitize_textarea_field( $params['your-message'] ) );
            $headers = array
            (
                'From: '         . $params['your-name'] . ' <' . $params['your-email'] . '>',
                'Reply-To: '     . $params['your-name'] . ' <' . $params['your-email'] . '>',
                'Content-Type: ' . 'text/html; charset=UTF-8',
            );
            $message .= '<br><br>---<br><br>';
            $message .= '<small>'.sprintf( __( "This support ticket was sent using the form on the Support Page (%s)", 'molongui-authorship' ), $_POST['domain'] ).'</small>';
            $message .= '<br><br><hr><br><br>';

            $user = array( 'name' => $params['your-name'], 'mail' => $params['your-email'] );

        break;

        case 'report':
            $current_user = wp_get_current_user();
            $subject = sprintf( __( "Support Report for %s", 'molongui-authorship' ), sanitize_text_field( $_POST['domain'] ) );
            $message = '';
            $headers = array
            (
                'From: ' . $current_user->display_name . ' <' . 'noreply@' . sanitize_text_field( $_POST['domain'] ) . '>',
                'Reply-To: ' . $current_user->display_name . ' <' . $current_user->user_email . '>',
                'Content-Type: ' . 'text/html; charset=UTF-8',
            );

            $user = array( 'name' => $current_user->user_firstname, 'mail' => $current_user->user_email );

        break;
    }
    if ( apply_filters( 'molongui/support/add_debug_data', true ) )
    {
        $message .= authorship_get_mail_appendix();
    }
    $sent = wp_mail( 'support@molongui.com', $subject, $message, $headers );
    if ( $sent and !empty( $user ) ) authorship_autorespond( $user );
    echo( $sent ? 'sent' : 'error' );
    wp_die();
}
add_action( 'wp_ajax_molongui_send_mail', 'authorship_send_mail' );