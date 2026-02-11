Project.modules.post_comment_emoji = {
	init: function () {
		debugger;
	    $(".displayemoji_comment").each(function(i,e){
	        var content = $(e).html();
	        $(e).html('');
	        window.emojiPicker.appendUnicodeAsImageToElement($(e),content);
	        $(e).show();
	    });
	}
};