<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\exportLogPercentage;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        /*Initialize Ajax export_log_percentage*/
        add_action('wp_ajax_export_log_percentage', array( $this, 'export_log_percentage' ));

    }


    /**
     * Ajax action name: export_log_percentage
     * @since    2.0.0
     * @access   public
     * @return json
     */
    public function export_log_percentage(){
        $id = isset($_POST['id']) ? sanitize_key($_POST['id']) : "";
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";

        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "rc-nonce" )){
                echo json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }

        global $wpdb;
        $totalExportedUrlLogs = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_urls_logs");
        $totalExportedUrls = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_urls_logs WHERE exported='1' ");
        $totalLogs = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_page_to_html_logs");

        $response = '';
        $cancel_command = $this->getSettings('cancel_command', false);
        $logs_in_details = $this->getSettings('logs_in_details', false);
        $exportStatus = $this->getSettings('task');
        $creatingHtmlProcess = $this->getSettings('creating_html_process');
        $creatingZipStatus = $this->getSettings('creating_zip_process');
        $total_zip_files = $this->getSettings('total_zip_files', 0);
        $total_pushed_file_to_zip = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_page_to_html_logs WHERE type='added_into_zip_file' ");
        $zipDownloadLink = $this->getSettings('zipDownloadLink');
        $ftp_upload_enabled = $this->getSettings('ftp_upload_enabled');
        $ftp_status = $this->getSettings('ftp_status');
        $lastUpdateTotalLogs = $this->getSettings('lastLogs');
        $lastLogsTime = (int) $this->getSettings('lastLogsTime');

        $logs = array();
        if($logs_in_details == 1){
            if ($id == 0||$id == '0') {
                $logs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}export_page_to_html_logs ORDER BY id ASC");
            } else {
                $logs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}export_page_to_html_logs ORDER BY id ASC LIMIT 5000 OFFSET {$id}");
            }
        }

        $createdLastHtmlFile = "";
        if($creatingHtmlProcess=="completed"){
            $tempUrl = wp_upload_dir()['baseurl'].'/exported_html_files/tmp_files';
            $created_html_file = $wpdb->get_results("SELECT comment FROM {$wpdb->prefix}export_page_to_html_logs WHERE type='created_html_file' ORDER BY ID ASC LIMIT 1");
            $createdLastHtmlFile = isset($created_html_file[0]) ? $created_html_file[0]->comment : '';
            if(!empty($createdLastHtmlFile)){
                $createdLastHtmlFile = $tempUrl .'/'. $createdLastHtmlFile;
            }
        }

        $total_file_uploaded = 0;
        if($ftp_upload_enabled == "yes"){
            $total_file_uploaded = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_page_to_html_logs WHERE type='file_uploaded_to_ftp' ");
        }

        $error = false;

        if(!empty($lastUpdateTotalLogs)&&!empty($lastLogsTime)){
            if ($lastUpdateTotalLogs==$totalLogs){
                if( ((time()-$lastLogsTime)/60) >= 5 ){
                    $error = true;
                    $this->setSettings('timestampError', true);
                }
            }else{
                $this->setSettings('lastLogsTime', time());
            }
        }
        else{
            $this->setSettings('lastLogsTime', time());
        }
        $this->setSettings('lastLogs', $totalLogs);



        $arrays = array(
            'success' => true,
            'status' => 'success',
            'response' => $response,
            'cancel_command' => $cancel_command,
            'total_urls_log' => $totalExportedUrlLogs,
            'total_url_exported' => $totalExportedUrls,
            'export_status' => $exportStatus,
            'creating_html_process' => $creatingHtmlProcess,
            'creating_zip_status'=> $creatingZipStatus,
            'total_pushed_file_to_zip'=> $total_pushed_file_to_zip,
            'total_zip_files'=> $total_zip_files,
            'logs_in_details'=> $logs_in_details,
            'total_logs' => $totalLogs,
            'logs' => $logs,
            'zipDownloadLink' => $zipDownloadLink,
            'ftp_upload_enabled' => $ftp_upload_enabled,
            'ftp_status' => $ftp_status,
            'total_file_uploaded' => $total_file_uploaded,
            'createdLastHtmlFile' => $createdLastHtmlFile,
            'error' => $error,
        );
        echo json_encode($arrays);

        die();
    }


}