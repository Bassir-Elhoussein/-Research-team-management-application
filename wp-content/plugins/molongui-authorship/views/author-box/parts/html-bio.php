<?php
if ( 'none' === $options['author_box_bio_source'] ) return;

?>

<div class="m-a-box-bio" <?php echo ( $add_microdata ? 'itemprop="description"' : '' ); ?>>
    <?php
    $bio = apply_filters( 'authorship/box/bio', str_replace( array( "\n\r", "\r\n", "\n\n", "\r\r" ), "<br>", wpautop( $author['bio'] ) ), $author );

    echo $bio;
    if ( !empty( $options['extra_content'] ) )
    {
        echo $options['extra_content'];
    }
    ?>
</div>
