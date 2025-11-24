<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.xllentech.com
 * @since      2.6.0
 *
 * @package    Xllentech_English_Islamic_Calendar
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function xllentech_calendar_uninstall(){
	global $wpdb;
	
	$xc_options = get_option("xc_options");
	if( $xc_options['xc_data_uninstall'] == 'Yes' ) {
		$month_days_table = $wpdb->prefix . 'month_days'; 
		$month_firstdate_table = $wpdb->prefix . 'month_firstdate';
		delete_option('xc_options');
	 
		$wpdb->query("DROP TABLE IF EXISTS ". $month_days_table);
		$wpdb->query("DROP TABLE IF EXISTS ". $month_firstdate_table);
		if( $wpdb->last_error != '' ) {
			$wpdb->print_error();
		}
	}
}
	/** Clear options, databse tables if UNINSTALL */
xllentech_calendar_uninstall();