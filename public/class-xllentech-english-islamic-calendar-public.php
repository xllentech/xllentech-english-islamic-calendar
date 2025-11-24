<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/public
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.6.0
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */
 // Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Xllentech_English_Islamic_Calendar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.6.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.6.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.6.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.6.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Xllentech_English_Islamic_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xllentech_English_Islamic_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/xllentech-english-islamic-calendar-public.css', array(), $this->version, 'all' );

	}
	
	/**
	 * Action hook to verify Options value periodically for the public-facing side of the site.
	 *
	 * @since    2.2.0
	 */
	public function verify_xc_options() {

		$xc_options = get_option("xc_options");
		if ( !is_array($xc_options) ) {
			$calendar_admin_email=get_option('admin_email');
			$xc_options = array(
			"islamic_months" => "Islamic Months,Muharram,Safar,Rabi'al Awwal,Rabi'al Thani,Jamadi'al Ula,Jamadi'al Thani,Rajab,Sha'ban,Ramadhan,Shawaal,Zul Qa'dah,Zul Hijjah",
			"islamic_month_days" => "12,30,29,30,29,30,29,30,29,30,29,30,29",
			"calendar_email_choice" => "No",
			"calendar_admin_email" => $calendar_admin_email,
			"days_email_sent" => "0",
			"xc_time_zone" => "America/Denver",
			"xc_page_pin" => "1234",
			"xc_color_theme" => "Default", 
			"xc_data_uninstall" => "No",
			"xc_first_day" => "Monday",
			"english_months" => "English Months,January,Febuary,March,April,May,June,July,August,September,October,November,December" );
			update_option("xc_options",$xc_options);
		}

		if( !isset($xc_options['english_months']) ) {
			$xc_options_new = array(
			"islamic_months" => $xc_options['islamic_months'],
			"islamic_month_days" => $xc_options['islamic_month_days'],
			"calendar_email_choice" => $xc_options['calendar_email_choice'],
			"calendar_admin_email" => $xc_options['calendar_admin_email'],
			"days_email_sent" => $xc_options['days_email_sent'],
			"xc_time_zone" => $xc_options['xc_time_zone'],
			"xc_page_pin" => $xc_options['xc_page_pin'],
			"xc_color_theme" => $xc_options['xc_color_theme'],
			"xc_data_uninstall" => $xc_options['xc_data_uninstall'],
			"xc_first_day" => $xc_options['xc_first_day'],
			"english_months" => "English Months,January,Febuary,March,April,May,June,July,August,September,October,November,December" );
			update_option("xc_options",$xc_options_new);
		}

	} // end verify_xc_options
	
	
	/**
	 * Action hook to calculate and insert in the database the value of Islamic Date 
	 * on the 1st day of the English Month for the public-facing side of the site.
	 * 
	 * @since    2.5.0
	 */
	public function calculate_islamic_date( $english_month, $stack ) {
		
		if( $stack > 12 ) {
			
			_e( "Xllentech Calendar Error: Islamic Date could not be found in the database. Please contact support or Add islamic date in the database from the Xllentech Calendar Settings -> Troubleshooting page." );
			return;
		}
		global $wpdb;
		
		$xc_options = get_option("xc_options");
		$month_days_table = $wpdb->prefix . 'month_days'; 
		$month_firstdate_table = $wpdb->prefix . 'month_firstdate';
			
		$islamic_month_days = explode(",", $xc_options['islamic_month_days']);
		
		$english_currentyear=date_format($english_month,'Y');
		$english_currentmonth=date_format($english_month,'n');
		
		$english_last_month = clone $english_month;
		$english_last_month->modify( '-1 month' );

		$english_previous_monthdays=date_format($english_last_month,'t');
		$english_previousyear=date_format($english_last_month,'Y');
		$english_previousmonth=date_format($english_last_month,'n');

		//Get previous month islamic date
		$islamic_date_data = $wpdb->get_results( $wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_previousyear, $english_previousmonth ) );

			//if doesn't exist, return empty
			if( count($islamic_date_data) <= 0 ) {
				
				$english_currentdate = date_create( '1-'. $english_previousmonth .'-'. $english_previousyear );
				
				$stack++;
				do_action( 'xc_calculate_islamic_date', $english_currentdate, $stack );
				
				//Get previous month islamic date
				$islamic_date_data = $wpdb->get_results( $wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_previousyear, $english_previousmonth ) );
				
				if( count( $islamic_date_data ) <= 0 ) {
					return;
				}
			}

			foreach( $islamic_date_data as $result_data ) {
				$islamic_previousday=$result_data->islamic_day;
				$islamic_previousmonth=$result_data->islamic_month;
				$islamic_previousyear=$result_data->islamic_year;
			}
			
			$islamic_month_days[$islamic_previousmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_previousmonth], $islamic_previousmonth, $islamic_previousyear );
			
			//NEW FORMULA START ************
			
			$newday=$islamic_previousday+$english_previous_monthdays-$islamic_month_days[$islamic_previousmonth];
			$newmonth=$islamic_previousmonth+1;
			$newyear=$islamic_previousyear;
				if( $newmonth > 12 ){
						$newyear++;
						$newmonth=1;
				}
			if( $newday > 28 ){
				$islamic_month_days[$newmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$newmonth], $newmonth, $newyear );
			}
			
			if( $newday > $islamic_month_days[$newmonth] ) {
				$newday=$newday-$islamic_month_days[$newmonth];
				$newmonth++;
				if( $newmonth > 12 ){
					$newyear++;
					$newmonth=1;
				}
			}
			//NEW FORMULA END ************
			
			$wpdb->insert( $month_firstdate_table, array( 'english_month' => $english_currentmonth,
			'english_year' => $english_currentyear, 'islamic_day' => $newday, 'islamic_month' => $newmonth, 'islamic_year' => $newyear ), array('%d','%d','%d','%d','%d') );
			
			//$newdate[0] = $newday; $newdate[1] = $newmonth; $newdate[2] = $newyear;

	} // end xc_calculate_islamic_date()
	
	/**
	 * Action hook to update number of days of the islamic month periodically for the public-facing side of the site.
	 *
	 * @since    2.5.0
	 */
	public function check_and_update_days( $islamic_days, $islamic_month, $islamic_year ) {
		global $wpdb;
		$month_days_table = $wpdb->prefix . 'month_days';
		
		$month_data = $wpdb->get_results( $wpdb->prepare( "SELECT days FROM $month_days_table WHERE year_number = %d AND month_number = %d", $islamic_year, $islamic_month ) );
		
		if( count( $month_data ) > 0 ) {
			foreach( $month_data as $islamic_date_data ) {
				$islamic_days = $islamic_date_data->days;
			}
		}
		
		return $islamic_days;
	}
	
	/**
	 * Action hook to display header with given month and year values on the public-facing side of the site.
	 *
	 * @since    2.5.0
	 */
	public function xc_display_base_header( $english_currentmonth, $english_currentyear, $islamic_firstmonth, $islamic_firstyear ) { 
	
		$xc_options = get_option("xc_options");
		
		?>
		<table border='1' class='xc_table_<?php esc_attr( $xc_options['xc_color_theme'] ); ?>'>
		

			<thead>
				<tr class='xllentech-main-nav xllentech_header'>
					<th colspan='7'>
						<div class='xllentech-month-names'>
							<span class='xllentech-english-month'><?php esc_html_e( $english_currentmonth, 'xllentech-calendar' ); echo ' '; esc_html_e( $english_currentyear, 'xllentech-calendar' ); ?></span>
							<span class='xllentech-islamic-month'><?php esc_html_e( $islamic_firstmonth, 'xllentech-calendar' ); echo ' '; esc_html_e( $islamic_firstyear, 'xllentech-calendar' ); ?></span>
						</div>
					</th>
				</tr>
			
		<?php	if( $xc_options['xc_first_day'] == "Monday" ) {	?>
					<tr class='xllentech-daynames xllentech_subheader'>
							<th>Mon</th>
							<th>Tue</th>
							<th>Wed</th>
							<th>Thu</th>
							<th>Fri</th>
							<th>Sat</th>
							<th>Sun</th>
					</tr>
		<?php 	}	else { ?>
					<tr class='xllentech-daynames xllentech_subheader'>
						<th>Sun</th>
						<th>Mon</th>
						<th>Tue</th>
						<th>Wed</th>
						<th>Thu</th>
						<th>Fri</th>
						<th>Sat</th>
					</tr>
		<?php 	} ?>
			</thead>
		<?php
		
	} // END xc_display_base_header()
	
	/**
	 * Action hook to display calendar body with given values on the public-facing side of the site.
	 *
	 * @since    2.5.0
	 */
	public function xc_display_base_body( $xllentech_english_css, $english_day_sequence, $xllentech_islamic_css, $islamic_day_sequence ) {
	
		$xc_options = get_option("xc_options");
		
		$english_currentdate = new DateTime('NOW', new DateTimeZone( $xc_options["xc_time_zone"] ) );
		$english_currentmonth = date_format($english_currentdate,'n');
		$english_currentyear = date_format($english_currentdate,'Y');
		
		$english_currentdate = date_create( '1-'.$english_currentmonth.'-'.$english_currentyear );
		
		if( $xc_options['xc_first_day'] == "Monday" )	{
			$english_current_firstday = date_format( $english_currentdate, 'N' );
			$english_current_firstday = $english_current_firstday-1;
		}	else {
			$english_current_firstday = date_format( $english_currentdate, 'w' );
		}
		$english_current_monthdays=date_format( $english_currentdate, 't' );

		?>

		<tbody>
			
				<tr>
			
		<?php 	for ($c=0; $c<35; $c++) { ?>
					<td>
						<div class='xllentech-daybox'>
							<span class='<?php echo esc_attr($xllentech_english_css[$c]); ?>'><?php esc_html_e( $english_day_sequence[$c], 'xllentech-calendar' ); ?></span>
							<span class='xllentech-spacing'></span>
							<span class='<?php echo esc_attr($xllentech_islamic_css[$c]); ?>'><?php esc_html_e( $islamic_day_sequence[$c], 'xllentech-calendar' ); ?></span>
						</div>
					</td>
				<?php 	if ( $c==6 || $c==13 || $c==20 || $c==27 ) { ?>
							</tr>
							<tr>
				<?php 	}
				} ?>
			
				</tr>


		<?php 	
				if ( ( $english_current_firstday == 5 && $english_current_monthdays > 30 ) || ( $english_current_firstday == 6 && $english_current_monthdays >= 30 ) ) { ?>

					<tr>
					
			<?php	for ($c=35; $c<42; $c++) { ?>
						<td>
							<div class='xllentech-daybox'>
								<span class='<?php echo esc_attr($xllentech_english_css[$c]); ?>'><?php esc_html_e( $english_day_sequence[$c], 'xllentech-calendar' ); ?></span>
								<span class='xllentech-spacing'></span>
								<span class='<?php echo esc_attr($xllentech_islamic_css[$c]); ?>'><?php esc_html_e( $islamic_day_sequence[$c], 'xllentech-calendar' ); ?></span>
							</div>
						</td>
			<?php 	} ?>
					
					</tr>

		<?php 	} ?>
			</tbody>
		</table>
		<?php
	} // END xc_display_base_body()
	
	
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.6.0
	 * /
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Xllentech_English_Islamic_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xllentech_English_Islamic_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 * /

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/xllentech-english-islamic-calendar-public.js', array( 'jquery' ), $this->version, false );

	}
	*/
	
}
