<?php
// Ajax call functions

if (!defined('ABSPATH')) exit;

// Search - Ajax call for auto suggestions from stats table in DB
add_action( 'wp_ajax_dpk_muc_umeta_search', 'dpk_muc_umeta_search' );
add_action( 'wp_ajax_nopriv_dpk_muc_umeta_search', 'dpk_muc_umeta_search' );
if (!function_exists('dpk_muc_umeta_search')) {
	function dpk_muc_umeta_search() {
		if ( !isset( $_POST) || empty($_POST) ) {
			header( 'HTTP/1.1 400 Empty POST Values' );
			echo 'Could not verify POST values';
			exit;
		}
		$q = sanitize_text_field( $_POST['q'] );
		global $wpdb;
		$_meta = $wpdb->get_results("SELECT DISTINCT meta_key FROM ".$wpdb->base_prefix."usermeta WHERE meta_key LIKE '%".$q."%' ORDER BY CHAR_LENGTH(meta_key) LIMIT 10", ARRAY_A);
		foreach($_meta as $k=>$v) {
			$user_meta_key = esc_html($v['meta_key']);
			$part1 = substr($user_meta_key,0, strlen($q));
			$part2 = substr($user_meta_key,strlen($part1));
			$res = $part1 . '<strong>' . $part2 . '</strong>';
			echo "<li>".$res."</li>";
		}
		exit;
	}
}
