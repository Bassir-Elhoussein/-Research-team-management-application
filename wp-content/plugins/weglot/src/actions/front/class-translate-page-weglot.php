<?php

namespace WeglotWP\Actions\Front;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Exception;
use Weglot\Client\Api\LanguageEntry;
use WeglotWP\Helpers\Helper_API;
use WeglotWP\Helpers\Helper_Is_Admin;
use WeglotWP\Models\Hooks_Interface_Weglot;
use Weglot\Client\Api\Enum\BotType;
use Weglot\Util\Server;
use WeglotWP\Services\Href_Lang_Service_Weglot;
use WeglotWP\Services\Language_Service_Weglot;
use WeglotWP\Services\Option_Service_Weglot;
use WeglotWP\Services\Redirect_Service_Weglot;
use WeglotWP\Services\Request_Url_Service_Weglot;
use WeglotWP\Services\Translate_Service_Weglot;


/**
 * Translate page
 *
 * @since 2.0
 */
class Translate_Page_Weglot implements Hooks_Interface_Weglot {
	/**
	 * @var Option_Service_Weglot
	 */
	private $option_services;

	/**
	 * @var LanguageEntry
	 */
	private $current_language;
	/**
	 * @var Request_Url_Service_Weglot
	 */
	private $request_url_services;
	/**
	 * @var Language_Service_Weglot
	 */
	private $language_services;
	/**
	 * @var Redirect_Service_Weglot
	 */
	private $redirect_services;
	/**
	 * @var Translate_Service_Weglot
	 */
	private $translate_services;
	/**
	 * @var Href_Lang_Service_Weglot
	 */
	private $href_lang_services;

	/**
	 * @throws Exception
	 * @since 2.0
	 */
	public function __construct() {
		$this->option_services      = weglot_get_service( 'Option_Service_Weglot' );
		$this->request_url_services = weglot_get_service( 'Request_Url_Service_Weglot' );
		$this->redirect_services    = weglot_get_service( 'Redirect_Service_Weglot' );
		$this->translate_services   = weglot_get_service( 'Translate_Service_Weglot' );
		$this->href_lang_services   = weglot_get_service( 'Href_Lang_Service_Weglot' );
		$this->language_services    = weglot_get_service( 'Language_Service_Weglot' );
	}

	/**
	 * @return void
	 * @throws Exception
	 * @see Hooks_Interface_Weglot
	 *
	 * @since 2.0
	 */
	public function hooks() {

		$referer = wp_parse_url( wp_get_referer() );
		if ( wp_is_json_request() && isset( $referer['query'] ) ) {
			if ( strpos( $referer['query'], 'action=edit' ) !== false ) {
				return;
			}
		}

		if ( Helper_Is_Admin::is_wp_admin() || 'wp-login.php' === $GLOBALS['pagenow'] ) {
			return;
		}

		if ( is_admin() && ( ! wp_doing_ajax() || $this->no_translate_action_ajax() ) ) {
			return;
		}

		if ( ! $this->option_services->get_option( 'api_key' ) ) {
			return;
		}

		$this->prepare_request_uri();
		$this->prepare_rtl_language();
		add_action( 'init', array( $this, 'weglot_init' ), 11 );
		add_action( 'wp_head', array( $this, 'weglot_href_lang' ) );
		add_action( 'wp_head', array( $this, 'weglot_custom_settings' ) );
	}

