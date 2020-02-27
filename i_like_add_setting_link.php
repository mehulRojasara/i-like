<?php
$plugin_name = basename(plugin_dir_path(dirname(__FILE__, 1)));
$plugin_file = esc_attr($plugin_name . '/' . $plugin_name . '.php');

add_filter('plugin_action_links_' . $plugin_file, 'i_like_settings_link');

function i_like_settings_link($links)
{
    // Build and escape the URL.
    $url = esc_url(add_query_arg(
        'page',
        'i-like-settings',
        get_admin_url() . 'admin.php'
    ));
    // Create the link.
    $settings_link = "<a href='$url'>" . __('Settings') . '</a>';
    // Adds the link to the end of the array.
    array_push(
        $links,
        $settings_link
    );
    return $links;
}
