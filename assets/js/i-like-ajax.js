// like ajax call
function i_like_btn_ajax(postId, userId) {
   var post_id = postId;
   var user_id = userId;

   if (user_id == 0) {
      jQuery('#i_like_ajax_response').html('<span class="warning">Please login First.</span>');
      setTimeout(function () {
         jQuery('#i_like_ajax_response span').hide();
      }, 5000);
   } else {
      jQuery.ajax({
         url: i_like_ajax_url.ajax_url,
         type: 'post',
         data: {
            action: 'i_like_ajax_btn_like',
            pid: post_id,
            uid: user_id
         },
         success: function (response) {
            jQuery("#i_like_count_" + postId + userId).html(response.likes);
            jQuery("#i_like_dislike_count_" + postId + userId).html(response.dislikes);
            if (response.class && !jQuery("#i_like_btn_" + postId + userId).hasClass('applied')) {
               jQuery("#i_like_btn_" + postId + userId).addClass('applied');
               jQuery("#i_like_dislike_btn_" + postId + userId).removeClass('applied');
            }
            jQuery('#i_like_ajax_response').html(response.message);
            setTimeout(function () {
               jQuery('#i_like_ajax_response span').hide();
            }, 5000)
         }
      });
   }
}

// dislike ajax call
function i_like_dislike_btn_ajax(postId, userId) {
   var post_id = postId;
   var user_id = userId;

   if (user_id == 0) {
      jQuery('#i_like_ajax_response').html('<span class="warning">Please login First.</span>');
      setTimeout(function () {
         jQuery('#i_like_ajax_response span').hide();
      }, 5000);
   } else {
      jQuery.ajax({
         url: i_like_ajax_url.ajax_url,
         type: 'post',
         data: {
            action: 'i_like_ajax_btn_dislike',
            pid: post_id,
            uid: user_id
         },
         success: function (response) {
            jQuery("#i_like_count_" + postId + userId).html(response.likes);
            jQuery("#i_like_dislike_count_" + postId + userId).html(response.dislikes);
            if (response.class && !jQuery("#i_like_dislike_btn_" + postId + userId).hasClass('applied')) {
               jQuery("#i_like_dislike_btn_" + postId + userId).addClass('applied');
               jQuery("#i_like_btn_" + postId + userId).removeClass('applied');
            }
            jQuery('#i_like_ajax_response').html(response.message);
            setTimeout(function () {
               jQuery('#i_like_ajax_response span').hide();
            }, 5000)
         }
      });
   }
}