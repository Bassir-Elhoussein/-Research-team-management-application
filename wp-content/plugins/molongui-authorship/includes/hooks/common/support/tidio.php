<?php
defined( 'ABSPATH' ) or exit;
function authorship_enqueue_tidio()
{
    if ( apply_filters( 'molongui/support/load_tidio', true ) )
    {
        echo '<script src="//code.tidio.co/foioudbu7xqepgvwseufnvhcz6wkp7am.js" async></script>';
    }
}
add_action( 'admin_footer-molongui_page_molongui-support', 'authorship_enqueue_tidio' );