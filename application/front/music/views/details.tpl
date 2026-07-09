<!--<pre>
    <%$musicDetail|print_r%>
</pre>-->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="min-h-screen bg-[#FDFDFF] text-slate-800 font-sans flex flex-col lg:flex-row">

    <aside class="lg:w-[380px] w-full lg:h-screen lg:sticky lg:top-0 bg-white border-r border-slate-100 p-8 flex flex-col z-20 shadow-sm">

        <!-- ================= PROFILE VIEW ================= -->
        <div id="sidebar-profile" class="flex flex-col justify-between h-full">

            <div>
                <div class="flex items-center justify-between mb-12">
                    <a href="music.html" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-arrow-left text-slate-400"></i>
                    </a>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-500">Curated Space</span>
                </div>

                <div class="text-center">
                    <div class="relative inline-block mb-6 group">
                    <div class="absolute -inset-1 bg-gradient-to-tr from-indigo-500 to-cyan-400 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <img src="<%$musicDetail[0]['user']['avatar']%>" alt="Avatar" class="relative w-32 h-32 rounded-full border-4 border-white shadow-xl object-cover">
                    <span class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></span>
                    </div>

                    <h2 class="text-3xl font-black tracking-tight text-slate-900 mb-1">
                    <%$musicDetail[0]['user']['name']%>
                    </h2>

                    <p class="text-slate-400 font-medium text-sm mb-8">
                    Architectural Cinematographer
                    </p>
                    
                    <div class="flex items-center justify-center gap-10 mb-10">
                    <div class="text-center">
                        <span class="block text-xl font-bold text-slate-900">
                        <%$musicDetail[0]['follower_count']%>
                        </span>
                        <span class="text-[10px] uppercase text-slate-400 font-bold tracking-widest">
                        Followers
                        </span>
                    </div>
                    <div class="text-center">
                        <span class="block text-xl font-bold text-slate-900">
                        <%$musicDetail[0]['following_count']%>
                        </span>
                        <span class="text-[10px] uppercase text-slate-400 font-bold tracking-widest">
                        Following
                        </span>
                    </div>
                    </div>

                    <div class="space-y-3">
                    <button 
                        id="follow-user"
                        data-userid="<%$musicDetail[0]['iUserId']%>"
                        data-myid = "<%$userId%>"
                        data-state="follow"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white transition-all py-4 rounded-2xl font-bold shadow-xl shadow-indigo-100 active:scale-[0.98]">
                        <%$following_status%>
                    </button>

                    <button 
                        id="open-discussion-btn"
                        class="w-full flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-500 py-4 rounded-2xl font-bold border border-slate-200 transition-all">
                        <i class="fa-regular fa-comment-dots text-lg"></i>
                        Open Discussion
                    </button>
                    </div>
                </div>
            </div>

            <div class="pt-8 mt-8 border-t border-slate-50 hidden lg:block">
                <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest leading-relaxed">
                    Shared Playlist &copy; 2026<br>
                    All Rights Reserved
                </p>
            </div>

        </div>


        <!-- ================= DISCUSSION VIEW ================= -->
        <div id="sidebar-discussion" class="hidden flex flex-col h-full">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">Discussion</h3>
            <button id="close-discussion" class="text-slate-400 text-2xl leading-none hover:text-slate-700">
                &times;
            </button>
            </div>

            <!-- Comment List -->
            <div id="comment-list" class="flex-1 overflow-y-auto space-y-4 mb-4 pr-2" data-userid="<%$musicDetail[0]['iUserId']%>" data-postid="<%$musicDetail[0]['iPostId']%>">
            <!-- Comments will appear here -->
            </div>

            <!-- Comment Input -->
            <div class="border-t border-slate-100 pt-4">
            <textarea 
                id="comment-input"
                placeholder="Write your thoughts..."
                class="w-full border border-slate-200 rounded-xl p-3 resize-none focus:outline-none"
                rows="3">
            </textarea>

            <button 
                id="submit-comment"
                class="mt-3 w-full bg-indigo-600 text-white py-3 rounded-xl">
                Post Comment
            </button>
            </div>

        </div>

    </aside>

  <main class="flex-1">
    
    <section class="relative w-full h-[60vh] lg:h-[75vh] overflow-hidden group">
      <img src="<%$musicDetail[0]['music']['thumbnail_url']%>" class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-105" alt="Featured">
      
      <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-black/20"></div>

      <div class="absolute top-10 left-10 flex gap-4">
        <div class="backdrop-blur-md bg-black/20 border border-white/20 px-5 py-2 rounded-full text-white text-xs font-bold uppercase tracking-widest">
           <i class="fa-solid fa-eye me-2"></i> 142.5k Views
        </div>
      </div>

        <div class="absolute bottom-0 left-0 w-full p-8 lg:p-12">
            <div class="backdrop-blur-2xl bg-white/80 border border-white p-8 lg:p-12 rounded-[3rem] shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8 max-w-[1600px] mx-auto">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-4">
                        <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                        <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">Premiere Selection</span>
                    </div>
                    <h1 class="text-3xl lg:text-5xl font-black text-slate-900 mb-4 tracking-tight"><%$musicDetail[0]['music']['title']%></h1>
                    <p class="text-slate-600 max-w-2xl text-lg leading-relaxed"><%$musicDetail[0]['tPostTextEmoji']%></p>
                </div>
                    <!--Main Audio-->
                <audio id="main-audio" src="<%$musicDetail[0]['music']['audio_url']%>"></audio>
                <button id="play-main-music" class="w-24 h-24 shrink-0 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:scale-110 hover:bg-indigo-700 transition-all shadow-2xl shadow-indigo-200">
                    <i class="fa-solid fa-play text-4xl ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    
