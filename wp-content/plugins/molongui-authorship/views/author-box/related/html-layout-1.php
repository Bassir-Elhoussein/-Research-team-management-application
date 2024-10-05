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
            <div class="m-a-box-related-entry-title">
                <i class="m-a-icon-doc"></i>
                <a class="molongui-remove-underline" href="<?php echo get_permalink( $related->ID ); ?>" <?php echo ( $add_microdata ? 'itemprop="url"' : '' ); ?>>
                    <span <?php echo ( $add_microdata ? 'itemprop="headline"' : '' ); ?>><?php echo $related->post_title; ?></span>
                </a>
            </div>
        </div>
    </li>
    <?php
}