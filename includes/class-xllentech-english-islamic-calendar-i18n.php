<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.xllentech.com
 * @since      2.6.0
 *
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.6.0
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */
 // Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Xllentech_English_Islamic_Calendar_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.6.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'xllentech-english-islamic-calendar',
			false,
			XC_PLUGIN_DIR . 'languages/'
		);

	}



}
