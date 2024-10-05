=== Manage User Columns ===
Contributors: deepakkite, mrking2201
Donate link: https://ko-fi.com/deepak1992
Tags: registration-date, user-column, filter, users, columns, registered, date
Requires at least: 4.0
Tested up to: 6.2
Stable tag: 1.0.4
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to manage columns under the users page in the WordPress admin area.

== Description ==

“Manage User Columns” is a small plugin that allows you to manage the user fields displayed on the users list page in the WordPress dashboard area.
The new fields will be added as columns with other user information. All new columns will be sortable.

You can add default user fields like registration-date, custom fields added by other plugins or custom code, and remove any default or custom field from the Users list table.
Removing columns will not delete any user data. So, you are safe to toggle between these columns.

This plugin adds a new column "Registration Date" as a default column which you can enable/disable easily.

Want to filter the users too? Check this [addon](https://www.mediajedi.com/product/manage-user-columns-pro/)

== Installation ==

You can install the Plugin in two ways.

= WordPress interface installation =

1. Go to plugins in the WordPress admin and click on “Add new”.
2. In the Search box enter “Manage User Columns” and press Enter.
3. Click on “Install” to install the plugin.
4. Activate the plugin.

= Manual installation =

1. Download and upload the plugin files to the /wp-content/plugins/manage-user-columns directory from the WordPress plugin repository.
2. Activate the plugin through the "Plugins" screen in WordPress admin area.

== Frequently Asked Questions ==

= How do I configure the user columns? =

To keep it simple, the plugin doesn't have any separate settings page. You can simply go to the users page after activating the plugin.
You will find a "Manage Columns" button. Clicking on this button will open a popup where you manage the columns.

= Are the columns sortable? =

Yes, all new columns that you add are sortable by default.

= How do I hide default columns? =

To remove default columns, simply uncheck the checkbox next to each default columns and click save button.

= How do I remove newly added columns? =

You can simply click on the red colored delete (x) icon next to each custom column that you want to remove.

= How many user columns can I add or remove? =

You can add as many user columns as you want and remove any default column. There is no restrictions.

= Can I add Filters to search users? =

You can add filters with the [PRO version](https://www.mediajedi.com/product/manage-user-columns-pro/).

== Screenshots ==
1. Users list with sortable columns
2. Manage columns from popup
3. Searchable new custom column
4. Easily delete custom columns

== Changelog ==

= 1.0.4 =
* 2021-12-30
* Fixed tooltip icon appearing issue due to conflict with other plugins styling.
* Fixed popup not closing issue.

= 1.0.3 =
* 2021-09-11
* Fixed warning for empty values on first setup.

= 1.0.2 =
* 2021-09-08
* Fixed a reported bug where sorting doesn't work for custom added columns.
* Tested with latest WP version 5.8

= 1.0.1 =
* 2021-07-14
* Fixed a reported bug where sorting doesn't work for registration date column.

== Upgrade Notice ==

== Features ==

* Add new columns to the Users list page in WordPress admin area.

* Shows the user registration date with a sortable column.

* Remove any default or newly added columns from the users page easily.

* Add custom columns based on the user meta information stored in database added by custom code or 3rd party plugin.

* All new columns will be sortable.

* Unlimited custom columns - You can add as many custom user columns as you want. There is no restrictions.

* All plugin configuration is on the users page itself with easy interface.

* Searchable text box when adding a new column so you can select the correct value.

* Array values will be displayed as simple text separated by a comma.

[PRO version Features](https://www.mediajedi.com/product/manage-user-columns-pro/)

* Add Filters on the users page itself.

* Add Custom filters as you want.

* Works with the free manage user columns plugin.

* Different Filter types – Textbox, dropdown, and exist/blank.

* Default filters – username, email, Registration Date, Role.

* Example – Filter your users based on Roles and registered between a range of dates.

* Supports Meta keys to create custom filter.
