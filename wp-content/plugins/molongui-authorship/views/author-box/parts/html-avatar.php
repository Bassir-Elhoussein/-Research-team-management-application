<?php
?>

<?php if ( $author['img'] and !empty( $options['author_box_avatar_show'] ) ) : ?>
	<div class="m-a-box-item m-a-box-avatar" data-source="<?php echo $options['author_box_avatar_source']; ?>">
		<?php
            if ( empty( $options['author_box_avatar_link'] ) or 'none' === $options['author_box_avatar_link']
                 or
                 ( 'custom' === $options['author_box_avatar_link'] and empty( $author['web'] ) )
                 or
                 ( 'archive' === $options['author_box_avatar_link']
                    and
                    ( ( 'guest' === $author['type'] and !authorship_has_pro() )
                        or
                      ( 'guest' === $author['type'] and !$options['guest_pages'] )
                        or
                      ( 'user' === $author['type'] and !$options['user_archive_enabled'] )
                    )
                 )
            ){
	            ?>
                <span>
                    <?php echo $author['img']; ?>
                </span>
                <?php
            }
            else
            {
                $url = 'archive' === $options['author_box_avatar_link'] ? $author['archive'] : $author['web'];
                ?>
                <a class="m-a-box-avatar-url" href="<?php echo esc_url( $url ); ?>">
                    <?php echo $author['img']; ?>
                </a>
                <?php
            }
        ?>
	</div>
<?php endif; ?>