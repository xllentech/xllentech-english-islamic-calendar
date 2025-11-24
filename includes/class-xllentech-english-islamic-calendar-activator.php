<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.6.0
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Xllentech_English_Islamic_Calendar_Activator {

	/**
	 * On Plugin activation, create table, insert initial values.
	 *
	 * This function is the core of the plugin, without this plugin will fail.
	 *
	 * @since    2.6.0
	 */
	public static function activate() {
		global $wpdb;
		
		$english_month = 8;
		$english_year = 2024;
		$islamic_day = 26;
		$islamic_month = 1;
		$islamic_year = 1446;

		$table1_name = $wpdb->prefix . 'month_days'; 
		$table2_name = $wpdb->prefix . 'month_firstdate'; 
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql1 = "CREATE TABLE $table1_name (
			month_number int(2) NOT NULL,
			year_number int(5) NOT NULL,
			days int(2) NOT NULL,
			PRIMARY KEY  (month_number,year_number)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql1);

		$sql2 = "CREATE TABLE $table2_name (
			english_month int(2) NOT NULL,
			english_year int(4) NOT NULL,
			islamic_day int(2) NOT NULL,
			islamic_month int(2) NOT NULL,
			islamic_year int(4) NOT NULL,
			PRIMARY KEY  (english_month,english_year)
		) $charset_collate;";
		dbDelta($sql2);

		$rows_affected = $wpdb->replace( $table2_name, array( 'english_month' => $english_month, 'english_year' => $english_year, 'islamic_day' => $islamic_day, 'islamic_month' => $islamic_month, 'islamic_year' => $islamic_year ));
		
		dbDelta( $rows_affected );
		
		//Add activation redirect to settings page
		set_transient( '_xllentech_calendar_activation_redirect', true, 30 );
		
		//Register XC_Options and initial values 
		register_setting(
			'xc_options',  // settings section
			'xc_options' // setting name
		 );
		 
		$xc_options = get_option("xc_options");
		if ( ! is_array($xc_options) ) {
			
			$calendar_admin_email = sanitize_email( get_option('admin_email') );
			$timezone = esc_html( wp_timezone_string() );
			
			$xc_options = array(
				"islamic_months" => "Islamic Months,Muharram,Safar,Rabi'al Awwal,Rabi'al Thani,Jamadi'al Ula,Jamadi'al Thani,Rajab,Sha'ban,Ramadhan,Shawaal,Zul Qa'dah,Zul Hijjah",
				"islamic_month_days" => "12,30,29,30,29,30,29,30,29,30,29,30,29",
				"calendar_email_choice" => 0,
				"calendar_admin_email" => $calendar_admin_email,
				"days_email_sent" => 0,
				"xc_time_zone" => $timezone,
				"xc_page_pin" => 1234,
				"xc_color_theme" => "Default", 
				"xc_data_uninstall" => 0,
				"xc_first_day" => "Monday",
				"english_months" => "English Months,January,Febuary,March,April,May,June,July,August,September,October,November,December"	
			);
			
			update_option( "xc_options", $xc_options );
			
		}
		
	}
	
	/**
	 * Validate our options before saving
	 */
	function xllentech_options_validate($input) {
		return $input;
	}
}
