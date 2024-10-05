<?php

namespace Molongui\Authorship\Includes;

use Molongui\Authorship\Includes\Libraries\Common\WP_Background_Process;
defined( 'ABSPATH' ) or exit;
class Update_Post_Counters
{
    protected $process_all;
    protected $post_types;
    public function __construct()
    {
        $this->process_all = new Update_Post_Counters_Request();
    }
    public function handle_all( $post_types = array() )
    {
        if ( \apply_filters( 'authorship/check_wp_cron', true ) and ( \defined( 'DISABLE_WP_CRON' ) and DISABLE_WP_CRON ) ) return false;
        $users = \molongui_get_users( array( 'fields' => 'ids' ) );
        $guests = \molongui_get_guests( array( 'fields' => 'ids' ) );
        foreach ( $post_types as $post_type )
        {
            if ( !empty( $users ) )
            {
                foreach ( $users as $user )
                {
                    $this->process_all->push_to_queue( array( 'author' => array( 'type' => 'user', 'id' => $user ), 'post_type' => $post_type ) );
                }
            }

            if ( !empty( $guests ) )
            {
                foreach ( $guests as $guest )
                {
                    $this->process_all->push_to_queue( array( 'author' => array( 'type' => 'guest', 'id' => $guest ), 'post_type' => $post_type ) );
                }
            }
        }
        $r = $this->process_all->save()->dispatch();

        if ( !\is_wp_error( $r ) )
        {
            \add_option( 'm_update_post_counters_running', true );
        }

        return $r;
    }
    public function handle_some( $post_types = array(), $authors = array() )
    {
        if ( empty( $post_types ) or empty( $authors ) ) return false;

        foreach ( $post_types as $post_type )
        {
            foreach ( $authors as $author )
            {
                $author_info = \explode( '-', $author );
                $author_id   = $author_info[1];
                $author_type = $author_info[0];
                $class = new Author( $author_id, $author_type );
                $count = $class->get_posts_count( $post_type );
                switch ( $author_type )
                {
                    case 'user':

                        $meta_key   = 'molongui_author_'.$post_type.'_count';
                        $meta_value = \get_user_meta( $author_id, $meta_key, true );
                        if ( empty( $meta_value ) and $meta_value != 0 ) // use != or !== '0'. Values from MySQL are strings.
                        {
                            \add_user_meta( $author_id, $meta_key, $count, true );
                        }
                        else \update_user_meta( $author_id, $meta_key, $count );

                    break;

                    case 'guest':

                        $meta_key = '_molongui_guest_author_'.$post_type.'_count';
                        if ( \get_post_meta( $author_id, $meta_key, true ) ) \update_post_meta( $author_id, $meta_key, $count );
                        else \add_post_meta( $author_id, $meta_key, $count, true );

                    break;
                }
            }
        }

        return true;
    }
    public function increment_counter( $post_types, $authors )
    {
        $this->incr_decr_counter( 'increment', $post_types, $authors );
    }
    public function decrement_counter( $post_types, $authors )
    {
        $this->incr_decr_counter( 'decrement', $post_types, $authors );
    }
    public function incr_decr_counter( $action = 'increment', $post_types = '', $authors = '' )
    {
        if ( empty( $post_types ) or empty( $authors ) ) return;
        if ( \is_string( $post_types ) ) $post_types = array( $post_types );
        if ( \is_string( $authors )    ) $authors    = array( $authors );

        foreach ( $post_types as $post_type )
        {
            foreach ( $authors as $author )
            {
                $author_info = \explode( '-', $author );
                $author_id   = $author_info[1];
                $author_type = $author_info[0];
                switch ( $author_type )
                {
                    case 'user':
                        $meta_key   = 'molongui_author_'.$post_type.'_count';
                        $meta_value = \get_user_meta( $author_id, $meta_key, true );
                        if ( $action === 'increment' ) ++$meta_value;
                        else --$meta_value;
                        if ( \get_user_meta( $author_id, $meta_key ) ) \update_user_meta( $author_id, $meta_key, $meta_value );
                        else \add_user_meta( $author_id, $meta_key, $meta_value, true );

                    break;

                    case 'guest':
                        $meta_key   = '_molongui_guest_author_'.$post_type.'_count';
                        $meta_value = \get_post_meta( $author_id, $meta_key, true );
                        if ( $action === 'increment' ) ++$meta_value;
                        else --$meta_value;
                        if ( \get_post_meta( $author_id, $meta_key ) ) \update_post_meta( $author_id, $meta_key, $meta_value );
                        else \add_post_meta( $author_id, $meta_key, $meta_value, true );

                    break;
                }
            }
        }
    }

} // class
class Update_Post_Counters_Request extends WP_Background_Process
{
    protected $prefix = 'm';
    protected $action = 'update_post_counters';
    protected function task( $item )
    {
        if ( !\is_array( $item ) or !isset( $item['author'] ) or !isset( $item['post_type'] ) ) return false;
        $author = new Author( $item['author']['id'], $item['author']['type'] );
        $count  = $author->get_posts_count( $item['post_type'] );
        switch ( $item['author']['type'] )
        {
            case 'user':

                $meta_key = 'molongui_author_'.$item['post_type'].'_count';
                \update_user_meta( $item['author']['id'], $meta_key, $count );

            break;

            case 'guest':

                $meta_key = '_molongui_guest_author_'.$item['post_type'].'_count';
                \update_post_meta( $item['author']['id'], $meta_key, $count );

            break;
        }
        return false;
    }
    protected function complete()
    {
        parent::complete();
        \add_option( 'm_update_post_counters_complete', true );
    }
}