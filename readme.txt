===  TPG Redirect ===
Contributors: Criss Swaim
Donate link: http://www.tpginc.net/wordpress-plugins/donate/
Tags: redirect, login required
Requires at least: 3.0    
Tested up to: 4.1
Stable tag: 1.0.4

if a user is not logged in, redirect to site specified site or show page with user defined message. 

== Description ==

When this plugin is active and the option enabled, it checks for a logged in user.  If the visitor is not logged in, then the user is redirected to another site as defined in the redirect path option or will display a page with message as entered on from the settings.  If logged in, site acts as normal.

Sites with this plugin active must access the site with sitename/wp-admin and log in.
	
== Usage ==


Install the plugin
Go to the settings page
Set the address for the redirect

The active/inactive switch allows temporary disabling of the plugin


== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory and unzip it.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Set the redirect page in the settings tab. 

== Frequently Asked Questions ==

= Why do I need this? =

If you have a development site and you want to keep unregistered users from accessing it.  Or if you are developing a site and want to refer visitors to another site until this is complete.

== Screenshots ==

1. Admin page

== Changelog ==
= 1.0.4=
* add option to show page with message
* Correct fatal error.
* Verify for WP 4.0

= 1.0.3=
* Correct warning messages.
* Verify for WP 4.0

= 1.0.2=
* Correct error on static calls.

= 1.0.1=
* Update doc on settings page.

= 1.0.0=
* Initial release. 

== Upgrade Notice ==


