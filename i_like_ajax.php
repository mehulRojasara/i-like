<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

function i_like_ajax_btn_like()
{
    global $wpdb, $user_ID;
    $like_message = get_option('like_message_field', 'Thanks for loving this post!!!');

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . "i_like_table";

    if (isset($_POST['pid']) && isset($_POST['uid'])) {

        $post_id = intval($_POST['pid']);
        $user_id = intval($_POST['uid']);

        $check_user = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id'");

        // update data if user was react before
        if ($check_user > 0) {
            $check_like = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id' AND like_count= 0 AND dislike_count= 1");
            if ($check_like > 0) {
                $result = $wpdb->update(
                    '' . $table_name . '',
                    array(
                        'like_count' => 1,
                        'dislike_count' => 0,
                    ),
                    array(
                        'post_id' => $post_id,
                        'user_id' => $user_id,
                    ),
                    array(
                        '%d',
                        '%d',
                    ),
                    array(
                        '%d',
                        '%d',
                    )
                );
                if ($result === 0 || $result > 0) {
                    $total_likes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND like_count= 1");
                    $total_dislikes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND dislike_count= 1");
                    $like_class = true;
                    $message = '<span class="success">' . $like_message . '</span>';
                    $response = array('likes' => $total_likes_count, 'dislikes' => $total_dislikes_count, 'class' => $like_class, 'message' => $message);
                    wp_send_json($response);
                }
            } else {
                esc_html_e('<span class="warning">You already liked this post</span>', 'i-like');
            }
        } else {
            // insert data if user was not react before
            $wpdb->insert(
                '' . $table_name . '',
                array(
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'like_count' => 1,
                    'dislike_count' => 0,
                ),
                array(
                    '%d',
                    '%d',
                    '%d',
                    '%d',
                )
            );
            if ($wpdb->insert_id) {
                $total_likes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND like_count= 1");
                $total_dislikes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND dislike_count= 1");
                $like_class = true;
                $message = '<span class="success">' . $like_message . '</span>';
                $response = array('likes' => $total_likes_count, 'dislikes' => $total_dislikes_count, 'class' => $like_class, 'message' => $message);
                wp_send_json($response);
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_i_like_ajax_btn_like', 'i_like_ajax_btn_like');
add_action('wp_ajax_nopriv_i_like_ajax_btn_like', 'i_like_ajax_btn_like');

// dislike ajax function callback
function i_like_ajax_btn_dislike()
{
    global $wpdb;
    $dislike_message = get_option('dislike_message_field', 'Thanks for your valuable response, we try to make it better!!!');

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . "i_like_table";

    if (isset($_POST['pid']) && isset($_POST['uid'])) {

        $post_id = intval($_POST['pid']);
        $user_id = intval($_POST['uid']);

        $check_user = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id'");
        // update data if user was react before
        if ($check_user > 0) {
            $check_like_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id='$user_id' AND post_id='$post_id' AND like_count= 1 AND dislike_count= 0");
            if ($check_like_count > 0) {
                $result = $wpdb->update(
                    '' . $table_name . '',
                    array(
                        'like_count' => 0,
                        'dislike_count' => 1,
                    ),
                    array(
                        'post_id' => $post_id,
                        'user_id' => $user_id,
                    ),
                    array(
                        '%d',
                        '%d',
                    ),
                    array(
                        '%d',
                        '%d',
                    )
                );
                if ($result === 0 || $result > 0) {
                    $total_likes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND like_count= 1");
                    $total_dislikes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND dislike_count= 1");
                    $like_class = true;
                    $message = '<span class="success">' . $dislike_message . '</span>';
                    $response = array('likes' => $total_likes_count, 'dislikes' => $total_dislikes_count, 'class' => $like_class, 'message' => $message);
                    wp_send_json($response);
                }
            } else {
                esc_html_e('<span class="warning">You already disliked this post</span>', 'i-like');
            }
        } else {
            // insert data if user was not react before
            $wpdb->insert(
                '' . $table_name . '',
                array(
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'like_count' => 0,
                    'dislike_count' => 1,
                ),
                array(
                    '%d',
                    '%d',
                    '%d',
                    '%d',
                )
            );
            if ($wpdb->insert_id) {
                $total_likes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND like_count= 1");
                $total_dislikes_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE post_id='$post_id' AND dislike_count= 1");
                $like_class = true;
                $message = '<span class="success">' . $dislike_message . '</span>';
                $response = array('likes' => $total_likes_count, 'dislikes' => $total_dislikes_count, 'class' => $like_class, 'message' => $message);
                wp_send_json($response);
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_i_like_ajax_btn_dislike', 'i_like_ajax_btn_dislike');
add_action('wp_ajax_nopriv_i_like_ajax_btn_dislike', 'i_like_ajax_btn_dislike');
