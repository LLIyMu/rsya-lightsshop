<?php

/*
 * Plugin Name: Wordpress Special Characters in Usernames
 * Plugin URI: http://www.oneall.com/
 * Description: Enables usernames containing special characters (russian, cyrillic, arabic ...) on your Wordpress Blog
 * Version: 2.0
 * Author: OneAll - User Integration Platform <support@oneall.com>
 * Author URI: http://www.oneall.com/
 * License: GPL2
 */

/**
 * Enabled charsets.
 */
function wscu_get_charsets ()
{
    return array(
        'arabic' => array(
            'name' => 'Arabic',
            'regexp' => '\p{Arabic}',
            'is_default' => 1
        ),
        'armenian' => array(
            'name' => 'Armenian',
            'regexp' => '\p{Armenian}'
        ),
        'bengali' => array(
            'name' => 'Bengali',
            'regexp' => '\p{Bengali}'
        ),
        'bopomofo' => array(
            'name' => 'Bopomofo',
            'regexp' => '\p{Bopomofo}'
        ),
        'braille' => array(
            'name' => 'Braille',
            'regexp' => '\p{Braille}'
        ),
        'buhid' => array(
            'name' => 'Buhid',
            'regexp' => '\p{Buhid}'
        ),
        'canadian_Aboriginal' => array(
            'name' => 'Canadian Aboriginal',
            'regexp' => '\p{Canadian_Aboriginal}'
        ),
        'cherokee' => array(
            'name' => 'Cherokee',
            'regexp' => '\p{Cherokee}'
        ),
        'cyrillic' => array(
            'name' => 'Cyrillic',
            'regexp' => '\p{Cyrillic}',
            'is_default' => 1
        ),
        'devanagari' => array(
            'name' => 'Devanagari',
            'regexp' => '\p{Devanagari}'
        ),
        'ethiopic' => array(
            'name' => 'Ethiopic',
            'regexp' => '\p{Ethiopic}'
        ),
        'georgian' => array(
            'name' => 'Georgian',
            'regexp' => '\p{Georgian}'
        ),
        'greek' => array(
            'name' => 'Greek',
            'regexp' => '\p{Greek}',
            'is_default' => 1
        ),
        'gujarati' => array(
            'name' => 'Gujarati',
            'regexp' => '\p{Gujarati}'
        ),
        'gurmukhi' => array(
            'name' => 'Gurmukhi',
            'regexp' => '\p{Gurmukhi}'
        ),
        'han' => array(
            'name' => 'Han',
            'regexp' => '\p{Han}'
        ),
        'hangul' => array(
            'name' => 'Hangul',
            'regexp' => '\p{Hangul}'
        ),
        'hanunoo' => array(
            'name' => 'Hanunoo',
            'regexp' => '\p{Hanunoo}'
        ),
        'hebrew' => array(
            'name' => 'Hebrew',
            'regexp' => '\p{Hebrew}'
        ),
        'hiragana' => array(
            'name' => 'Hiragana',
            'regexp' => '\p{Hiragana}'
        ),
        'kannada' => array(
            'name' => 'Kannada',
            'regexp' => '\p{Kannada}'
        ),
        'katakana' => array(
            'name' => 'Katakana',
            'regexp' => '\p{Katakana}'
        ),
        'khmer' => array(
            'name' => 'Khmer',
            'regexp' => '\p{Khmer}'
        ),
        'lao' => array(
            'name' => 'Lao',
            'regexp' => '\p{Lao}'
        ),
        'lao' => array(
            'name' => 'Lao',
            'regexp' => '\p{Lao}'
        ),
        'latin' => array(
            'name' => 'Latin',
            'regexp' => '\p{Latin}'
        ),
        'limbu' => array(
            'name' => 'Limbu',
            'regexp' => '\p{Limbu}'
        ),
        'malayalam' => array(
            'name' => 'Malayalam',
            'regexp' => '\p{Malayalam}'
        ),
        'mongolian' => array(
            'name' => 'Mongolian',
            'regexp' => '\p{Mongolian}'
        ),
        'myanmar' => array(
            'name' => 'Myanmar',
            'regexp' => '\p{Myanmar}'
        ),
        'ogham' => array(
            'name' => 'Ogham',
            'regexp' => '\p{Ogham}'
        ),
        'oriya' => array(
            'name' => 'Oriya',
            'regexp' => '\p{Oriya}'
        ),
        'runic' => array(
            'name' => 'Runic',
            'regexp' => '\p{Runic}'
        ),
        'sinhala' => array(
            'name' => 'Sinhala',
            'regexp' => '\p{Sinhala}'
        ),
        'syriac' => array(
            'name' => 'Syriac',
            'regexp' => '\p{Syriac}'
        ),
        'tagalog' => array(
            'name' => 'Tagalog',
            'regexp' => '\p{Tagalog}'
        ),
        'tagbanwa' => array(
            'name' => 'Tagbanwa',
            'regexp' => '\p{Tagbanwa}'
        ),
        'taiLe' => array(
            'name' => 'TaiLe',
            'regexp' => '\p{TaiLe}'
        ),
        'tamil' => array(
            'name' => 'Tamil',
            'regexp' => '\p{Tamil}'
        ),
        'telugu' => array(
            'name' => 'Telugu',
            'regexp' => '\p{Telugu}'
        ),
        'thaana' => array(
            'name' => 'Thaana',
            'regexp' => '\p{Thaana}'
        ),
        'thai' => array(
            'name' => 'Thai',
            'regexp' => '\p{Thai}'
        ),
        'tibetan' => array(
            'name' => 'Tibetan',
            'regexp' => '\p{Tibetan}'
        ),
        'yi' => array(
            'name' => 'Yi',
            'regexp' => '\p{Yi}'
        )
    );
}

