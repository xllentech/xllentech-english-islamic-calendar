<?php
/**
 *
 * The Options page of Xllentech_English_Islamic_Calendar Admin
 *
 * @link       https://www.xllentech.com
 * @package     Xllentech_English_Islamic_Calendar
 * @subpackage  Xllentech_English_Islamic_Calendar/admin/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.5.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

Class Xllentech_English_Islamic_Calendar_Options {
	
	
	//Validate options before save settings
	function xeic_options_validate_values( $options ) {
		
		$xc_options = get_option( "xc_options" );
		
		$validated_options = [];
		
		$checkboxFields = array( 'xeic_email_choice' );
			
		foreach ( $checkboxFields as $cbField ) {
			$options[$cbField] = empty( $options[$cbField] ) ? 0 : 1;
		}
		
		$validated_options['calendar_email_choice'] = $options['xeic_email_choice'];
		
		//if( timezone_offset_get( $options['timezone_list'] ) )
		$timezone_array = explode( '/', $options['timezone_list'] );
		$valid_timezone[0] = filter_var( $timezone_array[0], FILTER_SANITIZE_STRING );
		$valid_timezone[1] = filter_var( $timezone_array[1], FILTER_SANITIZE_STRING );
		if( isset($valid_timezone[0]) && isset($valid_timezone[1]) )
			$validated_options['xc_time_zone'] = implode( '/', $valid_timezone );
		else
			return NULL;
		//$validated_options['xc_time_zone'] = strpos( $options['timezone_list'] , '/' )?$options['timezone_list']:'';
		
		
		$validated_options['calendar_admin_email'] = sanitize_email( $_POST["admin_email"] );
		$validated_options['xc_first_day'] = sanitize_text_field( $_POST['xc_first_day'] );
		$validated_options['xc_color_theme'] = sanitize_text_field( $_POST['xc_color_theme'] );
		$validated_options['xc_page_pin'] = (int)$_POST['page_pin'];
		
		return $validated_options;
						
	}
	
	// Get default plugin options
	function xeic_default_options() {
		
		//global $xllentech_salat_timings_options;
		$xc_options = get_option( "xc_options" );
		
		if ( ! is_array( $xc_options ) ) {
			
			$calendar_admin_email = get_option('admin_email');
			
			$xc_options = array(
				"islamic_months" => "Islamic Months,Muharram,Safar,Rabi'al Awwal,Rabi'al Thani,Jamadi'al Ula,Jamadi'al Thani,Rajab,Sha'ban,Ramadhan,Shawaal,Zul Qa'dah,Zul Hijjah",
				"islamic_month_days" => "12,30,29,30,29,30,29,30,29,30,29,30,29",
				"calendar_email_choice" => 0,
				"calendar_admin_email" => $calendar_admin_email,
				"days_email_sent" => 0,
				"xc_time_zone" => "America/Denver",
				"xc_page_pin" => 1234,
				"xc_color_theme" => "Default", 
				"xc_data_uninstall" => 0,
				"xc_first_day" => "Monday",
				"english_months" => "English Months,January,Febuary,March,April,May,June,July,August,September,October,November,December"	
			);
			
		}
		
		return $xc_options;
	}
	
	// Retrieve plugin options
	function xeic_get_option( $option ) {
		
		$xc_options = get_option( "xc_options" );
		
		if ( ! isset( $xc_options ) ) {
			$xc_options = $this->xeic_default_options();
		}
		
		return ( isset( $xc_options[$option] ) ? $xc_options[$option] : null );
	}

	// Save plugin options
	function xeic_save_options( $options ) {
		
		//$defaultOptions = $this->xeic_default_options();
		$xc_options = get_option( "xc_options" );
		
		return update_option( 'xc_options', array_merge( $xc_options, $options ) );
	}
	
	/**
	 * Build the Admin Settings-> Options page
	 */
	public function xllentech_options_page() {
		
	?>
		<div class="wrap">
			<div class="xc-admin-title">
				<h2>XllenTech Calendar Settings</h2>
			
			<?php
			
			if( isset( $_POST["update_xc_options_settings"] ) && current_user_can( 'manage_options' ) ) {
				
				if ( ! empty( $_POST ) && check_admin_referer( 'xeic-settings-options-action','xeic-settings-options-nonce' )  ) {
					
					$validated_options = $this->xeic_options_validate_values( $_POST );
					//print_r( $validated_options );
					//echo '</br>';
					$xc_options = get_option( "xc_options" );
					//print_r( $xc_options );
					echo '</br>';
					if( $validated_options == NULL ) {
						_e( '<div class="error notice is-dismissible"><p>' . __( 'Values validation failed, The settings not saved.', 'xllentech-english-islamic-calendar' ) . '</p></div>' );
					} else {
						
						$result = $this->xeic_save_options( $validated_options );
								
						if( $result == NULL )
							_e( '<div class="error notice is-dismissible"><p>' . __( 'Invalid values, The settings not saved.', 'xllentech-english-islamic-calendar' ) . '</p></div>' );
						else
							_e( '<div class="notice notice-success is-dismissible"><p>' . __( 'The settings have been saved.', 'xllentech-english-islamic-calendar' ) . '</p></div>' );
					
					}
					
				}
			}
			
			wp_create_nonce( 'xeic-settings-options-nonce' );
			
			//import header menu and sidebar
			do_action( 'xc-add-header-menu', 'Options' );
			
			$xc_options = get_option( "xc_options" );
		
			$site_url=get_site_url();
			$islamic_months = explode(",", $xc_options['islamic_months']);
			$islamic_month_days = explode(",", $xc_options['islamic_month_days']);
			$calendar_email_choice= $xc_options['calendar_email_choice'];
		?>	
			
			<div class="xllentech_sidebar">
					<?php include_once XC_PLUGIN_DIR . 'admin/partials/xllentech-english-islamic-calendar-admin-sidebar.php';?> 
			</div>
			<div id="poststuff" class="xllentech-calendar-settings">
				
				<div id="postbox-container-1" class="postbox-container">
			
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div id="section1" class="postbox">
							<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: General Options</span><span class="toggle-indicator" aria-hidden="true"></span></button>
							<h2 class="hndle"><span>General Options</span></h2>
							<div class="inside">
			
							<form method="post" action="#" id="xc_update_settings" name="xc_update_settings">
							<ul class="xllentech-options">
								<li>
									<label><strong><?php _e( 'Select TimeZone', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<select name="timezone_list" id="timezone_list">
									<?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
										foreach($tzlist as $timezone_list) {
									?>
										<option value="<?php echo esc_html( $timezone_list ); ?>" <?php if( $timezone_list == $xc_options['xc_time_zone'] ) echo 'selected'; ?> ><?php echo esc_html( $timezone_list ); ?></option>
										<?php } ?>
									</select>
								</li>
								<li>
									<label><strong><?php _e( 'First Day of Calendar', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<input type="radio" name="xc_first_day" value="Sunday" class="theme_select" 
									<?php if($xc_options['xc_first_day']=='Sunday') echo 'checked="checked"'; ?>>
									<?php _e( 'Sunday', 'xllentech-english-islamic-calendar' ); ?>&nbsp;&nbsp;&nbsp;</input>

									<input type="radio" name="xc_first_day" value="Monday" class="theme_select" 
									<?php if($xc_options['xc_first_day']=='Monday') echo 'checked="checked"'; ?>>
									<?php _e( 'Monday', 'xllentech-english-islamic-calendar' ); ?></input>
									
								</li>
								<li>
									<label><strong><?php _e( 'Color Theme', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<input type="radio" name="xc_color_theme" value="Default" class="theme_select" <?php 
										if( $xc_options['xc_color_theme'] == 'Default' ) echo 'checked="checked"'; 
									?>>Default<span class="theme_color_box" style="background-color:#838487;"></span>
									
									<input type="radio" name="xc_color_theme" value="Blue" class="theme_select"	<?php 
										if( $xc_options['xc_color_theme'] == 'Blue' ) echo 'checked="checked"'; 
									?>>Blue<span class="theme_color_box" style="background-color:#4c6a92;"></span>
									
									<input type="radio" name="xc_color_theme" value="Red" class="theme_select" <?php 
										if( $xc_options['xc_color_theme'] == 'Red' ) echo 'checked="checked"'; 
									?>>Red<span class="theme_color_box" style="background-color:#b93a32;"></span>
									
									<span style="white-space:nowrap">
										<input type="radio" name="xc_color_theme" value="Green" class="theme_select" <?php 
											if( $xc_options['xc_color_theme'] == 'Green' ) echo 'checked="checked"'; 
									?>>Green<span class="theme_color_box" style="background-color:#008000;"></span>
									</span>
									
								</li>
								<li>
									<label><strong><?php _e( 'Email Feature', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<p align="justify"><?php _e( 'For this feature to work, you are required to create a page titled Days, Put the shortcode [xllentech-islamic-days] in it. Once the page is published, you can click buttons in the sample email below to make sure buttons take you to the page correctly.', 'xllentech-english-islamic-calendar' ); ?>
									<p align='justify'><?php _e( 'If the Enable Email is checked, Every 29th of Islamic Month, Email will be sent out to the Calendar Admin Email with the link. Clicking the 29 or 30 Days link in the email will take you to your website page, that will override islamic month days accordingly. Sample Email shown at bottom.', 'xllentech-english-islamic-calendar' ); ?> </p>
								</li>
								<li>
									<label><strong><?php _e( 'Enable Email', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<input type='checkbox' name='xeic_email_choice' id='xeic_email_choice' <?php 
										($xc_options['calendar_email_choice']>0)?" checked='checked'":""; ?> />
								</li>
								<li>
									<label><strong><?php _e( 'Calendar Admin Email', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<input type='text' name='admin_email' id='admin_email' value='<?php echo esc_html( $xc_options['calendar_admin_email'] ); ?>' style="width: 220px;"/>
								</li>
								<li>
									<label><strong><?php _e( 'Page PIN', 'xllentech-english-islamic-calendar' ); ?>: </strong></label>
									<input type='number' required size="6" maxlength="6" name="page_pin" id="page_pin" value="<?php echo esc_html( $xc_options['xc_page_pin'] ); ?>" />
								</li>
								<li>
									<input type='hidden' name='update_xc_options_settings' value='Y' />
									<button type="submit" class="button-primary"><?php _e( 'Save Settings', 'xllentech-english-islamic-calendar' ); ?></button>
									<?php wp_nonce_field( 'xeic-settings-options-action','xeic-settings-options-nonce' ); ?>
								</li>
								</ul>
								
							</form>
							</div>
						</div>
				
						<div id="section2" class="postbox">
							<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Sample Email</span><span class="toggle-indicator" aria-hidden="true"></span></button>
							<h3 class="hndle"><span><?php _e( 'Sample Email', 'xllentech-english-islamic-calendar' ); ?></span></h3>
							<div class="inside">
								<div class="tab3-sample-email">
							
									<h4>Islamic Month Days Override Form</h4>
									<p align="justify"><?php _e( 'Please check default number of days for the current Islamic Month on the Calendar on your website, If moon sighting is witnessed to be the same as the default shown in the Calendar, No action is required', 'xllentech-english-islamic-calendar' ); ?>. </p> 
									<p><?php _e( 'If the number of days of the Islamic Month is proven to be different, Click on the appropriate button below to override existing number of days shown in the Calendar', 'xllentech-english-islamic-calendar' ); ?>.</p>
									<table style='width:100%;'><tr><td>
									
									<form name='form29days' action="<?php echo esc_url($site_url); ?>/days" method='get' target="_blank">
									<input name='islamic_days' type='hidden' value='29'>
									<input name='month_number' type='hidden' value='2'>
									<input name='year_number' type='hidden' value='1443'>
									<button class='pure-button' type='submit' style='width:60%;height:35px;background:rgb(28,184,65);font-size: 125%;'>29 Days</button>
									</form></td><td></td>
									<td align><form name='form30days' action="<?php echo esc_url($site_url); ?>/days" method='get' target="_blank">
									<input name='islamic_days' type='hidden' value='30'>
									<input name='month_number' type='hidden' value='2'>
									<input name='year_number' type='hidden' value='1443'>
									<button class='pure-button' type='submit' style='width:60%;height:35px;background:rgb(28,184,65);font-size: 125%;'>30 Days</button>
									</form></td></tr></table>
									<p align="justify"><?php _e( 'If you are not able to click on the links above, your email client doesn\'t allow you to view external link in your email. Please open this email in the browser to be able to click on it.', 'xllentech-english-islamic-calendar' ); ?></p>
									<p align="justify"><?php _e( 'Please note that you have received this email, because your email has been mentioned as the Calendar Admin on website:', 'xllentech-english-islamic-calendar' ); _e( esc_url($site_url) );?>. <?php _e( 'If you are not the Admin, Please contact the Website Adminitrator to correct the information.', 'xllentech-english-islamic-calendar' ); ?></p>
								</div>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}