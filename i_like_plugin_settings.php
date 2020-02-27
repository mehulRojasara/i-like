<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// register menu page
function register_plugin_menu()
{
    add_menu_page('I Like Post Settings', 'i like', 'manage_options', 'i-like-settings', 'i_like_setting_structure', 'dashicons-thumbs-up', 30);
}
add_action('admin_menu', 'register_plugin_menu');

// plugin page html
function i_like_setting_structure()
{
    if (!is_admin()) {
        return;
    }?>
<div class="wrap">
   <h1 style="background-color: #23282d; color: #eee; padding: 10px;"><?php esc_html_e(get_admin_page_title(), 'i-like');?></h1>
   <form action="options.php" method="post">
        <?php
settings_fields('i_like_label_settings');
    do_settings_sections('i_like_label_settings');

    submit_button('Save Changes');
    ?>
   </form>
</div>
<?php
}

// add plugin settings
function i_like_plugin_setting()
{
    // register settings sections
    register_setting('i_like_label_settings', 'total_label', ['default' => '']);
    register_setting('i_like_label_settings', 'btn_like_label', ['default' => 'I Like']);
    register_setting('i_like_label_settings', 'btn_dislike_label', ['default' => "I Don't Like"]);

    register_setting('i_like_label_settings', 'like_message_field', ['default' => 'Thanks for loving this post!!!']);
    register_setting('i_like_label_settings', 'dislike_message_field', ['default' => 'Thanks for your valuable response, we try to make it better!!!']);
    register_setting('i_like_label_settings', 'login_message_field', ['default' => 'Please login First.']);

    // button label section
    add_settings_Section('i_like_label_settings_section', 'Button Labels', 'i_like_plugin_setting_section_cb', 'i_like_label_settings');

    // Message label section
    add_settings_Section('i_like_message_settings_section', 'Notification Messages', 'i_like_plugin_setting_message_cb', 'i_like_label_settings');

    // add setting fields
    add_settings_field('i_like_total_label_input', 'Total Indicator Label', 'i_like_total_label_cb', 'i_like_label_settings', 'i_like_label_settings_section');
    add_settings_field('i_like_label_input', 'Like Button Text', 'i_like_label_cb', 'i_like_label_settings', 'i_like_label_settings_section');
    add_settings_field('i_like_dislike_label_input', 'Dislike Button Text', 'i_like_dislike_label_cb', 'i_like_label_settings', 'i_like_label_settings_section');

    add_settings_field('i_like_message_input', 'Like The Post', 'i_like_message_cb', 'i_like_label_settings', 'i_like_message_settings_section');
    add_settings_field('i_like_dislike_message_input', 'Dislike The Post', 'i_like_dislike_message_cb', 'i_like_label_settings', 'i_like_message_settings_section');
    add_settings_field('i_like_login_input', 'User Not Logged in', 'i_like_login_message_cb', 'i_like_label_settings', 'i_like_message_settings_section');
}
add_action('admin_init', 'i_like_plugin_setting');

// callback functions
function i_like_plugin_setting_section_cb()
{
    // echo "<p>Define Button labels</p>";
}

function i_like_plugin_setting_message_cb()
{
    // echo "<p>Define Button labels</p>";
}

function i_like_total_label_cb()
{
    $totalLabelDB = get_option('total_label');?>
    <input type="text" name="total_label" value="<?php echo isset($totalLabelDB) ? esc_attr($totalLabelDB) : ''; ?>" />
<?php
}

function i_like_label_cb()
{
    $likeLabelDB = get_option('btn_like_label');?>
    <input type="text" name="btn_like_label" value="<?php echo isset($likeLabelDB) ? esc_attr($likeLabelDB) : ''; ?>" />
<?php
}

function i_like_dislike_label_cb()
{
    $dislikeLabelDB = get_option('btn_dislike_label');?>
    <input type="text" name="btn_dislike_label" value="<?php echo isset($dislikeLabelDB) ? esc_attr($dislikeLabelDB) : ""; ?>" />
<?php
}

function i_like_message_cb()
{
    $likeMessage = get_option('like_message_field');?>
    <input type="text" name="like_message_field" value="<?php echo isset($likeMessage) ? esc_attr($likeMessage) : ''; ?>" />
<?php
}

function i_like_dislike_message_cb()
{
    $dislikeMessage = get_option('dislike_message_field');?>
    <input type="text" name="dislike_message_field" value="<?php echo isset($dislikeMessage) ? esc_attr($dislikeMessage) : ''; ?>" />
<?php
}

function i_like_login_message_cb()
{
    $loginMessage = get_option('login_message_field');?>
    <input type="text" name="login_message_field" value="<?php echo isset($loginMessage) ? esc_attr($loginMessage) : ''; ?>" />
<?php
}

?>