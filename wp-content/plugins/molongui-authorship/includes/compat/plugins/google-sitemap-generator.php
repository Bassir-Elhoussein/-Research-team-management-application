<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'authorship/filter_author_link', function( $default, $args )
{
    if ( isset( $args['dbt'][4]['function'] ) and $args['dbt'][4]['function'] == 'BuildAuthors' and isset( $args['dbt'][4]['class'] ) and $args['dbt'][4]['class'] == 'GoogleSitemapGeneratorStandardBuilder' ) return true;
    return $default;
}, 10, 2 );