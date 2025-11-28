=== Xllentech English Islamic Calendar ===
Contributors: xllentech
Plugin URI: https://xllentech.com/
Tags: calendar, islamic calendar, hijri calendar, english islamic calendar, gregorian hijri calendar, xllentech calendar, php 
Requires at least: 3.0
Tested up to: 6.9
Stable tag: 2.8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Best English Islamic Calendar plugin on WordPress.

== Description ==

Xllentech English Islamic Calendar plugin shows calendar with English and Islamic dates by the current English month. This calendar plugin is fully programmed in php and requires no maintenance for Islamic dates year to year.

English and Islamic month names are customizable from Settings page. You need to update number of days of the Islamic month only if the number of days for the month is different(moon is sighted on different day) than the default shown in the calendar.

The plugin comes with first Islamic date for the current English month, if it doesn't match with your area Islamic date, you can change it from settings page. After that, This plugin calculates and keeps record of Islamic dates of all the following months lifetime.

In addition to the calendar widget, this plugin also adds widget to show today's English date and Islamic date. See Screenshots.

= Features =

* Responsive CSS
* Be worry free for Islamic dates, Requires no maintenance year to year
* Show Today's English, Islamic Date with separate widget
* Supports shortcode, use [xcalendar] to display the widget anywhere
* Supports shortcode for Today Widget, use [xllentech-today] to display the Today's dates
* Supports Time zones for Worldwide use
* Email Feature for easy reminder and updating of Islamic Month Days
* Color Themes
* Show Week Starting Sunday or Monday
* Customizable Islamic and English Month names

= Shortcodes you can use =

