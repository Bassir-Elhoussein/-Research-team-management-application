<?php
defined( 'ABSPATH' ) or exit;
$config = array
(
    'brand' => 'Molongui',
    'name'  => 'Authorship',
    'id'    => 'authorship',
    'title' => 'Authorship',
    'tag'   => 'Authorship',
    'web'   => 'https://www.molongui.com/authorship/',
    'demo'  => 'https://demos.molongui.com/test-drive-molongui-authorship-pro/',
    'db'  => 21,
    'cpt' => 'guest_author',
    'has_pro' => true,
    'min_pro' => '1.3.0', //'1.5.0',
    'recommended_pro' => '1.5.0',
);
$plugin_id = strtolower( str_replace( ' ', '-', $config['brand'] . ' ' . $config['name'] ) );
$plugin_px = str_replace( '-', '_', $plugin_id );
defined( 'MOLONGUI_AUTHORSHIP_DIR'  ) or define( 'MOLONGUI_AUTHORSHIP_DIR' , dirname( __DIR__ ) . '/' );
defined( 'MOLONGUI_AUTHORSHIP_FILE' ) or define( 'MOLONGUI_AUTHORSHIP_FILE', dirname( __DIR__ ) . '/' . $plugin_id . '.php' );
$constants = array
(
    'NAME'   => $plugin_id,
    'PREFIX' => $plugin_px,
    'ID'     => $config['id'],
    'TITLE'  => $config['brand'] . ' ' . $config['title'],
    'TAG'    => $config['tag'],
    'WEB'    => $config['web'],
    'DEMO'   => $config['demo'],
    'FOLDER'    => basename( dirname( MOLONGUI_AUTHORSHIP_FILE ) ),
    'URL'       => plugin_dir_url( MOLONGUI_AUTHORSHIP_FILE ),
    'BASENAME'  => plugin_basename( MOLONGUI_AUTHORSHIP_FILE ),
    'NAMESPACE' => str_replace( ' ', '', ucwords( strtr( ucwords( strtolower( $config['name'] ) ), array( '-' => ' ', '_' => ' ' ) ) ) ),
    'DB'                => $config['db'],
    'CPT'               => $config['cpt'],
    'DB_VERSION'        => $plugin_px.'_db_version',
    'INSTALLATION'      => $plugin_px.'_install',
    'NOTICES'           => $plugin_px.'_notices',
    'HAS_PRO' => $config['has_pro'],
    'MIN_PRO' => $config['min_pro'],
    'RECOMMENDED_PRO' => $config['recommended_pro'],
    'MAIN_SETTINGS'     => $plugin_px.'_options',
    'BOX_SETTINGS'      => $plugin_px.'_options',
    'BYLINE_SETTINGS'   => $plugin_px.'_options',
    'ARCHIVES_SETTINGS' => $plugin_px.'_options',
    'SEO_SETTINGS'      => $plugin_px.'_options',
    'COMPAT_SETTINGS'   => $plugin_px.'_options',
);
if ( isset( $dont_load_constants ) and $dont_load_constants )
{
    unset( $dont_load_constants );
    return;
}
$constant_prefix = strtoupper( $plugin_px.'_' );
foreach ( $constants as $const => $value )
{
    $const = $constant_prefix . $const;
    if ( !defined( $const ) ) define( $const, $value );
}