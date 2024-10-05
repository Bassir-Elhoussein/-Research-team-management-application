<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;

    $fn    = 'render';
    $class = array( 'Dynamic_News_Category_Posts_Single_Widget', 'Dynamic_News_Category_Posts_Boxed_Widget', 'Dynamic_News_Category_Posts_Columns_Widget', 'Dynamic_News_Category_Posts_Grid_Widget' );

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$i]['class'] ) and ( in_array( $args['dbt'][$i]['class'], $class ) ) )
    {
        $filter = false;
    }

    return array( $filter, $user );
}, 10, 2 );