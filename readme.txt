=== Plugin Name ===
Contributors: job_castrop
Donate link: http://www.jobcastrop.nl
Tags: vevent, rich snippets
Requires at least: 2.0.2
Tested up to: 3.2.1
Stable tag: 1.9

Add events as rich snippets to your wordpress blog

== Description ==

Add events as rich snippets to your wordpress blog, this plugin gives you the handles to do that using a simple shortcode system, to find out what a rich snippet event is check this link http://www.google.com/support/webmasters/bin/answer.py?hl=en&answer=164506

This plugin now has a widget for easy use!

Examples:
<ul>
	<li>
		<a href="http://www.playstation-vita.nl/releases/">Playstation Vita Release</a>
	</li>
	<li>
		<a href="http://www.playstation-vita.nl/">PS Vita (sidebar widget)</a>
	</li>
	<li>
		<a href="http://ps4blog.nl/release/">PS4 release</a>
	</li>
	<li>
		<a href="http://ps4blog.nl/">PS4 blog</a>
	</li>
</ul>

For more information please check my website <a href="http://jobcastrop.nl/php/events-rich-snippet-plugin-for-wordpress/">jobcastrop.nl</a>.

== Installation ==

1. Upload `job_castrop_events.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[vevents]` in your templates


== A brief Markdown Example ==
[vevents list="listname"]

== Changelog ==

= 1.1 =
* Added lists

= 1.2 =
* Added delete functionallity for both lists and events

= 1.3 =
* Added settings, you can now choose the date format and table heads

= 1.4 =
* Bug fix: default values for table heads

= 1.5 =
* added a widget for easy use!

= 1.6 =
* You can choose which list you want per widget now

= 1.7 =
* Fixed url capping bug, url can now be 255 chars long

= 1.8 =
* Fixed compatibility with 3w total cache

= 1.9 =
* Added new shorttage [vevents_list]