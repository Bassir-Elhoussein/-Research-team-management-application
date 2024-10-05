<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\searchPosts;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{

    public function __construct()
    {
        /*Initialize Ajax rc_search_posts*/
        add_action('wp_ajax_rc_search_posts', array( $this, 'rc_search_posts' ));

    }


    /**
     * Ajax action name: rc_search_posts
     * @since    1.0.0
     * @access   public
     * @return json
     */

    public function rc_search_posts(){
        //$post = $_POST['post'];
        $value = isset($_POST['value']) ? sanitize_text_field($_POST['value']) : "";
        $nonce = isset($_POST['rc_nonce']) ? sanitize_key($_POST['rc_nonce']) : "";

        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "rc-nonce" )){
                echo json_encode(array('success' => 'false', 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            's' => $value
        );



        $query = new \WP_Query( $args );

        $middle_pathesponse = "";

        $options = array();
        ob_start();
        if (!empty($query->posts)) {
            foreach ($query->posts as $key => $post) {
                $post_id = $post->ID;
                $post_title = $post->post_title;
                $permalink = get_the_permalink($post_id);
                $parts = parse_url($permalink);

                if(isset($parts['query'])){
                    parse_str($parts['query'], $query);
                    if (!empty($query)) {
                        $permalink = strtolower(str_replace(" ", "-", $post_title));
                    }
                }

                $option = array();
                /*$option['post_id'] = $post_id;
                $option['post_title'] = $post_title; */

                $option['id'] = $post_id;
                $option['text'] = $post_title;

                $option['permalink'] = $permalink;

                $options[] = $option;

            }
        }

        if (!empty($options)) {
            $middle_pathesponse = $options;
        }


        //echo json_encode(array('success' => 'true', 'status' => 'success', 'response' => $middle_pathesponse));

        echo json_encode(array('success' => 'true', 'status' => 'success', 'results' => $middle_pathesponse, 'pagination' => array ('more' => false)));

        die();
    }


}