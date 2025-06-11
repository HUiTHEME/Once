jQuery(document).ready(function(jQuery) {
	var __cancel = jQuery('#cancel-comment-reply-link'),
		__cancel_text = __cancel.text(),
		__list = 'comment-list';//your comment wrapprer
	jQuery(document).on("submit", "#commentform", function() {
		jQuery.ajax({
			url: ajaxcomment.ajax_url,
			data: jQuery(this).serialize() + "&action=ajax_comment",
			type: jQuery(this).attr('method'),
			beforeSend: faAjax.createButterbar("提交中...."),
			error: function(request) {
				var t = faAjax;
				t.createButterbar(request.responseText);
			},
			success: function(data) {
				jQuery('textarea').each(function() {
					this.value = ''
				});
				var t = faAjax,
					cancel = t.I('cancel-comment-reply-link'),
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId),
					post = t.I('comment_post_ID').value,
					parent = t.I('comment_parent').value;
				if (parent != '0') {
					jQuery('#respond').before('<ol class="children">' + data + '</ol>');
				} else if (!jQuery('.' + __list ).length) {
					if (ajaxcomment.formpostion == 'bottom') {
						jQuery('#respond').before('<ol class="' + __list + '">' + data + '</ol>');
					} else {
						jQuery('#respond').after('<ol class="' + __list + '">' + data + '</ol>');
					}

				} else {
					if (ajaxcomment.order == 'asc') {
						jQuery('.' + __list ).append(data); // your comments wrapper
					} else {
						jQuery('.' + __list ).prepend(data); // your comments wrapper
					}
				}
				t.createButterbar("提交成功");
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	faAjax = {
		I: function(e) {
			return document.getElementById(e);
		},
		clearButterbar: function(e) {
			if (jQuery(".butterBar").length > 0) {
				jQuery(".butterBar").remove();
			}
		},
		createButterbar: function(message) {
			var t = this;
			t.clearButterbar();
			jQuery("body").append('<div class="butterBar"><p class="butterBar-message">' + message + '</p></div>');
			setTimeout("jQuery('.butterBar').remove()", 3000);
		}
	};
});

