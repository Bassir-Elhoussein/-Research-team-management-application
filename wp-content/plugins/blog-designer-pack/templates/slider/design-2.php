<?php
/**
 * Slider Design 2
 * 
 * @package Blog Designer Pack
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="bdp-post-slides">
	<div class="bdp-medium-7 bdp-columns">
		<div class="bdp-post-image-bg" style="background-image: url(<?php echo esc_url( $feat_image ); ?>);"></div>
	</div>
	<div class="bdp-medium-5 bdp-columns">
		<div class="bdp-post-overlay">
			<?php if( $showCategory == "true" ) { ?>
			<div class="bdp-post-categories"><?php echo wp_kses_post( $cate_name ); ?></div>
			<?php } ?>

			<h2 class="bdp-post-title">
				<a href="<?php echo esc_url( $post_link ); ?>"><?php the_title(); ?></a>
			</h2>

			<?php if( $showDate == "true" || $showAuthor == 'true' || $show_comments =="true" ) { ?>
				<div class="bdp-post-meta">
					<?php if( $showAuthor == 'true' ) { ?>
					<span class="bdp-post-meta-innr bdp-user-img"><?php the_author(); ?></span>
					<?php }

					echo ( $showAuthor == 'true' && $showDate == 'true' ) ? '<span class="bdpp-post-meta-sep">/</span>' : '';

					if( $showDate == "true" ) { ?>
					<span class="bdp-post-meta-innr bdp-time"> <?php echo get_the_date(); ?> </span>
					<?php }

					echo ( $showAuthor == 'true' && $showDate == 'true' && $show_comments == 'true' && ! empty( $comments ) ) ? '<span class="bdpp-post-meta-sep">/</span>' : '';

					if( ! empty( $comments ) && $show_comments == 'true' ) { ?>
					<span class="bdp-post-meta-innr bdp-post-comments">
						<a href="<?php the_permalink(); ?>#comments"><?php echo esc_html( $comments.' '.$reply ); ?></a>
					</span>
					<?php } ?>
				</div>
			<?php }

			if( $showContent == "true" ) { ?>
			<div class="bdp-post-content">
				<div class="bdp-post-short-content"><?php echo bdp_get_post_excerpt( $post->ID, get_the_content(), $words_limit); ?></div>				
				<?php if( $showreadmore == 'true' ) { ?>
				<a href="<?php echo esc_url( $post_link ); ?>" class="bdp-readmorebtn"><?php esc_html_e('Read More', 'blog-designer-pack'); ?></a>
				<?php } ?>
			</div>
			<?php }

			if( ! empty( $tags ) && $show_tags == 'true' ) { ?>
			<div class="bdp-post-tags"><?php echo wp_kses_post( $tags ); ?></div>
			<?php } ?>
		</div>
	</div>
</div>