<?php

namespace Molongui\Authorship\Includes;
\defined( 'ABSPATH' ) or exit;
final class Plugin
{
    private static $_instance = null;
    public function __clone()
    {
        \_doing_it_wrong( __FUNCTION__, \esc_html__( "Cloning instances of this class is forbidden.", 'molongui-authorship' ), '4.4.0' );
    }
    public function __wakeup()
    {
        \_doing_it_wrong( __FUNCTION__, \esc_html__( "Unserializing instances of this class is forbidden.", 'molongui-authorship' ), '4.4.0' );
    }
    public static function instance()
    {
        if ( \is_null( self::$_instance ) )
        {
            self::$_instance = new self();
            \do_action( 'authorship/loaded' );
        }

        return self::$_instance;
    }
    function __construct()
    {
        require_once MOLONGUI_AUTHORSHIP_DIR . 'config/plugin.php';
        require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/autoloader.php';
        \register_activation_hook( MOLONGUI_AUTHORSHIP_FILE  , array( $this, 'activate'   ) );
        \register_deactivation_hook( MOLONGUI_AUTHORSHIP_FILE, array( $this, 'deactivate' ) );
        \add_action( 'wpmu_new_blog', array( $this, 'activate_on_new_blog' ), 10, 6 );
        \add_action( 'plugin_loaded' , array( $this, 'on_plugin_loaded'  ) );
        \add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ) );
        return true;
    }
    public function activate( $network_wide )
    {
        Activator::activate( $network_wide );
    }
    public function deactivate( $network_wide )
    {
        Deactivator::deactivate( $network_wide );
    }
    public function activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
    {
        Activator::activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta );
    }
    public function on_plugin_loaded( $plugin )
    {
        if ( MOLONGUI_AUTHORSHIP_FILE !== $plugin ) return;
        require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/overwrites.php';
    }
    public function on_plugins_loaded()
    {
        $this->update_db();

        if ( $this->is_compatible() )
        {
            $this->init();
        }
    }
    private function update_db()
    {
        $update_db = new \Molongui\Authorship\Includes\Libraries\Common\DB_Update( MOLONGUI_AUTHORSHIP_DB, MOLONGUI_AUTHORSHIP_DB_VERSION, MOLONGUI_AUTHORSHIP_NAMESPACE );
        if ( $update_db->db_update_needed() ) $update_db->run_update();
    }
    private function is_compatible()
    {

        return true;
    }
    public function init()
    {
        require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/load.php';
        \do_action( 'authorship/init' );
    }

} // class
Plugin::instance();