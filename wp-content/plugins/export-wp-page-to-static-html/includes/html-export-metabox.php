<?php

abstract class pp_group_notif_Meta_Box {
 
 
    /**
     * Set up and add the meta box.
     */
    public static function add() {
        $screens = rc_get_all_post_types();
        foreach ( $screens as $screen ) {
            add_meta_box(
                '_export_html_settings',          // Unique ID
                'Export html settings', // Box title
                [ self::class, 'html' ],   // Content callback, must be of type callable
                $screen,                  // Post type
                'side',
                'high'
            );
        }
    }
 
 
    /**
     * Save the meta box selections.
     *
     * @param int $post_id  The post ID.
     */
    public static function save( int $post_id ) {
        if ( array_key_exists( 'upload_to_ftp', $_POST ) ) {
            if ( array_key_exists( 'ftp_upload_path', $_POST ) ) {
                //rc_export_page_to_ftp_server($post_id, $_POST['ftp_upload_path']);

                update_post_meta(
                    $post_id,
                    '_upload_to_ftp_path',
                    $_POST['ftp_upload_path']
                );
            }
            
            update_option('rc_export_pages_as_html_task', 'running');
            update_option('rc_is_export_pages_zip_downloaded', 'no');

            update_post_meta(
                $post_id,
                '_upload_to_ftp',
                $_POST['upload_to_ftp']
            );
        }
        else{
        	update_post_meta(
                $post_id,
                '_upload_to_ftp',
                ''
            );
        }
    }
 
 
    /**
     * Display the meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function html( $post ) {
        $status = get_option('rc_export_html_ftp_connection_status');
        $data = get_option('rc_export_html_ftp_data');

        $is_ftp = get_post_meta($post->ID, '_upload_to_ftp', true);
        $path = get_post_meta($post->ID, '_upload_to_ftp_path', true);

        $checked = '';
        if ($is_ftp == 'on') {
            $checked = 'checked=""';
        }
        if (empty($path) && $status == 'connected' && isset($data->path)){
            $path = $data->path;
        }
    	?>
        <div class="ftp_uploading_section">
            <input id="upload_to_ftp" type="checkbox" name="upload_to_ftp"
            <?php if ($status !== 'connected'): ?>
                disabled =""
            <?php endif ?> <?php echo $checked; ?>>
            <label for="upload_to_ftp">Upload to ftp server</label>

            <br>

            <input id="ftp_upload_path" type="text" name="ftp_upload_path" placeholder="FTP path to upload" value="<?php echo $path; ?>" style="<?php if ($is_ftp=='on'): ?>
                display: block;
            <?php endif ?>">
            <?php if ($status !== 'connected'): ?>
                <span>FTP server is not connected from <a href="options-general.php?page=export-wp-page-to-html?tab=ftp_settings">Export WP page to static HTML</a> settings page. </span>
            <?php endif ?>
        </div>

        <style>
            #ftp_upload_path {
                margin-top: 10px;
                width: 100%;
                display: none;
            }
        </style>

        <script>
            (function ($) {
                'use strict';
            
                  $(document).on("change", "#upload_to_ftp", function(){
                      if ($(this).is(':checked')) {
                        $('#ftp_upload_path').slideDown(200);
                      }
                      else{
                        $('#ftp_upload_path').slideUp(200);
                      }
                  });
            })(jQuery);
        </script>
		<?php
    }


}
add_action( 'add_meta_boxes', [ 'pp_group_notif_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'pp_group_notif_Meta_Box', 'save' ] );


function rc_get_all_post_types(){

    $need = array();
    foreach (get_post_types() as $key => $value) {
        if ($value !== 'attachment'&&$value !== 'revision'&&$value !== 'nav_menu_item'&&$value !== 'oembed_cache'&&$value !== 'user_request') {
            $need[] = $value;
        }
        
    }

    return $need;
}

function rc_export_page_to_ftp_server($post_id, $path=''){
    add_cron_job_to_start_html_exporting_for_save_post($post_id, $path);
}

function add_cron_job_to_start_html_exporting_for_save_post($post_id = 0, $path=''){
    $permalink = get_permalink($post_id);

    global $wpdb;
    $upload_dir = wp_upload_dir()['basedir'];
    rmdir_recursive2($upload_dir . '/exported_html_files/tmp_files');
    $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}export_page_to_html_logs");
    $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}export_urls_logs ");

    $settings = array(
        'skipAssetsFiles' => array(),
        'replaceUrlsToHash' => false,
        'receive_email' => false,
        'email_lists' => "",
        'ftp_upload_enabled' => true,
        'ftp_path' => $path,
    );

    wp_schedule_single_event( time() , 'start_export_custom_url_to_html_event', array( $permalink, $settings ) );
    
    return json_encode(array('success' => 'true', 'status' => 'success', 'response' => 'task running'));

}

    function rmdir_recursive2($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive2("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }


function rc_after_posts_save_hook(){
    if (isset($_GET['post'])&&isset($_GET['action'])&&isset($_GET['message'])&&($_GET['message']=='1'||$_GET['message']=='6')) {
        
        $post_id = sanitize_key($_GET['post']);
        $is_ftp = get_post_meta($post_id, '_upload_to_ftp', true);
        $path = get_post_meta($post_id, '_upload_to_ftp_path', true);
        if ($is_ftp == 'on') {
            $post_name = get_permalink($post_id);
            update_option('rc_single_post_exporting', 'on');
            update_option('rc_single_post_exporting_post_name', basename($post_name));
            rc_export_page_to_ftp_server($post_id, $path);  
            //update_option('rc_single_post_exporting', '');
        }
    }
}
add_action("init", "rc_after_posts_save_hook");