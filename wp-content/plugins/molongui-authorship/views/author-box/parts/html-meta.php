<?php
$nofollow = ( $options['add_nofollow'] ? 'rel="nofollow"' : '' );
$add_separator = false;

?>

<?php if ( !empty( $options['author_box_meta_show'] ) ) : ?>
<div class="m-a-box-item m-a-box-meta">

    <?php if ( $author['job'] ) : ?>
        <span <?php echo ( $add_microdata ? 'itemprop="jobTitle"' : '' ); ?>><?php echo $author['job']; ?></span>
        <?php $add_separator = true; ?>
    <?php endif; ?>

    <?php if ( $author['job'] and $author['company'] ) echo ' <span class="m-a-box-string-at">'.( $options['author_box_meta_at'] ? $options['author_box_meta_at'] : __( "at", 'molongui-authorship' ) ).'</span> '; ?>

    <?php if ( $author['company'] ) : ?>
        <span <?php echo ( $add_microdata ? 'itemprop="worksFor" itemscope itemtype="https://schema.org/Organization"' : '' ); ?>>
            <?php if ( $author['company_link'] ) echo '<a href="' . esc_url( $author['company_link'] ) . '" target="_blank" '.( $add_microdata ? 'itemprop="url"' : '' ). $nofollow . '>'; ?>
            <span <?php echo ( $add_microdata ? 'itemprop="name"' : '' ); ?>><?php echo $author['company']; ?></span>
            <?php if ( $author['company_link'] ) echo '</a>'; ?>
        </span>
        <?php $add_separator = true; ?>
    <?php endif; ?>

	<?php if ( $author['phone'] and $author['show_meta_phone'] ) : ?>
		<?php
            $phone_item = '<a href="tel:'.$author['phone'].'"'. ( $add_microdata ? ' itemprop="telephone"' : '' ) . ' content="'.$author['phone'].'" '.$nofollow.'>' . $author['phone'] . '</a>';
            $phone_item = apply_filters( 'authorship/box/meta/phone', $phone_item, $author['phone'], $add_microdata, $nofollow );
        ?>
		<?php if ( $add_separator ) echo ' '.'<span class="m-a-box-meta-divider">'.$options['author_box_meta_divider'].'</span>'.' '; ?>
        <?php echo $phone_item; ?>
        <?php $add_separator = true; ?>
	<?php endif; ?>

	<?php if ( $author['mail'] and $author['show_meta_mail'] ) : ?>
        <?php
            $email_item = '<a href="mailto:'.$author['mail'].'" target="_top"'. ( $add_microdata ? ' itemprop="email"' : '' ) . ' content="'.$author['mail'].'" '.$nofollow.'>' . $author['mail'] . '</a>';
            $email_item = apply_filters( 'authorship/box/meta/email', $email_item, $author['mail'], $add_microdata, $nofollow );
        ?>
        <?php if ( $add_separator ) echo ' '.'<span class="m-a-box-meta-divider">'.$options['author_box_meta_divider'].'</span>'.' '; ?>
        <?php echo $email_item; ?>
        <?php $add_separator = true; ?>
	<?php endif; ?>

	<?php if ( $author['web'] ) : ?>
        <?php if ( $add_separator ) echo ' '.'<span class="m-a-box-meta-divider">'.$options['author_box_meta_divider'].'</span>'.' '; ?>
		<a href="<?php echo esc_url( $author['web'] ); ?>" target="_blank"  <?php echo $nofollow; ?>><?php echo ' <span class="m-a-box-string-web">'.( $options['author_box_meta_web'] ? apply_filters( 'authorship/box/meta/web', $options['author_box_meta_web'], $author ) : __( "Website", 'molongui-authorship' ) ).'</span>'; ?></a>
        <?php $add_separator = true; ?>
	<?php endif; ?>

	<?php if ( $options['author_box_layout'] == 'slim' and $options['author_box_related_show'] and ( !empty( $author['posts'] ) or !empty( $options['author_box_related_show_empty'] ) ) ) : ?>
        <?php if ( $add_separator ) echo ' '.'<span class="m-a-box-meta-divider">'.$options['author_box_meta_divider'].'</span>'.' '; ?>
		<script type="text/javascript" language="JavaScript">
			if ( typeof window.ToggleAuthorshipData === 'undefined' )
			{
				function ToggleAuthorshipData(id, author)
				{
					let box_selector = '#mab-' + id;
                    let box = document.querySelector(box_selector);
                    if ( box.getAttribute('data-multiauthor') ) box_selector = '#mab-' + id + ' [data-author-ref="' + author + '"]';
                    let label = document.querySelector(box_selector + ' ' + '.m-a-box-data-toggle');
					label.innerHTML = ( label.text.trim() === "<?php echo ( $options['author_box_meta_posts'] ? apply_filters( 'authorship/box/meta/more', $options['author_box_meta_posts'], $author ) : __( "+ posts", 'molongui-authorship' ) ); ?>" ? " <span class=\"m-a-box-string-bio\"><?php echo ( $options['author_box_meta_bio'] ? apply_filters( 'authorship/box/meta/bio', $options['author_box_meta_bio'], $author ) : __( "Bio", 'molongui-authorship' ) ); ?></span>" : " <span class=\"m-a-box-string-more-posts\"><?php echo ( $options['author_box_meta_posts'] ? apply_filters( 'authorship/box/meta/more', $options['author_box_meta_posts'], $author ) : __( "+ posts", 'molongui-authorship' ) ); ?></span>" );
                    let bio     = document.querySelector(box_selector + ' ' + '.m-a-box-bio');
                    let related = document.querySelector(box_selector + ' ' + '.m-a-box-related-entries');

					if ( related.style.display === "none" )
					{
						related.style.display = "block";
						bio.style.display     = "none";
					}
					else
					{
						related.style.display = "none";
						bio.style.display     = "block";
					}
				}
			}
		</script>
		<a href="javascript:ToggleAuthorshipData(<?php echo $random_id; ?>, '<?php echo $author['type'].'-'.$author['id']; ?>')" class="m-a-box-data-toggle" <?php echo $nofollow; ?>><?php echo ' <span class="m-a-box-string-more-posts">'.( $options[ 'author_box_meta_posts' ] ? apply_filters( 'authorship/box/meta/more', $options['author_box_meta_posts'], $author ) : __( "+ posts", 'molongui-authorship' ) ).'</span> '; ?></a>
	<?php endif; ?>

</div><!-- End of .m-a-box-meta -->
<?php endif; ?>