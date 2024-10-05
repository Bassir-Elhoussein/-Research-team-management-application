<?php
defined( 'ABSPATH' ) or exit;
function authorship_is_feature_enabled( $feature = null )
{
    if ( empty( $feature ) ) return false;
    $options = authorship_get_options();

    $features = array
    (
        'box'           => 'author_box',
        'multi'         => 'enable_multi_authors',
        'guest'         => 'guest_authors',
        'avatar'        => 'enable_local_avatars',
        'user_profile'  => 'enable_user_profiles',
        'author_search' => 'enable_search_by_author',
        'guest_search'  => 'enable_guests_in_search',
        'cache'         => 'enable_cache',
        'box_styles'    => 'enable_author_box_styles',
        'microdata'     => 'box_schema',
        'theme_compat'  => 'enable_theme_compat',
        'plugin_compat' => 'enable_plugin_compat',
        'author_in_api' => 'enable_authors_in_api',
        'guest_in_api'  => 'enable_guests_in_api',
    );

    return !empty( $options[$features[$feature]] );
}
function authorship_byline_takeover()
{
    return ( authorship_is_feature_enabled( 'guest' ) or authorship_is_feature_enabled( 'multi' ) );
}
function authorship_get_social_networks( $query = 'all', $networks = array() )
{
    $sn = array();
    if ( empty( $networks ) ) $networks = include MOLONGUI_AUTHORSHIP_DIR . 'config/social.php';
    if ( empty( $networks ) ) return $sn;
    if ( 'all' !== $query )
    {
        $options = authorship_get_options();
        if ( empty( $options ) or !isset( $options['social_networks'] ) ) return $sn;
        $config = explode( ",", $options['social_networks'] );
    }
    else
    {
        $config = array();
    }
    $mod = ( $query == 'all' ? 'true or ' : ( $query == 'disabled' ? '!' : '' ) );
    foreach ( $networks as $id => $network )
    {
        if ( $mod.in_array( $id, (array)$config ) )
        {
            $sn[$id]             = $network;
            $sn[$id]['id']       = $id;
            $sn[$id]['icon']     = 'm-a-icon-'.$id;
            $sn[$id]['label']    = $network['name'];
            $sn[$id]['disabled'] = authorship_has_pro() ? false : $network['premium'];
        }
    }
    $order = apply_filters( 'authorship/social_networks/order', array(), array_keys( $sn ) );
    $order = array_intersect( array_unique( $order ), array_keys( $networks ) );
    if ( empty( $order ) )
    {
        $sn = molongui_sort_array( $sn, 'ASC', 'name' );
    }
    else
    {
        foreach ( $order as $o )
        {
            $tmp[$sn[$o]['id']] = $sn[$o];
        }
        $sn = $tmp;
    }
    return $sn;
}
function authorship_clear_cache( $key = 'all' )
{
    $known = array( 'posts', 'users', 'guests' );
    if ( 'all' === $key )
    {
        foreach ( $known as $key )
        {
            molongui_cache_clear( $key );
        }
    }
    if ( !in_array( $key, $known ) ) return;
    molongui_cache_clear( $key );
}