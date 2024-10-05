<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\seeLogsInDetails;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        /*Initialize Ajax see_logs_in_details*/
        add_action('wp_ajax_see_logs_in_details', array( $this, 'see_logs_in_details' ));

    }

    /**
     * Ajax action name: see_logs_in_details
     * @since    2.0.0
     * @access   public
     * @return json
     */
    public function see_logs_in_details(){
        $id = isset($_POST['id']) ? sanitize_key($_POST['id']) : 0;
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";

        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "rc-nonce" )){
                echo json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }

        $logs = array();
        if( ($this->getSettings('task') == "completed" || $this->getSettings('cancel_command')) && $this->getSettings('logs_in_details') !== '1'){
            global $wpdb;
            $logs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}export_page_to_html_logs ORDER BY id ASC");
        }
        $cancel_command = false;
        if($this->getSettings('cancel_command')){
            $cancel_command = true;
        }

        $this->setSettings('logs_in_details', true);

        echo json_encode(array('success' => true, 'status' => 'success', 'response' => true, 'logs' => $logs, 'cancel_command' => $cancel_command));

        die();
    }


}