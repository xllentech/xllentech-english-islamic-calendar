<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Xllentech_English_Islamic_Calendar
 * @subpackage Xllentech_English_Islamic_Calendar/public/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.5.0
 * @author     Abbas Momin <abbas.momin@xllentech.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }
	
	$english_current_monthname = date_format($english_currentdate,'F');

	$english_current_monthdays=date_format($english_currentdate,'t');

	$english_current_dayname=date_format($english_currentdate,'D');

	$english_last_month = clone $english_currentdate;
	$english_last_month->modify( '-1 month' );

	$english_last_monthdays=date_format($english_last_month,'t');
	$english_last_monthname=date_format($english_last_month,'M');

	if($this->xc_options['xc_first_day']=="Monday")	{
		$english_current_firstday = date_format( $english_currentdate, 'N' );
		$english_current_firstday = $english_current_firstday-1;

		$english_grid_firstday = $english_last_monthdays-$english_current_firstday+1;
	}	else {
		$english_current_firstday = date_format( $english_currentdate, 'w' );
	//	$english_current_firstday=$english_current_firstday-1;

		$english_grid_firstday = $english_last_monthdays-$english_current_firstday+1;
	}

	//Find Islamic date first day by rewinding by english first day count
		$islamic_grid_firstday=$islamic_firstday;
		$islamic_grid_firstmonth=$islamic_firstmonth;
		$islamic_grid_firstyear=$islamic_firstyear;
		
	// NEW FORMULA START
	$islamic_grid_firstday=$islamic_firstday-$english_current_firstday;
	if( $islamic_grid_firstday <= 0 ) {
		$islamic_grid_firstmonth--;
		if( $islamic_grid_firstmonth < 0 ){
			$islamic_grid_firstmonth=12;
			$islamic_grid_firstyear--;
		}
		
		$islamic_month_days[$islamic_grid_firstmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_grid_firstmonth], $islamic_grid_firstmonth, $islamic_grid_firstyear );

		$islamic_grid_firstday=$islamic_grid_firstday+$islamic_month_days[$islamic_grid_firstmonth];
	
	}	else {
		
		$islamic_month_days[$islamic_firstmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_firstmonth], $islamic_firstmonth, $islamic_firstyear );
		
	}
	//NEW FORMULA END
	// End of the search
	
	$k1=$islamic_grid_firstday;
	$islamic_currentmonth=$islamic_grid_firstmonth;
	$islamic_currentyear=$islamic_grid_firstyear;
	$islamic_css_current="xllentech-islamic-1";
				
	for ($i=0; $i<$english_current_firstday; $i++) {
		
		$xllentech_english_css[$i]="xllentech-english-previous";
		$english_day_sequence[$i]=$english_grid_firstday;
		$english_grid_firstday++;
			
		If ($k1>$islamic_month_days[$islamic_currentmonth]){
			$k1=1;
			$islamic_currentmonth=$islamic_currentmonth+1;
			
			if ($islamic_currentmonth>12){
				$islamic_currentmonth=1;
				$islamic_currentyear=$islamic_currentyear+1;
			}
			
			$islamic_month_days[$islamic_currentmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_currentmonth], $islamic_currentmonth, $islamic_currentyear );
							
			if ($islamic_css_current=="xllentech-islamic-1") {
				$islamic_css_current="xllentech-islamic-2";	
			}
			else {
				$islamic_css_current="xllentech-islamic-1";
			}
			
			$xllentech_islamic_css[$i]="xllentech-islamic-3";
			
			$islamic_day_sequence[$i]=$islamic_months[$islamic_currentmonth]." " .$k1;
			
		}
		else{
			
			$xllentech_islamic_css[$i]=$islamic_css_current;
			$islamic_day_sequence[$i]=$k1;
		}

		$k1++;
		
	}

	$n=$english_current_monthdays+$english_current_firstday;
	$j=1; 

	for ($i=$english_current_firstday; $i<$n; $i++) {
		
		$xllentech_english_css[$i]="xllentech-english-current";
		$english_day_sequence[$i]=$j;
		$j++;
		
		If ($k1>$islamic_month_days[$islamic_currentmonth]){
			$k1=1;
			$islamic_currentmonth=$islamic_currentmonth+1;
			if ($islamic_currentmonth>12){
				$islamic_currentmonth=1;
				$islamic_currentyear=$islamic_currentyear+1;
			}
			
			$islamic_month_days[$islamic_currentmonth] = apply_filters( 'xc_update_islamic_month_days', $islamic_month_days[$islamic_currentmonth], $islamic_currentmonth, $islamic_currentyear );
				
			if ($islamic_css_current=="xllentech-islamic-1") {
				$islamic_css_current="xllentech-islamic-2";	
			}
			else {
				$islamic_css_current="xllentech-islamic-1";
			}
			
			$xllentech_islamic_css[$i]="xllentech-islamic-3";	
			
			$islamic_day_sequence[$i]=$islamic_months[$islamic_currentmonth]." " .$k1;
		}
		else{
			
			$xllentech_islamic_css[$i]=$islamic_css_current;
			$islamic_day_sequence[$i]=$k1;
		}

		$k1++;

	}

	$m=1;

	for ($q=$n; $q<35; $q++) {
		
		$xllentech_english_css[$q]="xllentech-english-next";
		$english_day_sequence[$q]=$m;
		$m++;

		If ($k1>$islamic_month_days[$islamic_currentmonth]){
			$k1=1;
			$islamic_currentmonth=$islamic_currentmonth+1;
				if ($islamic_currentmonth>12){
					$islamic_currentmonth=1;
					$islamic_currentyear=$islamic_currentyear+1;
				}
			if ($islamic_css_current=="xllentech-islamic-1") {
				$islamic_css_current="xllentech-islamic-2";	
			}
			else {
				$islamic_css_current="xllentech-islamic-1";
			}
			
			$xllentech_islamic_css[$q]="xllentech-islamic-3";
			$islamic_day_sequence[$q]=$islamic_months[$islamic_currentmonth]." " .$k1;
		}
		else{
			
			$xllentech_islamic_css[$q]=$islamic_css_current;
			$islamic_day_sequence[$q]=$k1;
		}

		$k1++;

	}

	// OPTIONAL BOTTOM ROW 6TH
	if ( ($english_current_firstday==5 && $english_current_monthdays>30) || ($english_current_firstday==6 && $english_current_monthdays>=30)) {

		$m=1;

		for ($i=$n; $i<42; $i++) {
			
			$xllentech_english_css[$i]="xllentech-english-next";
			$english_day_sequence[$i]=$m;
			$m++;
			
			If ($k1>$islamic_month_days[$islamic_currentmonth]){
				$k1=1;
				$islamic_currentmonth=$islamic_currentmonth+1;
					if ($islamic_currentmonth>12){
						$islamic_currentmonth=1;
						$islamic_currentyear=$islamic_currentyear+1;
					}
				
				if ($islamic_css_current=="xllentech-islamic-1") {
				$islamic_css_current="xllentech-islamic-2";	
			}
			else {
				$islamic_css_current="xllentech-islamic-1";
			}
			
				$xllentech_islamic_css[$i]="xllentech-islamic-3";
				
				$islamic_day_sequence[$i]=$islamic_months[$islamic_currentmonth]." " .$k1;
			}
			else{
				$xllentech_islamic_css[$i]=$islamic_css_current;
				$islamic_day_sequence[$i]=$k1;
			}
			$k1++;
		}
	}