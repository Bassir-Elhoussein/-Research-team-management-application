<?php

namespace Molongui\Authorship\Includes;
\defined( 'ABSPATH' ) or exit;
class Activator
{
    public static function activate( $network_wide )
    {
	    if ( \function_exists('is_multisite') and \is_multisite() and $network_wide )
	    {
		    if ( !\is_super_admin() ) return;
		    foreach ( \molongui_get_sites() as $site_id )
		    {
			    \switch_to_blog( $site_id );
			    self::activate_single_blog();
			    \restore_current_blog();
		    }
        }
        else
        {
	        if ( !\current_user_can( 'activate_plugins' ) ) return;

	        self::activate_single_blog();
        }
	    \set_transient( MOLONGUI_AUTHORSHIP_NAME.'-activated', 1 );
    }
	private static function activate_single_blog()
	{
        \wp_cache_flush();
		$update_db = new \Molongui\Authorship\Includes\Libraries\Common\DB_Update( MOLONGUI_AUTHORSHIP_ID, MOLONGUI_AUTHORSHIP_DB, MOLONGUI_AUTHORSHIP_NAMESPACE );
		if ( $update_db->db_update_needed() ) $update_db->run_update();
		self::save_installation_data();
		self::add_default_options();
		self::run_background_tasks();
	}
	public static function activate_on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta )
	{
		if ( \is_plugin_active_for_network( MOLONGUI_AUTHORSHIP_BASENAME ) )
		{
			\switch_to_blog( $blog_id );
			self::activate_single_blog();
			\restore_current_blog();
		}
	}
	public static function save_installation_data()
	{
		if ( \get_option( MOLONGUI_AUTHORSHIP_INSTALLATION ) ) return;
		$installation = array
		(
			'timestamp' => \time(),
			'version'   => MOLONGUI_AUTHORSHIP_VERSION,
		);
		\add_option( MOLONGUI_AUTHORSHIP_INSTALLATION, $installation, null, false );
	}
    public static function add_default_options()
    {
        require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/helpers/options/defaults.php';
        require_once MOLONGUI_AUTHORSHIP_DIR . 'includes/helpers/common/options/options.php';

        \authorship_add_defaults();
    }
    public static function run_background_tasks()
    {
        if ( \apply_filters( 'authorship/check_wp_cron', true ) and ( \defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) ) return false;

        $options = \authorship_get_options();

        if ( $options['guest_authors'] or $options['enable_multi_authors'] )
        {
            \add_option( 'molongui_authorship_update_post_authors', true );
            \add_option( 'molongui_authorship_update_post_counters', true );
        }
    }

} // class