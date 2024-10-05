<?php

use Molongui\Authorship\Includes\Author;
defined( 'ABSPATH' ) or exit;
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    $fn    = 'getCurrentUser';
    $class = 'WpdiscuzHelper';
    list( $filter, $user ) = $data;
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == $class ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );
add_filter( '_authorship/get_avatar_data/filter/author', function( $author, $id_or_email, $dbt )
{
    $fn    = 'renderFrontForm';
    $class = 'wpdFormAttr\Form';
    $file  = '/wpdiscuz/forms/wpDiscuzForm.php';
    if ( $i = array_search( $fn, array_column( $dbt, 'function' ) ) )
    {
        if ( isset( $dbt[$i]['class'] ) and $dbt[$i]['class'] == $class )
        {
            if ( is_int( $id_or_email ) )
            {
                if ( !is_object( $author->object ) ) $author->object = new WP_User();
                $author->object->ID = $id_or_email;
                $author->id         = $id_or_email;
                $author->type       = 'user';
            }
        }
    }
    return $author;
}, 10, 3 );
add_filter( 'wpdiscuz_comment_author', function( $authorName, $comment )
{
    return ( $comment->comment_author ? $comment->comment_author : __( 'Anonymous', 'wpdiscuz' ) );
}, 99, 2 );
add_filter( 'get_comment_author_url', function( $commentAuthorUrl, $comment_id, $comment )
{
    $email = $comment->comment_author_email;
    if ( !$email ) return $commentAuthorUrl;
    if ( $guest = molongui_get_author_by( '_molongui_guest_author_mail', $email, 'guest' ) )
    {
        $author = new Author( $guest->ID, 'guest' );
        $commentAuthorUrl = $author->get_url();
    }
    return $commentAuthorUrl;

}, 10, 3 );
add_filter( 'wpdiscuz_profile_url', function( $profileUrl, $user )
{
    return '';
}, 10, 2 );
add_filter( 'wpdiscuz_author_avatar_field', function( $authorAvatarField, $comment, $user, $profileUrl )
{
    return $comment->comment_author_email ? $comment->comment_author_email : $authorAvatarField;
}, 10, 4 );
add_filter( '_authorship/filter/get_user_by', function( $data, $args )
{
    $fn    = 'start_el';
    $class = 'WpdiscuzWalker';
    list( $filter, $user ) = $data;
    if ( $key = array_search( $fn, array_column( $args['dbt'], 'function' ) ) and
         isset( $args['dbt'][$key]['class'] ) and ( $args['dbt'][$key]['class'] == $class ) )
    {
        $filter = false;
    }
    return array( $filter, $user );
}, 10, 2 );