<?php
/**
* Plugin Name: Manage User Columns
* Description: This plugin allows you to manage columns under the users page in the WordPress admin area.
* Version: 1.0.4
* Author: Media Jedi
* Author URI: https://www.mediajedi.com/
* License: GPL+2
* Text Domain: manage-user-columns
* Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined('ABSPATH') ) {
   exit;
}

add_action( 'plugins_loaded', 'dpk_muc_init' );
if (!function_exists('dpk_muc_init')) {
	function dpk_muc_init(){
		if ( is_admin() ){
			add_action( 'admin_enqueue_scripts', 'dpk_muc_styles_scripts' );
			add_filter( 'manage_users_columns', 'dpk_muc_modify_user_table' );
			add_filter( 'manage_users_custom_column', 'dpk_muc_modify_user_table_row', 10, 3 );
			add_filter( 'manage_users_sortable_columns', 'dpk_muc_allow_sorting' );
			add_action('load-users.php', 'dpk_muc_users_page_loaded');
			add_action( 'admin_footer', 'dpk_muc_users_page_html' );
			add_action( 'pre_get_users', 'dpk_muc_pre_sorting' );
		}
	}
}

if (!function_exists('dpk_muc_styles_scripts')) {
	function dpk_muc_styles_scripts(){
		wp_register_style( 'dpk-muc-style', plugins_url('style.css',__FILE__ ) );
		wp_enqueue_style( 'dpk-muc-style' );
		
		wp_enqueue_script(
			'dpk-muc-script',
			plugins_url('main.js',__FILE__ ),
			array('jquery')
		);
		wp_localize_script(
			'dpk-muc-script',
			'ajax_dpk_muc_obj',
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		);
	}
}

// Creates new columns for users screen
if (!function_exists('dpk_muc_modify_user_table')) {
	function dpk_muc_modify_user_table( $columns ) {
		$columns['reg'] = 'Registration Date'; // add registration_date by default
		$muc_cc = get_option('muc_custom_cols');
		if($muc_cc){
			foreach($muc_cc as $col_id=>$val){
				$columns[$col_id] = $val;
			}
		}
		$muc_defaults = get_option('muc_def_cols');
		if($muc_defaults){
			if($muc_defaults['username'] != 1){ unset( $columns['username'] ); }
			if($muc_defaults['name'] != 1){ unset( $columns['name'] ); }
			if($muc_defaults['email'] != 1){ unset( $columns['email'] ); }
			if($muc_defaults['role'] != 1){ unset( $columns['role'] ); }
			if($muc_defaults['posts'] != 1){ unset( $columns['posts'] ); }
			if($muc_defaults['reg'] != 1){ unset( $columns['reg'] ); }
		}
		return $columns;
	}
}
// Fill our new columns with user details
if (!function_exists('dpk_muc_modify_user_table_row')) {
	function dpk_muc_modify_user_table_row( $output, $column_id, $uid ) {
		$date_format = 'M j, Y H:i';
		$user_obj = get_userdata( $uid );
		if($column_id == 'reg') {
			return date( $date_format, strtotime( $user_obj->user_registered ) );
		}
		$muc_cc = get_option('muc_custom_cols');
		if($muc_cc){
			if(array_key_exists($column_id, $muc_cc)){
				$user_meta_val = get_user_meta($user_obj->ID, $column_id, true);
				if(!is_array($user_meta_val)){
					return $user_meta_val;
				} else{
					return http_build_query($user_meta_val,'',', ');
				}
			}
		}
		return $output;
	}
}
// Make our new columns sortable
if (!function_exists('dpk_muc_allow_sorting')) {
	function dpk_muc_allow_sorting( $columns ) {
		$muc_cc = get_option('muc_custom_cols');
		$muc_cc['reg'] = 'Registration Date';
		return wp_parse_args( $muc_cc, $columns );
	}
}

// Fixed bugs - sorting
if (!function_exists('dpk_muc_pre_sorting')) {
	function dpk_muc_pre_sorting( $query ) {
		$sorted_clm = $query->get( 'orderby' );
		$muc_actv_col = get_option('muc_custom_cols');
		$target_meta_key = '';
		if($muc_actv_col){
			foreach($muc_actv_col as $key => $val){
				if($sorted_clm == $val){
					$target_meta_key = $key;
				}
			}
		}
		
		// For custom column - sort by meta value
		if ($target_meta_key && 'login' != $sorted_clm && 'email' != $sorted_clm && 'Registration Date' != $sorted_clm ){
			$query->set( 'meta_key', $target_meta_key );
			$query->set( 'orderby', 'meta_value' );
		}
		
		// For registration date
		if ( 'Registration Date' == $sorted_clm ) {
			$query->set( 'orderby', 'registered' ); // meta_value_num for custom date type meta
		}
		
	}
}

// Save the submitted column details
if (!function_exists('dpk_muc_users_page_loaded')) {
	function dpk_muc_users_page_loaded() {
		if(isset($_POST['save_muc_def'])) {
			$muc_def_cols = ['username' => 0, 'name' => 0, 'email' => 0, 'role' => 0, 'posts' => 0, 'reg' => 0];
			
			if(isset($_POST['tgl_uname'])){
				$tgl_username = filter_var($_POST['tgl_uname'], FILTER_SANITIZE_STRING);
				if($tgl_username == 'on'){
					$muc_def_cols['username'] = 1;
				}
			}
			if(isset($_POST['tgl_name'])){
				$tgl_name = filter_var($_POST['tgl_name'], FILTER_SANITIZE_STRING);
				if($tgl_name == 'on'){
					$muc_def_cols['name'] = 1;
				}
			}
			if(isset($_POST['tgl_email'])){
				$tgl_email = filter_var($_POST['tgl_email'], FILTER_SANITIZE_STRING);
				if($tgl_email == 'on'){
					$muc_def_cols['email'] = 1;
				}
			}
			if(isset($_POST['tgl_role'])){
				$tgl_role = filter_var($_POST['tgl_role'], FILTER_SANITIZE_STRING);
				if($tgl_role == 'on'){
					$muc_def_cols['role'] = 1;
				}
			}
			if(isset($_POST['tgl_posts'])){
				$tgl_posts = filter_var($_POST['tgl_posts'], FILTER_SANITIZE_STRING);
				if($tgl_posts == 'on'){
					$muc_def_cols['posts'] = 1;
				}
			}
			if(isset($_POST['tgl_reg'])){
				$tgl_reg = filter_var($_POST['tgl_reg'], FILTER_SANITIZE_STRING);
				if($tgl_reg == 'on'){
					$muc_def_cols['reg'] = 1;
				}
			}
			update_option('muc_def_cols', $muc_def_cols);
		} else if(isset($_POST['save_muc_col']) && isset($_POST['col_name']) && isset($_POST['col_id'])) {
			if($_POST['col_name'] != '' && $_POST['col_id'] != ''){ // validate submitted column details
				$col_id = sanitize_text_field($_POST['col_id']); // sanitize submitted column_id
				$col_name = sanitize_text_field($_POST['col_name']); // sanitize submitted column_name
				$new_col = [$col_id => $col_name];
				$old_cols = get_option('muc_custom_cols');
				if($old_cols){
					$new_col = array_merge($old_cols, $new_col); // add new column details with old column details
				}
				if($new_col){ // update option only if we have the proper new column value
					update_option('muc_custom_cols', $new_col);
				}
			}
		} else if(isset($_POST['delt_col'])){
			if($_POST['delt_col'] != ''){ // check if col_id was sent properly
				$col_id = sanitize_text_field($_POST['delt_col']);
				$old_cols = get_option('muc_custom_cols');
				unset($old_cols[$col_id]);
				update_option('muc_custom_cols', $old_cols);
			}
		}
	}
}

// Including render and ajax functions
include ( plugin_dir_path(__FILE__ ) . 'render.php' );
include ( plugin_dir_path(__FILE__ ) . 'ajax-functions.php' );
