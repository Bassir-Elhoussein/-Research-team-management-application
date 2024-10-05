<?php

if ( !empty( $options['author_box_social_show'] ) )
{
	$networks = authorship_get_social_networks( 'active' );
    if ( $author['show_social_web'] )   $networks['web']   = array ( 'name' => 'Website', 'url' => 'https://www.example.com/', 'color' => '#333', 'premium' => false, );
	if ( $author['show_social_mail'] )  $networks['mail']  = array ( 'name' => 'E-mail',  'url' => 'your_name@example.com',    'color' => '#333', 'premium' => false );
	if ( $author['show_social_phone'] ) $networks['phone'] = array ( 'name' => 'Phone',   'url' => '123456789',                'color' => '#333', 'premium' => false, );
	$continue = false;
	foreach ( $networks as $id => $network )
	{
		if ( !empty( $author[$id] ) )
		{
			$continue = true;
			break; // There is at least one social network to show, no need to keep looking.
		}
	}
	if ( !$continue ) return;
	if ( isset( $options['author_box_social_style'] ) )
	{
		$ico_style = $options['author_box_social_style'];
		if ( $ico_style == 'default' ) $ico_style = '';
	}
	$nofollow = $options['add_nofollow'] ? 'rel="nofollow"' : '' ;
    $target = !empty( $options['author_box_social_target'] ) ? '_blank' : '_self' ;
	echo '<div class="m-a-box-item m-a-box-social '.( ( isset( $options['author_box_profile_layout'] ) and !in_array( $options['author_box_profile_layout'], array( 'layout-7', 'layout-8' ) ) and isset( $options['author_box_profile_valign'] ) and !empty( $options['author_box_profile_valign'] ) and $options['author_box_profile_valign'] != 'center' ) ? 'molongui-align-self-'.$options['author_box_profile_valign'] : '' ).'">';
        foreach ( $networks as $id => $network )
        {
            $url = $author[$id];

            if ( !empty( $url ) )
            {
	            if ( $id == 'mail' )
	            {
                    $mail = sanitize_email( $url );
		            if ( !empty( $options['encode_email'] ) ) $url = molongui_ascii_encode( 'mailto:'.$mail );
		            else $url = 'mailto:'.$mail;
	            }
	            elseif ( $id == 'phone' )
	            {
		            $phone = $url;
		            if ( !empty( $options['encode_phone'] ) ) $url = molongui_ascii_encode( 'tel:'.$phone );
		            else $url = 'tel:'.$phone;
	            }
	            else
                {
                    $url = set_url_scheme( esc_url( $url ) );
                }
				?>
					<div class="m-a-box-social-icon m-a-list-social-icon">
						<a class="m-icon-container m-ico-<?php echo $id; ?> m-ico-<?php echo $ico_style; ?>" <?php echo $nofollow; ?> href="<?php echo $url; ?>" target="<?php echo $target; ?>" <?php echo ( $add_microdata ? 'itemprop="sameAs"' : '' ); ?> aria-label="<?php printf( __( "View %s's %s profile", 'molongui-authorship' ), $author['name'], ucfirst( $id ) ); ?>">
							<i class="m-a-icon-<?php echo $id; ?>"></i>
						</a>
					</div>
				<?php
            }
        }
    echo '</div>';
}