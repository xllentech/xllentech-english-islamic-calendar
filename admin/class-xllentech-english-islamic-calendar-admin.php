<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and admin hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/admin
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */
 
 // Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Xllentech_English_Islamic_Calendar_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the Settings link on Plugins page in the Admin area.
	 *
	 * @since    2.4.0
	 */
	public function xc_plugin_add_settings_link ( $links ) {
	
		if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {
			$xc_settings_link = array(
			'<a href="' . admin_url( 'edit.php?post_type=xl_english_events&page=xllentech_options' ) . '">Settings</a>',	);
		} else {
			$xc_settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=xllentech_options' ) . '">Settings</a>',	);
		}
		return array_merge( $links, $xc_settings_link );
	}
	
	/**
	 * Register the Admin pages in the admin menu.
	 *
	 * @since    2.2.0
	 */
	public function xllentech_add_options_submenu_page() {
		
			//Add required admin files
		require XC_PLUGIN_DIR . 'admin/partials/class-xllentech-english-islamic-calendar-options.php';
		$options = new Xllentech_English_Islamic_Calendar_Options();

		require XC_PLUGIN_DIR . 'admin/partials/class-xllentech-english-islamic-calendar-monthnames.php';
		$monthnames = new Xllentech_English_Islamic_Calendar_Monthnames();

		require XC_PLUGIN_DIR . 'admin/partials/class-xllentech-english-islamic-calendar-monthdays.php';
		$monthdays = new Xllentech_English_Islamic_Calendar_Monthdays();

		require XC_PLUGIN_DIR . 'admin/partials/class-xllentech-english-islamic-calendar-troubleshooting.php';
		$troubleshooting = new Xllentech_English_Islamic_Calendar_Troubleshooting();
		
		if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {
			
			$xc_settings_page=add_submenu_page(
				  'edit.php?post_type=xl_english_events',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Settings', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options',                // admin page slug, e.g. options-general.php?page=xllentech_options
				  array( $options, 'xllentech_options_page' )           // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'edit.php?post_type=xl_english_events',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab2',      // admin page slug, e.g. options-general.php?page=xllentech_options_tab2
				  array( $monthdays, 'xllentech_options_tab2' )           // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'edit.php?post_type=xl_english_events',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab3',     // admin page slug, e.g. options-general.php?page=xllentech_options_tab3
				  array( $monthnames, 'xllentech_options_tab3' )           // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'edit.php?post_type=xl_english_events',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab4',    // admin page slug, e.g. options-general.php?page=xllentech_options_tab4 
				  array( $troubleshooting, 'xllentech_options_tab4' )           // callback function to display the options page
			);
			
		} else {
			
			$xc_settings_page=add_submenu_page(
				  //'edit.php?post_type=xllentech_calendar',          // admin page slug
				  'options-general.php',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options',                // admin page slug, e.g. options-general.php?page=xllentech_options
				  array( $options, 'xllentech_options_page' )            // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'options-general.php',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab2',      // admin page slug, e.g. options-general.php?page=xllentech_options_tab2
				  array( $monthdays, 'xllentech_options_tab2' )            // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'options-general.php',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab3',     // admin page slug, e.g. options-general.php?page=xllentech_options_tab3
				  array( $monthnames, 'xllentech_options_tab3' )           // callback function to display the options page
			);
			$xc_features_page=add_submenu_page(
				  'options-general.php',          // admin page slug
				  __( 'Xllentech Calendar Settings', 'xllentech-calendar' ), // page title
				  __( 'Xllentech Calendar', 'xllentech-calendar' ), // menu title
				  'manage_options',               // capability required to see the page
				  'xllentech_options_tab4',    // admin page slug, e.g. options-general.php?page=xllentech_options_tab4 
				  array( $troubleshooting, 'xllentech_options_tab4' )           // callback function to display the options page
			);
		}
	} //end function xllentech_add_options_submenu_page()
	
	/**
	 * Unregister Admin pages from the admin menu that should not be displayed, only Main option page displayed on menu.
	 *
	 * @since    2.0.0
	 */
	function xllentech_remove_menus() {
		if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {
			remove_submenu_page( 'edit.php?post_type=xl_english_events', 'xllentech_options_tab2' );
			remove_submenu_page( 'edit.php?post_type=xl_english_events', 'xllentech_options_tab3' );
			remove_submenu_page( 'edit.php?post_type=xl_english_events', 'xllentech_options_tab4' );
		} else {
			remove_submenu_page( 'options-general.php', 'xllentech_options_tab2' );
			remove_submenu_page( 'options-general.php', 'xllentech_options_tab3' );
			remove_submenu_page( 'options-general.php', 'xllentech_options_tab4' );
		}
	} // END xllentech_remove_menus()
	
	/**
	 * Store erros on activation.
	 *
	 * @since    2.5.0
	 */
	function xllentech_calendar_activation_error() {
		file_put_contents( XC_PLUGIN_DIR . '/error_activation.html', ob_get_contents() );
	}
	
	/**
	 * Add activation redirect to settings page.
	 *
	 * @since    2.4.0
	 */
	function xllentech_calendar_do_activation_redirect() {
	  // Bail if no activation redirect
		if ( !get_transient( '_xllentech_calendar_activation_redirect' ) ) {
		return;
		}

		// Delete the redirect transient
		delete_transient( '_xllentech_calendar_activation_redirect' );

	  // Bail if activating from network, or bulk
	  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	  }
	  // Redirect to options page
		if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) {
			wp_safe_redirect( add_query_arg( array( 'page' => 'xllentech_options' ), admin_url( 'edit.php?post_type=xl_english_events' ) ) );
		} else {
			wp_safe_redirect( add_query_arg( array( 'page' => 'xllentech_options' ), admin_url( 'options-general.php' ) ) );
		}
	}
	
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/xllentech-english-islamic-calendar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.6.0
	 */
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
		 */

		//wp_enqueue_script( 'common' );
		//wp_enqueue_script( 'wp-lists' );
        //wp_enqueue_script( 'postbox' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/xllentech-english-islamic-calendar-admin.js', array( 'jquery' ), $this->version, true );

	}
	
	/**
	 * Action to display Settings menu on each Settings page in Admin.
	 *
	 * @since    2.5.0
	 */
	function admin_header_menu( $page_title ) {

		$menu_class_active = 'nav-tab nav-tab-active';
		$menu_class_inactive = 'nav-tab';
		
		$options_class = $menu_class_inactive;
		$monthname_class = $menu_class_inactive;
		$monthdays_class = $menu_class_inactive;
		$troubleshooting_class = $menu_class_inactive;
		$pro_options_class = $menu_class_inactive;
		$datepicker_class = $menu_class_inactive;
			
		if( $page_title == 'Options' ) {
			$options_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Options</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} elseif( $page_title == 'Month-names' ) {
			$monthname_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Month Names</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} elseif( $page_title == 'Month-days' ) {
			$monthdays_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Month Days</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} elseif( $page_title == 'Troubleshooting' ) {
			$troubleshooting_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Troubleshooting</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} elseif( $page_title == 'Pro-options' ) {
			$pro_options_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Pro Options</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} elseif( $page_title == 'Datepicker' ) {
			$datepicker_class = $menu_class_active; ?>
				<h3 class="xc-admin-subtitle">Settings > Datepicker Options</h3>
			</div>
			<div class="wp-header-end xc-admin-clear"></div>
			<?php
		} else { 
			die( 'No script kiddies please!' ); 
		}
		
		if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) )
			$menu_path = 'edit.php?post_type=xl_english_events&';
		else
			$menu_path = 'options-general.php?';
		
		?>
		<h2 class="nav-tab-wrapper">
			<a class="<?php 
				echo $options_class; 
					?>" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_options') ); ?>">
			<?php _e( 'Options', 'xllentech-calendar' ); ?></a>
			
			<a class="<?php 
				echo $monthname_class; 
					?>" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_options_tab3') ); ?>">
			<?php _e( 'Month Names', 'xllentech-calendar' ); ?></a>
			
			<a class="<?php 
				echo $monthdays_class; 
					?>" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_options_tab2') ); ?>">
			<?php _e( 'Month Days', 'xllentech-calendar' ); ?></a>
			
			<a class="<?php 
				echo $troubleshooting_class; 
					?>" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_options_tab4') ); ?>">
			<?php _e( 'Troubleshooting', 'xllentech-calendar' ); ?></a>

			<?php if( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) { ?>
			<a class="<?php 
				echo $pro_options_class; 
					?> xllentech_pro_tab" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_pro_options') ); ?>">
			<?php _e( 'PRO Options', 'xllentech-calendar' ); ?></a>
			<?php } ?>
			
			<?php if( is_plugin_active( 'xllentech-datepicker/xllentech-datepicker.php' ) ) { ?>
			<a class="<?php 
				echo $datepicker_class; 
					?> xllentech_datepicker_tab" href="<?php echo esc_url( admin_url( $menu_path .'page=xllentech_datepicker_options') ); ?>">
			<?php _e( 'Datepicker Options', 'xllentech-calendar' ); ?></a>
			<?php } ?>
			
		</h2>
		
		<?php
	}
	
} // END Class Xllentech_English_Islamic_Calendar_Admin