[xcalendar] - Displays XllenTech English Islamic Calendar
[xllentech-today] - Displays Today's English and Islamic Date
[xllentech-islamic-days] - Displays form to update Month days(29/30) for the Islamic month, used in private page as explained in [Documentation](https://apps.xllentech.com/documentation/how-to-use-the-private-page-to-update-islamic-month-days/).

= View Demo =
- [Xllentech Calendar Basic](https://apps.xllentech.com/xllentech-english-islamic-calendar/)

= Need Help? =
- [Documentation](https://apps.xllentech.com/documentation/)
- [Contact Author](https://apps.xllentech.com/contact-us/)


= Extensions galore =

Some amazing ADD-ONs you might be interested in:

The Pro Version of the calendar provides next month and previous month links, so that viewers can go back or forward for any past or future months with no limit. Also show Today's Date as colored box on the Calendar. And much more..Visit the link below.

- [XllenTech Calendar Pro](https://apps.xllentech.com/xllentech-calendar-pro/)

The Datepicker Pro extension can be used to display Calendar Pop-up with English and Islamic Dates in your contact forms/booking calendar/event calendar, Your customer will have ability to choose date with better accuracy with Islamic dates displayed alongside English date. You can choose English or Islamic date to be filled in the date field when your customer selects the date.

- [XllenTech Datepicker Pro](https://apps.xllentech.com/english-islamic-datepicker/)



== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/xllentech-english-islamic-calendar` directory, or install the plugin through the WordPress plugins screen directly;

2. Activate the plugin through the 'Plugins' screen in WordPress;

3. Place the plugin using Widgets section in your WordPress admin login, Give it the title you like.




== Frequently Asked Questions ==



= How do I override number of days for the Islamic month? =

You have 2 options, Login to WordPress Admin panel, and from Month Days tab, add month and days entry. 2nd option, you can use a dedicated private page to override.

= How to use the private page to update Islamic month days? =

Create a page with title as Days, add shortcode [xllentech-islamic-days]. You are done. 

I recommend making the page private or password protected to make 2 stage authentication. 1st your password and 2nd authentication is the pin used in the file, it's 1234 by default, Go to Settings to change it to whatever you like.

= I get error "Oops, Looks like First Islamic Date is missing in the database, Plz contact support for guidance.", what do I do? =

Please Login to WordPress Admin panel, Visit Settings->Xllentech Calendar, go to Troubleshooting tab, You will see  table with empty text boxes, Please add current English month number in Month, current English year in Year, Islamic day on the 1st day of current English month in Islamic Day, similarly Islamic month on the 1st day of current English month in Islamic Month and Islamic year on the 1st day of current English month in Islamic Year and Click ADD. Calendar should work fine now.



== Screenshots ==

1. Xllentech Calendar Displaying Week Starting Monday, The plugin show dates for the current English month. Users are required to update the Islamic month days 29 or 30. Other than that no other maintenance is required.

2. Xllentech Calendar Displaying Week Starting Sunday

3. Calendar Admin Page Options

4. Calendar Admin Page Month Names

5. Calendar Admin Page Month Days

6. Calendar Admin Page Troubleshooting

7. Xllentech Today widget, how it displays Today's English and Islamic date every day.


== Changelog ==
= 2.8.0 =
* Updated: Islamic date for new installs
* Updated: Tested 6.9 Compatibility

= 2.7.3 =
* Updated: Islamic date for new installs
* Updated: Tested 6.6 Compatibility

= 2.7.2 =
* Updated: Islamic date for new installs
* Updated: Tested 6.4 Compatibility

= 2.7.1 =
* Updated: Islamic date for new installs
* Updated: Tested 6.1 Compatibility

= 2.7.0 =
* Updated: Islamic date for new installs
* Updated: Tested 5.9 Compatibility

= 2.6.9 =
* Updated: Islamic date for new installs
* Updated: Tested 5.8 Compatibility

= 2.6.8 =
* Fixed: Hotfix to SQL injection vulnerability
* Updated: Tested 5.7 Compatibility

= 2.6.7 =
* Updated: Tested 5.6 Compatibility
* Updated: Islamic first date for new installs

= 2.6.6 =
* Updated: Tested 5.4 Compatibility

= 2.6.5 =
* Fixed: First Islamic date failed to auto calculate
* Fixed: plugin name variable value wrong
* Updated: Tested 5.3 Compatibility

= 2.6.4 =
* Fixed: Today widget displayed test word("no")

= 2.6.3 =
* Updated: Admin GUI improvements
* Updated: List of Existing Islamic Month Days Override Entries are displayed sorted by Year and month Descending
* Updated: List of First Date Entries are displayed sorted by Year and Month Descending
* Fixed: Security improvements, added additional checks and validations
* Fixed: Added validation of certain arrays before using them
* Fixed: Fatal error on activation in some cases


= 2.6.2 =
* Updated: Updated Islamic date for October 2018
* Fixed: Islamic date calculation failed under certain conditions
* Fixed: Islamic today calculation failed under certain conditions
* Fixed: Islamic today calculation was wrong under certain conditions
* Fixed: Renamed a few hooks to avoid conflicts

= 2.6.1 =
* Updated: Admin: Adding Month days entry overwrites existing entry rather than giving error of duplicate entry
* Fixed: Admin: Add/remove Islamic first date entry kept giving error


= 2.6.0 =
* Updated: Xllentech now follows Boilerplate architecture for all our plugins
* Updated: SQL Query improvements
* Updated: [xllentech-islamic-days] shortcode page improvements & Islamic month days update requests now overwrites previous entries if exists.
* Updated: Many performance improvements
* Fixed: Security fixes and improvements

= 2.5.0 =
* Added: Now Xllentech Today widget can be displayed with shortcode [xllentech-today]
* Added: Now Xllentech Today widget is independent for Islamic date, doesn't rely on calendar webpage
* Added: Breadcrumb style Admin settings current page display
* Updated: Calculating new English month Islamic date is recursive(Even if calendar webpage has not been visited for upto 12 months calendar will not break down).
* Fixed: On activation redirect to settings page failed when PRO ADD-ON installed


= 2.4.1 =
* Added: Implemented WordPress Nonce as an extra layer of security
* Updated: Islamic first date for January 2018
* Added: Improved Admin page CSS, collapsible boxes
* Fixed: Admin responsive CSS issues
* Fixed: Enable email checkbox not reflecting change after saved.
* Fixed: On database error in admin, Display generic error only for security

= 2.4.0 =
* Added: Various addition to support Xllentech Calendar Pro ADD-ON
* Updated: Islamic first date for December 2017
* Fixed: Admin CSS issues


= 2.3.1 =
* Updated: Various under the hood improvements
* Fixes: Various bug fixes

= 2.3.0 =
* Added: Tested 4.8 Compatibility
* Added: Now English Month names are customizable
* Updated: Xllentech Calendar Pro is now an ADD-ON
* Updated: With Pro ADD-ON Installed, Free version Widget also reflects Pro Settings
* Fixed: Admin Page Responsive view issues
* Fixed: Various code improvements


= 2.2.4 =
* Code optimization/Improvements
* CSS made relative to width for better look

= 2.2.3 =
* Minor bug fixes

= 2.2.2 =
* Minor bug fixes
* Improved error handling

= 2.2.1 =
* Added 4.7 compatibility

= 2.2.0 =
* Added option to show week first day Sunday or Monday
* Minor improvements

= 2.1.1 =
* Added separate troubleshooting admin page
* Improved queries to prevent sql injection attack
* Improved code to prevent direct access to files by hackers
* Added Delete All data on Uninstall
* Verified compatibility with WordPress 4.6

= 2.1.0 =
* Added Color Themes
* Added shortcode [xllentech-islamic-days] to update Islamic month days from page

= 2.0.1 =
* Fixed XllenTech Today plugin doesn't reflect time zone

= 2.0.0 =
* Added Email Feature, Go to settings page for more information
* Added Time zone to support worldwide use
* Improved/Added number of Setting options
* Minor Date formula tweaks
* Easy Troubleshooting from settings page, if needed
* Improved islamic-month-days.php
* Minor bug fixes

= 1.2.2 =
*Minor bug fix

= 1.2.1 =

* Verified and added WordPress 4.5 compatibility

= 1.2.0 =

* Added Settings page
* Added Feature to Customize Islamic month names
* Added Feature to update month days from Settings page
* Settings page shows existing month days override entries

= 1.1.1 =

Fixed minor bug, improved islamic-month-days.php

= 1.1.0 =

1. Added support of shortcode [xcalendar]

= 1.0: 27th Feb, 2016 =

1. First release of the plugin

== Upgrade Notice ==
= 2.6.9 =
* Updated: Islamic date for new installs
* Updated: Tested 5.8 Compatibility

= 2.6.8 =
* Fixed: Hotfix to SQL injection vulnerability, Update Immediately
* Updated: Tested 5.7 Compatibility

= 2.6.7 =
* Updated: Tested 5.6 Compatibility

= 2.6.5 =
Includes fixes and improvement

= 2.6.4 =
Includes many fixes and improvement, if you are updating from 2.5 or below, you may need to re-activate this plugin!!

= 2.6.3 =
Includes many fixes and improvement, You may need to re-activate this plugin, if you are updating from 2.5 or below!!

= 2.6.2 =
Includes many fixes, You may need to re-activate this plugin, if you are updating from 2.5 or below!!

= 2.6.1 =
You may need to re-activate this plugin, if you are updating from 2.5 or below!!
Please make sure to update Xllentech English Islamic Calendar to 2.6.* version before updating Xllentech Calendar Pro to 2.6.*, if you have both.

= 2.6.0 =
* Updated: Xllentech now follows Boilerplate architecture for all our plugins
* Updated: SQL Query improvements
* Updated: [xllentech-islamic-days] shortcode page improvements & Islamic month days update requests now overwrites previous entries if exists.
* Updated: Many performance improvements
* Fixed: Security fixes and improvements

= 2.5.0 =
* Added: Breadcrumb style Admin settings current page display
* Added: Now Xllentech Today widget can be displayed with shortcode [xllentech-today]
* Added: Now Xllentech Today widget is independent for Islamic date, doesn't rely on calendar webpage
* Updated: Calculating new English month Islamic date is recursive(Even if calendar webpage has not been visited for upto 12 months calendar will not break down).
* Fixed: On activation redirect to settings page failed when PRO ADD-ON installed

= 2.4.1 =
* No special steps needed

= 2.4.0 =
* Added: Various addition to support Xllentech Calendar Pro ADD-ON
* Updated: Islamic first date for December 2017
* Fixed: Admin css issues

= 2.3.1 =
* Updated: Various under the hood improvements
* Fixes: Various bug fixes

= 2.3.0 =
If you have Xllentech Calendar Pro Installed, Now you need to have Free version from WordPress.org installed.
* Added: Tested 4.8 Compatibility
* Added: Now English Month names are customizable
* Updated: Xllentech Calendar Pro is now an ADD-ON
* Updated: With Pro ADD-ON Installed, Free version Widget also reflects Pro Settings
* Fixed: Admin Page Responsive view issues
* Fixed: Various code improvements

= 2.2.4 =
* Code optimization/Improvements
* CSS made relative to width for better look

= 2.2.3 =
* Minor bug fixes

= 2.2.2 =
* Minor bug fixes
* Improved error handling

= 2.2.1 =
* Added 4.7 compatibility

= 2.2.0 =
* Added option to show week first day Sunday or Monday
* Minor improvements

= 2.1.1 =
* Added separate troubleshooting admin page
* Improved queries to prevent sql injection attack
* Improved code to prevent direct access to files by hackers
* Added Delete All data on Uninstall
* Verified compatibility with WordPress 4.6

= 2.1.0 =
Some Settings like time zone, calendar admin email, page pin will be reset to defaults, Plz re-set them after upgrading.
* Added Color Themes
* Added shortcode [xllentech-islamic-days] to update Islamic month days from page, without logging into Admin Panel.

= 2.0.1 =
* Fixed XllenTech Today plugin doesn't reflect time zone

= 2.0.0 =
Upgrade this to resolve number of minor issues. Make sure to change Time zone from settings to match your area.
* Added Email Feature, Go to settings page for more information
* Added Time zone to support worldwide use
* Improved/Added number of Setting options
* Minor Date formula tweaks
* Easy Troubleshooting from settings page, if needed on support ticket
* Improved islamic-month-days.php
* Minor bug fixes

= 1.2.2 =
*Minor bug fix

= 1.2.1 =

* Verified and added WordPress 4.5 compatibility, No User action required

= 1.2.0 =

* Added Settings page
* Added Feature to Customize Islamic month names
* Added Feature to update month days from Settings page
* Settings page shows existing month days override entries

= 1.1.1 =

Fixed minor bug, improved islamic-month-days.php

= 1.1.0 =

Added support of shortcode [xcalendar]

= 1.0.0: 27th Feb, 2016 =

First release of the plugin