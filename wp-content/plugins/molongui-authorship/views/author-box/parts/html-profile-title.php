<?php
if ( empty( $options['author_box_profile_title'] ) ) return;
?>

<div class="m-a-box-profile-title">
    <?php echo apply_filters( 'authorship/box/profile/title', $options['author_box_profile_title'], $author ); ?>
</div>