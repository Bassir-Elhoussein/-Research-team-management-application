<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_bypass_original_user_id_if', function( $default )
{
    $dbt   = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 10 );

    $i     = 7;
    $fn    = 'get_post_value';
    $class = 'Essential_Grid_Item_Skin';

    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class
    )
        return true;

    return $default;
});
add_filter( 'molongui_authorship_filter_the_author_display_name_post_id', function( $post_id, $post, $display_name )
{
    $dbt   = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 8 );
    $i     = 7;
    $fn    = 'get_post_value';
    $class = 'Essential_Grid_Item_Skin';
    if ( isset( $dbt[$i]['function'] ) and $dbt[$i]['function'] == $fn and
         isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class and
         isset( $dbt[$i]['object'] )
    ){
        $ReflectionProperty = new \ReflectionProperty( $class, "post" );
        $ReflectionProperty->setAccessible( true );
        $current_post       = $ReflectionProperty->getValue( $dbt[$i]['object'] );

        return (int) $current_post['ID'];
    }
    return $post_id;
}, 10, 3 );