<?php

/**
 * Helper methods for running the blocks functionalities.
 *
 * @package     wpum-blocks
 * @copyright   Copyright (c) 2020, WP User Manager
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1.0
 */
namespace WPUM\WPUserManagerBlocks;

use WPUM\ACP\Search\Helper\Sql\Comparison\Like;
use WPUM\WPUserManagerBlocks\Blocks\AccountPage;
use WPUM\WPUserManagerBlocks\Blocks\LikeButton;
use WPUM\WPUserManagerBlocks\Blocks\LoginForm;
use WPUM\WPUserManagerBlocks\Blocks\LoginLink;
use WPUM\WPUserManagerBlocks\Blocks\LogoutLink;
use WPUM\WPUserManagerBlocks\Blocks\PasswordRecoveryForm;
use WPUM\WPUserManagerBlocks\Blocks\PrivateContent;
use WPUM\WPUserManagerBlocks\Blocks\ProfileCard;
use WPUM\WPUserManagerBlocks\Blocks\ProfilePage;
use WPUM\WPUserManagerBlocks\Blocks\RecentlyRegisteredUsers;
use WPUM\WPUserManagerBlocks\Blocks\RegistrationForm;
use WPUM\WPUserManagerBlocks\Blocks\SocialLoginButtons;
use WPUM\WPUserManagerBlocks\Blocks\UserDirectory;
use WPUM\WPUserManagerBlocks\Blocks\GroupDirectory;
use WPUM\WPUserManagerBlocks\Blocks\PostForm;
// Exit if accessed directly.
\defined('ABSPATH') || exit;
/**
 * Helper methods for running the blocks.
 */
class Loader
{
    public function init()
    {
        if (!\function_exists('\\register_block_type')) {
            return;
        }
        add_action('init', array($this, 'register'));
    }
    /**
     * Register server side blocks for the editor.
     */
    public function register()
    {
        (new AccountPage())->register();
        (new LoginForm())->register();
        (new LoginLink())->register();
        (new LogoutLink())->register();
        (new PasswordRecoveryForm())->register();
        (new ProfileCard())->register();
        (new ProfilePage())->register();
        (new RecentlyRegisteredUsers())->register();
        (new RegistrationForm())->register();
        (new UserDirectory())->register();
        if (\class_exists('\\WPUM_Groups')) {
            (new GroupDirectory())->register();
        }
        if (\class_exists('\\WPUM_Frontend_Posting')) {
            (new PostForm())->register();
        }
        if (\class_exists('WPUM\\WPUM_Likes')) {
            (new LikeButton())->register();
        }
        if (\class_exists('WPUM\\WPUM_Social_Login')) {
            (new SocialLoginButtons())->register();
        }
        if (\class_exists('WPUM\\WPUM_Private_Content')) {
            (new PrivateContent())->register();
        }
    }
    /**
     * Get the js variables required for the block editor.
     *
     * @return array
     */
    public function get_js_vars()
    {
        return ['wpum_svg_logo' => WPUM_PLUGIN_URL . 'assets/images/logo.svg', 'ajax' => admin_url('admin-ajax.php'), 'blocks' => apply_filters('wpum_blocks', [])];
    }
}
