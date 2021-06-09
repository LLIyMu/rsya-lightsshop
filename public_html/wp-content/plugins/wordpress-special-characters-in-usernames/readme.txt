=== Wordpress Special Characters in Usernames ===
Contributors: ClaudeSchlesser, OneAll.com
Tags: special characters, cyrillic usernames, russian usernames, arabic usernames, registration, russian, cyrillic, arabic
Requires at least: 3.0
Tested up to: 5.6
Stable tag: 2.0

Enables usernames containing special characters (russian, cyrillic, arabic ...) on your Wordpress Blog.

== Description ==

<strong>This plugin enables usernames containing special characters (russian, cyrillic, arabic ...) on your WordPress blog.</strong>

Per default WordPress does not allow to use special characters in usernames. Non-latin characters are silently filtered out and your users cannot create accounts containing cyrillic (russian) or arabic letters. This plugin is the solution to this problem.

The plugin works for users that are added by the administrator, for users that register with their username/password and for users that register using our <a href="https://wordpress.org/plugins/oa-social-login/">Social Login</a> plugin for WordPress.

<strong>Please Note</strong><br />
Special characters are encoded in the database and take a bit more space than regular characters. 

If users having special characters in their usernames still cannot register after having installed the plugin then you probably have to increase the length of the column <code>user_nicename</code> in the table <code>wp_users</code> in your database.

<strong>Example:</strong><pre>
ALTER TABLE `wp_users` CHANGE `user_nicename` `user_nicename` VARCHAR(255) NOT NULL DEFAULT '';
</pre>

<strong>Available Charsets</strong>
You can enable/disable each charset individually in the <strong>Settings \ WSCU Settings</strong> page in your WordPress admin area. 

 * Arabic
 * Armenian
 * Bengali
 * Bopomofo
 * Braille
 * Buhid
 * Canadian Aboriginal
 * Cherokee
 * Cyrillic
 * Devanagari
 * Ethiopic
 * Georgian
 * Greek
 * Gujarati
 * Gurmukhi
 * Han
 * Hangul
 * Hanunoo
 * Hebrew
 * Hiragana
 * Kannada
 * Katakana
 * Khmer
 * Lao
 * Latin
 * Limbu
 * Malayalam
 * Mongolian
 * Myanmar
 * Ogham
 * Oriya
 * Runic
 * Sinhala
 * Syriac
 * Tagalog
 * Tagbanwa
 * TaiLe
 * Tamil
 * Telugu
 * Thaana
 * Thai
 * Tibetan
 * Yi 
 
== Installation ==

1. Upload the plugin folder to the '/wp-content/plugins/' directory of your WordPress site,
2. Activate the plugin through the 'Plugins' menu in WordPress,

== Frequently Asked Questions ==

= Where can I report bugs, leave my feedback and get support? =

Our team answers your questions at:
http://www.oneall.com/company/contact-us/

== Changelog ==

= 2.0 =
* Added admin settings
* Added 30+ charsets
* Tested with WordPress 5.3

= 1.2 = 
* Tested with WordPress 3.6

= 1.1 = 
* Stable release

= 1.0 =
* Initial release