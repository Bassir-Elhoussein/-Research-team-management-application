<?php
defined( 'ABSPATH' ) or exit;
function authorship_filter_posts_by_author()
{
    global $post_type;
    $post_types = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', false );
    if ( in_array( $post_type, $post_types ) )
    {
        $params = array
        (
            'name'            => 'author',                                   // this is the "name" attribute for filter <select>
            'show_option_all' => __( "All authors", 'molongui-authorship' ), // label for all authors (display posts without filter)
        );
        if ( isset( $_GET['author'] ) ) $params['selected'] = $_GET['author'];
        wp_dropdown_users( $params );
    }
}
add_action( 'restrict_manage_posts', 'authorship_filter_posts_by_author' );
function authorship_filter_posts_by_guest()
{
    global $post_type;
    $post_types = molongui_supported_post_types( MOLONGUI_AUTHORSHIP_PREFIX, 'all', false );
    if ( in_array( $post_type, $post_types ) )
    {
        $guests = molongui_get_guests();

        if ( !empty( $guests ) )
        {
            $selected = isset( $_GET['guest'] ) ? $_GET['guest'] : 0;

            $output  = '<select id="filter-by-guest" name="guest">';
            $output .= '<option value="0">' . __( "All guest authors", 'molongui-authorship' ) . '</option>';
            foreach( $guests as $guest )
            {
                $output .= '<option value="' . $guest->ID . '" ' . ( $guest->ID == $selected ? 'selected' : '' ) . '>' . $guest->post_title . '</option>';
            }
            $output .= '</select>';

            echo $output;
        }
    }
}
add_action( 'restrict_manage_posts', 'authorship_filter_posts_by_guest' );