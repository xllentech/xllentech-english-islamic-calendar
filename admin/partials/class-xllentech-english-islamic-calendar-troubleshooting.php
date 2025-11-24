<?php
/**
 *
 * The Troubleshooting page of Xllentech_English_Islamic_Calendar Admin
 *
 * @link       https://www.xllentech.com
 * @package     Xllentech_English_Islamic_Calendar
 * @subpackage  Xllentech_English_Islamic_Calendar/admin/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.5.0
 */
 
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

Class Xllentech_English_Islamic_Calendar_Troubleshooting {
	
	//Validate options before save
	function xeic_troubleshooting_validate_values( $options ) {
		
		$validated_options = [];
		
		$validated_options['english_month'] = filter_var( $options["english_month"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['english_month'] || $validated_options['english_month'] < 1 || $validated_options['english_month'] > 12 ) return NULL;
		
		$validated_options['english_year'] = filter_var( $options["english_year"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['english_year'] || $validated_options['english_year'] < 2018 || $validated_options['english_year'] > 9999 ) return NULL;
		
		$validated_options['islamic_year'] = filter_var( $options["islamic_year"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['islamic_year'] || $validated_options['islamic_year'] < 1440 || $validated_options['islamic_year'] >9999 ) return NULL;
		
		$validated_options['islamic_month'] = filter_var( $options["islamic_month"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['islamic_month'] || $validated_options['islamic_month'] < 1 || $validated_options['islamic_month'] > 12 ) return NULL;
		
		$validated_options['islamic_day'] = filter_var( $options["islamic_day"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['islamic_day'] || $validated_options['islamic_day'] > 30 || $validated_options['islamic_day'] < 1 ) return NULL;
		
		return $validated_options;
						
	}
	
	/**
	 * Build the Admin Settings-> Troubleshooting page
	 */
	function xllentech_options_tab4() {
		global $wpdb;
		$month_days_table = $wpdb->prefix . 'month_days';
		$month_firstdate_table = $wpdb->prefix . 'month_firstdate';

		$xc_options = get_option("xc_options");
		
		wp_create_nonce( 'xc-troubleshooting-data-nonce' );
		wp_create_nonce( 'xc-troubleshooting-delete-date-nonce' );
		wp_create_nonce( 'xc-troubleshooting-add-date-nonce' );
	?>
	<div class="wrap">
		
		<div class="xc-admin-title">
			<h2>XllenTech Calendar Settings</h2>
			

	<?php
		if( isset( $_POST["update_xc_troubleshooting"] ) && current_user_can( 'manage_options' ) ) {
			
			if( ! empty( $_POST ) && check_admin_referer( 'xc-troubleshooting-data-action','xc-troubleshooting-data-nonce' ) ) {
				
				$checkboxFields = array( 'xc_data_uninstall' );
			
				foreach ( $checkboxFields as $cbField ) {
					$xc_options[$cbField] = ( empty( $_POST[$cbField] ) ? 0 : 1 );
				}
				
				update_option("xc_options",$xc_options);
				?>
				<div class="updated notice is-dismissible"><p><strong><?php _e( 'Settings Saved!', 'xllentech-calendar' ); ?></strong></p></div> <?php
			} else {
				?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-calendar' ); ?></strong></p></div> <?php
			}
		}	elseif( isset( $_POST["delete_firstdate"] ) && current_user_can( 'manage_options' ) ) {
			
			if( !empty( $_POST ) && check_admin_referer( 'xc-troubleshooting-delete-date-action','xc-troubleshooting-delete-date-nonce' ) ) {
				
				$year_number = filter_var( $_POST["year_number"], FILTER_SANITIZE_NUMBER_INT );
				$month_number = filter_var($_POST["month_number"], FILTER_SANITIZE_NUMBER_INT);
				
				$wpdb->delete( $month_firstdate_table, array( 'english_month' => $month_number, 'english_year' => $year_number ), array( '%d', '%d' ) ); 
				if( $wpdb->last_error != '' ) {
					// $wpdb->print_error();
					?>
					<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, Something went wrong, Please try again!', 'xllentech-calendar' ); ?></strong></p></div> 
					<?php
				}	else { ?>
					<div class="updated notice is-dismissible"><p><strong><?php _e( 'You have successfully Deleted the data row!', 'xllentech-calendar' ); ?></strong></p></div> <?php
				}
			} else {
				?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-calendar' ); ?></strong></p></div> <?php
			}
				
		}	elseif( isset($_POST["add_firstdate"]) && current_user_can( 'manage_options' ) ) {
			
			if( !empty( $_POST ) && check_admin_referer( 'xc-troubleshooting-add-date-action','xc-troubleshooting-add-date-nonce' ) ) {
					// Do the saving
				
				$validated_options = $this->xeic_troubleshooting_validate_values( $_POST );
				
				if( $validated_options != NULL ) {

					$wpdb->replace( $month_firstdate_table, array( 'english_month' => $validated_options["english_month"],
																		'english_year' => $validated_options["english_year"], 
																			'islamic_day' => $validated_options["islamic_day"], 
																				'islamic_month' => $validated_options["islamic_month"], 
																					'islamic_year' => $validated_options["islamic_year"] ), 
															array('%d','%d','%d','%d','%d') );

					if($wpdb->last_error != '') {
						//$wpdb->print_error(); 
						?>
						<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, something went wrong, please try again!', 'xllentech-calendar' ); ?></strong></p></div> 
						<?php
					}	else { ?>
						<div class="updated notice is-dismissible"><p><strong><?php _e( 'You have successfully Added Data row!', 'xllentech-calendar' ); ?></strong></p></div> <?php
					}
					
				} else { ?>
							<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, looks like you did not enter correct data. Please try again, make sure Month, Year and Day are not empty and integer value only!', 'xllentech-calendar' ); ?></strong></p></div> <?php
				}
				
			} else {
				?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, security check failed!', 'xllentech-calendar' ); ?></strong></p></div> <?php
			}
		}
		
		//$xc_options = get_option("xc_options");
		
		//import header menu and sidebar
		do_action('xc-add-header-menu', 'Troubleshooting' );
		
	?>
		
		<div class="xllentech_sidebar">
				<?php include_once XC_PLUGIN_DIR . 'admin/partials/xllentech-english-islamic-calendar-admin-sidebar.php';?> 
		</div>
		<div id="poststuff" class="xllentech-calendar-settings">
			<div id="postbox-container" class="postbox-container">
				<?php 
				//<div class="xllentech_sidebar">include_once XC_PLUGIN_DIR . 'admin/sidebar.php'; </div>?>
			
				<div class="meta-box-sortables ui-sortable" id="normal-sortables">
					<div class="postbox " id="section1">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Uninstall Option</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Uninstall Option</span></h3>
						<div class="inside">
							<form method="post" action="#">
								<ul class="xllentech-troubleshooting">
									<li>
										<label><strong>Delete Data on Uninstall: </strong></label>
										<input type='checkbox' name='xc_data_uninstall' id='xc_data_uninstall' <?php 
										if( $xc_options['xc_data_uninstall']!='No' ): echo 'value="Yes" checked'; else: echo 'value="No"'; endif; 
										?> />
									</li>
									<li>
										<input type='hidden' name='update_xc_troubleshooting' value='Y' />
										<?php wp_nonce_field('xc-troubleshooting-data-action','xc-troubleshooting-data-nonce'); ?>
										
										<button type="submit" class="button-primary"><?php _e( 'Save Setting', 'xllentech-english-islamic-calendar' ); ?></button>
									</li>
								</ul>
							</form>
						</div>
					</div>
					
					<div class="postbox " id="section2">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Existing Month First Date Entries</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Existing Month First Date Entries</span></h3>
						<div class="inside">
							<h4>TROUBLESHOOTING Purpose Only: <br>DO NOT Add OR Delete anythings in below form.. The purpose of displaying below data is only for troubleshooting. I Recommend <a href="https://wordpress.org/support/plugin/xllentech-english-islamic-calendar" target="_blank">Submit a Support Ticket</a> for any issue you may have. Changing below data may break down the Calendar.</h4>
							<table class="xllentech-settings-table" style="border: 1px solid #7d7d7d;border-collapse: collapse;">
								<tr>
									<th>Month</th><th>Year</th><th>Islamic Day</th><th>Islamic Month</th><th>Islamic Year</th><th>Action</th>
								</tr>
				<?php 
					$month_data = $wpdb->get_results( "SELECT * FROM $month_firstdate_table ORDER BY english_year DESC, english_month DESC" );
						foreach( $month_data as $islamic_date_data ) {
							?>
								<tr>
									<td><?php echo esc_html( $islamic_date_data->english_month ); ?></td>
									<td><?php echo esc_html( $islamic_date_data->english_year ); ?></td>
									<td><?php echo esc_html(  $islamic_date_data->islamic_day ); ?></td>
									<td><?php echo esc_html(  $islamic_date_data->islamic_month ); ?></td>
									<td><?php echo esc_html( $islamic_date_data->islamic_year ); ?></td>

									<td>
										<form method="post" action="#">
											<input type="hidden" name="month_number" value="<?php echo esc_html( $islamic_date_data->english_month ); ?>">
											<input type="hidden" name="year_number" value="<?php echo esc_html( $islamic_date_data->english_year ); ?>">
											<input type="hidden" name="delete_firstdate" value="Y">
											<?php wp_nonce_field( "xc-troubleshooting-delete-date-action", "xc-troubleshooting-delete-date-nonce" ); ?>
											<button type="submit" class="button-primary"><?php _e( 'Delete', 'xllentech-english-islamic-calendar' ); ?></button>
										</form>
									</td>
								</tr>
				<?php	}	?>
							</table>
								<form method="post" action="#">
								<table class="xllentech-settings-table" style="border: 1px solid #7d7d7d;border-collapse: collapse;">
									<tr>
										<td style="padding-right:0px"><input style="width:50px" type="number" required name="english_month" id="english_month"></td>
										<td style="padding-right:0px"><input style="width:70px" type="number" required name="english_year" id="english_year"></td>
										<td><input style="width: 80px" type="number" required name="islamic_day" id="islamic_day"></td>
										<td><input style="width: 80px" type="number" required name="islamic_month" id="islamic_month"></td>
										<td><input style="width: 86px" type="number" required name="islamic_year" id="islamic_year"></td>
										<td><input class="xc_textbox" type="hidden" name="add_firstdate" value="Y">
										
										<?php wp_nonce_field('xc-troubleshooting-add-date-action','xc-troubleshooting-add-date-nonce'); ?>
										
										<button type="submit" class="button-primary"><?php _e( 'Add', 'xllentech-english-islamic-calendar' ); ?></button>
										</td>
									</tr>
								</table>
								</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	} // End function
}