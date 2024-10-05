<?php

foreach( $author['posts'] as $related )
{
    ?>
    <li>
        <div class="m-a-box-related-entry" <?php echo ( $add_microdata ? 'itemscope itemtype="http://schema.org/CreativeWork"' : '' ); ?>>

            <div class="molongui-display-none" <?php echo ( $add_microdata ? 'itemprop="author" itemscope itemtype="http://schema.org/Person"' : '' ); ?>>
                <div <?php echo ( $add_microdata ? 'itemprop="name"' : '' ); ?>><?php echo $author['name']; ?></div>
                <div <?php echo ( $add_microdata ? 'itemprop="url"' : '' ); ?>><?php echo esc_url( $author['archive'] ); ?></div>
            </div>

            <!-- Related entry thumb -->
            <div class="m-a-box-related-entry-thumb">
                <?php if ( has_post_thumbnail( $related->ID ) ) : ?>
                    <a href="<?php echo get_permalink( $related->ID ); ?>">
                        <?php echo get_the_post_thumbnail( $related->ID, 'thumbnail', $attr = ( $add_microdata ? array( 'itemprop' => 'thumbnailUrl' ) : array() ) ) ?>
                    </a>
                <?php else : ?>
                    <img src="<?php echo MOLONGUI_AUTHORSHIP_URL.'assets/img/related_placeholder.svg'; ?>" width="<?php echo get_option( 'thumbnail_size_w' ).'px'; ?>">
                <?php endif; ?>
            </div>

            <div class="m-a-box-related-entry-data">
                <!-- Related entry date -->
                <div class="m-a-box-related-entry-date" <?php echo ( $add_microdata ? 'itemprop="datePublished"' : '' ); ?>>
                    <?php echo get_the_date( '', $related->ID ); ?>
                </div>

                <!-- Related entry title -->
                <div class="m-a-box-related-entry-title">
                    <a class="molongui-remove-underline" href="<?php echo get_permalink( $related->ID ); ?>" <?php echo ( $add_microdata ? 'itemprop="url"' : '' ); ?>>
                        <span <?php echo ( $add_microdata ? 'itemprop="headline"' : '' ); ?>><?php echo $related->post_title; ?></span>
                    </a>
                </div>
            </div>

        </div>
    </li>
    <?php
}