/**
 * Overrides the Wordpress sanitize_user filter to allow special characters
 */
function wscu_sanitize_user($username, $raw_username, $strict)
{
    // Read charsets.
    $wscu_charsets = wscu_get_charsets();

    // Strip HTML Tags.
    $username = wp_strip_all_tags($raw_username);

    // Remove accents.
    $username = remove_accents($username);

    // Kill octets.
    $username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);

    // Kill entities.
    $username = preg_replace('/&.+?;/', '', $username);

    // If strict, reduce to ASCII and enabled charsets.
    if ($strict)
    {
        // Allowed charsets.
        $allowed_charsets = array();

        // Read settings.
        $settings = get_option('wscu_settings');

        // Read charsets.
        foreach ($wscu_charsets as $key => $charset)
        {
            // This is probably an older version the the plugin.
            if (!is_array($settings) || !isset($settings[$key]))
            {
                // Add if it's a default charset.
                if ( ! empty ($charset['is_default']))
                {
                     $allowed_charsets[] = $charset['regexp'];
                }
            }
            else
            {
                if ($settings[$key] == 1)
                {
                    $allowed_charsets[] = $charset['regexp'];
                }
            }

        }

        // Replace all except the allowed ones.
        $username = preg_replace('|[^a-z' . implode($allowed_charsets) . '0-9 _.\-@]|iu', '', $username);
    }

    // Remove whitespaces.
    $username = trim($username);

    // Consolidate contiguous whitespaces.
    $username = preg_replace('|\s+|', ' ', $username);

    // Done.
    return $username;
}
add_filter('sanitize_user', 'wscu_sanitize_user', 10, 3);

/**
 * Adds a link to the dettings panel.
 */
function wscu_add_settings_page()
{
    add_options_page('WSCU Settings', 'WSCU Settings', 'manage_options', 'wordpress-special-characters-in-usernames', 'wscu_settings_page');
}
add_action('admin_menu', 'wscu_add_settings_page');

/**
 * Registers the settings group.
 */
function wcu_init_settings()
{
    register_setting("wscu_settings_group", "wscu_settings", "wscu_settings_validate");
}
add_action("admin_init", "wcu_init_settings");

/**
 * Validates the settings on submit.
 */
function wscu_settings_validate($settings)
{
    // Check user capabilities.
    if (!current_user_can('manage_options'))
    {
        return;
    }

    // Read charsets.
    $wscu_charsets = wscu_get_charsets();

    // Check format.
    if (!is_array($settings))
    {
        $settings = array();
    }

    // Adds empty values if these are not in the request.
    foreach ($wscu_charsets as $key => $charset)
    {
        if (!isset($settings[$key]))
        {
            $settings[$key] = 0;
        }
    }

    // Removes invalid values.
    foreach ($settings as $key => $value)
    {
        if (!isset($wscu_charsets[$key]))
        {
            unset($settings[$key]);
        }
        else
        {
            if (!in_array($value, array(0, 1)))
            {
                $settings[$key] = 1;
            }
        }
    }

    // Done.
    return $settings;
}

/**
 * Displays the settings.
 */
function wscu_settings_page()
{
    // Check user capabilities.
    if (!current_user_can('manage_options'))
    {
        return;
    }

    // Read charsets.
    $wscu_charsets = wscu_get_charsets();

    ?>
    <div class="wrap">
        <h1>
            <?php echo esc_html( get_admin_page_title() ); ?>
        </h1>
        <p>
            <?php _e('Per default WordPress does not allow to use special characters in usernames.', 'wordpress-special-characters-in-usernames');?><br />
            <?php _e('Non-latin characters are silently filtered out and your users  cannot create accounts containing cyrillic, arabic (etc.) letters.', 'wordpress-special-characters-in-usernames');?><br />
            <?php printf(__('The <a href="%s" target="_blank">Special Characters in Usernames</a> plugin is the solution to this problem.', 'wordpress-special-characters-in-usernames'), 'https://wordpress.org/plugins/wordpress-special-characters-in-usernames/');?>
        </p>
        <p>
            <?php printf(__('Please take a minute and <a href="%s" target="_blank">leave a quick review</a> if you like the plugin.', 'wordpress-special-characters-in-usernames'), 'https://wordpress.org/plugins/wordpress-special-characters-in-usernames/#reviews');?>
        </p>
        <h2>
            <?php _e('Which characters would you like to allow in usernames?', 'wordpress-special-characters-in-usernames');?>
        </h2>
        <form action="options.php" method="post">
            <?php

                // Init settings.
                settings_fields('wscu_settings_group');
                $settings = get_option('wscu_settings');

                foreach ($wscu_charsets as $key => $charset)
                {
                    $enabled = false;

                    if (!is_array($settings) || !isset($settings[$key]))
                    {
                        if ( ! empty ($charset['is_default']))
                        {
                            $enabled = true;
                        }
                    }
                    else
                    {
                        if ($settings[$key] == 1)
                        {
                            $enabled = true;
                        }
                    }

                    ?>
                        <p>
                            <input type="checkbox" id="charset_<?php echo $key; ?>" name="wscu_settings[<?php echo $key; ?>]" value="1" <?php checked('1', $enabled);?> />
                            <?php echo $charset['name']; ?>
                        </p>
                   <?php
                }
                submit_button('Save Settings');

            ?>
        </form>
    </div>
<?php
}
