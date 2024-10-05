<?php

namespace Molongui\Authorship\Includes;
\defined( 'ABSPATH' ) or exit;
class Deactivator
{
    public static function deactivate( $network_wide )
    {
	    if ( \function_exists('is_multisite') and \is_multisite() and $network_wide )
	    {
		    if ( !\is_super_admin() ) return;
		    foreach ( \molongui_get_sites() as $site_id )
		    {
			    \switch_to_blog( $site_id );
				self::deactivate_single_blog();
			    \restore_current_blog();
		    }
	    }
	    else
	    {
		    if ( !\current_user_can( 'activate_plugins' ) ) return;

			self::deactivate_single_blog();
	    }
    }
	private static function deactivate_single_blog()
	{
        \authorship_clear_cache();
		\delete_transient( MOLONGUI_AUTHORSHIP_NAME.'-activated' );
		\delete_transient( MOLONGUI_AUTHORSHIP_NAME.'-updated' );
	}

} // class