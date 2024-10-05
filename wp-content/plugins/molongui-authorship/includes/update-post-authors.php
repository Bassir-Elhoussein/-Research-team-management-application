<?php

namespace Molongui\Authorship\Includes;

use Molongui\Authorship\Includes\Libraries\Common\WP_Background_Process;
defined( 'ABSPATH' ) or exit;
class Update_Post_Authors
{
    protected $process_all;
    protected $post_types;
    public function __construct()
    {
        $this->process_all = new Update_Post_Authors_Request();
    }
    public function run( $post_types = array() )
    {
        if ( \apply_filters( 'authorship/check_wp_cron', true ) and ( \defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) ) return false;
        $post_ids = \get_posts( array
        (
            'numberposts'      => -1,
            'meta_key'         => '_molongui_author',
            'meta_compare'     => 'NOT EXISTS',
            'post_type'        => $post_types,
            'suppress_filters' => true,
            'post_status' => \authorship_post_status( $post_types ),
            'fields' => 'ids',
        ));
        if ( !empty( $post_ids ) )
        {
            foreach ( $post_ids as $post_id )
            {
                $this->process_all->push_to_queue( $post_id );
            }
            $r = $this->process_all->save()->dispatch();

            if ( !\is_wp_error( $r ) )
            {
                \add_option( 'm_update_post_authors_running', true );
            }

            return $r;
        }

        return true;
    }

} // class
class Update_Post_Authors_Request extends WP_Background_Process
{
    protected $prefix = 'm';
    protected $action = 'update_post_authors';
    protected function task( $post_id )
    {
        $post_id     = (int) $post_id;
        $post_author = get_post_field( 'post_author', $post_id );

        \update_post_meta( $post_id, '_molongui_main_author', 'user-'.$post_author );
        \update_post_meta( $post_id, '_molongui_author', 'user-'.$post_author );
        return false;
    }
    protected function complete()
    {
        parent::complete();
        \add_option( 'm_update_post_authors_complete', true );
    }
}