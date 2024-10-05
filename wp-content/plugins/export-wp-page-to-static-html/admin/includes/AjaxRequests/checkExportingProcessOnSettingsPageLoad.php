<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\checkExportingProcessOnSettingsPageLoad;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        /*Initialize Ajax check_exporting_process_on_settings_page_load*/
        add_action('wp_ajax_if_is_running_html_exporting_process', array( $this, 'check_exporting_process_on_settings_page_load' ));
    }


    /**
     * Ajax action name: check_exporting_process_on_settings_page_load
     * @since    1.0.0
     * @access   public
     * @reason   when settings page load then this ajax process will trigger
     * @return json
     */

    public function check_exporting_process_on_settings_page_load(){
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";


        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "rc-nonce" )){
                echo json_encode(array('success' => 'false', 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }

        die();
    }



}