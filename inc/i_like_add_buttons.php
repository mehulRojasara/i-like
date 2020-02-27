<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// append buttons to every post
function i_like_dislike_buttons($content)
{
    // counter data generate variables
    global $wpdb;
    $table_name = $wpdb->prefix . "i_like_table";

    $post_id = get_the_ID();
    $user_id = get_current_user_id();

    $like_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND like_count= 1");
    $dislike_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND dislike_count= 1");

    $user_like_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id' AND like_count= 1");
    $user_dislike_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id' AND dislike_count= 1");

    $total_label = get_option('total_label', '');

    // Make sure single post is being viewed.
    if (is_single()) {
        $total_counts = '<div class="total-ld-counts"><span class="total-label">' . esc_html($total_label) . '</span>'
        . '<span class="total-likes"><i class="fas fa-thumbs-up"></i><span id="i_like_count_' . esc_attr($post_id) . esc_attr($user_id) . '">' . esc_html($like_count) . '</span></span>'
        . '<span class="total-dislikes"><i class="fas fa-thumbs-down"></i><span id="i_like_dislike_count_' . esc_attr($post_id) . esc_attr($user_id) . '">' . esc_html($dislike_count) . '</span></span>'
            . '</div>';

        //  button structure generate variables
        $like_btn_label = get_option('btn_like_label', 'Like');
        $dislike_btn_label = get_option('btn_dislike_label', 'Dislike');

        // add like dislike class
        if ($user_like_count > 0): $like_class = sanitize_html_class("applied");else:$like_class = "";endif;
        if ($user_dislike_count > 0): $dislike_class = sanitize_html_class("applied");else:$dislike_class = "";endif;

        $button_wrap = '<div class="i-like-buttons">'
        . '<a href="javascript:void(0);" id="i_like_btn_' . esc_attr($post_id) . esc_attr($user_id) . '" onClick="i_like_btn_ajax(' . esc_attr($post_id) . ',' . esc_attr($user_id) . ')" class="i-like-btn btn-like ' . esc_html($like_class) . '"><i class="fas fa-thumbs-up"></i> ' . esc_html($like_btn_label) . '</a>'
        . '<a href="javascript:void(0);" id="i_like_dislike_btn_' . esc_attr($post_id) . esc_attr($user_id) . '" onClick="i_like_dislike_btn_ajax(' . esc_attr($post_id) . ',' . esc_attr($user_id) . ')" class="i-like-btn btn-dislike ' . esc_html($dislike_class) . '"><i class="fas fa-thumbs-down"></i> ' . esc_html($dislike_btn_label) . '</a>'
            . '</div>';

        $i_like_ajax_response = '<div id="i_like_ajax_response" class="i-like-ajax-response"></div>';

        //  generate structure

        $content .= '<div class="i-like-wrapper">';

        $content .= $total_counts;
        $content .= $button_wrap;
        $content .= $i_like_ajax_response;

        $content .= '</div>';
        return $content;
    }else{
        return $content;
    }

}
add_filter('the_content', 'i_like_dislike_buttons');
