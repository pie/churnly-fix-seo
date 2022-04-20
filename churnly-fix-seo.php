<?php
/*
Plugin Name: Churnly: YoastSEO Compatibility Fix
Description: Adds a fix to bypass Yoast SEO's reload so that notifications display as expected on Update Credit Card page
Version: 0.1
Author: The team at PIE
Author URI: http://pie.co.de
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/* PIE\ChurnlySEOFix is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

PIE\ChurnlySEOFix is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with PIE\ChurnlySEOFix. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html */

namespace PIE\ChurnlySEOFix;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Override Yoast SEO's reload to avoid notices not showing on update CC page
 */
function override_seo_reload() {
	$update_cc_page = get_option( 'woocommerce_churnly_cc_update_page' );
	if ( is_page( $update_cc_page ) ) {
		global $wpseo_front;
		if ( defined( $wpseo_front ) ) {
			remove_action( 'wp_head', array( $wpseo_front, 'head' ), 1 );
		} else {
			$instance = WPSEO_Frontend::get_instance();
			remove_action( 'wp_head', array( $instance, 'head' ), 1 );
		}
	}
}
add_action( 'template_redirect', __NAMESPACE__ . '\override_seo_reload' );
