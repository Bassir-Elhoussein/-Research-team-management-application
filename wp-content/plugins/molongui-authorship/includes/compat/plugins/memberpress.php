<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    if ( $key = array_search( 'get_user_by', array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == 'MeprUtils' ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;
    if ( array_intersect( array( 'MeprUser', 'MeprLoginCtrl', 'MeprAppCtrl' ), array_column( $args['dbt'], 'class' ) ) ) $filter = false;
    return array( $filter, $user );
}, 10, 2 );
if ( is_plugin_active( 'memberpress-corporate/main.php' ) )
{
    add_filter( '_authorship/filter/get_user_by', function( $data, $args )
    {
        list( $filter, $user ) = $data;
        if ( $key = array_search( 'current_user_has_access', array_column( $args['dbt'], 'function' ) ) and
             isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == 'MPCA_Corporate_Account' ) )
        {
            $filter = false;
        }
        return array( $filter, $user );
    }, 10, 2 );
}