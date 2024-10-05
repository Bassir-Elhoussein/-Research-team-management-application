<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'uwp_check_redirect_author_page', function()
{
    if ( is_guest_author() ) return false;
    return true;
});