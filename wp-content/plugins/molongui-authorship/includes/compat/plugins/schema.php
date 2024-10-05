<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'schema_wp_author', function( $author )
{
    global $post;
    if ( !is_multiauthor_post( $post->ID ) ) return $author;
    $post_authors = get_post_authors( $post->ID );
    $authors = array();
    foreach ( $post_authors as $post_author )
    {
        $author_class = new \Molongui\Authorship\Includes\Author( $post_author->id, $post_author->type );
        $url_enable = schema_wp_get_option( 'author_url_enable' );
        $url 		= ( $url_enable == true ) ? esc_url( $author_class->get_url() ) : '';

        $author = array
        (
            '@type'	=> 'Person',
            'name'	=> $author_class->get_name(),
            'url'	=> $url
        );

        if ( $description = $author_class->get_bio() )
        {
            $author['description'] = strip_tags( $description );
        }
        $gravatar_enable = schema_wp_get_option( 'gravatar_image_enable' );

        if ( $gravatar_enable == true )
        {
            $image_size	= apply_filters( 'schema_wp_get_author_array_img_size', 96 );

            $image_url	= $author_class->get_avatar( $image_size, 'url' );

            if ( $image_url )
            {
                $author['image'] = array
                (
                    '@type'		=> 'ImageObject',
                    'url' 		=> $image_url,
                    'height' 	=> $image_size,
                    'width' 	=> $image_size
                );
            }
        }
        $website 	= esc_attr( stripslashes( $author_class->get_meta( 'web' ) ) );
        $facebook 	= esc_attr( stripslashes( $author_class->get_meta( 'facebook' ) ) );
        $twitter 	= esc_attr( stripslashes( $author_class->get_meta( 'twitter' ) ) );
        $instagram 	= esc_attr( stripslashes( $author_class->get_meta( 'instagram' ) ) );
        $youtube 	= esc_attr( stripslashes( $author_class->get_meta( 'youtube' ) ) );
        $linkedin 	= esc_attr( stripslashes( $author_class->get_meta( 'linkedin' ) ) );
        $myspace 	= esc_attr( stripslashes( $author_class->get_meta( 'myspace' ) ) );
        $pinterest 	= esc_attr( stripslashes( $author_class->get_meta( 'pinterest' ) ) );
        $soundcloud = esc_attr( stripslashes( $author_class->get_meta( 'soundcloud' ) ) );
        $tumblr 	= esc_attr( stripslashes( $author_class->get_meta( 'tumblr' ) ) );
        $github 	= esc_attr( stripslashes( $author_class->get_meta( 'github' ) ) );
        if ( isset( $twitter ) && $twitter != '' ) $twitter = 'https://twitter.com/' . $twitter;

        $sameAs_links = array( $website, $facebook, $twitter, $instagram, $youtube, $linkedin, $myspace, $pinterest, $soundcloud, $tumblr, $github );

        $social = array();
        foreach ( $sameAs_links as $sameAs_link )
        {
            if ( $sameAs_link != '' ) $social[] = $sameAs_link;
        }

        if ( !empty( $social ) )
        {
            $author["sameAs"] = $social;
        }

        $authors[] = $author;
    }
    return $authors;
});