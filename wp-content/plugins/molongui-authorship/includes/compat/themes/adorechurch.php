<?php
defined( 'ABSPATH' ) or exit;
add_filter( 'molongui_authorship_bypass_original_user_id_if', '__return_true' );