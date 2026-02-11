
<style>
.gif-grid-css {
    display: grid;
    grid-template-columns: auto auto auto;
    overflow-y: scroll;
    width: 100%;
    height: 11rem;
    background: white;
}

.comment-image {
    max-width: 31%;
    max-height: 84px;
    object-fit: cover;
    border-radius: 10px;
}
</style>

<%if !empty($row['comment_details'])%>
    <%assign var=comments value=$row['comment_details']%>
    <%include file="common/display_comments.tpl" comments=$row['comment_details']%>
<%else%>
    <li>No comments</li>
<%/if%>


<script>
function checkEnter(event, commentId) {
    if (event.key === "Enter") {
        event.preventDefault(); 
        reply_comment(commentId);
    }
}

function reply_comment(commentId) {
    const commentText = document.getElementById(`replycommentad_${commentId}`).value;
    const postId = document.getElementById(`reply_postId_${commentId}`).value;

    console.log("Replying to comment ID:", commentId);
    console.log("Comment text:", commentText);
    console.log("Post Id:", postId);

    const url = "<%$this->url->make('movement/movement/comments_reply')%>";
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            post_comment_id: commentId,
            post_id: postId,
            reply_text: commentText
        },
        success: function(response) {
            document.getElementById(`replycommentad_${commentId}`).value = '';  // Clear input

            if (typeof response === 'string') {
                response = JSON.parse(response);
            }

            if (response.success == 1 && response.reply_comment) {
                console.log("Replies received:", response.reply_comment);

                const replyList = $('#replycommentshow_' + commentId);
                if (replyList.length > 0) {
                    replyList.empty(); // Clear old replies if any
                }

                // Loop through and append replies
                response.reply_comment.forEach(reply => {
                    const replyHtml = `
                        <li id="showreplyloader" style="margin-right:25px;">
                            <div class="user-comments-row">
                                <div class="comments-block">
                                    <div class="comments-user-row">
                                        <div class="comments-user-details">
                                            <i class="cmn-user-img" style="min-width: 37px !important; height: 39px !important; width: 0px !important;">
                                                <a href="/profile/${reply.user_id}" class="name">
                                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${reply.profile_image}" alt="User Image" class="img-fluid" style="height: 4rem !important;">
                                                </a>
                                            </i>
                                            <h6 style="display: flex;">
                                                <a href="/profile/${reply.user_id}" class="name">${reply.user_name}</a>
                                                <div class="comments-time">
                                                    ${reply.added_date}
                                                </div>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="user-comments">
                                        <p>${reply.comment}</p>
                                        ${reply.upload_file ? `
                                            <video controls height="auto" width="300px">
                                                <source src="/path/to/videos/${reply.upload_file}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>` : ''}
                                    </div>
                                </div>
                            </div>
                        </li>`;
                    
                    replyList.append(replyHtml);
                });

                // Show the reply section if it was hidden
                $('#feed_replies_' + commentId).show();
            } else {
                console.error('No reply_comment data found');
            }
        },
        error: function(error) {
            console.error("Error submitting reply:", error);
        }
    });
}

</script>