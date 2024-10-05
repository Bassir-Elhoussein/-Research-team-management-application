<?php

namespace Molongui\Authorship\Includes;
defined( 'ABSPATH' ) or exit;
class Highlights
{
	public function highlights_plugin()
	{
        $is_pro = authorship_has_pro();
		ob_start();
		?>
		<p><?php  _e( "Molongui Authorship is probably the most complete suite on all about authors and authorship. Check below some of its awesome features:", 'molongui-authorship' ); ?></p>
        <ul>
			<li class="molongui-notice-icon-check"><?php printf( __( "%sCo-authors%s. Assign multiple authors to your posts. Just locate the 'Authors' module on the right of your edit post screen and start adding authors.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
			<li class="molongui-notice-icon-check"><?php printf( __( "%sGuest authors%s. Assign guest authors to your posts without creating WordPress user accounts. Open the 'Authors' menu and define your guest authors.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php printf( __( "%sAuthor box%s. Display the author profile in all your posts or just on those you define. Customize the box to your likings to best fit your site with %slive-preview%s!.", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Pro only', 'molongui-authorship' ); ?></span><?php printf( __( "%sShortcodes%s. Display author boxes on your sidebar or anywhere you like, a list of authors and contributors of your blog and a list of posts by author.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
		    <?php if ( !$is_pro ) : ?>
                <li class="molongui-notice-icon-check molongui-notice-only-premium"><span><?php _e( "Pro only", 'molongui-authorship' ); ?></span><?php printf( __( "%sPro features%s. More layouts, more styles, more customization settings, guest author archive pages and Premium support.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
		    <?php endif; ?>
        </ul>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "Thanks for choosing %s plugin!", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
                    'href'   => authorship_editor_url(),
                    'target' => '_self',
                    'class'  => 'molongui-notice-button-green',
                    'icon'   => '',
                    'label'  => __( "Editor", 'molongui-authorship' ),
                    'hidden' => false,
				),
				'settings' => array
				(
					'href'   => 'admin.php?page=' . MOLONGUI_AUTHORSHIP_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( "Settings", 'molongui-authorship' ),
					'hidden' => false,
				),
				'documentation' => array
				(
					'href'   => 'https://www.molongui.com/docs/molongui-authorship/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( "Documentation", 'molongui-authorship' ),
					'hidden' => false,
				),
				'premium' => array
				(
					'href'   => MOLONGUI_AUTHORSHIP_WEB,
					'target' => '_blank',
					'class'  => 'molongui-notice-button-orange',
					'icon'   => '',
					'label'  => __( "Go Pro", 'molongui-authorship' ),
					'hidden' => $is_pro,
				),
			),
		);
		return $content;
	}
	public function highlights_release_210()
	{
        $is_pro = authorship_has_pro();
		ob_start();
		?>
			<p><?php _e( "We have listened to you and we have focused this update on improving the customization of the author box.", 'molongui-authorship' ); ?></p>
			<ul>
				<li class="molongui-notice-icon-check"><?php printf( __( "The author box can be now customized with %slive preview%s from the WordPress Customizer.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
				<li class="molongui-notice-icon-check"><?php _e( "Settings page reorganization for clarity's sake.", 'molongui-authorship' ); ?></li>
				<?php if ( !$is_pro ) : ?>
                    <li class="molongui-notice-icon-check"><?php printf( __( "Added the options to display the author box %sonly on posts%s or %sonly on pages%s.", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
				    <li class="molongui-notice-icon-check"><?php _e( "Author name color is now customizable.", 'molongui-authorship' ); ?></li>
                <?php endif; ?>
                <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php printf( __( "Added setting to %sdisable user archive pages%s and redirect pages to any given destination.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
                <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php printf( __( "Added setting to %schange author archives template and the author base%s.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
                <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php _e( "Added more customization settings: text style, border style...", 'molongui-authorship' ); ?></li>
            </ul>
            <p class="molongui-notice-message-important"><?php _e( "Some styling modifications have been introduced. Please, make sure the author box looks like you want and customize it required.", 'molongui-authorship' ); ?></p>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
                    'href'   => authorship_get_customizer(),
                    'target' => '_self',
                    'class'  => 'molongui-notice-button-green',
                    'icon'   => '',
                    'label'  => __( 'Open new customizer', 'molongui-authorship' ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', 'molongui-authorship' ),
				),
				'changelog' => array
				(
					'href'   => 'https://www.molongui.com/molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', 'molongui-authorship' ),
				),
			),
		);
		return $content;
	}
	public function highlights_release_300()
	{
        $is_pro = authorship_has_pro();
		ob_start();
		?>
        <p><?php _e( "Huge update with endless author box layout combinations!", 'molongui-authorship' ); ?></p>
        <ul>
            <li class="molongui-notice-icon-check"><?php printf( __( "Added a %snew box layout%s that displays author profile above related posts in the same author box.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added settings to customize box tabs.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check"><?php printf( __( "Added a %snew template to display related entries%s into the author box.", 'molongui-authorship' ), '<strong>', '</strong>', '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added 'Hide on these post categories' setting to control on which categories the author box won't be displayed by default.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php printf( __( "Added 7 %snew profile templates%s.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php printf( __( "Added a %sthird new template%s to display related entries into the author box.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check <?php echo ( !$is_pro ? 'molongui-notice-only-premium' : '' ); ?>"><span><?php _e( 'Premium only', 'molongui-authorship' ); ?></span><?php printf( __( "New %s'Contributors' page%s featuring a list of all authors in your site.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
        </ul>
        <p class="molongui-notice-message-important"><?php _e( "Some styling modifications have been introduced. Please, make sure the author box looks like you want and customize it if required.", 'molongui-authorship' ); ?></p>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
                    'href'   => authorship_get_customizer(),
                    'target' => '_self',
                    'class'  => 'molongui-notice-button-green',
                    'icon'   => '',
                    'label'  => __( 'Open customizer', 'molongui-authorship' ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', 'molongui-authorship' ),
				),
				'changelog' => array
				(
					'href'   => 'https://www.molongui.com/molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', 'molongui-authorship' ),
				),
			),
		);
		return $content;
	}
	public function highlights_release_320()
	{
		ob_start();
		?>
        <p><?php _e( "Huge update with endless author box layout combinations!", 'molongui-authorship' ); ?></p>
        <ul>
            <li class="molongui-notice-icon-check"><?php printf( __( "Now you can edit 'first name', 'last name' and 'display name' %sseparately%s for your guest authors. Just like you do for regular users.", 'molongui-authorship' ), '<strong>', '</strong>' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added setting to align name and author meta within the author box.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Added 'Entries' column to 'Users list' to display number of entries for each user.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Removed 'e-mail' and 'website' from social networks list. Both can be optionally displayed as an icon.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Now it is possible to show phone number as another icon within the social icons section.", 'molongui-authorship' ); ?></li>
            <li class="molongui-notice-icon-check"><?php _e( "Restyled 'Support' page. Now you can open support tickets and chat with Molongui without leaving the Dashboard :)", 'molongui-authorship' ); ?></li>
        </ul>
		<?php
		$message = ob_get_clean();
		$content = array
		(
			'image'   => '',
			'title'   => sprintf( __( "What's new on %s %s", 'molongui-authorship' ), MOLONGUI_AUTHORSHIP_TITLE, MOLONGUI_AUTHORSHIP_VERSION ),
			'message' => $message,
			'buttons' => array
			(
				'customizer' => array
				(
                    'href'   => authorship_get_customizer(),
                    'target' => '_self',
                    'class'  => 'molongui-notice-button-green',
                    'icon'   => '',
                    'label'  => __( 'Open customizer', 'molongui-authorship' ),
				),
				'settings' => array
				(
					'href'   => 'admin.php?page='.MOLONGUI_AUTHORSHIP_NAME,
					'target' => '_self',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'Settings page', 'molongui-authorship' ),
				),
				'changelog' => array
				(
					'href'   => 'https://www.molongui.com/molongui-authorship-changelog/',
					'target' => '_blank',
					'class'  => '',
					'icon'   => '',
					'label'  => __( 'See changelog', 'molongui-authorship' ),
				),
			),
		);
		return $content;
	}

} // End of the class.