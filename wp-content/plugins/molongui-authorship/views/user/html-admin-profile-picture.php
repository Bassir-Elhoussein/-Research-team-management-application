<?php
defined( 'ABSPATH' ) or exit;

$user_profile = authorship_is_feature_enabled( 'user_profile' );
$local_avatar = authorship_is_feature_enabled( 'avatar' );

?>

<?php if ( $local_avatar ) : ?>

    <div id="molongui-local-avatar">

        <h3><?php echo ( $user_profile ? __( 'Local Avatar', 'molongui-authorship' ) : __( 'Profile Picture', 'molongui-authorship' ) ); ?></h3>

        <?php if ( $user_profile ) : ?>
            <ul class="m-tip"><li><?php _e( "Want to use a custom local image instead of Gravatar's? Profile picture is displayed in the author box, comments and other relevant sections. WordPress uses Gravatar service to display user's profile picture which is based on the email address. If you do not have a Gravatar account then your profile picture will be replaced with a default image placeholder which is called 'Mystery Man'. Molongui Authorship allows you to use any photo you upload here as your avatar. If none is uploaded, your Gravatar avatar or Default Avatar will be displayed.", 'molongui-authorship' ); ?></li></ul>
        <?php endif; ?>

        <table class="form-table" role="presentation">
            <tbody>

            <?php if ( get_option( 'show_avatars' ) and !$user_profile ) : ?>
                <!-- Gravatar -->
                <tr class="user-m-gravatar-wrap">
                    <th><label><?php _e( 'Gravatar', 'molongui-authorship' ); ?></label></th>
                    <td>
                        <?php include 'html-admin-gravatar-field.php'; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <!-- Local avatar -->
            <tr class="user-m-avatar-wrap">
                <th><label for="molongui_author_image"><?php echo ( $user_profile ? __( 'Profile Picture', 'molongui-authorship' ) : __( 'Local Avatar', 'molongui-authorship' ) ); ?></label></th>
                <td>
                    <?php include 'html-admin-avatar-field.php'; ?>
                </td>
            </tr>

            </tbody>
        </table>

    </div>

<?php endif; ?>