	/**
	 * @return boolean
	 * @since 2.1.1
	 *
	 */
	protected function no_translate_action_ajax() {
		$action_ajax_no_translate = apply_filters(
			'weglot_ajax_no_translate',
			array(
				'add-menu-item', // WP Core.
				'query-attachments', // WP Core.
				'avia_ajax_switch_menu_walker', // Enfold theme.
				'query-themes', // WP Core.
				'wpestate_ajax_check_booking_valability_internal', // WP Estate theme.
				'wpestate_ajax_add_booking', // WP Estate theme.
				'wpestate_ajax_check_booking_valability', // WP Estate theme.
				'mailster_get_template', // Mailster Pro.
				'mmp_map_settings', // MMP Map.
				'elementor_ajax', // Elementor since 2.5.
				'ct_get_svg_icon_sets', // Oxygen.
				'oxy_render_nav_menu', // Oxygen.
				'hotel_booking_ajax_add_to_cart', // Hotel booking plugin.
				'imagify_get_admin_bar_profile', // Imagify Admin Bar.
				'el_check_user_login', // Event list plugin.
				'wcfm_ajax_controller', // wcfm_ajax_controller.
				'jet_ajax_search', // jet_ajax_search.
				'woofc_update_qty', // jet_ajax_search.
			)
		);

		if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['action'] ) && in_array( $_POST['action'], $action_ajax_no_translate ) ) { //phpcs:ignore
			return true;
		}

		if ( 'GET' === $_SERVER['REQUEST_METHOD'] && isset( $_GET['action'] ) && in_array( $_GET['action'], $action_ajax_no_translate ) ) { //phpcs:ignore
			return true;
		}

		return false;
	}

	/**
	 * @return void
	 * @throws Exception
	 * @version 2.3.0
	 * @see init
	 * @since 2.0
	 */
	public function weglot_init() {
		do_action( 'weglot_init_start' );

		// We refresh the current language as now the wp_doing_ajax is valid.
		$this->current_language = $this->request_url_services->get_current_language();

		if ( ! $this->option_services->get_option( 'original_language' ) ) {
			return;
		}

		if ( $this->request_url_services->is_allowed_private() ) {
			if ( ! isset( $_COOKIE['weglot_allow_private'] ) ) {
				setcookie( "weglot_allow_private", true, time() + 86400 * 2, '/' ); //phpcs:ignore
			}
		}

		$active_translation = apply_filters( 'weglot_active_translation_before_process', true );

		if ( ! $active_translation ) {
			return;
		}

		$this->check_need_to_redirect();

		do_action( 'weglot_init_before_translate_page' );

		if ( ! function_exists( 'curl_version' ) ) {
			return;
		}

		$active_translation = apply_filters( 'weglot_active_translation_before_treat_page', true );

		if ( ! $active_translation ) {
			return;
		}

		$file = apply_filters( 'weglot_debug_file', WEGLOT_DIR . '/content.html' );


		if ( defined( 'WEGLOT_DEBUG' ) && WEGLOT_DEBUG && file_exists( $file ) ) {
			$this->translate_services->set_original_language( $this->language_services->get_original_language() );
			$this->translate_services->set_current_language( $this->request_url_services->get_current_language() );
			echo $this->translate_services->weglot_treat_page( file_get_contents( $file ) ); //phpcs:ignore
			die;
		} else {
			$this->translate_services->weglot_translate();
		}
	}

	/**
	 * @return void
	 * @throws Exception
	 * @since 2.0
	 */
	public function check_need_to_redirect() {

		$only_home     = apply_filters( 'weglot_autoredirect_only_home', false );
		$skip_redirect = apply_filters( 'weglot_autoredirect_skip', false );
		if (
			! $skip_redirect &&
			! wp_doing_ajax() && // no ajax.
			! is_rest() &&
			! Helper_Is_Admin::is_wp_admin() &&
			$this->language_services->get_original_language() === $this->request_url_services->get_current_language() &&
			! isset( $_COOKIE['WG_CHOOSE_ORIGINAL'] ) && // No force redirect.
			Server::detectBot( $_SERVER ) === BotType::HUMAN && //phpcs:ignore
			! Server::detectBotVe( $_SERVER ) && //phpcs:ignore
			( ! $only_home || ( $only_home && $this->request_url_services->get_weglot_url()->getPath() === '/' ) ) && // front_page.
			$this->option_services->get_option( 'auto_redirect' ) // have option redirect.
		) {
			$this->redirect_services->auto_redirect();
		}
	}

	/**
	 * @return void
	 * @version 2.1.0
	 * @since 2.0
	 */
	public function prepare_request_uri() {
		$original_language = $this->language_services->get_original_language();

		// We initialize the URL here for the first time, the current language might be wrong in case of ajax with the language in a referer because at this time wp_doing_ajax is always false.
		$this->current_language = $this->request_url_services->get_current_language();

		// If the URL has a GET parameter wg-choose-original we need to set / unset the cookie and redirect.
		$this->redirect_services->verify_no_redirect();

		if ( $original_language === $this->current_language ) {
			return;
		}

		// If we are not in the original language, but the URL is not available in the current language, and the option redirect is true,  we redirect to original.
		$redirect = $this->request_url_services->get_weglot_url()->getExcludeOption( $this->current_language, 'exclusion_behavior' );

		if ( $redirect ) {
			if ( ! $this->request_url_services->get_weglot_url()->getForLanguage( $this->current_language ) && ! strpos( $this->request_url_services->get_weglot_url()->getForLanguage( $this->language_services->get_original_language() ), 'wp-comments-post.php' ) !== false ) {
				wp_redirect( $this->request_url_services->get_weglot_url()->getForLanguage( $this->language_services->get_original_language() ), 301 );
				exit;
			}
		}

		// If we receive a not translated slug we return a 301. For example if we have /fr/products but should have /fr/produits we should redirect to /fr/produits.
		if ( $this->request_url_services->get_weglot_url()->getRedirect() !== null ) {
			$redirect_to = $this->request_url_services->get_weglot_url()->getRedirect();
			wp_redirect( '/' . $this->current_language->getExternalCode() . $redirect_to, 301 );
			exit;
		}

		$_SERVER['REQUEST_URI'] = $this->request_url_services->get_weglot_url()->getPathPrefix() .
		                          $this->request_url_services->get_weglot_url()->getPathAndQuery();
	}

	/**
	 * @return void
	 * @since 2.0
	 *
	 */
	public function prepare_rtl_language() {
		if ( $this->current_language->isRtl() ) {
			$GLOBALS['text_direction'] = 'rtl'; // phpcs:ignore
		} else {
			$GLOBALS['text_direction'] = 'ltr'; // phpcs:ignore
		}
	}

	/**
	 * @return void
	 * @since 2.0
	 * @version 2.3.0
	 * @see wp_head
	 */
	public function weglot_href_lang() {
		$remove_google_translate = apply_filters( 'weglot_remove_google_translate', true );
		if ( $remove_google_translate ) {
			$original_language = $this->language_services->get_original_language();
			$current_language  = $this->request_url_services->get_current_language( false );
			if ( $current_language !== $original_language ) {
				echo "\n" . '<meta name="google" content="notranslate"/>';
			}
		}

		$add_href_lang = apply_filters( 'weglot_add_hreflang', true );
		if ( $add_href_lang ) {
			echo $this->href_lang_services->generate_href_lang_tags(); //phpcs:ignore
		}
	}

	/**
	 * @return void
	 * @since 2.0
	 * @version 2.3.0
	 * @see wp_head
	 */
	public function weglot_custom_settings() {
		$settings = get_transient( 'weglot_cache_cdn', false );
		if ( empty( $settings ) ) {
			$settings = $this->option_services->get_options();
		}
		unset( $settings['deleted_at'] );
		unset( $settings['api_key'] );
		unset( $settings['technology_id'] );
		unset( $settings['category'] );
		unset( $settings['versions'] );
		unset( $settings['page_views_enabled'] );
		unset( $settings['external_enabled'] );
		unset( $settings['media_enabled'] );
		unset( $settings['translate_amp'] );
		unset( $settings['translate_search'] );
		unset( $settings['translate_email'] );
		unset( $settings['button_style'] );
		unset( $settings['translation_engine'] );
		unset( $settings['auto_switch_fallback'] );
		unset( $settings['auto_switch'] );
		unset( $settings['language_from_custom_name'] );
		unset( $settings['language_from_custom_flag'] );
		unset( $settings['dynamics'] );
		unset( $settings['technology_name'] );
		$settings['current_language'] = $this->current_language->getInternalCode();
		$settings['switcher_links']   = array();
		foreach ( $this->language_services->get_original_and_destination_languages( $this->request_url_services->is_allowed_private() ) as $language ) {
			$link_button = $this->request_url_services->get_weglot_url()->getForLanguage( $language, true );
			if ( $link_button ) {
				$settings['switcher_links'][ $language->getInternalCode() ] = $link_button;
			}
		}
		$settings['original_path'] = $this->request_url_services->get_weglot_url()->getPath();
		echo '<script type="application/json" id="weglot-data">';
		echo wp_json_encode( $settings );
		echo '</script>';
		if ( isset( $settings['custom_settings']['switchers'] ) && ! empty( $settings['custom_settings']['switchers'] ) ) {
			echo wp_kses($this->add_custom_templatefile( $settings['custom_settings']['switchers'] ), array(
				'script'      => array(
					'id'  => array(),
					'src' => array(),
				)
			));
		}
	}

	/**
	 * @param array $switchers array of switchers.
	 *
	 * @return string
	 * @since 2.3.0
	 */
	public function add_custom_templatefile( $switchers ) {
		$template_file = array();
		$file_to_load  = '';
		foreach ( $switchers as $switcher ) {
			if ( isset( $switcher['template'] ) ) {
				if ( ! in_array( $switcher['template'], $template_file ) ) {
					$template_file[] = $switcher['template'];
				}
			}
		}
		if ( ! empty( $template_file ) ) {
			$template_file = array_merge( $template_file );
			foreach ( $template_file as $filename ) {
				$filename_esc = esc_attr( 'weglot-switcher-' . $filename['name'] );
				if ( isset( $filename['hash'] ) && ! empty( $filename['hash'] ) ) {
					$file_to_load .= '<script id="' . $filename_esc . '" src="' . esc_url(Helper_API::get_tpl_switchers_url() . $filename['name'] . '.' . $filename['hash']) . '.min.js"></script>';
				} else {
					$file_to_load .= '<script id="' . $filename_esc . '" src="' . esc_url(Helper_API::get_tpl_switchers_url() . $filename['name'] ) . '.min.js"></script>';
				}
			}
		}

		return $file_to_load;
	}
}
