<?php
defined( 'ABSPATH' ) or exit;
if ( !function_exists( 'get_user_by' ) )
{
    function get_user_by( $field, $value )
    {
        global $current_user;

        $userdata = WP_User::get_data_by( $field, $value );

        if ( ! $userdata )
        {
            /*!
             * PRIVATE FILTER.
             *
             * For internal use only. Not intended to be used by plugin or theme developers.
             * Future compatibility NOT guaranteed.
             *
             * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be
             * used only by Molongui. It may be edited, renamed or removed from future releases without prior notice or
             * deprecation phase.
             *
             * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk
             *  andknowing that it could cause code failure.
             */
            $user = apply_filters( '_authorship/no_userdata', false, $field, $value );
            if ( $user ) return $user;

            return false;
        }

        $user = new WP_User;
        $user->init( $userdata );

        /*!
         * PRIVATE FILTER.
         *
         * For internal use only. Not intended to be used by plugin or theme developers.
         * Future compatibility NOT guaranteed.
         *
         * Please do not rely on this filter for your custom code to work. As a private filter it is meant to be used
         * only by Molongui. It may be edited, renamed or removed from future releases without prior notice or
         * deprecation phase.
         *
         * If you choose to ignore this notice and use this filter, please note that you do so at on your own risk and
         * knowing that it could cause code failure.
         */
        $user = apply_filters( '_authorship/get_user_by', $user, $field, $value );

        return $user;
    }
}