<!--comments section-->
<!-- Discussion Section -->
<section id="discussion-section" class="hidden p-8 lg:p-16 max-w-[1200px] mx-auto border-t border-slate-100">
  
  <h3 class="text-2xl font-bold mb-6">Discussion</h3>

  <!-- Comment Form -->
  <div class="mb-8">
    <textarea 
      id="comment-input"
      placeholder="Write your thoughts..."
      class="w-full border border-slate-200 rounded-xl p-4 resize-none focus:outline-none"
      rows="4"></textarea>

    <button 
      id="submit-comment"
      class="mt-4 px-6 py-3 bg-indigo-600 text-white rounded-xl">
      Post Comment
    </button>
  </div>

  <!-- Comment List -->
  <div id="comment-list" class="space-y-6">
    <!-- Comments will appear here -->
  </div>

</section>

    <section class="p-8 lg:p-16 max-w-[1800px] mx-auto">
      <div class="flex items-end justify-between mb-12">
        <div>
          <h3 class="text-4xl font-black text-slate-900 tracking-tighter">Up Next</h3>
          <p class="text-slate-400 mt-2 font-medium">Continue your journey through the collection</p>
        </div>
        <div class="flex gap-4">
          <button class="w-14 h-14 rounded-2xl border border-slate-100 bg-white flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
          <button class="w-14 h-14 rounded-2xl border border-slate-100 bg-white flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
            <i class="fa-solid fa-chevron-right text-indigo-600"></i>
          </button>
        </div>
      </div>

        <div id="musicGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            <%foreach item=row from=$otherPosts%>
                <a href="<%$this->url->make('music/music/musicDetails')%>?postId=<%$row['iPostId']%>">
                    <div class="group cursor-pointer">
                        <div class="relative aspect-video rounded-[2.5rem] overflow-hidden mb-6 shadow-xl shadow-slate-100 group-hover:shadow-indigo-100 transition-all duration-500">
                            <img src="<%$row['music']['thumbnail_url']%>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-indigo-900/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-5 right-5 w-12 h-12 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-play text-xs"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors"><%$row['tPostTextEmoji']%></h4>
                        <p class="text-slate-400 text-sm font-semibold mt-1"><%$row['music']['duration']%> • Music</p>
                    </div>
                </a>
            <%/foreach%>
        </div>

        <div class="text-center mt-8 p-12">
            <button class="group relative px-10 py-4 overflow-hidden rounded-2xl bg-white/40 backdrop-blur-md border border-white shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] transition-all duration-300 hover:shadow-[0_8px_32px_0_rgba(168,85,247,0.2)] hover:bg-white/60 active:scale-95">
                <div class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-purple-400/20 to-transparent"></div>
                <div class="relative flex items-center justify-center space-x-3" id="loadMoreMusic">
                    <span class="text-purple-900 font-extrabold text-sm tracking-widest uppercase">
                        Explore More
                    </span>
                    <div class="relative w-5 h-5 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-full border border-purple-200 group-hover:border-purple-500 transition-colors"></div>
                        <span class="block w-1.5 h-1.5 border-t-2 border-r-2 border-purple-600 rotate-45 transition-transform group-hover:translate-x-0.5"></span>
                    </div>
                </div>
                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1/3 h-1 bg-purple-500/40 blur-md opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </div>

    </section>
  </main>
</div>


<!--jQuery to play and pause audios-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
const commentInput = $("#comment-input");
commentInput.val("");
$(document).ready(function () {

    const profileView = $("#sidebar-profile");
    const discussionView = $("#sidebar-discussion");
    const commentList = $("#comment-list");

    // 🔹 Open Discussion
    $("#open-discussion-btn").on("click", function () {

        profileView.addClass("hidden");
        discussionView.removeClass("hidden");

        const postId = commentList.data("postid");
        const userId = commentList.data("userid");

        loadComments(postId, userId);
    });

    // 🔹 Close Discussion
    $("#close-discussion").on("click", function () {
        discussionView.addClass("hidden");
        profileView.removeClass("hidden");
    });

});

