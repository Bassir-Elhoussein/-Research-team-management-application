<?php
defined( 'ABSPATH' ) or exit;
function authorship_uncanny_automator_dont_filter_user_data( $data, $args )
{
    list( $filter, $user ) = $data;
    $dbt = $args['dbt'];

    $class = 'Uncanny_Automator\Automator_Input_Parser';

    if ( $i = array_search( $class, array_column( $args['dbt'], 'class' ) ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
};