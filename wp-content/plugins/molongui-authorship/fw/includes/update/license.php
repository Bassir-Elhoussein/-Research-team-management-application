<?php

namespace Molongui\Authorship\Fw\Includes\Update;

\defined( 'ABSPATH' ) or exit;
if ( !\class_exists( 'Molongui\Authorship\Fw\Includes\Update\License' ) )
{
    class License
    {
        public function remove( $force = false )
        {
            return true;
        }
    }
}
if ( !defined( 'MOLONGUI_AUTHORSHIP_PRO_DASHED_ID' ) ) define( 'MOLONGUI_AUTHORSHIP_PRO_DASHED_ID', 'molongui-authorship-pro' );