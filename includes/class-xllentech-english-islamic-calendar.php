<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.xllentech.com
 * @since      1.0.0
 *
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 */
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/includes
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */
class Xllentech_English_Islamic_Calendar extends WP_Widget {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.6.0
	 * @access   protected
	 * @var      Xllentech_English_Islamic_Calendar_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.6.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.6.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
	 * The instance of the xllentech calendar pro options.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $xc_pro_options    The instance of the pro options.
	 */
	 protected $xc_pro_options;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.6.0
	 */
	public function __construct() {
		if ( defined( 'XC_PLUGIN_VERSION' ) ) {
			$this->version = XC_PLUGIN_VERSION;
		} else {
			$this->version = '2.6.0';
		}
		$this->plugin_name = 'xllentech-english-islamic-calendar';

		global $wpdb;
        $this->wpdb = $wpdb;
		
		$this->month_days_table = $wpdb->prefix . 'month_days'; 
		$this->month_firstdate_table = $wpdb->prefix . 'month_firstdate';
		
		do_action( 'verify_xc_options' );
		$this->xc_options = get_option("xc_options");
		
		if ( is_array( get_option("xc_pro_options") ) ) {
			do_action( 'verify_xc_pro_options' );
			$this->xc_pro_options = get_option("xc_pro_options");
		}
		
		parent::__construct('xllentech_calendar', __('XllenTech Calendar', 'xllentech-calendar'), array( 'description' => __( 'Displays English Islamic Calendar', 'xllentech-calendar' ),
	        'before_widget' => '',
	        'after_widget' => '',
	        'before_title' => '',
	        'after_title' => '' ) ); // Args
			
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Xllentech_English_Islamic_Calendar_Loader. Orchestrates the hooks of the plugin.
	 * - Xllentech_English_Islamic_Calendar_i18n. Defines internationalization functionality.
	 * - Xllentech_English_Islamic_Calendar_Admin. Defines all hooks for the admin area.
	 * - Xllentech_English_Islamic_Calendar_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.6.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xllentech-english-islamic-calendar-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xllentech-english-islamic-calendar-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-xllentech-english-islamic-calendar-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-xllentech-english-islamic-calendar-public.php';

		$this->loader = new Xllentech_English_Islamic_Calendar_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Xllentech_English_Islamic_Calendar_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.6.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Xllentech_English_Islamic_Calendar_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

		
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.6.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Xllentech_English_Islamic_Calendar_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//Add settings link on Plugins page
		$this->loader->add_filter( 'plugin_action_links_' . XC_PLUGIN_BASENAME, $plugin_admin, 'xc_plugin_add_settings_link' );
		//register admin pages
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'xllentech_add_options_submenu_page' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'xllentech_remove_menus' );
		//store erros on activation
		$this->loader->add_action( 'activated_plugin', $plugin_admin, 'xllentech_calendar_activation_error' );
		// Admin Menu 
		$this->loader->add_action('xc-add-header-menu', $plugin_admin, 'admin_header_menu', 10, 1);
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.6.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Xllentech_English_Islamic_Calendar_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'verify-xc-options', $plugin_public, 'verify_xc_options' );
		$this->loader->add_action( 'xc_calculate_islamic_date', $plugin_public, 'calculate_islamic_date', 10, 2 );
		$this->loader->add_filter( 'xc_update_islamic_month_days', $plugin_public, 'check_and_update_days', 10, 3 );
		$this->loader->add_action( 'xc_display_base_header', $plugin_public, 'xc_display_base_header', 10, 4 );
		$this->loader->add_action( 'xc_display_base_body', $plugin_public, 'xc_display_base_body', 10, 4 );
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.6.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.6.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.6.0
	 * @return    Xllentech_English_Islamic_Calendar_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.6.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	// widget form creation
	function form($instance) {
		// Check values
		if( $instance)
			$title = esc_attr($instance['title']);
		else
			$title = '';
		
	?>
	<p>
		<label for="<?php _e( $this->get_field_id('title') ); ?>"><?php _e( 'Widget Title', 'xllentech-calendar' ); ?></label>
		<input class="widefat" id="<?php esc_attr_e( $this->get_field_id('title') ); ?>" name="<?php esc_attr_e( $this->get_field_name('title') ); ?>" type="text" value="<?php esc_html_e( $title, 'xllentech-calendar' ); ?>" />
	</p>
	<?php
	}
	
	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	private function handle_error($error) {
		return new WP_Error( 'broke', __( $error ) );
	}

	// display widget
	function widget($args, $instance) {

	   extract( $args );

	   // these are the widget options
	   $title = isset($instance['title'])?apply_filters('xllentech_calendar', $instance['title']) :"";

		//$output_calendar = '';
	   
	   echo $before_widget;
	   // Display the widget

	   // Check if title is set
	   if ( $title ) {
			echo $before_title;
			echo esc_html($title);
			echo $after_title;
	   }
		 
		$islamic_months = explode( ",", $this->xc_options['islamic_months'] );
		$islamic_month_days = explode( ",", $this->xc_options['islamic_month_days'] );
		$english_months = explode( ",", $this->xc_options['english_months'] );

		$english_currentdate = new DateTime( 'NOW', new DateTimeZone( $this->xc_options["xc_time_zone"] ) );
		$english_currentmonth = date_format( $english_currentdate,'n' );
		$english_currentyear = date_format( $english_currentdate,'Y' );

		$english_currentdate = date_create( '1-'.$english_currentmonth.'-'.$english_currentyear );
		
		$islamic_date_data = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $this->month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_currentyear, $english_currentmonth ) );

		$err_msg="";

		if( count($islamic_date_data) <= 0 ) {

			//If existing english month has no islamic first date in database, make new from previous month
			do_action( 'xc_calculate_islamic_date', $english_currentdate, 1 );

			$islamic_date_data = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT islamic_day, islamic_month, islamic_year FROM $this->month_firstdate_table WHERE english_year = %d AND english_month = %d", $english_currentyear, $english_currentmonth ) );
			if( count($islamic_date_data) <= 0 ) {
				$err_msg = $this->handle_error( '<p><strong>Oops, Looks like First Islamic Date is missing in the Xllentech Calendar, Plz Visit the FAQ on the wordpress plugin page or contact support for guidance.</strong></p>' );
				echo esc_html( $err_msg->get_error_message() );
				echo esc_html( $after_widget );
			//	_e( $output_calendar );
				return;
			}
		}

		foreach( $islamic_date_data as $result_data ) {
			$islamic_firstday=$result_data->islamic_day;
			$islamic_firstmonth=$result_data->islamic_month;
			$islamic_firstyear=$result_data->islamic_year;
		}

		$islamic_firstdate = date_create($islamic_firstday.'-'.$islamic_firstmonth.'-'.$islamic_firstyear);

		?>
		<div class='xllentech-calendar-widget'>
		<?php
		/**
		 * Detect if xllentech-english-islamic-calendar/ plugin exists and active
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		try {
			if ( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {
				
				$filepath = WP_PLUGIN_DIR . '/xllentech-calendar-pro/public/partials/pro-calculate-dates.php';
				if( file_exists( $filepath ) )
					require $filepath;
				else {
					_e( 'Required file missing in Xllentech Calendar Pro ADD-ON, You may have older version, Please update your ADD-ON or contact support.' );
					return;
				}
		
				//import Islamic events monthly from CPT
				$islamic_firstday = $islamic_grid_firstday .'-'. $islamic_grid_firstmonth .'-'. $islamic_grid_firstyear;
				$islamic_lastday = $idn .'-'. $islamic_currentmonth .'-'. $islamic_currentyear;
				$islamic_day_cpt_events = array();
				$islamic_day_cpt_events = apply_filters( 'xc_add_monthly_islamic_events', $islamic_day_cpt_events, $islamic_firstday, $islamic_lastday );
				
				//import English date events monthly from CPT
				$english_firstday = $english_last_month_firstday .'-'. $english_previous_month_number .'-'. $english_previous_year_number;
				$english_lastday = $edn .'-'. $english_next_month_number .'-'. $english_next_year_number;
				$english_day_cpt_events = array();
				$english_day_cpt_events = apply_filters( 'xc_add_monthly_english_events', $english_day_cpt_events, $english_firstday, $english_lastday, $english_currentmonth, $english_last_monthdays, $english_current_monthdays, $this->xc_options['xc_first_day'] );
				
				
				//import calendar display code
				do_action( 'xc_display_base_header_in_pro', $english_months[$english_currentmonth], $english_currentyear, $islamic_months[$islamic_firstmonth], $islamic_firstyear );
				
				$filepath = WP_PLUGIN_DIR . '/xllentech-calendar-pro/public/templates/display-calendar-pro-body.php';
				if( file_exists( $filepath ) )
					require $filepath;
				else {
					_e( 'Required file missing in Xllentech Calendar Pro ADD-ON, You may have older version, Please update your ADD-ON or contact support.');
					return;
				}

			} else {
				require XC_PLUGIN_DIR . 'public/partials/base-calculate-dates.php';
				
				
				do_action( 'xc_display_base_header', $english_months[$english_currentmonth], $english_currentyear, $islamic_months[$islamic_firstmonth], $islamic_firstyear );
				do_action( 'xc_display_base_body', $xllentech_english_css, $english_day_sequence, $xllentech_islamic_css, $islamic_day_sequence );
				
			}
		}	catch (Exception $e) {
			$err_msg = $this->handle_error( 'Error: Required file(s) missing in PRO ADD-ON! Please check if all files exists in the plugin folder OR Check if Xllentech English Islamic Calendar and Xllentech Calendar Pro are up-to-date. Otherwise Create ticket at plugin support.' );
			
			echo esc_html( $err_msg->get_error_message() );
			echo $after_widget;
			//_e( $output_calendar );
			return;
			// Or handle $e some other way instead of `exit`-ing, if you wish.
		}
		//_e( $output_calendar );
		
		?>
		</div>
		<?php
		echo $after_widget;

	} //end function widget
	
}
