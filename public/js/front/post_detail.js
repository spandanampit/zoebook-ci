Project.modules.post_detailpage = {
	tmp_files_length: 0,
    tmp_files_cur_index: 0,
    tmp_files: [],
    del_files: [],
    scrollloaded : false,
	init: function () {
		Project.modules.post_detailpage.initPlyr(); 

		$(function() {
			$(".displayemoji_comment").each(function(i,e){
	            var content = $(e).html();
	            $(e).html('');
	            window.emojiPicker.appendUnicodeAsImageToElement($(e),content);
	            $(e).show();
	        });
		});	

        $(window).scroll(function () {
            var position = $(window).scrollTop();
            var bottom = $(document).height() - $(window).height();

            if (position >= $(window).height()-300 && Project.modules.post_detailpage.scrollloaded == false) {

                Project.modules.post_detailpage.scrollloaded = true;
                if ($('#nx_pg').val() == '1') {
                    //$(".new_loader").show();
                    var params = {
                        nxpg: parseInt($('#cr_pg').val()) + 1,
                        post_id : $('#mainpost_id').val()
                    }

                    $.ajax({
                        type: "get",
                        url: site_url + "home/getOtherPosts",
                        data: params,
                        dataType: 'json',
                        success: function (response) {

                            //$(".otherpost_item:last").append(response.posts_data).show().fadeIn("slow");
                            $(response.posts_data).insertAfter( ".otherpost_item:last" ).show().fadeIn("slow");

                            $('#cr_pg').val(response.cr_pg);
                            $('#nx_pg').val(response.nx_pg);

                            //$(".new_loader").hide();  
                        },
                        complete : function() {
                            Project.modules.post_detailpage.scrollloaded = false;
                        },

                    });
                }

            }
        });

        

        $(document).on("click", ".delete_post", function (e) {
            e.preventDefault();
            var post_id = $(this).data("postid");
            bootbox.confirm("Are you sure you want to delete ?", function (result) {
                if (result) {
                    Project.showUILoader($(".post-details-block"), {style: 'black', message: 'Loading.. Please Wait..'});

                    $.ajax({
                        url: site_url + 'home/delete_post?post_id=' + post_id,
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            window.location.href = site_url + "home.html";
                        },
                        error: function (e) {
                            console.log("ERROR : ", e);
                            Project.hideUILoader($(".post-details-block"));
                        }
                    });
                }
            });
        });


		$(document).on("click", ".edit_post", function (e) {
            e.preventDefault();
            $('.preview_media').html('');
            var post_id = $(this).data("postid");
            Project.showUILoader($(".post-details-block"), {style: 'black', message: 'Loading.. Please Wait..'});

            $.ajax({
                url: site_url + 'home/get_edit_post?post_id=' + post_id,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    Project.hideUILoader($(".post-details-block"));
                    if (response.status == "Success") {
                        $("#edit_post_id").val(response.data.post_id);
                        //$("#edit_post_text").val(response.data.post_text);
                        $(".displayemoji_comment").each(function(i,e){
                                var content = $(e).html();
                                $(e).html('');
                                window.emojiPicker.appendUnicodeAsImageToElement($(e),content);
                                $(e).show();
                            });

                        $("#edit_post_text").siblings(".emoji-wysiwyg-editor").html(response.data.post_text);
                        $("#edit_visibility_" + response.data.visibility).prop("checked", true);
                        if (response.data.post_type == "Media") {
                            var media_data = response.data.media;
                            for (i = 0; i < media_data.length; i++) {
                                var media_type = media_data[i]['pm_media_type'];
                                var media_id = media_data[i]['post_media_id'];

                                if (media_type == "Image") {
                                    var img_link = media_data[i]['display_image'];
                                    var preview_html = '<div class="thumbnail-box media_box_' + media_id + '"><a title="Delete" href="javascript:" data-mediaid="' + media_id + '" class="delete_media"><i class="fa fa-times-circle"></i></a><img src="' + img_link + '" alt="" class="img-thumbnail"></div>';
                                    $('.preview_media').append(preview_html);
                                } else if (media_type == "Video") {
                                    var preview_html = '<div class="thumbnail-box media_box_' + media_id + '"><a title="Delete" href="javascript:" data-mediaid="' + media_id + '" class="delete_media"><i class="fa fa-times-circle"></i></a><img src="' + site_url + 'public/images/front/video-icon.png" alt="" class="img-thumbnail"></div>';
                                    $('.preview_media').append(preview_html);
                                }
                            }
                        }
                        $('#editPost').modal('show');
                    }
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                    Project.hideUILoader($(".post-details-block"));
                }
            });
        });

        $(document).on("click", "#submit_edit_post", function (e) {
            var posttype = "Text";
            var media_length = $("#form_edit_post .thumbnail-box").length;
            if (media_length > 5) {
                bootbox.alert("Maximum 5 items allowed for a post.");
                return false;
            }
            if (media_length > 0) {
                posttype = "Media";
            }
            var formData = new FormData();
            var count = 0;
            $.each(Project.modules.post_detailpage.tmp_files, function (i, file) {
                formData.append(count, file);
                count++;
            });
            var other_data = $("#form_edit_post").serializeArray();
            $.each(other_data, function (key, input) {
                //formData.append(input.name, input.value);
                if(input.name == 'edit_post_text') {
                    formData.append(input.name, $("#edit_post_text").siblings(".emoji-wysiwyg-editor").html());
                } else if(input.name == 'post_text_emoji') {
                    var emojidata = $("#edit_post_text").val();
                    formData.append(input.name, emojidata);
                } else if(input.name == 'edit_post_detailpage') {
                    formData.append(input.name, 'Yes');
                } else {
                    formData.append(input.name, input.value);
                }
            });

            formData.append('post_type', posttype);
            var edit_post_id = $("#edit_post_id").val();
            var delete_media_id = Project.modules.post_detailpage.del_files;
            formData.append('delete_media_id', delete_media_id);
            //$(".new_loader").show();
            Project.showUILoader($("#form_edit_post"), {style: 'black', message: 'Loading.. Please Wait..'});
            $.ajax({
                url: site_url + 'home/update_post',
                type: 'POST',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    Project.modules.post_detailpage.tmp_files = [];
                    Project.modules.post_detailpage.del_files = [];
                    $('#editPost').modal('toggle');
                    if (response.status == "Success") {
                        $("#displayedittext").html(response.post_data);
                        $(".images-slider-block").html(response.post_media_data);
                        Project.modules.post_detailpage.initPlyr();
                        $('#media-slider').owlCarousel({
                            loop: true,
                            margin: 10,
                            items: 1,
                            dots:false,
                            nav:true,
                            video:true,
                            autoHeight:true,
                            navText: [
                              '<i class="fas fa-angle-left"></i>',
                              '<i class="fas fa-angle-right"></i>'
                            ],
                          });

                    } else {
                        Project.setMessage(response.message, 0);
                    }
                    $("#submit_post").prop("disabled", false);
                    Project.hideUILoader($("#form_edit_post"));
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                    $("#submit_post").prop("disabled", false);
                    Project.hideUILoader($("#form_edit_post"));
                }

            });
        });

        $(document).on('change', '#upload_file', function (data) {
            var i;
            if (data.target.files.length > 5) {
                bootbox.alert("Maximum 5 items allowed for a post.");
                return false;
            }
            for (i = 0; i < data.target.files.length; i++) {
                var imageFile = data.target.files[i];
                Project.modules.post_detailpage.tmp_files_cur_index = Project.modules.post_detailpage.tmp_files_length + 1;
                Project.modules.post_detailpage.tmp_files.push(imageFile);
                //Project.modules.posts.tmp_files[Project.modules.posts.tmp_files_cur_index] = imageFile;
                Project.modules.post_detailpage.tmp_files_length = Project.modules.post_detailpage.tmp_files_length + 1;
                var filetype = imageFile['type'];
                var filetypearr = filetype.split('/');
                var media_type = filetypearr[0];

                var reader = new FileReader();
                reader.readAsDataURL(imageFile);
                if (media_type == "image") {
                    reader.onload = function (evt) {
                        //var preview_html = '<div class="thumbnail-box upload_file_ready"><a title="Delete" href="javascript:" data-tempid="' + Project.modules.posts.tmp_files_cur_index + '" class="delete_media"><i class="fa fa-times-circle"></i></a><img src="' + evt.target.result + '" alt="" class="img-thumbnail"></div>';
                        var preview_html = '<div class="thumbnail-box" style="margin-top:18px;"><img src="' + evt.target.result + '" alt="" class="img-thumbnail"></div>';
                        $('.preview_media').append(preview_html);
                    }
                } else if (media_type == "video") {
                    //var preview_html = '<div class="thumbnail-box upload_file_ready"><a title="Delete" href="javascript:" data-tempid="' + Project.modules.posts.tmp_files_cur_index + '" class="delete_media"><i class="fa fa-times-circle"></i></a><img src="' + site_url + 'public/images/front/video-icon.png" alt="" class="img-thumbnail"></div>';
                    var preview_html = '<div class="thumbnail-box" style="margin-top:18px;"><img src="' + site_url + 'public/images/front/video-icon.png" alt="" class="img-thumbnail"></div>';
                    $('.preview_media').append(preview_html);
                    /*var fileUrl = window.URL.createObjectURL(imageFile);
                     reader.onload = function (evt) {
                     var preview_html = '<video width="100%" height="100%" controls><source src="' + fileUrl + '" type="' + filetype + '"></video>';
                     $('.preview_media').append(preview_html);
                     }*/
                }
            }
            //Project.modules.post_detailpage.checkValid();
        });

        $(document).on("click", ".delete_media", function (e) {
            e.preventDefault();
            var media_id = $(this).data('mediaid');
            Project.modules.post_detailpage.del_files.push(media_id);
            $(".media_box_" + media_id).remove();
            //console.log(Project.modules.post_detailpage.del_files);
        });


		$(document).on("click", ".share_postdetail", function () {
            var post_id = $(this).data('postid');
            if($(this).data('userid') == '') {
            	location.href= site_url;
            	return false;
            }
            $("#share_post_id").val(post_id);
            $('#sharePostdetail').modal('show');
        });

		$("#sharePostdetail").on('hide.bs.modal', function(){
	        $("#share_post_text").val('');
	     });

        $(document).on("click", "#share_timeline_postdetail", function () {
            
            var formData = new FormData($('#form_share_postdetail')[0]);

            var sharetext = $('#share_post_text').val();
            if(sharetext == '') {
            	$('#share_post_textErr').attr('display','block').html('Please enter share text');
            	return false;
            }
            Project.showUILoader($("#sharePostdetail"), {style: 'black', message: 'Loading.. Please Wait..'});
            $.ajax({
                url: site_url + 'home/share_post_mytimeline',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    $('#sharePostdetail').modal('toggle');
                    $('#share_post_textErr').attr('display','none').html('');
                    if (response.status == "Success") {
                        Project.setMessage("Post shared successfully to your timeline", 1);
                    } else {
                        Project.setMessage(response.message, 0);
                    }
                    Project.hideUILoader($("#sharePostdetail"));
                },
                error: function (e) {
                    //console.log("ERROR : ", e);
                    $('#sharePostdetail').modal('toggle');
                    Project.hideUILoader($("#sharePostdetail"));
                }
            });
        });


		$(document).on('click', '.postreply-link', function () {
			$(this).closest("div").siblings('.reply-comment-box').slideToggle();
		});

		$(document).on('click', '.owl-next', function (e) {

			var mediaid = $('div.owl-item.active>div.item').data('getmediaid');
			var postid = $('div.owl-item.active>div.item').data('getpostid');

		    Project.modules.post_detailpage.ajax_callpostdetail(postid, mediaid);
		    
		});

		$(document).on('click', '.owl-prev', function (e) {

			var mediaid = $('div.owl-item.active>div.item').data('getmediaid');
			var postid = $('div.owl-item.active>div.item').data('getpostid');

		    Project.modules.post_detailpage.ajax_callpostdetail(postid, mediaid);
		    
		});

		$(document).on('keypress', '.actkeypress_postcomment', function (e) {
			var key = window.event.keyCode;
			//console.log(key)
			if(key == 13)  {
				e.preventDefault();
				$('.act_postcomment').trigger('click');
			}
		});

		$(document).on('click', '.act_postcomment', function (e) {
			//var key = window.event.keyCode;
			//console.log(key)
			//if(key == 13) 
			// feed-addedcomment
			{
				//e.preventDefault();
				var comment = $('#commentadd').val(); 
			    var comment_post_id = $(this).data('postid');
			    var comment_mediaid = $(this).data('mediaid');
			    var params = {
			        comment: comment,
			        comment_post_id: comment_post_id,
			        comment_mediaid : comment_mediaid,
			        pagefrom : 'postdetail'
			    }
			    Project.showUILoader($(".post-add-comment"), {style: 'black', message: 'Adding Comment.. please wait ..'});
			    $.ajax({
			        url: site_url + 'home/comment_post',
			        type: 'POST',
			        data: params,
			        dataType: 'json',
			        success: function (response) {
			        	Project.hideUILoader($(".post-add-comment"));
			        	$('#commentadd').val(""); // val
			        	$('.emoji-wysiwyg-editor').html(""); // val
			        	if(response.status == 'Failure') {
			        		$('#errorcomment_disp').html('Error:'+e);
			        	} else {
			        		var countele = parseInt($('#calc_comment_count').html());
			        		countele = countele+1;
			        		$('#calc_comment_count').html(countele);
			        		
		                    $("#comments_list_" + comment_post_id).html(response.comments_data);

		                    $(".displayemoji_comment").each(function(i,e){
	                            var content = $(e).html();
	                            $(e).html('');
	                            window.emojiPicker.appendUnicodeAsImageToElement($(e),content);
	                            $(e).show();
	                        });

							location.reload();
			        	}
			        },
			        error: function (e) {
			            //console.log("ERROR : ", e);
			            $('#commentadd').val("");
			            Project.hideUILoader($(".post-add-comment"));
			        }
			    });
			}
		    
		});

		/*Like or Dislike post*/
		$(document).on('click', '.act_likepost', function () {
		    var post_id = $(this).data('postid');
		    var likes_count = $("#likes_count_" + post_id).html();
		    var mediaid = $(this).data('mediaid');
		    var like_status = 1;
		    if ($("#like_" + post_id).hasClass("active")) {
		        like_status = 0;
		    }
		    Project.showUILoader($(".post-details-block"), {style: 'black', message: 'Please wait ..'});
		    var params = {
		        like_status: like_status,
		        post_id: post_id,
		        mediaid : mediaid,
			    pagefrom : 'postdetail'
		    }
		    $.ajax({
		        type: "post",
		        url: site_url + "home/like_post",
		        data: params,
		        dataType: 'json',
		        success: function (response) {
		        	Project.hideUILoader($(".post-details-block"));
		            if (response.status == "Success") {
		                if (like_status == 1) {
		                    var new_likes_count = parseInt(likes_count) + 1;
		                    $("#like_" + post_id).addClass("active");
		                    $("#like_" + post_id + " i").removeClass("far");
		                    $("#like_" + post_id + " i").addClass("fas");
		                } else {
		                    var new_likes_count = parseInt(likes_count) - 1;
		                    if (isNaN(new_likes_count) || (new_likes_count < 0)) {
		                        new_likes_count = 0;
		                    }
		                    $("#like_" + post_id).removeClass("active");
		                    $("#like_" + post_id + " i").removeClass("fas");
		                    $("#like_" + post_id + " i").addClass("far");
		                }
		                if (new_likes_count == 1) {
		                    var likes_txt = "&nbsp;Like";
		                } else {
		                    var likes_txt = "&nbsp;Likes";
		                }
		                $("#likes_count_" + post_id).attr("data-likescount", new_likes_count);
		                $("#likes_count_" + post_id).html(new_likes_count);
		                $("#displiketext_" + post_id).html(likes_txt);
		            } else {
		            	if(response.status == 'NotLogin') {
		            		location.href = site_url;
		            	} else {
		            		Project.setMessage(response.message, 0);
		            	}
		            }
		        }
		    });
		});

		/*Like or Dislike post comment */
		$(document).on('click', '.act_likepostcomment', function () {
		    var post_id = $(this).data('postid');
		    var postcomment_id = $(this).data('postcommentid');
		    var likes_count = $("#commentlikes_count_" + postcomment_id).html();
		    var like_status = 1;
		    if ($("#postlike_" + postcomment_id).hasClass("active")) {
		        like_status = 0;
		    }
		    Project.showUILoader($("#showloader_"+postcomment_id), {style: 'black', message: 'Please wait ..'});
		    var params = {
		        postcommentid: postcomment_id,
		        post_id: post_id,
		        like_status : like_status
		    }
		    $.ajax({
		        type: "post",
		        url: site_url + "home/like_postcomment",
		        data: params,
		        dataType: 'json',
		        success: function (response) {
		        	Project.hideUILoader($("#showloader_"+postcomment_id));
		            if (response.status == "Success") {
		                if (like_status == 1) {
		                    var new_likes_count = parseInt(likes_count) + 1;
		                    $("#postlike_" + postcomment_id).removeClass("grey-link").addClass('active');
		                    $("#postlike_" + postcomment_id + " i").removeClass("far");
		                    $("#postlike_" + postcomment_id + " i").addClass("fas");
		                } else {
		                    var new_likes_count = parseInt(likes_count) - 1;
		                    if (isNaN(new_likes_count) || (new_likes_count < 0)) {
		                        new_likes_count = 0;
		                    }
		                    $("#postlike_" + postcomment_id).addClass("grey-link").removeClass('active');
		                    $("#postlike_" + postcomment_id + " i").removeClass("fas");
		                    $("#postlike_" + postcomment_id + " i").addClass("far");
		                }
		                /*if (new_likes_count == 1) {
		                    var likes_txt = new_likes_count + " Like";
		                } else {
		                    var likes_txt = new_likes_count + " Likes";
		                }*/
		                $("#commentlikes_count_" + postcomment_id).attr("data-likescount", new_likes_count);
		                $("#commentlikes_count_" + postcomment_id).html(new_likes_count);
		            } else {
		                if(response.status == 'NotLogin') {
		            		location.href = site_url;
		            	} else {
		            		Project.setMessage(response.message, 0);
		            	}
		            }
		        }
		    });
		});


		$(document).on('click', '.report_postdetail', function () {
		    var post_id = $(this).data('postid');
		    if($(this).data('userid') == '') {
            	location.href= site_url;
            	return false;
            }
		    var report_type = $(this).data('report_type');
		    $("#eReprtType").val(report_type);
		    $("#report_post_id").val(post_id);
		    $('#reportPostdetail').modal('show');
		});

		$(document).on('click', '#submit_report_postdetail', function () {
		    var formData = new FormData($('#form_report_postdetail')[0]);
		    Project.showUILoader($("#reportPostdetail"), {style: 'black', message: 'Loading.. Please Wait..'});
		    $.ajax({
		        url: site_url + 'home/report_post',
		        type: 'POST',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        dataType: 'json',
		        success: function (response) {
		            $('#reportPostdetail').modal('toggle');
		            if (response.status == "Success") {
		                Project.setMessage(response.message, 1);
		            } else {
		                Project.setMessage(response.message, 0);
		            }
		            Project.hideUILoader($("#reportPostdetail"));
		        },
		        error: function (e) {
		            $('#reportPostdetail').modal('toggle');
		            Project.hideUILoader($("#reportPostdetail"));
		        }

		    });
		});

		$(document).on('keypress', '.reply_postcomment', function (e) {
			var key = window.event.keyCode;

			//console.log(key)
			if(key == 13) 
			{
				e.preventDefault();
			    var comment_post_id = $(this).data('postid');
			    var postcomment_id = $(this).data('postcommentid');
			    var comment_mediaid = $(this).data('mediaid');
			    var comment = $('#replycommentad_'+postcomment_id).val();
			    var params = {
			        comment: comment,
			        comment_post_id: comment_post_id,
			        comment_mediaid : comment_mediaid,
			        postcomment_id : postcomment_id,
			        pagefrom : 'reply_comment'
			    }
			    Project.showUILoader($("#showloader_"+postcomment_id), {style: 'black', message: 'Please wait ..'});
			    $.ajax({
			        url: site_url + 'home/comment_post',
			        type: 'POST',
			        data: params,
			        dataType: 'json',
			        success: function (response) {
			        	Project.hideUILoader($("#showloader_"+postcomment_id));


			        	$('#replycommentshow_'+postcomment_id).html(response.postdata);
			        	$('#replycommentshow_'+postcomment_id).closest('.feed-comments').mCustomScrollbar("update");
			        	$('#replycommentshow_'+postcomment_id).closest('.feed-comments').mCustomScrollbar("scrollTo", "bottom");	

			        	$('#replycommentad_'+postcomment_id).val('');
			        	if(response.status == 'Failure') {
			        		$('#errorcomment_disp').html('Error:'+e);
			        	} else {
			        		$('.reply-comment-box').hide();
			        		var countele = parseInt($('#disp_replycount_'+postcomment_id).html());
			        		countele = countele+1;
			        		$('#disp_replycount_'+postcomment_id).html(countele);

							location.relode();
			        	}
			        },
			        error: function (e) {
			            $('#replycommentad_'+postcomment_id).val('');
			            Project.hideUILoader($("#showloader_"+postcomment_id));
			        }
			    });
			}
		    
		});

		$(document).on('click', '.deletepostcomment', function () {
		    var post_id = $(this).data('postid');
		    var postcomment_id = $(this).data('postcommentid');


		    bootbox.confirm("Are you sure you want to delete ?", function (result) {

		    	if(result) 
			    {
			    	var params = {
				        post_id: post_id,
				        postcomment_id : postcomment_id
					}
					Project.showUILoader($("#showloader_"+postcomment_id), {style: 'black', message: 'Deleting Please wait ..'});
				    $.ajax({
					        url: site_url + 'home/delete_comment_post',
					        type: 'POST',
					        data: params,
					        dataType: 'json',
					        success: function (response) {
					        	Project.hideUILoader($("#showloader_"+postcomment_id));

					        	$("#showloader_"+postcomment_id).slideToggle();
					        },
					        error: function (e) {
					            Project.hideUILoader($("#showloader_"+postcomment_id));
					            Project.setMessage(response.message, 0);
					        }
					 });
				}

		    });
		    
			    
		});

        $(document).on('click', '.block_user', function(){
          
            $(".new_loader").show();
            user_id = $(this).data('userid');           
            var params = {block_user_id: user_id} 
            $.ajax({
                url: site_url + 'home/block_user',
                type: 'POST',
                data: params,
                dataType: 'json',               
                success: function (response) { 
                               
                    if (response.status == "success") {

                        Project.setMessage(response.message, 1);
                        window.location.href = site_url + 'viral-posts.html';
                    } else {
                        Project.setMessage(response.message, 0);
                    }
                    $(".new_loader").hide();
                   // window.location.reload();
                   
                },
                error: function (e) {
                    console.log("ERROR : ", e);                   
                    $(".new_loader").hide();
                }

            });   
        });

		$(document).on('click', '.deletereplycomment', function () {
		    var post_id = $(this).data('postid');
		    var postcomment_id = $(this).data('postcommentid');

		    bootbox.confirm("Are you sure you want to delete ?", function (result) {
			    if(result) 
			    {
			    	var params = {
				        post_id: post_id,
				        postcomment_id : postcomment_id
					}
					Project.showUILoader($("#showreplyloader_"+postcomment_id), {style: 'black', message: 'Deleting Please wait ..'});
				    $.ajax({
					        url: site_url + 'home/delete_comment_post',
					        type: 'POST',
					        data: params,
					        dataType: 'json',
					        success: function (response) {
					        	Project.hideUILoader($("#showreplyloader_"+postcomment_id));

					        	$("#showreplyloader_"+postcomment_id).slideToggle();
					        },
					        error: function (e) {
					            Project.hideUILoader($("#showreplyloader_"+postcomment_id));
					            Project.setMessage(response.message, 0);
					        }
					    });
				    }
				});
		    });
	},
	ajax_callpostdetail : function (postid, mediaid) {
		var params = {
	        posted_postid: postid,
	        posted_mediaid : mediaid,
	        pagefrom : 'reloadpost'
	    }
	    Project.showUILoader($(".main-container"), {style: 'black', message: 'Loading.. Please Wait..'});
	    $.ajax({
	        url: site_url + 'home/post_detail',
	        type: 'POST',
	        data: params,
	        dataType: 'json',
	        success: function (response) {
	        	Project.hideUILoader($(".main-container"));
	        	$("#inner_postdetail").html(response.post_data);
	        },
	        error: function (e) {
	            Project.hideUILoader($(".main-container"));
	        }
	    });
	},
    initPlyr: function () {
        plyr.setup(".plyr-video");
    }
};

/*$(document).on('click', '.otherpost_act', function (e) {

	var postid = $(this).data('otherpostid');

    ajax_callpostdetail(postid, 0);
    
});*/