function loadComments(postId, userId) {

    const commentList = $("#comment-list");

    commentList.html(`
        <div class="text-center py-6 text-slate-400">
            <i class="fa-solid fa-spinner fa-spin text-xl text-indigo-500"></i>
        </div>
    `);

    $.post("<%$this->url->make('home/home/get_comments')%>", {
        comment_post_id: postId,
        raw_data: 1
    }, function (res) {

        if (!res.comments_data || res.comments_data.length === 0) {
            commentList.html(`
                <div class="text-center text-slate-400">
                    No comments yet
                </div>
            `);
            return;
        }

        let html = "";

        $.each(res.comments_data, function (i, c) {

            html += `
                <div class="border border-slate-200 p-3 rounded-xl">
                    <div class="flex justify-between items-center mb-1">
                        <strong>${c.user_name}</strong>
                        <span class="text-xs text-slate-400">
                            ${c.created_at || ''}
                        </span>
                    </div>
                    <p class="text-sm">${c.comment}</p>
                </div>
            `;
        });

        commentList.html(html);

    }, "json");
}

$(document).on("click", "#submit-comment", function () {

    const commentInput = $("#comment-input");
    const commentText = commentInput.val().trim();
    const commentList = $("#comment-list");

    if (!commentText) return;

    const postId = commentList.data("postid");

    $.ajax({
        url: "<%$this->url->make('home/home/add_comment')%>",
        type: "POST",
        data: {
            comment: commentText,
            comment_post_id: postId
        },
        dataType: "json",
        success: function (response) {

            if (response.status === "success") {

                const newComment = `
                    <div class="border border-slate-200 p-3 rounded-xl">
                        <div class="flex justify-between items-center mb-1">
                            <strong>${response.user_name || 'You'}</strong>
                            <span class="text-xs text-slate-400">
                                ${new Date().toLocaleString()}
                            </span>
                        </div>
                        <p class="text-sm">${commentText}</p>
                    </div>
                `;

                commentList.prepend(newComment);
                commentInput.val("");
            }
        }
    });
});
</script>

<script>
$(document).ready(function () {
    const audio = document.getElementById('main-audio');    

    $('#play-main-music').on('click', function () {
        const icon = $(this).find('i');

        if (audio.paused) {
            audio.play();
            icon.removeClass('fa-play ml-2').addClass('fa-pause');
        } else {
            audio.pause();
            icon.removeClass('fa-pause').addClass('fa-play ml-2');
        }
    });

    audio.addEventListener('ended', function () {
        $('#play-main-music i')
            .removeClass('fa-pause')
            .addClass('fa-play');
    });
});


$(document).on("click", "#follow-user", function () {
    const btn = this;
    const userId = $(btn).data("userid");
    const myId = $(btn).data("myid");
    const prevState = btn.dataset.state;

    btn.disabled = true;
    btn.style.opacity = '0.7';

    let url = "<%$this->url->make('home/home/followuser_action')%>";
    let formData = new FormData();
    formData.append('followid', userId);
    formData.append('userid', myId);
    formData.append('pendingrequestid', '');
    formData.append('pendingrequestid_ar', '');
    formData.append('btnactval', 'follow');

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",

        success: function (response) {
            if (response.success == 1) {
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

    console.log('Follow user with ID:', userId);
});


function getNextState(state) {
    switch (state) {
        case 'follow':
            return 'requested';
        case 'requested':
            return 'follow';
        case 'following':
            return 'follow';
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


let page = 1;
$(document).on("click", "#loadMoreMusic", function () {
    page++;

    $.ajax({
        url: site_url + 'music/getMorePosts',
        type: 'POST',
        data: { page: page },
        dataType: 'json',
        success: function (res) {

            if (res.length === 0) {
                $("#loadMoreMusic").hide();
                return;
            }

            if (res.length === 0) {
                if (page === 1) {
                    $("#musicGrid").hide();
                    $("#noMusicMsg").removeClass("hidden");
                } else {
                    $("#loadMoreMusic").hide();
                }
                return;
            }

            let html = '';

            $.each(res, function (i, row) {

                let avatar = row.user.avatar ? row.user.avatar : 'https://via.placeholder.com/50';

                html += `
                <a href="${site_url}music/music/musicDetails?postId=${row.iPostId}">
                    <div class="group cursor-pointer">
                        <div class="relative aspect-video rounded-[2.5rem] overflow-hidden mb-6 shadow-xl shadow-slate-100 group-hover:shadow-indigo-100 transition-all duration-500">
                            <img src="${row.music.thumbnail_url}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-indigo-900/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-5 right-5 w-12 h-12 bg-white/90 backdrop-blur rounded-2xl flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-play text-xs"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">${row.music.title}</h4>
                        <p class="text-slate-400 text-sm font-semibold mt-1">${row.music.duration} • Music</p>
                    </div>
                </a>
                `;
            });

            $("#musicGrid").append(html);
        }
    });
});

</script>
