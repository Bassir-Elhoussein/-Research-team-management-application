<?php
$name_tag = ( !empty( $options['author_box_name_tag'] ) ? $options['author_box_name_tag'] : 'h5' );

?>

<div class="m-a-box-name m-a-box-title">
	<<?php echo $name_tag; ?> <?php echo ( $add_microdata ? 'itemprop="name"' : '' ); ?>>
        <?php
            if ( empty( $options['author_box_name_link'] ) or 'none' === $options['author_box_name_link']
                 or
                 ( 'custom' === $options['author_box_name_link'] and empty( $author['web'] ) )
                 or
                 ( 'archive' === $options['author_box_name_link']
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
			        <?php echo $author['name']; ?>
                </span>
	            <?php
            }
            else
            {
                $url = 'archive' === $options['author_box_name_link'] ? $author['archive'] : $author['web'];
                ?>
                <a class="m-a-box-name-url <?php echo ( $options['author_box_name_underline'] == 'remove' ? 'molongui-remove-underline' : '' ); ?>" href="<?php echo esc_url( $url ); ?>" <?php echo ( $add_microdata ? 'itemprop="url"' : '' ); ?>>
		            <?php echo $author['name']; ?>
                </a>
	            <?php
            }
        ?>
	</<?php echo $name_tag; ?>>
</div>