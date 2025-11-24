<?php
/**
 *
 * The Month Names page of Xllentech_English_Islamic_Calendar Admin
 *
 * @link       https://www.xllentech.com
 * @package     Xllentech_English_Islamic_Calendar
 * @subpackage  Xllentech_English_Islamic_Calendar/admin/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.5.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

Class Xllentech_English_Islamic_Calendar_Monthnames {
	
	// Validate values before saved
	function xeic_month_names_validate_islamic_values( $options ) {
		
		if( ! empty( $options["islamic_months1"] ) && ! empty( $options["islamic_months2"] )
			&& ! empty( $options["islamic_months3"] ) && ! empty( $options["islamic_months4"] ) && ! empty( $options["islamic_months5"] )
			&& ! empty( $options["islamic_months6"] ) && ! empty( $options["islamic_months7"] ) && ! empty( $options["islamic_months8"] )
			&& ! empty( $options["islamic_months9"] ) && ! empty( $options["islamic_months10"] ) 
			&& ! empty( $options["islamic_months11"] ) && ! empty( $options["islamic_months12"]) ) {
				
				$options["islamic_months1"] = filter_var( $options["islamic_months1"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months2"] = filter_var( $options["islamic_months2"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months3"] = filter_var( $options["islamic_months3"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months4"] = filter_var( $options["islamic_months4"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months5"] = filter_var( $options["islamic_months5"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months6"] = filter_var( $options["islamic_months6"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months7"] = filter_var( $options["islamic_months7"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months8"] = filter_var( $options["islamic_months8"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months9"] = filter_var( $options["islamic_months9"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months10"] = filter_var( $options["islamic_months10"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months11"] = filter_var( $options["islamic_months11"], FILTER_SANITIZE_STRIPPED );
				$options["islamic_months12"] = filter_var( $options["islamic_months12"], FILTER_SANITIZE_STRIPPED );
			
				return $options;
				
		} else {
			return NULL;
		}
		
	}
	
	// Validate values before saved
	function xeic_month_names_validate_english_values( $options ) {
		
		if( ! empty( $options["english_months1"] ) && ! empty( $options["english_months2"] )
			&& ! empty( $options["english_months3"] ) && ! empty( $options["english_months4"] ) && ! empty( $options["english_months5"] )
			&& ! empty( $options["english_months6"] ) && ! empty( $options["english_months7"] ) && ! empty( $options["english_months8"] )
			&& ! empty( $options["english_months9"] ) && ! empty( $options["english_months10"] ) 
			&& ! empty( $options["english_months11"] ) && ! empty( $options["english_months12"]) ) {
				
				$options["english_months1"] = filter_var( $options["english_months1"], FILTER_SANITIZE_STRIPPED );
				$options["english_months2"] = filter_var( $options["english_months2"], FILTER_SANITIZE_STRIPPED );
				$options["english_months3"] = filter_var( $options["english_months3"], FILTER_SANITIZE_STRIPPED );
				$options["english_months4"] = filter_var( $options["english_months4"], FILTER_SANITIZE_STRIPPED );
				$options["english_months5"] = filter_var( $options["english_months5"], FILTER_SANITIZE_STRIPPED );
				$options["english_months6"] = filter_var( $options["english_months6"], FILTER_SANITIZE_STRIPPED );
				$options["english_months7"] = filter_var( $options["english_months7"], FILTER_SANITIZE_STRIPPED );
				$options["english_months8"] = filter_var( $options["english_months8"], FILTER_SANITIZE_STRIPPED );
				$options["english_months9"] = filter_var( $options["english_months9"], FILTER_SANITIZE_STRIPPED );
				$options["english_months10"] = filter_var( $options["english_months10"], FILTER_SANITIZE_STRIPPED );
				$options["english_months11"] = filter_var( $options["english_months11"], FILTER_SANITIZE_STRIPPED );
				$options["english_months12"] = filter_var( $options["english_months12"], FILTER_SANITIZE_STRIPPED );
			
				return $options;
				
		}	else {
			return NULL;
		}
		
	}
	
	/**
	 * Build the Admin Settings-> Month-names page
	 */
	function xllentech_options_tab3() {
		global $wpdb;
		$month_days_table = $wpdb->prefix . 'month_days';
		
		$xc_options = get_option("xc_options");
		
		wp_create_nonce( 'xc-settings-islamic-month-names-nonce' );
		wp_create_nonce( 'xc-settings-english-month-names-nonce' );
		
		?>
	<div class="wrap">
		<div class="xc-admin-title">
			<h2>XllenTech Calendar Settings</h2>
			
	<?php

	if( isset( $_POST["islamic_months_update"] ) && current_user_can( 'manage_options' ) ) {
		
		if( ! empty( $_POST ) && check_admin_referer( 'xc-settings-islamic-month-names-action','xc-settings-islamic-month-names-nonce' ) ) {
			
			$validated_options = $this->xeic_month_names_validate_islamic_values( $_POST );
			
			if( $validated_options != NULL ) {
				
				$new_islamic_months = 'Islamic Months,' . $validated_options["islamic_months1"] . ',' . $validated_options["islamic_months2"] . ',' . $validated_options["islamic_months3"] . ',' . $validated_options["islamic_months4"] . ',' . $validated_options["islamic_months5"] . ',' . $validated_options["islamic_months6"] . ',' . $validated_options["islamic_months7"] . ',' . $validated_options["islamic_months8"] . ',' . $validated_options["islamic_months9"] . ',' . $validated_options["islamic_months10"] . ',' . $validated_options["islamic_months11"] . ',' . $validated_options["islamic_months12"];
				
				$new_islamic_months = stripslashes( $new_islamic_months );
				
				$xc_options['islamic_months'] = $new_islamic_months;
				update_option("xc_options", $xc_options);
			?>
				<div class="updated notice is-dismissible"><p><strong><?php _e( 'New Islamic Month Names Saved!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
			}	else {	?>
				<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, You can not leave month name empty, Please try again!','xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
			}
			
		} else {
			?>
			<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-calendar' ); ?></strong></p></div> <?php
		}
		
	} elseif ( isset( $_POST["english_months_update"] ) && current_user_can( 'manage_options' ) ) {

		if( ! empty( $_POST ) && check_admin_referer( 'xc-settings-english-month-names-action','xc-settings-english-month-names-nonce' )  ) {
				
				$validated_options = $this->xeic_month_names_validate_english_values( $_POST );
				
				if( $validated_options != NULL ) {
					
					$new_english_months = 'English Months,'.$validated_options["english_months1"].','.$validated_options["english_months2"].','.$validated_options["english_months3"].','.$validated_options["english_months4"].','.$validated_options["english_months5"].','.$validated_options["english_months6"].','.$validated_options["english_months7"].','.$validated_options["english_months8"].','.$validated_options["english_months9"].','.$validated_options["english_months10"].','.$validated_options["english_months11"].','.$validated_options["english_months12"];
					
					$new_english_months = stripslashes( $new_english_months );
					
					$xc_options['english_months'] = $new_english_months;
					
					update_option( "xc_options",$xc_options );
				?>
					<div class="updated notice is-dismissible"><p><strong><?php _e( 'New English Month Names Saved!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
				}
				else {	?>
					<div class="error notice is-dismissible"><p><strong><?php _e( 'Oops, You can not leave month name empty, Please try again!','xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
				}
		} else {
			?>
			<div class="error notice is-dismissible"><p><strong><?php _e( 'Not saved, Security check failed!', 'xllentech-english-islamic-calendar' ); ?></strong></p></div> <?php
		}
	}

		$islamic_months = explode(",", $xc_options['islamic_months']);
		$islamic_month_days = explode(",", $xc_options['islamic_month_days']);
		$english_months = explode(",", $xc_options['english_months']);
		
		//import header menu and sidebar
		do_action('xc-add-header-menu', 'Month-names' );
		
	?>
		
		<div class="xllentech_sidebar">
				<?php include_once XC_PLUGIN_DIR . 'admin/partials/xllentech-english-islamic-calendar-admin-sidebar.php'; ?> 
		</div>		
		<div id="poststuff" class="xllentech-calendar-settings">
			<div id="postbox-container" class="postbox-container">
				<?php 
				//<div class="xllentech_sidebar">include_once XC_PLUGIN_DIR . 'admin/sidebar.php'; </div>?>
			
				<div class="meta-box-sortables ui-sortable" id="normal-sortables">
					<div class="postbox " id="section1">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Customize Islamic Month Names</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Customize Islamic Month Names</span></h3>
						<div class="inside">

							<p>Change Islamic month names as you like here and save to customize!</p>
							<form method="post" action="#">
								<ul class="xllentech-month-names">
									<li>
										<label for="islamic_months1">1</label>
										<input type="text" required name="islamic_months1" value="<?php echo esc_html( $islamic_months[1] ); ?>" />
									</li>
									<li>
										<label for="islamic_months2">2</label>
										<input type="text" required name="islamic_months2" value="<?php echo esc_html( $islamic_months[2] ); ?>" />
									</li>
									<li>
										<label for="islamic_months3">3</label>
										<input type="text" required name="islamic_months3" value="<?php echo esc_html( $islamic_months[3] ); ?>" />
									</li>
									<li>
										<label for="islamic_months4">4</label>
										<input type="text" required name="islamic_months4" value="<?php echo esc_html( $islamic_months[4] ); ?>" />
									</li>
									<li>
										<label for="islamic_months5">5</label>
										<input type="text" required name="islamic_months5" value="<?php echo esc_html( $islamic_months[5] ); ?>" />
									</li>
									<li>
										<label for="islamic_months6">6</label>
										<input type="text" required name="islamic_months6" value="<?php echo esc_html( $islamic_months[6] ); ?>" />
									</li>
									<li>
										<label for="islamic_months7">7</label>
										<input type="text" required name="islamic_months7" value="<?php echo esc_html( $islamic_months[7] ); ?>" />
									</li>
									<li>
										<label for="islamic_months8">8</label>
										<input type="text" required name="islamic_months8" value="<?php echo esc_html( $islamic_months[8] ); ?>" />
									</li>
									<li>
										<label for="islamic_months8">9</label>
										<input type="text" required name="islamic_months9" value="<?php echo esc_html( $islamic_months[9] ); ?>" />
									</li>
									<li>
										<label for="islamic_months10">10</label>
										<input type="text" required name="islamic_months10" value="<?php echo esc_html( $islamic_months[10] ); ?>" />
									</li>
									<li>
										<label for="islamic_months11">11</label>
										<input type="text" required name="islamic_months11" value="<?php echo esc_html( $islamic_months[11] ); ?>" />
									</li>
									<li>
										<label for="islamic_months12">12</label>
										<input type="text" required name="islamic_months12" value="<?php echo esc_html( $islamic_months[12] ); ?>" />
									</li>
									<li style="width:100%">
										<input type="hidden" name="islamic_months_update" value="Y"/>
										<?php wp_nonce_field( 'xc-settings-islamic-month-names-action','xc-settings-islamic-month-names-nonce' ); ?>
										
										<button type="submit" class="button-primary"><?php _e( 'Save Names', 'xllentech-english-islamic-calendar' ); ?></button>
										
									</li>
								</ul>
							</form>
						</div>
					</div>
					
					<div class="postbox " id="section2">
						<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Customize English Month Names</span><span class="toggle-indicator" aria-hidden="true"></span></button>
						<h3 class="hndle"><span>Customize English Month Names</span></h3>
						<div class="inside">
						
							<p>Change English month names as you like here and save to customize!</p>
							<form method="post" action="#">
								<ul class="xllentech-month-names">
								<li><label for="english_months1">1</label><input type="text" required name="english_months1" value="<?php echo esc_html( $english_months[1] ); ?>" /></li>
								<li><label for="english_months2">2</label><input type="text" required name="english_months2" value="<?php echo esc_html( $english_months[2] ); ?>" /></li>
								<li><label for="english_months3">3</label><input type="text" required name="english_months3" value="<?php echo esc_html( $english_months[3] ); ?>" /></li>
								<li><label for="english_months4">4</label><input type="text" required name="english_months4" value="<?php echo esc_html( $english_months[4] ); ?>" /></li>
								<li><label for="english_months5">5</label><input type="text" required name="english_months5" value="<?php echo esc_html( $english_months[5] ); ?>" /></li>
								<li><label for="english_months6">6</label><input type="text" required name="english_months6" value="<?php echo esc_html( $english_months[6] ); ?>" /></li>
								<li><label for="english_months7">7</label><input type="text" required name="english_months7" value="<?php echo esc_html( $english_months[7] ); ?>" /></li>
								<li><label for="english_months8">8</label><input type="text" required name="english_months8" value="<?php echo esc_html( $english_months[8] ); ?>" /></li>
								<li><label for="english_months9">9</label><input type="text" required name="english_months9" value="<?php echo esc_html( $english_months[9] ); ?>" /></li>
								<li><label for="english_months10">10</label><input type="text" required name="english_months10" value="<?php echo esc_html( $english_months[10] ); ?>" /></li>
								<li><label for="english_months11">11</label><input type="text" required name="english_months11" value="<?php echo esc_html( $english_months[11] ); ?>" /></li>
								<li><label for="english_months12">12</label><input type="text" required name="english_months12" value="<?php echo esc_html( $english_months[12] ); ?>" /></li>
								
								<li style="width:100%">
									<input type="hidden" name="english_months_update" value="Y"/>
									<?php wp_nonce_field( 'xc-settings-english-month-names-action', 'xc-settings-english-month-names-nonce' ); ?>
									<button type="submit" class="button-primary"><?php _e( 'Save Names', 'xllentech-english-islamic-calendar' ); ?></button>
								</li>
								</ul>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
}