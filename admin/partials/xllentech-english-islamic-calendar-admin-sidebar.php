<?php
/**
 *
 * The Sidebar of Xllentech_English_Islamic_Calendar Admin
 *
 * @link       https://www.xllentech.com
 * @package     Xllentech_English_Islamic_Calendar
 * @subpackage  Xllentech_English_Islamic_Calendar/admin/partials
 * @copyright   Copyright (c) 2018, xllentech
 * @since       2.6.0
 */
 
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>
<div>
	<center><h2 style="color:#999;font-size:18px;line-height:26px;font-weight:bold">XllenTech Calendar <?php esc_html_e( XC_PLUGIN_VERSION ); ?></h2></center>
	</center>
</div>

<div style="height: 20px">
	<a style="text-decoration: none" href="https://wordpress.org/support/view/plugin-reviews/xllentech-english-islamic-calendar" target="_blank">
		<div class="xllentech_review">
			<span style="font-size: 13px; color:#777;"><?php _e('Please rate us', 'xllentech-english-islamic-calendar'); ?></span>
		</div>
	</a>
</div>

<div style="height: 20px; clear:both;">
	<div style="float:left">
		<span style="font-size: 13px; color:#777;"><?php _e('Having issues?', 'xllentech-english-islamic-calendar'); ?></span>
	</div>
	<div style="float:right">
		<a style="text-decoration: none" href="https://xllentech.com/wp-plugins/contact/" target="_blank"><?php _e('Contact Author', 'xllentech-calendar'); ?></a>
	</div>
</div>

<div style="height: 20px; clear:both;">
	<div style="float:left">
		<span style="font-size: 13px; color:#777;"><?php _e('Developed by:', 'xllentech-english-islamic-calendar'); ?></span>
	</div>
	<div style="float:right">
		<a style="text-decoration: none" href="https://xllentech.com/wp-plugins/" target="_blank">Abbas Momin</a>
	</div>
</div>
<div>
	<center>
		<p style="text-align: justify"><?php _e('Thank You for using XllenTech Calendar, Feel free to contact for support, Don\'t have Wordpress login, No Problem, Contact me directly. I would love to help resolve issue(s).', 'xllentech-calendar'); ?></p>
	<p style="text-align:right"><?php _e('Thank you again!', 'xllentech-calendar'); ?></p>
	<center>
		<a href="https://xllentech.com/wp-plugins/xllentech-english-islamic-calendar/" target="_blank">
			<div class="xllentech_demo">
				<span style="padding:10px"></span>
			</div>
		</a>
	</center>
</div>
<div style="border-top:3px solid #aaa;margin-top:20px;border-bottom:1px solid #ccc;text-align:center">
	<span style="font-size:16px;color:#777;font-weight:bold" class="add-on-url"><?php _e('Available Extensions', 'xllentech-calendar'); ?></span>
</div>
<div style="float:left;padding:15px 5px">
	<span style="font-size:16px;color:#777;font-weight:bold;padding-top:20px"><?php _e('Calendar Pro:', 'xllentech-calendar'); ?></span>
</div>
<div style="float:right">
	<span class="button-primary" style="color:#fff;float:right;margin-bottom:10px"><?php if ( is_plugin_active( 'xllentech-calendar-pro/xllentech-calendar-pro.php' ) ) echo 'Installed & Active'; else echo '<a href="https://www.xllentech.com/wp-plugins/xllentech-calendar-pro/" style="color:#fff;text-decoration:none" target="_blank">View Demo/Buy</a>'; ?></span>
</div>
<div style="clear:both"></div>
<div style="float:left;padding:15px 5px">
	<span style="font-size:16px;color:#777;font-weight:bold;padding-top:20px"><?php _e('Datepicker:', 'xllentech-calendar'); ?></span>
</div>
<div style="clear:right">
	<span class="button-primary" style="color:#fff;float:right;margin-bottom:10px"><?php if ( is_plugin_active( 'xllentech-datepicker/xllentech-datepicker.php' ) ) echo 'Installed & Active'; else echo '<a href="https://www.xllentech.com/wp-plugins/english-islamic-datepicker/" style="color:#fff;text-decoration:none" target="_blank">View Demo/Buy</a>'; ?></span>
</div>