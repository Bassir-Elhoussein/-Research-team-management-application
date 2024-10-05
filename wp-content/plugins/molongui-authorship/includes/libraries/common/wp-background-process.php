<?php

namespace Molongui\Authorship\Includes\Libraries\Common;
defined( 'ABSPATH' ) or exit;
if ( !class_exists( 'Molongui\Authorship\Includes\Libraries\Common\WP_Background_Process' ) )
{
    abstract class WP_Background_Process extends WP_Async_Request
    {
        protected $action = 'background_process';
        protected $start_time = 0;
        protected $cron_hook_identifier;
        protected $cron_interval_identifier;
        public function __construct() {
            parent::__construct();

            $this->cron_hook_identifier     = $this->identifier . '_cron';
            $this->cron_interval_identifier = $this->identifier . '_cron_interval';

            add_action( $this->cron_hook_identifier, array( $this, 'handle_cron_healthcheck' ) );
            add_filter( 'cron_schedules', array( $this, 'schedule_cron_healthcheck' ) );
        }
        public function dispatch() {
            $this->schedule_event();
            return parent::dispatch();
        }
        public function push_to_queue( $data ) {
            $this->data[] = $data;

            return $this;
        }
        public function save() {
            $key = $this->generate_key();

            if ( ! empty( $this->data ) ) {
                update_site_option( $key, $this->data );
            }

            return $this;
        }
        public function update( $key, $data ) {
            if ( ! empty( $data ) ) {
                update_site_option( $key, $data );
            }

            return $this;
        }
        public function delete( $key ) {
            delete_site_option( $key );

            return $this;
        }
        protected function generate_key( $length = 64 ) {
            $unique  = md5( microtime() . rand() );
            $prepend = $this->identifier . '_batch_';

            return substr( $prepend . $unique, 0, $length );
        }
        public function maybe_handle() {
            session_write_close();

            if ( $this->is_process_running() ) {
                wp_die();
            }

            if ( $this->is_queue_empty() ) {
                wp_die();
            }

            check_ajax_referer( $this->identifier, 'nonce' );

            $this->handle();

            wp_die();
        }
        protected function is_queue_empty() {
            global $wpdb;

            $table  = $wpdb->options;
            $column = 'option_name';

            if ( is_multisite() ) {
                $table  = $wpdb->sitemeta;
                $column = 'meta_key';
            }

            $key = $this->identifier . '_batch_%';

            $count = $wpdb->get_var( $wpdb->prepare( "
                SELECT COUNT(*)
                FROM {$table}
                WHERE {$column} LIKE %s
            ", $key ) );

            return ! ( $count > 0 );
        }
        protected function is_process_running() {
            if ( get_site_transient( $this->identifier . '_process_lock' ) ) {
                return true;
            }

            return false;
        }
        protected function lock_process() {
            $this->start_time = time(); // Set start time of current process.

            $lock_duration = ( property_exists( $this, 'queue_lock_time' ) ) ? $this->queue_lock_time : 60; // 1 minute
            $lock_duration = apply_filters( $this->identifier . '_queue_lock_time', $lock_duration );

            set_site_transient( $this->identifier . '_process_lock', microtime(), $lock_duration );
        }
        protected function unlock_process() {
            delete_site_transient( $this->identifier . '_process_lock' );

            return $this;
        }
        protected function get_batch() {
            global $wpdb;

            $table        = $wpdb->options;
            $column       = 'option_name';
            $key_column   = 'option_id';
            $value_column = 'option_value';

            if ( is_multisite() ) {
                $table        = $wpdb->sitemeta;
                $column       = 'meta_key';
                $key_column   = 'meta_id';
                $value_column = 'meta_value';
            }

            $key = $this->identifier . '_batch_%';

            $query = $wpdb->get_row( $wpdb->prepare( "
                SELECT *
                FROM {$table}
                WHERE {$column} LIKE %s
                ORDER BY {$key_column} ASC
                LIMIT 1
            ", $key ) );

            $batch       = new \stdClass();
            $batch->key  = $query->$column;
            $batch->data = maybe_unserialize( $query->$value_column );

            return $batch;
        }
        protected function handle() {
            $this->lock_process();

            do {
                $batch = $this->get_batch();

                foreach ( $batch->data as $key => $value ) {
                    $task = $this->task( $value );

                    if ( false !== $task ) {
                        $batch->data[ $key ] = $task;
                    } else {
                        unset( $batch->data[ $key ] );
                    }

                    if ( $this->time_exceeded() || $this->memory_exceeded() ) {
                        break;
                    }
                }
                if ( ! empty( $batch->data ) ) {
                    $this->update( $batch->key, $batch->data );
                } else {
                    $this->delete( $batch->key );
                }
            } while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

            $this->unlock_process();
            if ( ! $this->is_queue_empty() ) {
                $this->dispatch();
            } else {
                $this->complete();
            }

            wp_die();
        }
        protected function memory_exceeded() {
            $memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
            $current_memory = memory_get_usage( true );
            $return         = false;

            if ( $current_memory >= $memory_limit ) {
                $return = true;
            }

            return apply_filters( $this->identifier . '_memory_exceeded', $return );
        }
        protected function get_memory_limit() {
            if ( function_exists( 'ini_get' ) ) {
                $memory_limit = ini_get( 'memory_limit' );
            } else {
                $memory_limit = '128M';
            }

            if ( ! $memory_limit || -1 === $memory_limit ) {
                $memory_limit = '32000M';
            }

            return intval( $memory_limit ) * 1024 * 1024;
        }
        protected function time_exceeded() {
            $finish = $this->start_time + apply_filters( $this->identifier . '_default_time_limit', 20 ); // 20 seconds
            $return = false;

            if ( time() >= $finish ) {
                $return = true;
            }

            return apply_filters( $this->identifier . '_time_exceeded', $return );
        }
        protected function complete() {
            $this->clear_scheduled_event();
        }
        public function schedule_cron_healthcheck( $schedules ) {
            $interval = apply_filters( $this->identifier . '_cron_interval', 5 );

            if ( property_exists( $this, 'cron_interval' ) ) {
                $interval = apply_filters( $this->identifier . '_cron_interval', $this->cron_interval );
            }
            $schedules[ $this->identifier . '_cron_interval' ] = array(
                'interval' => MINUTE_IN_SECONDS * $interval,
                'display'  => sprintf( __( 'Every %d minutes', 'molongui-authorship' ), $interval ),
            );

            return $schedules;
        }
        public function handle_cron_healthcheck() {
            if ( $this->is_process_running() ) {
                exit;
            }

            if ( $this->is_queue_empty() ) {
                $this->clear_scheduled_event();
                exit;
            }

            $this->handle();

            exit;
        }
        protected function schedule_event() {
            if ( ! wp_next_scheduled( $this->cron_hook_identifier ) ) {
                $r = wp_schedule_event( time(), $this->cron_interval_identifier, $this->cron_hook_identifier );
            }
        }
        protected function clear_scheduled_event() {
            $timestamp = wp_next_scheduled( $this->cron_hook_identifier );

            if ( $timestamp ) {
                wp_unschedule_event( $timestamp, $this->cron_hook_identifier );
            }
        }
        public function cancel_process() {
            if ( ! $this->is_queue_empty() ) {
                $batch = $this->get_batch();

                $this->delete( $batch->key );

                wp_clear_scheduled_hook( $this->cron_hook_identifier );
            }

        }
        abstract protected function task( $item );

    }
}