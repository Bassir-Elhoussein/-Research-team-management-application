<?php
defined( 'ABSPATH' ) or exit;
function authorship_user_clear_object_cache()
{
    authorship_clear_cache( 'users' );
    authorship_clear_cache( 'posts' );
}
add_action( 'user_register' , 'authorship_user_clear_object_cache', 0 ); // Fires immediately after a new user is registered.
add_action( 'profile_update', 'authorship_user_clear_object_cache', 0 ); // Fires immediately after an existing user is updated.
add_action( 'deleted_user'  , 'authorship_user_clear_object_cache', 0 ); // Fires immediately after a user is deleted from the database.