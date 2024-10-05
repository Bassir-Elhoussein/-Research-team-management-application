<?php
//about theme info
add_action( 'admin_menu', 'skt_ayurveda_abouttheme' );
function skt_ayurveda_abouttheme() {    	
	add_theme_page( esc_html__('About Theme', 'skt-ayurveda'), esc_html__('About Theme', 'skt-ayurveda'), 'edit_theme_options', 'skt_ayurveda_guide', 'skt_ayurveda_mostrar_guide');   
} 
//guidline for about theme
function skt_ayurveda_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
?>
<div class="wrapper-info">
	<div class="col-left">
   		   <div class="col-left-area">
			  <?php esc_html_e('Theme Information', 'skt-ayurveda'); ?>
		   </div>
          <p><?php esc_html_e('Ayurvedic Medicine WordPress theme for ayurveda, herbal, body clinic, skin, spa treatment, health, wellness, naturopathy, homeopathy, healing, spa, massage, reiki, yoga, meditative practice, exercise, stretching, discipline, physical, spiritual, relaxing help, green, nature, indian medicinal herbs etc. It is responsive, user friendly, works well with Gutenberg editor and WooCommerce compatible and SEO plugins compatible. Flexible, scalable and easy to use.','skt-ayurveda'); ?></p>
          <a href="<?php echo esc_url(SKT_AYURRVEDA_SKTTHEMES_PRO_THEME_URL); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/free-vs-pro.png" alt="" /></a>
	</div><!-- .col-left -->
	<div class="col-right">			
			<div class="centerbold">
				<hr />
				<a href="<?php echo esc_url(SKT_AYURRVEDA_SKTTHEMES_LIVE_DEMO); ?>" target="_blank"><?php esc_html_e('Live Demo', 'skt-ayurveda'); ?></a> | 
				<a href="<?php echo esc_url(SKT_AYURRVEDA_SKTTHEMES_PRO_THEME_URL); ?>"><?php esc_html_e('Buy Pro', 'skt-ayurveda'); ?></a> | 
				<a href="<?php echo esc_url(SKT_AYURRVEDA_SKTTHEMES_THEME_DOC); ?>" target="_blank"><?php esc_html_e('Documentation', 'skt-ayurveda'); ?></a>
                <div class="space5"></div>
				<hr />                
                <a href="<?php echo esc_url(SKT_AYURRVEDA_SKTTHEMES_THEMES); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/sktskill.jpg" alt="" /></a>
			</div>		
	</div><!-- .col-right -->
</div><!-- .wrapper-info -->
<?php } ?>