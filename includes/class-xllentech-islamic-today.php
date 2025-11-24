<?php
/**
 * The Class for displaying Xllentech Today widget, gets replaced by class-xllentech-today-pro.php with Pro options when Pro is installed and active
 *
 * @since      2.6.0
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */

// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !class_exists( 'Xllentech_Islamic_Today' ) ) {
	
	class Xllentech_Islamic_Today extends WP_Widget {

		/**
		 * The private instance of the global wpdb.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $wbdb    The instance of the global wpdb.
		 */
		protected $wpdb;
		
		/**
		 * The instance of the database table that has user overridden islamic month days.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $month_days_table    The instance of the database table.
		 */
		protected $month_days_table;
		
		/**
		 * The instance of the database table that has islamic first date for the english month.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $month_firstdate_table    The instance of the database table.
		 */
		protected $month_firstdate_table;
				
		/**
		 * The instance of the xllentech english islamic calendar base options.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $xc_options    The instance of the base options.
		 */
		private $xc_options;
		
		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    2.0.0
		 */
		public function __construct() {
			
			global $wpdb;
			$this->wpdb = $wpdb;
			
			$this->month_days_table = $wpdb->prefix . 'month_days';
			$this->month_firstdate_table = $wpdb->prefix . 'month_firstdate';
			
			$this->xc_options = get_option("xc_options");
			if ( !is_array($this->xc_options) ) {
				Xllentech_Calendar_Plugin::verify_xc_options();
				$this->xc_options = get_option("xc_options");
			}
			
	
			/* ... */
			parent::__construct('xllentech_islamic_today_plugin',__('XllenTech Today', 'xllentech_calendar'),
			array( 'description' => __( 'Displays Today\'s English and Islamic Date', 'xllentech_calendar'),
				'before_widget' => '',
				'after_widget' => '',
				'before_title' => '',
				'after_title' => '' ) ); // Args
		}
		
		// widget form creation
		function form($instance) {

			// Check values
			if( $instance) {
				 $title = esc_attr($instance['title']);
			} else {
				 $title = '';
			}
			?>

			<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e( 'Widget Title', 'wp_widget_plugin' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php esc_html_e( $title, 'xllentech-calendar' ); ?>" />
			</p>

			<?php
		}

		
		function calculate_islamic_today( $english_date_array ) {

			$islamic_date_array[] = null;
			
			$islamic_month_days = explode(",", $this->xc_options['islamic_month_days']);
			
			if( isset( $english_date_array ) && array_key_exists ( 2, $english_date_array ) )
				$query = $this->wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $this->month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_date_array[2],  $english_date_array[1] );
			else
				return;
			
			$islamic_date_data = $this->wpdb->get_results( $query );
			
			if( count($islamic_date_data) > 0 ) {
				
				foreach( $islamic_date_data as $results ) {
					$islamic_day = $islamic_date_data[0]->islamic_day;
					$islamic_month = $islamic_date_data[0]->islamic_month;
					$islamic_year = $islamic_date_data[0]->islamic_year;
				}
				
			} else {

				$english_currentdate = date_create( '1-'. $english_date_array[1] .'-'. $english_date_array[2] );
				
				//If existing english month has no islamic first date in database, make new from previous month
				do_action( 'xc_calculate_islamic_date', $english_currentdate, 1 );
				
				$islamic_date_data = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $this->month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_date_array[2], $english_date_array[1] ) );
				
				if( count($islamic_date_data) > 0 ) {
					
					foreach( $islamic_date_data as $results ) {
						$islamic_day = $islamic_date_data[0]->islamic_day;
						$islamic_month = $islamic_date_data[0]->islamic_month;
						$islamic_year = $islamic_date_data[0]->islamic_year;
					}
					
				} else {
					return;
				}
			}
				
			$day = $islamic_day + ( $english_date_array[0] - 1 );

			if( $day > 28 ) {
				$islamic_month_days[$islamic_month] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_month], $islamic_month, $islamic_year );
			}
			
			if( $day > $islamic_month_days[$islamic_month] ){
				
				$day = $day - $islamic_month_days[$islamic_month];
				
				$islamic_month++;
				if( $islamic_month > 12 ) {
					$islamic_month = 1;
					$islamic_year++;
				}
				if( $day > 28 ) {
					$islamic_month_days[$islamic_month] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_month], $islamic_month, $islamic_year );
				}
				
				if( $day > $islamic_month_days[$islamic_month] ) {
					
					$day = $day - $islamic_month_days[$islamic_month];
					
					$islamic_month++;
					if( $islamic_month > 12 ) {
						$islamic_month = 1;
						$islamic_year++;
					}
				}
			}
			
			$islamic_date_array[0] = $day;
			$islamic_date_array[1] = $islamic_month;
			$islamic_date_array[2] = $islamic_year;
			
			return $islamic_date_array;
			
		} // end calculate_islamic_today()
	
		private function send_reminder_email( $today_islamic_date ) {

			if( $this->xc_options['calendar_email_choice'] == "Yes" ) {

				if( $this->xc_options['days_email_sent'] == 0 && $today_islamic_date[0] >= 29 ) {
					
					$site_url = get_site_url();
					
					$email_body="<html><body><h2>Islamic Month Days Override Form</h2>
					<p>Please check default number of days for the current Islamic Month on the Calendar on your website, Wait for the Moon News, If moon sighting is witnessed and If the number of days are same as the default shown in the Calendar, No action is required. </p> <p>If the number of days of the Islamic Month is proven to be different, Click on the appropriate button below to override existing number of days shown in the Calendar.</p>
					<table style='width:100%;'><tr><td>
					<form name='form29days' action='".esc_url($site_url)."/days?year_number=" . esc_html($today_islamic_date[2]) . "&month_number=" . esc_html($today_islamic_date[1]) . "&islamic_days=29' type='post'>
					<input name='days' type='hidden' value='29'>
					<input name='islamic_month' type='hidden' value='0'>
					<input name='islamic_year' type='hidden' value='0'>
					<button class='pure-button' type='submit' style='width:60%;height:35px;background:rgb(28,184,65);font-size: 125%;'>29 Days</button>
					</form></td><td></td>
					<td align><form action='". esc_url($site_url) ."/days?year_number=" . esc_html($today_islamic_date[2]) . "&month_number=" . esc_html($today_islamic_date[1]) . "&islamic_days=30' name='form30days' type='post'>
					<input name='days' type='hidden' value='30'>
					<input name='islamic_month' type='hidden' value='0'>
					<input name='islamic_year' type='hidden' value='0'>
					<button class='pure-button' type='submit' style='width:60%;height:35px;background:rgb(28,184,65);font-size: 125%;'>30 Days</button>
					</form></td></tr></table>
					<p>If you are not able to click on the links above, your email client doesn't allow you to view external link in your email. Please open this email in the browser to be able to click on it.</p>
					<p>Please note that you have received this email, because your email has been mentioned as the Calendar Admin on website: ". esc_url($site_url) .". If you are not the Admin, Please contact the Website Adminitrator to correct the information.</p>
					</body></html>";
					
					$to=$this->xc_options['calendar_admin_email'];
					
					$email_subject='Xllentech Calendar Islamic Month Days Override';
					// Always set content-type when sending HTML email
					$headers[] = "MIME-Version: 1.0";
					$headers[] = 'Content-type: text/html;charset=UTF-8';
								
					wp_mail($to,$email_subject,$email_body,$headers);
					$this->xc_options['days_email_sent']="1";
					update_option("xc_options",$this->xc_options);

				}	elseif( $today_islamic_date[0] <= 3 && $this->xc_options['days_email_sent'] == 1 ) {
					$this->xc_options['days_email_sent']="0";
					update_option("xc_options",$this->xc_options);
				}
			}
			
		}  //end funcion send_reminder_email
	
	
		// update widget
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			// Fields
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

			// display widget
		function widget($args, $instance) {

			extract( $args );
			
		   // these are the widget options
			$title = isset($instance['title'])?apply_filters('widget_title', $instance['title']) :"";
			
			wp_enqueue_style( 'xllentech-calendar-css' );
					
			//$output_dates = '';
			echo $before_widget;
		   // Display the widget

			// Check if title is set
			if ( $title ) {
				echo $before_title;
				echo esc_html($title);
				echo $after_title;
			}
			
			$islamic_months = explode(",", $this->xc_options['islamic_months']);
			$islamic_month_days = explode(",", $this->xc_options['islamic_month_days']);

			$english_currentdate=new DateTime( 'NOW', new DateTimeZone( $this->xc_options["xc_time_zone"] ) );
			
			$english_currentday = date_format($english_currentdate,'j');
			$english_currentmonth = date_format($english_currentdate,'n');
			$english_currentyear = date_format($english_currentdate,'Y');

		//	$english_currentmonth_days=date_format($english_currentdate,'t');
			$english_currentmonth_name=date_format($english_currentdate,'M');
			
			$english_date_array[0] = $english_currentday;
			$english_date_array[1] = $english_currentmonth;
			$english_date_array[2] = $english_currentyear;
			
			$islamic_date_array = $this->calculate_islamic_today( $english_date_array );
			
			if( $islamic_date_array == NULL ) {
				?>
				<p><strong>Sorry, There's an Error in Xllentech Today Widget. Plz contact support! Error: Function call for English to Islamic Date Conversion failed.</strong></p>
				<?php
			} else {
				?>
				<div class='xllentech-islamic-today'>
					<span class='xllentech-today-english-date-LTR xllentech_english_<?php echo esc_attr( $this->xc_options['xc_color_theme'] ); ?>'>
				
					<?php esc_html_e( $english_currentday, 'xllentech-calendar' ); echo "-"; echo esc_html( $english_currentmonth_name, 'xllentech-calendar' ); echo "-"; esc_html_e( $english_currentyear, 'xllentech-calendar' ); ?>
					</span>
				
					<span class='xllentech-today-spacing'></span>
					<span class='xllentech-today-islamic-date-LTR xllentech_islamic_<?php esc_attr( $this->xc_options['xc_color_theme'] ); ?>'>
						<?php esc_html_e( $islamic_date_array[0], 'xllentech-calendar' ); echo "-"; echo esc_html( $islamic_months[ $islamic_date_array[1] ] ); echo "-"; esc_html_e( $islamic_date_array[2], 'xllentech-calendar' ); ?>
				
					</span>
				</div>
			<?php }
			
			echo $after_widget;
		
			$this->send_reminder_email( $islamic_date_array );
		
		} //end function widget ()
		
	
	} //end class
	
} // end if class exists