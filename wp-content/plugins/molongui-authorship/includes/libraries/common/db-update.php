<?php

namespace Molongui\Authorship\Includes\Libraries\Common;
defined( 'ABSPATH' ) or exit;
if ( !class_exists( 'Molongui\Authorship\Includes\Libraries\Common\DB_Update' ) )
{
	class DB_Update
	{
		protected $target_version;
		protected $plugin_db_key;
		protected $plugin_namespace;
		public function __construct( $target, $db_key, $namespace )
		{
			$this->target_version   = $target;
			$this->plugin_db_key    = $db_key;
			$this->plugin_namespace = $namespace;
		}
		public function db_update_needed()
		{
            $update = true;
			$current_version = get_option( $this->plugin_db_key );
			if ( empty( $current_version ) )
			{
				update_option( $this->plugin_db_key, $this->target_version );
                $update = false;
			}
			else
            {
                if ( ( $current_version > $this->target_version ) and ( 19 == (int) $this->target_version ) )
                {
                    $current_version = 18;
                    update_option( $this->plugin_db_key, 18 );
                }

                if ( $current_version >= $this->target_version ) $update = false;
            }

			return $update;
		}
		public function run_update()
		{
			$current_db_ver = get_option( $this->plugin_db_key, 1 );
			$target_db_ver = $this->target_version;
			while ( $current_db_ver < $target_db_ver )
			{
				$current_db_ver ++;
				$func = "db_update_{$current_db_ver}";
				if ( method_exists( '\Molongui\\'.$this->plugin_namespace.'\Includes\DB_Update', $func ) )
				{
					$class_name   = '\Molongui\\'.$this->plugin_namespace.'\Includes\DB_Update';
					$plugin_class = new $class_name();
					$plugin_class->{$func}();
				}
				update_option( $this->plugin_db_key, $current_db_ver );
			}
		}
	}
}