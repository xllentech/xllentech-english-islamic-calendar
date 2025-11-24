<?php
/**
 *
 * The Month Days page of Xllentech_English_Islamic_Calendar Admin
 *
 * @link       https://www.xllentech.com
 * @package     Xllentech_English_Islamic_Calendar
 * @subpackage  Xllentech_English_Islamic_Calendar/admin/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.5.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

Class Xllentech_English_Islamic_Calendar_Monthdays {
	
	//Validate options before save settings
	function xeic_month_days_validate_values( $options ) {
		
		$validated_options = [];
		
		$validated_options['year_number'] = filter_var( $options["year_number"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['year_number'] ) return NULL;
		
		$validated_options['month_number'] = filter_var( $options["month_number"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['month_number'] ) return NULL;
		
		$validated_options['islamic_days'] = filter_var( $options["islamic_days"], FILTER_SANITIZE_NUMBER_INT );
		if( ! $validated_options['islamic_days'] ) return NULL;
		
		return $validated_options;
						
	}
	
	/**
	 * Build the Admin Settings-> Month Days page
	 */
	function xllentech_options_tab2() {
		
		global $wpdb;
		$month_days_table = $wpdb->prefix . 'month_days';
		$month_firstdate_table=$wpdb->prefix . 'month_firstdate';
		
		wp_create_nonce( 'xc-settings-add-month-days-nonce' );
		wp_create_nonce( 'xc-settings-delete-month-days-nonce' );
	?>
	<div class="wrap">
		<div class="xc-admin-title">
			<h2>XllenTech Calendar Settings</h2>
			
	<?php
		if( isset($_POST["add_monthdays"]) ) {
			
			if( ! empty( $_POST ) && check_admin_referer( 'xc-settings-add-month-days-action', 'xc-settings-add-month-days-nonce' ) && current_user_can( 'manage_options' ) ) {
				
				$validated_options = $this->xeic_month_days_validate_values( $_POST );
				
				if( $validated_options != NULL ) {

					$wpdb->replace( $month_days_table, array( 'month_number' => $validated_options["month_number"],
																	'year_number' => $validated_options["year_number"], 
																		'days' => $validated_options["islamic_days"] ), 
																			array( '%d', '%d', '%d' )
									);

					if($wpdb->last_error != '') {
					//	$wpdb->print_error();
						?>
						<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, Something went wrong, Please try again, Make sure Month, Year and Days are not duplicate to existing entry!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
						
					}	else { ?>
						<div class="updated notice is-dismissible"><p><strong><?php _e( 'You have successfully overridden Islamic Month Days, You should see the Calendar dates move accordingly!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
					}
					
				}	else { ?>
						<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, Looks like You did not enter correct data, Please try again, Make sure Month, Year and Days are not empty and integer value only!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
				}
				
			} else {
				?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
			}
			
		}	elseif( isset( $_POST["delete_monthdays"] ) ) {
			
			if( ! empty( $_POST ) && check_admin_referer( 'xc-settings-delete-month-days-action', 'xc-settings-delete-month-days-nonce' ) && current_user_can( 'manage_options' ) ) {
				
				$month_number = (int)$_POST['month_number'];
				$year_number = (int)$_POST['year_number'];
				$wpdb->delete( $month_days_table, array( 'month_number' => $month_number,
															'year_number' => $year_number ),
													array( '%d', '%d' )
							);

				if($wpdb->last_error != '') {
					//$wpdb->print_error();
					?>
						<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, Something went wrong, Please try again!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
				}
				else { ?>
					<div class="updated notice is-dismissible"><p><strong><?php _e( 'You have successfully Deleted the data row!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
				}
			} else {
				?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
			}
			
		}
		
		$xc_options = get_option("xc_options");
		
		$islamic_months = explode(",", $xc_options['islamic_months']);
		$islamic_month_days = explode(",", $xc_options['islamic_month_days']);
		
		//import header menu and sidebar
		do_action('xc-add-header-menu', 'Month-days'); 
		
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
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Update Islamic Month Days</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Update Islamic Month Days</span></h3>
						<div class="inside">
							<p>Use below form to override default number of days of islamic month on Calendar.</p>
							<form method="post" action="#">
								<ul class="xllentech-month-days">
									<li><label for="month_number">Month:</label>
									<select name="month_number">
										<option value="1">1 - <?php esc_html_e( $islamic_months[1], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="2">2 - <?php esc_html_e( $islamic_months[2], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="3">3 - <?php esc_html_e( $islamic_months[3], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="4">4 - <?php esc_html_e( $islamic_months[4], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="5">5 - <?php esc_html_e( $islamic_months[5], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="6">6 - <?php esc_html_e( $islamic_months[6], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="7">7 - <?php esc_html_e( $islamic_months[7], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="8">8 - <?php esc_html_e( $islamic_months[8], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="9">9 - <?php esc_html_e( $islamic_months[9], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="10">10 - <?php esc_html_e( $islamic_months[10], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="11">11 - <?php esc_html_e( $islamic_months[11], 'xllentech-english-islamic-calendar' ); ?></option>
										<option value="12">12 - <?php esc_html_e( $islamic_months[12], 'xllentech-english-islamic-calendar' ); ?></option>
									</select></li>
									<li><label for="year_number">Year:</label><input value="1443" type="number" name="year_number"/></li>
									<li><label for="islamic_days">Number of Days:</label>
									<select name="islamic_days" style="width:50px;">
										<option value="29">29</option>
										<option value="30">30</option></select> 
									</li>
									<li style="width:100%">
										<input type="hidden" name="add_monthdays" value="Y"/>
										
										<?php wp_nonce_field('xc-settings-add-month-days-action','xc-settings-add-month-days-nonce'); ?>
										
										<button type="submit" class="button-primary"><?php _e( 'Add to Database', 'xllentech-english-islamic-calendar' ); ?></button>
										
									</li>
								</ul>
							</form>
						</div>
					</div>

					<div class="postbox " id="section2">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Islamic Month Days Override Existing Entries</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Islamic Month Days Override Existing Entries</span></h3>
						<div class="inside">
							<table class="xllentech-settings-table" style="border: 1px solid #7d7d7d;border-collapse: collapse;">
							<tr>
								<th>Month</th><th>Year</th><th>Days</th><th>Delete</th>
							</tr>
					<?php 
						$month_data = $wpdb->get_results( "SELECT * FROM $month_days_table ORDER BY year_number DESC, month_number DESC" );
							foreach( $month_data as $islamic_date_data ) {
								?> 
									<tr>
										<td> <?php esc_html_e( $islamic_date_data->month_number, 'xllentech-english-islamic-calendar' ); ?></td>
										<td> <?php esc_html_e( $islamic_date_data->year_number, 'xllentech-english-islamic-calendar' ); ?></td>
										<td> <?php esc_html_e( $islamic_date_data->days, 'xllentech-english-islamic-calendar' ); ?></td>
								
										<td>
											<form method="post" action="#">
												<input type="hidden" name="month_number" value="<?php esc_html_e( $islamic_date_data->month_number, 'xllentech-english-islamic-calendar' ); ?>">
												<input type="hidden" name="year_number" value="<?php esc_html_e( $islamic_date_data->year_number, 'xllentech-english-islamic-calendar' ); ?>">
												<input type="hidden" name="delete_monthdays" value="Y">
												<?php wp_nonce_field( "xc-settings-delete-month-days-action", "xc-settings-delete-month-days-nonce" ); ?>
												<button type="submit" class="button-primary"><?php _e( 'Delete', 'xllentech-english-islamic-calendar' ); ?></button>
											</form>
										</td>
									</tr>
					<?php	}	?>
							</table>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<?php	
	}
	
}