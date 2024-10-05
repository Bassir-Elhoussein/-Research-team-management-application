<?php
defined( 'ABSPATH' ) or exit;
function authorship_post_clear_object_cache()
{
    authorship_clear_cache( 'posts' );
}