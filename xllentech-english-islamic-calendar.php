<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://xllentech.com
 * @since             1.0.0
 * @package           Xllentech_English_Islamic_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       XllenTech English Islamic Calendar
 * Plugin URI:        https://wordpress.org/plugins/xllentech-english-islamic-calendar/
 * Description:       The Best English Islamic Calendar plugin on Wordpress. It shows calendar with English(gregorian) and Islamic(hijri) dates. No maintenace year to year.
 * Version:           2.7.3
 * Author:            XllenTech Solutions
 * Author URI:        https://xllentech.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       xllentech-english-islamic-calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( "XC_PLUGIN_VERSION" ) ) 	define( "XC_PLUGIN_VERSION",  "2.7.3");
if ( ! defined( "XC_PLUGIN_DIR" ) ) define( "XC_PLUGIN_DIR", plugin_dir_path( __FILE__ ));
if ( ! defined( 'XC_PLUGIN_URL' ) ) define( 'XC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	// Plugin Basename aka: "pluginfolder/mainfile.php"
if ( ! defined( 'XC_PLUGIN_BASENAME' ) ) define( 'XC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xllentech-english-islamic-calendar-activator.php
 */
function activate_xllentech_english_islamic_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xllentech-english-islamic-calendar-activator.php';
	Xllentech_English_Islamic_Calendar_Activator::activate();
}
	
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xllentech-english-islamic-calendar-deactivator.php
 */
function deactivate_xllentech_english_islamic_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xllentech-english-islamic-calendar-deactivator.php';
	Xllentech_English_Islamic_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_xllentech_english_islamic_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_xllentech_english_islamic_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require XC_PLUGIN_DIR . 'includes/class-xllentech-english-islamic-calendar.php';
//include islamic month days update front end page shortcode
include XC_PLUGIN_DIR . 'public/partials/shortcode-islamic-month-days.php';

/*Shortcode code [xcalendar] Starts */
function xllentech_calendar_shortcode($instance){
	global $wp_widget_factory;
	$my_widget_name="Xllentech_English_Islamic_Calendar";
	
	ob_start();
	the_widget( $my_widget_name );
	$output = ob_get_clean();
	//ob_end_clean();
	return $output;
}
add_shortcode('xcalendar', 'xllentech_calendar_shortcode');
/*Shortcode code [xcalendar] Ends */


//XllenTech Today Widget Class
/**
	 * Detect if xllentech-english-islamic-calendar/ plugin exists and active
	 */
include_once ABSPATH . 'wp-admin/includes/plugin.php';
 
if ( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {

	$class_xllentech_today = WP_PLUGIN_DIR . '/xllentech-calendar-pro/public/partials/class-xllentech-islamic-today-pro.php';

	if( file_exists($class_xllentech_today) )
		include_once $class_xllentech_today;
	else
		include_once XC_PLUGIN_DIR . 'includes/class-xllentech-islamic-today.php';
	
} else {
	
	include_once XC_PLUGIN_DIR . 'includes/class-xllentech-islamic-today.php';

}


/*Shortcode code [xllentech-today] Starts */
function xllentech_today_shortcode($instance){
	global $wp_widget_factory;
	$my_widget_name="Xllentech_Islamic_Today";
	
	ob_start();
	the_widget( $my_widget_name );
	$output = ob_get_clean();
	//ob_end_clean();
	return $output;
}
add_shortcode('xllentech-today', 'xllentech_today_shortcode');
/*Shortcode code [xllentech-today] Ends */
// register widget
add_action( 'widgets_init', 'xllentech_calendar_widget' );

function xllentech_calendar_widget() {
    register_widget( 'Xllentech_English_Islamic_Calendar' );
    register_widget( 'Xllentech_Islamic_Today' );
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.6.0
 */
function run_xllentech_english_islamic_calendar() {

	$plugin = new Xllentech_English_Islamic_Calendar();
	$plugin->run();

}
run_xllentech_english_islamic_calendar();
