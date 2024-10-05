<?php
defined( 'ABSPATH' ) or exit;
$img_id       = get_the_author_meta( 'molongui_author_image_id',   $user->ID );
$img_url      = get_the_author_meta( 'molongui_author_image_url',  $user->ID );
$img_edit_url = get_the_author_meta( 'molongui_author_image_edit', $user->ID );
if ( !empty( $user->ID ) and authorship_is_feature_enabled( 'user_profile' ) )
{
    $gravatar_url = get_avatar_url( $user->ID, array( 'size' => '150' ) );
    $gravatar_img = get_avatar( $user->ID, '150', '', '', array( 'class' => 'molongui_current_img', 'extra_attr' => 'id="m-default-gravatar"' ) );
}
else
{
    $gravatar_url = 'http://placehold.jp/cccccc/666666/150x150.png?text=Upload%20custom%20image';
    $gravatar_img = '<img class="molongui_current_img placeholder" src="'.$gravatar_url.'">';
}

if ( current_user_can( 'upload_files' ) ) :
    wp_enqueue_media();
    authorship_enqueue_edit_avatar_scripts();
    authorship_enqueue_media_uploader_styles();
    ?>

    <div id="molongui_author_image">

        <!-- Outputs the image after save -->
        <span class="current_img">
            <?php if ( !empty( $img_url ) ) : ?>
                <img class="molongui_current_img" src="<?php echo esc_url( $img_url ); ?>">
                <span class="edit_options uploaded">
                    <a class="remove_img"><span><?php _e( "Remove", 'molongui-authorship' ); ?></span></a>
                    <a class="edit_img" href="<?php echo $img_edit_url; ?>" target="_blank"><span><?php _e( "Edit", 'molongui-authorship' ); ?></span></a>
                </span>
            <?php else : ?>
                <?php echo $gravatar_img; ?>
            <?php endif; ?>
        </span>

        <!-- Hold the value here of WPMU image -->
        <div class="molongui_image_upload">
            <input type="hidden" class="hidden" name="molongui_author_image_id"   id="molongui_author_image_id"   value="<?php echo $img_id; ?>" />
            <input type="hidden" class="hidden" name="molongui_author_image_url"  id="molongui_author_image_url"  value="<?php echo esc_url_raw( $img_url ); ?>" />
            <input type="hidden" class="hidden" name="molongui_author_image_edit" id="molongui_author_image_edit" value="<?php echo $img_edit_url; ?>" />
            <input type='button' class="molongui_wpmu_button button-primary"      id="molongui_author_image_btn"  value="<?php echo ( $img_url ? __( "Change Avatar", 'molongui-authorship' ) : __( "Upload Avatar", 'molongui-authorship' ) ); ?>" />
            <br />
        </div>

    </div>

<?php else : ?>

    <?php if ( $img_url ): ?>
        <img src="<?php echo esc_url( $img_url ); ?>" class="molongui_current_img">
    <?php else : ?>
        <?php echo $gravatar_img; ?>
    <?php endif; ?>
    <div>
        <p class="description"><?php _e( "You do not have permission to upload a custom profile picture. Please, contact the administrator of this site.", 'molongui-authorship' ); ?></p>
    </div>

<?php endif; ?>