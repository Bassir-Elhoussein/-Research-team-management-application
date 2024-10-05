<?php
if ( empty( $options['author_box_related_title'] ) ) return;
?>

<div class="m-a-box-related-title">
    <?php echo apply_filters( 'authorship/box/related/title', $options['author_box_related_title'], $author ); ?>
</div>