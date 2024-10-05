<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    list( $filter, $user ) = $data;

    $fn    = 'widget';
    $class = 'ct_mission_news_post_list';

    if ( $i = array_search( $fn, array_column( $args['dbt'], 'function' ) )
         and
         isset( $args['dbt'][$i]['class'] ) and ( $args['dbt'][$i]['class'] === $class ) )
    {
        $filter = false;
    }

    return array( $filter, $user );
}, 10, 2 );