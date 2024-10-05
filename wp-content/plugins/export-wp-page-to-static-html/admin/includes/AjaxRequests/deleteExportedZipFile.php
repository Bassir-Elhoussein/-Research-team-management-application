<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\deleteExportedZipFile;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        /*Initialize Ajax delete_exported_zip_file*/
        add_action('wp_ajax_delete_exported_zip_file', array( $this, 'delete_exported_zip_file' ));

    }


    /**
     * Ajax action name: delete_exported_zip_file
     * @since    1.0.0
     * @access   public
     * @return json
     */

    public function delete_exported_zip_file(){
        $file_name = isset($_POST['file_name']) ? sanitize_file_name($_POST['file_name']) : "";
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";

        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "rc-nonce" )){
                echo json_encode(array('success' => 'false', 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }


        $upload_dir = wp_upload_dir()['basedir'] . '/exported_html_files/';

        $response = unlink($upload_dir.$file_name);;


        echo json_encode(array('success' => 'true', 'status' => 'success', 'response' => $response));

        die();
    }


}