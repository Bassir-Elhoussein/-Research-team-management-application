<?php
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $dbt = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 10 );

    $fn    = 'get_post_layout';
    $class = 'PremiumAddons\Includes\Premium_Template_Tags';

    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) )
         and
         isset( $dbt[$i]['class'] ) and ( $dbt[$i]['class'] === $class ) )
    {
        $post_id = authorship_get_post_id();
        if ( !empty( $post_id ) )
        {
            $main_author = get_main_author( $post_id );
            if ( !empty( $main_author ) )
            {
                $author->id   = $main_author->id;
                $author->type = $main_author->type;
            }
        }
    }

    return $author;
}, 10, 3 );