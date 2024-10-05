<?php
defined( 'ABSPATH' ) or exit;
function authorship_cache_status()
{
    return authorship_is_feature_enabled( 'cache' );
}
add_filter( 'authorship/cache', 'authorship_cache_status' );