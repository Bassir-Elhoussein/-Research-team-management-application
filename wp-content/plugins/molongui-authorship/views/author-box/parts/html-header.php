<?php
$header_html_tag = ( !empty( $options['author_box_header_tag'] ) ? $options['author_box_header_tag'] : 'h3' );
?>

<!-- Author Box Header -->
<div class="m-a-box-item m-a-box-header m-a-box-headline">
    <<?php echo $header_html_tag; ?>>
        <?php if ( !empty( $options['author_box_header_url'] ) ) : ?><a class="m-a-box-header-url" href="<?php echo esc_url( $options['author_box_header_url'] ); ?>"><?php endif; ?>
        <span class="m-a-box-header-title m-a-box-string-headline">
            <?php echo apply_filters( 'authorship/box/header', ( $options['author_box_header_title'] ? $options['author_box_header_title'] : __( "About the author", 'molongui-authorship' ) ), $author ); ?>
        </span>
        <?php if ( !empty( $options['author_box_header_url'] ) ) : ?></a><?php endif; ?>
    </<?php echo $header_html_tag; ?>>
</div>