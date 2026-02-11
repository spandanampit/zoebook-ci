<section class="reels-section">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary-blue: #0866ff;
        --soft-bg: #f0f2f5;
        --glass-white: rgba(255, 255, 255, 0.9);
        --text-dark: #1c1e21;
        --border-radius: 20px;
    }

    body {
        margin: 0;
        background: var(--soft-bg);
        overflow: hidden;
        height: 100vh;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* 1. Perfect Screen Fit Container */
    .reels-container {
        height: 100vh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scrollbar-width: none;
        scroll-behavior: smooth;
    }
    .reels-container::-webkit-scrollbar { display: none; }

    .reel {
        height: 105vh; /* Fixed height to match viewport */
        width: 100%;
        scroll-snap-align: start;
        scroll-snap-stop: always;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    /* 2. Enhanced Video Frame */
    .video-frame {
        position: relative;
        width: min(420px, 95%);
        height: min(820px, 92vh); /* Prevents the "peeking" issue */
        background: #000;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        border: 4px solid #fff;
    }

    .reel-video { width: 100%; height: 100%; object-fit: cover; }

    /* 3. Navigation & Fixed Buttons */
    .reel-back-btn {
        position: fixed;
        top: 90px;
        left: 25px;
        width: 45px;
        height: 45px;
        background: var(--glass-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .reel-back-btn:hover { transform: scale(1.1); }

    .nav-arrows {
        position: fixed;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 20px;
        z-index: 1000;
    }

    .nav-btn {
        width: 45px;
        height: 45px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* 4. Action Sidebar & Info */
    .right-bar {
        position: absolute;
        right: 15px;
        bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 10;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background: var(--glass-white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 4px;
        backdrop-filter: blur(8px);
    }

    .icon-circle i { font-size: 20px; color: var(--text-dark); }
    .action-item span { color: white; font-size: 12px; font-weight: 700; text-shadow: 0 1px 3px #000; }
    .liked i { color: #ff3b5c !important; }

    .bottom-info {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        padding: 40px 80px 30px 20px;
        background: linear-gradient(transparent, rgba(0,0,0,0.85));
        color: white;
        z-index: 5;
    }

    .user-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .follow-btn {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 15px;
        font-weight: 700;
        font-size: 12px;
    }

    /* 5. Modern Comment Sidebar */
    .comments-panel {
        position: fixed;
        right: 0; top: 0; bottom: 0;
        width: 100%; max-width: 420px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(25px); /* Strong frosted glass effect */
        -webkit-backdrop-filter: blur(25px);
        z-index: 2000;
        transform: translateX(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        border-left: 1px solid rgba(255, 255, 255, 0.3);
    }

    .comments-header {
        padding: 24px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comments-header h3 {
        font-weight: 800;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #0866ff, #00c6ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .comments-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        scroll-behavior: smooth;
    }

    /* Modern Bubble Style */
    .comment-item {
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        animation: slideIn 0.3s ease forwards;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .comment-avatar {
        width: 38px;
        height: 38px;
        border-radius: 12px; /* Squircle for modern look */
        object-fit: cover;
    }

    .comment-content {
        background: #fff;
        padding: 12px 16px;
        border-radius: 18px;
        border-top-left-radius: 4px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        flex: 1;
    }

    /* AI Smart Input Area */
    .comments-footer {
        padding: 20px;
        background: rgba(255, 255, 255, 0.5);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .ai-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 30px;
        padding: 4px;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease;
    }

    /* Neon Pulse Border for AI feel */
    .ai-input-wrapper:focus-within {
        box-shadow: 0 0 0 2px #0866ff, 0 0 15px rgba(8, 102, 255, 0.2);
    }

    #commentInput {
        flex: 1;
        border: none;
        padding: 12px 18px;
        background: transparent;
        outline: none;
        font-size: 14px;
    }

    .ai-sparkle-btn {
        background: linear-gradient(135deg, #0866ff, #00c6ff);
        color: #fff;
        border: none;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .ai-sparkle-btn:hover {
        transform: scale(1.05) rotate(5deg);
    }

    /* AI Suggestions Chips */
    .ai-chips {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .ai-chips::-webkit-scrollbar { display: none; }

    .chip {
        white-space: nowrap;
        background: rgba(8, 102, 255, 0.08);
        color: #0866ff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid rgba(8, 102, 255, 0.1);
    }

    .chip:hover {
        background: #0866ff;
        color: #fff;
    }
    /* Buttons with Glow Effect */
    #timelineModal .btn-primary {
        background: linear-gradient(135deg, #0866ff, #00c6ff);
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(8, 102, 255, 0.3);
        transition: all 0.3s ease;
    }

    .comments-panel.active {
        transform: translateX(0);
    }

    #timelineModal .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(8, 102, 255, 0.4);
    }

    #timelineModal .btn-secondary {
        background: transparent;
        color: #65676b;
        border: none;
        font-weight: 600;
    }

    /* Animation: Smooth Scale-in */
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }

    /*loader*/
    /* Container centering */
    .advanced-loader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        gap: 15px;
    }

    /* The Spinner Shell */
    .loader-spinner {
        position: relative;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Gradient Rotating Ring */
    .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(from 0deg, transparent 30%, #0866ff);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 4px), #fff 0);
        mask: radial-gradient(farthest-side, transparent calc(100% - 4px), #fff 0);
        animation: spin 0.8s linear infinite;
    }

    /* Pulsing Core */
    .spinner-core {
        width: 12px;
        height: 12px;
        background: #0866ff;
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(8, 102, 255, 0.5);
        animation: pulse 1.5s ease-in-out infinite;
    }

    /* Shimmering Text */
    .loader-text {
        font-size: 13px;
        font-weight: 600;
        color: #8e8e8e;
        letter-spacing: 0.5px;
        background: linear-gradient(90deg, #8e8e8e 0%, #1c1e21 50%, #8e8e8e 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 2s linear infinite;
    }

    /* Animations */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.3); opacity: 1; }
    }

    @keyframes shimmer {
        to { background-position: 200% center; }
    }

    .action-item .fa-eye {
        font-size: 18px;
        opacity: 0.9;
    }

    #offcanvasExample {
        display: none;
    }

    .header-search-2 {
        width: 40% !important;
        margin-right: 0;
    }
</style>

<div class="reel-back-btn" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></div>

<div class="reels-container" id="reelsContainer">
    <%foreach item=row key=i from=$reelsData%>
    <div class="reel" data-post-id="<%$row['p_post_id']%>" data-media-id="<%$row['post_media_id']%>">
        <div class="video-frame">
            <%if $row['um_media_type'] eq 'Video'%>
            <video class="reel-video" src="<%$row['um_upload_file']%>" loop playsinline muted onclick="this.paused ? this.play() : this.pause()"></video>
            <%else%>
            <img src="<%$row['um_upload_file']%>" class="reel-video">
            <%/if%>

            <div class="bottom-info">
                <div class="user-pill">
                    <img src="<%$row['u_profile_image']%>" style="width:40px; height:40px; border-radius:50%; border:2px solid #fff">
                    <span style="font-weight:700"><%$row['u_name']%></span>
                    <button
                        class="follow-btn"
                        onclick="followUserV2(event, this, <%$row['p_user_id']%>)">
                        Follow
                    </button>

                </div>
                <div style="font-size:14px; margin-bottom:10px; line-height:1.4"><%$row['p_post_text']%></div>
                <div style="font-size:13px; opacity:0.9"><i class="fa-solid fa-music"></i> <%$row['u_name']%> · Original Audio</div>
            </div>

            <div class="right-bar">
                <div class="action-item" onclick="handleLike(this)">
                    <div class="icon-circle <%if $row['is_like'] == 1%>liked<%/if%>">
                        <i class="fa-heart <%if $row['is_like'] == 1%>fa-solid<%else%>fa-regular<%/if%>"></i>
                    </div>
                    <span><%$row['likes_count']%></span>
                </div>

                <div class="action-item" onclick="showComments(this)">
                    <div class="icon-circle"><i class="fa-regular fa-comment"></i></div>
                    <span><%$row['comment_count']%></span>
                </div>

                <div class="action-item"
                    onclick="addToPlaylist(this, <%$row['p_post_id']%>)"
                    data-added="<%$row['is_top_playlist']%>">

                    <div class="icon-circle">
                        <i class="fa-solid <%if $row['is_top_playlist'] == 1%>fa-check<%else%>fa-plus<%/if%> playlist-icon"></i>
                    </div>

                    <span class="playlist-text">
                        <%if $row['is_top_playlist'] == 1%>Added<%else%>Add<%/if%>
                    </span>
                </div>
 

                <div class="action-item" onclick="shareReel(<%$row['p_post_id']%>)" data-toggle="modal" data-target="#timelineModal">
                    <div class="icon-circle"><i class="fa-solid fa-share"></i></div>
                    <span>Share</span>
                </div>

                <div class="action-item">
                    <div class="icon-circle">
                        <i class="fa-regular fa-eye"></i>
                    </div>
                    <span><%$row['views_count']%></span>
                </div>
            </div>
        </div>
    </div>
    <%/foreach%>
</div>

<div class="nav-arrows">
    <div class="nav-btn" onclick="scrollReel('up')"><i class="fa-solid fa-chevron-up"></i></div>
    <div class="nav-btn" onclick="scrollReel('down')"><i class="fa-solid fa-chevron-down"></i></div>
</div>

<div class="comments-panel" id="commentsPanel">
    <div class="comments-header">
        <h3 style="margin:0">Comments</h3>
        <i class="fa-solid fa-circle-xmark close-comments" onclick="closeComments()" style="cursor:pointer; font-size:24px; color: #b0b3b8;"></i>
    </div>

    <div class="comments-body" id="commentsBody">
        <!--loader-->
        <div id="commentsLoader" style="display:none;">
            <div class="advanced-loader-container">
                <div class="loader-spinner">
                    <div class="spinner-ring"></div>
                    <div class="spinner-core"></div>
                </div>
                <div class="loader-text">Loading insights...</div>
            </div>
        </div>

        <div class="comment-item">
            <img src="https://zoebook.mydevfactory.com/public/images/noimage.gif" class="comment-avatar">
            <div class="comment-content">
                <div style="font-weight: 800; font-size: 13px; color: #1c1e21; margin-bottom: 2px;">Alex Rivera</div>
                <div style="font-size: 14px; color: #4b4b4b; line-height: 1.4;">This edit is absolutely next level! 🔥</div>
            </div>
        </div>
    </div>

    <div class="comments-footer">
        <div class="ai-chips">
            <div class="chip" onclick="applyChip('Amazing! 🔥')">Amazing! 🔥</div>
            <div class="chip" onclick="applyChip('Love the edit! 🙌')">Love the edit! 🙌</div>
            <div class="chip" onclick="applyChip('Tutorial please? ✨')">Tutorial please? ✨</div>
        </div>

        <div class="ai-input-wrapper">
            <input type="text" id="commentInput" placeholder="Add a comment...">
            <input type="hidden" id="post_id" value="">
            <input type="hidden" id="media_id" value="">
            <button class="ai-sparkle-btn" onclick="submitComment()">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-between">
                <h5 class="modal-title" id="timelineModalLabel">Share Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; opacity: 0.5;">
                    <span aria-hidden="true" style="font-size: 28px;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <input type="hidden" class="modal-post-id" name="share_post_id" value="">
                <textarea class="form-control" placeholder="Add your thoughts to this reel..." rows="4"></textarea>
                
                <div class="mt-3 d-flex gap-2">
                    <span style="font-size: 12px; font-weight: 700; color: #0866ff; background: rgba(8, 102, 255, 0.1); padding: 4px 12px; border-radius: 20px; cursor: pointer;">#Trending</span>
                    <span style="font-size: 12px; font-weight: 700; color: #0866ff; background: rgba(8, 102, 255, 0.1); padding: 4px 12px; border-radius: 20px; cursor: pointer;">#Viral</span>
                </div>
            </div>
            <div class="modal-footer" style="border-top: none; padding: 20px 25px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Share Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    let isLoading = false;
    let nextPage = 2;
    let noMoreReels = false;
    let currentCommentPostId = null;

    // 1. Snapping & Playback (Updated Observer with play/pause and initial active)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const reel = entry.target;
            const video = reel.querySelector('.reel-video');

            if (entry.isIntersecting) {
                reel.classList.add('active-reel');
                if (video && video.tagName === 'VIDEO') {
                    video.play().catch(() => {}); // Handle play errors silently (e.g., browser policies)
                }

                // 🧠 IF comments panel is open → reload comments
                if (document.getElementById('commentsPanel').classList.contains('active')) {
                    const commentBtn = reel.querySelector(
                        '.action-item i.fa-comment'
                    )?.closest('.action-item');

                    if (commentBtn) {
                        showComments(commentBtn);
                    }
                }
            } else {
                reel.classList.remove('active-reel');
                if (video && video.tagName === 'VIDEO') {
                    video.pause();
                }
            }
        });
    }, { threshold: 0.8 });

    document.querySelectorAll('.reel').forEach(r => observer.observe(r));

    // Set first reel as active on load and play if video
    const firstReel = document.querySelector('.reel');
    if (firstReel) {
        firstReel.classList.add('active-reel');
        const firstVideo = firstReel.querySelector('.reel-video');
        if (firstVideo && firstVideo.tagName === 'VIDEO') {
            firstVideo.play().catch(() => {});
        }
    }

    // 2. Navigation Logic (Now works with initial active)
    function scrollReel(dir) {
        const container = document.getElementById('reelsContainer');
        const active = document.querySelector('.active-reel');
        if (!active) return; // Safety check, though initial active is now set
        const target = dir === 'down' ? active.nextElementSibling : active.previousElementSibling;
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // 3. Like Logic
    function handleLike(el) {
        const btn = el.querySelector('.icon-circle');
        const icon = btn.querySelector('i');
        const count = el.querySelector('span');
        const reel = el.closest('.reel');
        
        const isLiked = btn.classList.toggle('liked');
        icon.classList.toggle('fa-solid');
        icon.classList.toggle('fa-regular');
        
        let val = parseInt(count.innerText);
        count.innerText = isLiked ? val + 1 : val - 1;

        $.post("<%$this->url->make('home/home/like_post')%>", {
            post_id: reel.dataset.postId,
            mediaid: reel.dataset.mediaId,
            like_status: isLiked ? 1 : 0
        });
    }

    // 4. Comment AJAX Logic (From your original code)
    function showComments(el) {
        const reel = el.closest('.reel');
        const postId = reel.dataset.postId;
        const mediaId = reel.dataset.mediaId;

        // avoid useless reload
        if (currentCommentPostId === postId) return;
        currentCommentPostId = postId;

        const panel = document.getElementById('commentsPanel');
        const body  = document.getElementById('commentsBody');

        panel.classList.add('active');

        document.getElementById('post_id').value = postId;
        document.getElementById('media_id').value = mediaId;

        // 🔥 clear + loader
        body.innerHTML = `
            <div style="text-align:center; padding:40px;">
                <i class="fa-solid fa-spinner fa-spin"
                style="font-size:24px; color:#0866ff;"></i>
            </div>
        `;

        $.post("<%$this->url->make('home/home/get_comments')%>", {
            comment_post_id: postId,
            comment_mediaid: mediaId,
            raw_data: 1
        }, function (res) {

            body.innerHTML = res.comments_data?.length
                ? res.comments_data.map(c => `
                    <div style="display:flex; gap:12px; margin-bottom:15px">
                        <img src="${c.profile_image_url || 'https://via.placeholder.com/35'}"
                            style="width:35px; height:35px; border-radius:50%">
                        <div style="background:#fff; padding:10px; border-radius:15px; flex:1">
                            <div style="font-weight:700; font-size:13px">${c.user_name}</div>
                            <div style="font-size:13px">${c.comment}</div>
                        </div>
                    </div>
                `).join('')
                : `<div style="text-align:center; padding:30px; color:#888;">
                    No comments yet
                </div>`;
        }, 'json');
    }

    function closeComments() {
        document.getElementById('commentsPanel').classList.remove('active');
        currentCommentPostId = null; // Reset to allow reload on reopen
    }

    // Playlist Logic
    window.addToPlaylist = function(el, postId) {
        const icon = el.querySelector('.playlist-icon');
        const text = el.querySelector('.playlist-text');
        icon.classList.replace('fa-plus', 'fa-check');
        text.innerText = 'Added';
        
        $.post("<%$this->url->make('content/content/addToPlaylist')%>", { postId: postId });
    };

    function shareReel(postId) {
        const modal = $('#timelineModal');
        modal.find('.modal-post-id').val(postId);
        // Clear previous text
        modal.find('textarea').val('');
    }

    function submitTimeline() {
        var modal = $('#timelineModal');

        var postId = modal.find('.modal-post-id').val();
        var caption = modal.find('textarea').val().trim();

        console.log(caption);

        if (!postId) {
            Project.setMessage('Invalid post.', 0);
            return;
        }

        var formData = new FormData();
        formData.append('share_post_id', postId);
        formData.append('share_post_text', caption);

        Project.showUILoader(modal, {
            style: "black",
            message: "Sharing.. Please wait..",
        });

        $.ajax({
            url: site_url + "home/share_post_mytimeline",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                modal.modal('hide');

                if (response.status === "Success") {
                    Project.setMessage(response.message, 1);
                } else {
                    Project.setMessage(response.message, 0);
                }

                Project.hideUILoader(modal);
            },
            error: function (e) {
                console.log("ERROR:", e);
                modal.modal('hide');
                Project.setMessage('Something went wrong. Try again.', 0);
                Project.hideUILoader(modal);
            }
        });
    }

    function applyChip(text) {
        const input = document.getElementById('commentInput');
        input.value = text;
        input.focus();
    }

    // Helper to scroll to bottom when new comment added
    function scrollToBottom() {
        const body = document.getElementById('commentsBody');
        body.scrollTop = body.scrollHeight;
    }


    function followUserV2(e, btn, userId) {
        e.preventDefault();
        e.stopPropagation();

        if (!userId || btn.disabled) return;

        const prevState = btn.dataset.state || 'follow';

        // lock button
        btn.disabled = true;
        btn.style.opacity = '0.7';

        let formData = new FormData();
        formData.append('user_follow_request_id', userId);

        let url = "<%$this->url->make('home/home/followUser')%>";

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",

            success: function (response) {
                if (response.success == 1) {
                    // 🔥 FRONTEND decides next state
                    const nextState = getNextState(prevState);
                    applyButtonState(btn, nextState);
                } else {
                    applyButtonState(btn, prevState);
                }
            },

            error: function () {
                applyButtonState(btn, prevState);
            },

            complete: function () {
                btn.disabled = false;
                btn.style.opacity = '1';
            }
        });
    }

    /**
    * State machine (frontend-only)
    */
    function getNextState(state) {
        switch (state) {
            case 'follow':
                return 'requested';   // send request
            case 'requested':
                return 'follow';      // cancel request
            case 'following':
                return 'follow';      // unfollow
            default:
                return 'follow';
        }
    }


    function applyButtonState(btn, state) {
        btn.dataset.state = state;

        switch (state) {
            case 'follow':
                btn.innerText = 'Follow';
                btn.style.background = 'var(--primary-blue)';
                btn.style.color = '#fff';
                break;

            case 'requested':
                btn.innerText = 'Requested';
                btn.style.background = '#999';
                btn.style.color = '#fff';
                break;

            case 'following':
                btn.innerText = 'Following';
                btn.style.background = '#65676b';
                btn.style.color = '#fff';
                break;
        }
    }


    function submitComment() {
        const input   = document.getElementById('commentInput');
        const comment = input.value.trim();
        const postId  = document.getElementById('post_id').value;
        const mediaId = document.getElementById('media_id').value;

        if (!comment || !postId) return;

        let url = "<%$this->url->make('home/home/comment_post')%>";

        let params = {
            comment_post_id: postId,
            comment: comment,
            comment_mediaid: mediaId,
            raw_data: 1
        };

        $.post(url, params, function (res) {
            if (res.status !== 'Success' || !res.comments_data?.length) return;

            const newComment = res.comments_data[0];

            appendComment(newComment);
            incrementCommentCount();
            scrollToBottom();
        }, 'json');

        input.value = '';
    }

    function appendComment(c) {
        const body = document.getElementById('commentsBody');

        const html = `
            <div class="comment-item">
                <img src="${c.profile_image_url || 'https://zoebook.mydevfactory.com/public/images/noimage.gif'}"
                    class="comment-avatar">

                <div class="comment-content">
                    <div style="font-weight:800; font-size:13px; margin-bottom:2px">
                        ${c.user_name}
                    </div>
                    <div style="font-size:14px; line-height:1.4">
                        ${escapeHtml(c.comment)}
                    </div>
                </div>
            </div>
        `;

        body.insertAdjacentHTML('afterbegin', html);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }

    function incrementCommentCount() {
        const postId = document.getElementById('post_id').value;

        if (!postId) return;

        const reel = document.querySelector(`.reel[data-post-id="${postId}"]`);
        if (!reel) return;

        const commentAction = reel.querySelector('.action-item i.fa-comment')?.closest('.action-item');
        const countSpan = commentAction?.querySelector('span');

        if (!countSpan) return;

        countSpan.innerText = parseInt(countSpan.innerText || 0) + 1;
    }

    function commentsLoaderHTML() {
        return `
            <div class="advanced-loader-container">
                <div class="loader-spinner">
                    <div class="spinner-ring"></div>
                    <div class="spinner-core"></div>
                </div>
                <div class="loader-text">Loading insights...</div>
            </div>
        `;
    }

    const reelsContainer = document.getElementById('reelsContainer');

    reelsContainer.addEventListener('scroll', () => {
        if (noMoreReels || isLoading) return;

        const threshold = 4500; 
        if (
            reelsContainer.scrollTop + reelsContainer.clientHeight >=
            reelsContainer.scrollHeight - threshold
        ) {
            loadMoreReels();
        }
    });

    function loadMoreReels() {
        isLoading = true;

        const lastReel = document.querySelector('.reel:last-child');
        const lastPostId = lastReel ? lastReel.dataset.postId : 0;

        // fetch(`/reels/get_more_reels?nxpg=${nextPage}&post_id=${lastPostId}`)
        fetch("<%$this->url->make('home/home/get_more_reels')%>?nxpg=" + nextPage + "&post_id=" + lastPostId)
        .then(res => res.json())
        .then(data => {
            if (!data || data.length === 0) {
                noMoreReels = true;
                return;
            }

            appendReels(data);
            nextPage++;
        })
        .catch(err => console.error(err))
        .finally(() => {
            isLoading = false;
        });
    }

    function appendReels(reels) {
        const container = document.getElementById('reelsContainer');

        reels.forEach(row => {
            const div = document.createElement('div');
            div.className = 'reel';
            div.dataset.postId = row.p_post_id;
            div.dataset.mediaId = row.post_media_id;

            div.innerHTML = `
                <div class="video-frame">
                    ${
                        row.um_media_type === 'Video'
                            ? `<video class="reel-video" src="${row.um_upload_file}" loop playsinline muted onclick="this.paused ? this.play() : this.pause()"></video>`
                            : `<img src="${row.um_upload_file}" class="reel-video">`
                    }

                    <div class="bottom-info">
                        <div class="user-pill">
                            <img src="${row.u_profile_image}" style="width:40px; height:40px; border-radius:50%; border:2px solid #fff">
                            <span style="font-weight:700">${row.u_name}</span>
                            <button class="follow-btn"
                                onclick="followUserV2(event, this, ${row.p_user_id})">
                                Follow
                            </button>
                        </div>
                        <div style="font-size:14px; margin-bottom:10px; line-height:1.4">
                            ${row.p_post_text}
                        </div>
                        <div style="font-size:13px; opacity:0.9"><i class="fa-solid fa-music"></i> ${row.u_name} · Original Audio</div>
                    </div>

                    <div class="right-bar">
                        <div class="action-item" onclick="handleLike(this)">
                            <div class="icon-circle ${row.is_like == 1 ? 'liked' : ''}">
                                <i class="fa-heart ${row.is_like == 1 ? 'fa-solid' : 'fa-regular'}"></i>
                            </div>
                            <span>${row.likes_count}</span>
                        </div>

                        <div class="action-item" onclick="showComments(this)">
                            <div class="icon-circle"><i class="fa-regular fa-comment"></i></div>
                            <span>${row.comment_count}</span>
                        </div>

                        <div class="action-item"
                            onclick="addToPlaylist(this, ${row.p_post_id})"
                            data-added="${row.is_top_playlist}">

                            <div class="icon-circle">
                                <i class="fa-solid ${row.is_top_playlist == 1 ? 'fa-check' : 'fa-plus'} playlist-icon"></i>
                            </div>

                            <span class="playlist-text">
                                ${row.is_top_playlist == 1 ? 'Added' : 'Add'}
                            </span>
                        </div>

                        <div class="action-item" onclick="shareReel(${row.p_post_id})" data-toggle="modal" data-target="#timelineModal">
                            <div class="icon-circle"><i class="fa-solid fa-share"></i></div>
                            <span>Share</span>
                        </div>

                        <div class="action-item">
                            <div class="icon-circle">
                                <i class="fa-regular fa-eye"></i>
                            </div>
                            <span>${row.p_post_id}</span>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(div);
            observer.observe(div);
        });
    }


</script>
</section>