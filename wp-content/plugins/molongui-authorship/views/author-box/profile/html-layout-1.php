<?php
?>

<div class="m-a-box-content-top">

	<?php if ( $options['author_box_layout'] == 'stacked' ) include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-profile-title.php'; ?>

</div><!-- End of .m-a-box-content-top -->

<div class="m-a-box-content-middle">

    <!-- Author picture -->
    <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-avatar.php'; ?>

    <!-- Author social -->
    <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-socialmedia.php'; ?>

    <!-- Author data -->
    <div class="m-a-box-item m-a-box-data">

        <!-- Author name -->
        <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-name.php'; ?>

        <!-- Author metadata -->
        <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-meta.php'; ?>

        <!-- Author bio -->
        <?php include MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/parts/html-bio.php'; ?>

        <?php if ( $options['author_box_layout'] == 'slim' and !empty( $options['author_box_related_show'] ) ) : ?>

            <!-- Author related posts -->
            <div class="m-a-box-related" data-related-layout="<?php echo $options['author_box_related_layout']; ?>">
                <div class="m-a-box-item m-a-box-related-entries" <?php echo ( $options['author_box_layout'] == 'slim' ? 'style="display: none;"' : '' ); ?>>

                    <ul>
                        <?php
                        if ( !empty( $author['posts'] ) )
                        {
                            if ( file_exists( $file = MOLONGUI_AUTHORSHIP_DIR . 'views/author-box/related/html-'.$options['author_box_related_layout'].'.php' ) )
                            {
                                ob_start();
                                include $file;
                                $related_layout = ob_get_clean();
                            }
                            else
                            {
                                $related_layout = '';
                            }
                            echo apply_filters( 'authorship/author_box/related_layout', $related_layout, $options, $author );
                        }
                        else
                        {
                            echo ' <span class="m-a-box-string-no-related-posts">'. ( $options['author_box_related_none'] ? $options['author_box_related_none'] : __( "This author does not have any more posts.", 'molongui-authorship' ) ).'</span>';
                        }
                        ?>
                    </ul>

                </div><!-- End of .m-a-box-related-entries -->
            </div><!-- End of .m-a-box-related -->

        <?php endif; ?>

    </div><!-- End of .m-a-box-data -->

</div><!-- End of .m-a-box-content-middle -->

<div class="m-a-box-content-bottom"></div><!-- End of .m-a-box-content-bottom -->