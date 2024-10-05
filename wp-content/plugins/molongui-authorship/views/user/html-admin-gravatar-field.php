<?php
defined( 'ABSPATH' ) or exit;

$user_id = $user->ID;
$profileuser = get_user_to_edit( $user_id );

?>

<?php echo get_avatar( $user_id, '150' ); ?>
<p class="description">
    <?php
    if ( IS_PROFILE_PAGE ) {
        $description = sprintf(
            __( '<a href="%s">You can change your profile picture on Gravatar</a>.' ),
            __( 'https://en.gravatar.com/' )
        );
    } else {
        $description = '';
    }
    echo apply_filters( 'user_profile_picture_description', $description, $profileuser );
    ?>
</p>