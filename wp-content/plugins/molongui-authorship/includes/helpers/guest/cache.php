<?php
defined( 'ABSPATH' ) or exit;
function authorship_guest_clear_object_cache()
{
    authorship_clear_cache( 'guests' );
    authorship_clear_cache( 'posts'  );
}