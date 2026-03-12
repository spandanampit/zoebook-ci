$(document).on("submit", "#musicUploadForm", function (e) {
    e.preventDefault();
    $('#musicModal').modal('hide');
    $('#loader-container-processing').show();


    const form = this;
    const formData = new FormData(form);

    console.log('formData', formData);

    const audioFile = document.getElementById('music_file').files[0];
    const thumbnailFile = document.getElementById('music_thumbnail').files[0];
    const musicTitle = document.getElementById('music_title').value;
    const musicDescription = document.getElementById('music_description').value;
    
    getAudioDuration(audioFile).then(duration => {

        console.log('Audio File:', {
            name: audioFile.name,
            sizeMB: (audioFile.size / 1024 / 1024).toFixed(2),
            type: audioFile.type,
            lastModified: audioFile.lastModified,
            durationSeconds: duration,
            durationFormatted: new Date(duration * 1000).toISOString().substr(14, 5)
        });

        if (thumbnailFile) {
            console.log('Thumbnail File:', {
                name: thumbnailFile.name,
                sizeMB: (thumbnailFile.size / 1024 / 1024).toFixed(2),
                type: thumbnailFile.type,
                lastModified: thumbnailFile.lastModified
            });
        }

        const formData = new FormData();
        formData.append('music_file', audioFile);
        formData.append('music_thumbnail', thumbnailFile);
        formData.append('title', musicTitle);
        formData.append('description', musicDescription);
        formData.append(
            'duration',
            new Date(duration * 1000).toISOString().substr(14, 5)
        );

        $.ajax({
            url: site_url + 'music/uploadMusic',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
    if (typeof res === "string") res = JSON.parse(res);

    const processngContainer = document.getElementById("loader-container-processing");
    const audioUrl = res.audio_url;
    const thumbUrl = res.thumbnail_url;

    processngContainer.innerHTML = `
        <style>
            /* Container styling */
            .music-post-card {
                position: relative;
                max-width: 600px;
                margin: 20px auto;
                height: 350px;
                border-radius: 24px;
                overflow: hidden;
                font-family: 'Inter', -apple-system, sans-serif;
                background: #000; /* Fallback */
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            }

            /* Background Image */
            .card-bg {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }

            .music-post-card:hover .card-bg {
                transform: scale(1.05);
            }

            /* Dark Overlay for text readability */
            .card-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.8) 100%);
            }

            /* Content Layout */
            .card-content {
                position: absolute;
                inset: 0;
                padding: 24px;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                color: white;
            }

            /* Trending Badge */
            .badgeNew {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(4px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                width: fit-content;
                margin-bottom: 12px;
                color: #22c55e;
                bottom: 55%;
                position: relative;
            }

            .song-title {
                font-size: 28px;
                font-weight: 800;
                margin: 0 0 8px 0;
                letter-spacing: -0.5px;
            }

            /* Artist Section */
            .artist-info {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
            }

            .artist-thumb {
                width: 24px;
                height: 24px;
                border-radius: 50%;
                object-fit: cover;
            }

            .artist-name {
                font-size: 14px;
                font-weight: 500;
                opacity: 0.9;
            }

            /* Floating Play Button */
            .play-btn-float {
                position: absolute;
                top: 24px;
                right: 24px;
                width: 48px;
                height: 48px;
                background: #1ed760;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: black;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                cursor: pointer;
            }

            /* Audio Player Custom styling (Standard) */
            .audio-container {
                width: 100%;
                background: rgba(255,255,255,0.05);
                border-radius: 12px;
                padding: 5px;
            }

            audio {
                width: 100%;
                height: 32px;
                opacity: 0.8;
                filter: invert(1) hue-rotate(180deg); /* Makes standard player look dark/modern */
            }
            
            #reloadBtn {
                position: absolute;
                top: 24px;
                left: 24px;
                color: white;
                cursor: pointer;
                background: rgba(0,0,0,0.3);
                padding: 8px;
                border-radius: 50%;
            }
        </style>

        <div class="music-post-card">
            <img src="${thumbUrl}" class="card-bg" alt="Cover" />
            <div class="card-overlay"></div>

            <div class="card-content">
                <div class="badgeNew">Trending Now</div>
                <h1 class="song-title">Just Uploaded</h1>

                <div class="audio-container">
                    <audio controls>
                        <source src="${audioUrl}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
        </div>
    `;
}
        });
        console.log('testing music.php');
    });
});

//Navigation
const slider = document.querySelector('.playlist-scroll');
document.querySelector('.playlist-left').onclick = () => {
    console.log('hits 1');
  slider.scrollBy({ left: -300, behavior: 'smooth' });
};

document.querySelector('.playlist-right').onclick = () => {
  slider.scrollBy({ left: 300, behavior: 'smooth' });
};


$(document).ready(function () {
    const $scroll = $("#playlistScroll");
    const $loader = $("#playlistLoader");

    function loadMorePlaylists() {
        if ($scroll.data("loading") === 1) return;
        $scroll.data("loading", 1);
        $loader.removeClass("hidden");

        let page = parseInt($scroll.data("page")) + 1;

        $.ajax({
            url: "/getMorePlaylist",
            type: "GET",
            data: { page: page },
            dataType: "json",
            success: function (res) {
                console.log('API Response:', res);

                // ── Changed part ───────────────────────────────────────
                const posts = Array.isArray(res) ? res : (res.data || []);

                if (posts.length === 0) {
                    $loader.addClass("hidden");
                    $scroll.data("finished", true);
                    return;
                }

                posts.forEach(post => {
                    const media = post.main_media?.[0] || {};
                    const thumbnail    = media.full_thumbnail_url || '';
                    const videoSrc     = media.vUploadFile || '';
                    const profileImage = media.u_profile_image || '';
                    const userName     = media.u_name || '';

                    // rest of your template string stays the same...
                    const html = `
                        <a href="content/content/playlistshare?playlistId=${post.playlist_id}&userId=${post.playlist_userId}"
                        class="group relative w-[220px] h-[320px] rounded-xl overflow-hidden flex-shrink-0 shadow-xl">
                            ${thumbnail ? `
                                <img src="${thumbnail}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            ` : `
                                <video class="w-full h-full object-cover" muted preload="auto" loop playsinline>
                                    <source src="${videoSrc}" type="video/mp4">
                                </video>
                            `}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-3 left-0 right-0 flex flex-col items-center z-10">
                                <div class="w-12 h-12 rounded-full border-2 border-yellow-400 overflow-hidden mb-1">
                                    <img src="${profileImage}" class="w-full h-full object-cover">
                                </div>
                                <p class="text-white text-xs font-semibold text-center px-2 truncate max-w-full">
                                    ${userName}
                                </p>
                            </div>
                        </a>
                    `;
                    $scroll.append(html);
                });

                $scroll.data("page", page);
                $scroll.data("loading", 0);
                $loader.addClass("hidden");
            },
            error: function () {
                $scroll.data("loading", 0);
                $loader.addClass("hidden");
                console.log("Failed to load more playlists");
            }
        });
    }

    // ── Horizontal scroll detection ───────────────────────────────
    $scroll.on("scroll", function () {
        // Optional: prevent calling load more many times in quick succession
        if ($scroll.data("finished") === true) return;

        const scrollLeft = this.scrollLeft;
        const scrollWidth = this.scrollWidth;
        const clientWidth = this.clientWidth;

        // How much is left to scroll
        const remaining = scrollWidth - (scrollLeft + clientWidth);

        // Trigger when ~80-90% scrolled (or when very close to end)
        if (remaining < 300 || scrollLeft >= scrollWidth - clientWidth - 50) {
            loadMorePlaylists();
        }
    });

    // Optional: also support arrow buttons
    $(".playlist-right").on("click", function () {
        $scroll.animate({
            scrollLeft: $scroll[0].scrollLeft + 400
        }, 400);
    });

    $(".playlist-left").on("click", function () {
        $scroll.animate({
            scrollLeft: $scroll[0].scrollLeft - 400
        }, 400);
    });
});


function getAudioDuration(audioFile) {
    return new Promise((resolve, reject) => {
        const audio = document.createElement('audio');
        audio.preload = 'metadata';

        audio.onloadedmetadata = () => {
            URL.revokeObjectURL(audio.src);
            resolve(audio.duration);
        };

        audio.onerror = () => reject('Failed to load audio metadata');

        audio.src = URL.createObjectURL(audioFile);
    });
}


let page = 1;
$(document).on("click", "#loadMoreMusic", function () {
    page++;

    $.ajax({
        url: site_url + 'music/getMorePosts',
        type: 'POST',
        data: { pageIndex: page },
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
                    <div class="relative w-full h-96 rounded-[2rem] overflow-hidden shadow-2xl group cursor-pointer bg-black">
                        
                        <img src="${row.music.thumbnail_url}" 
                            class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 ease-out group-hover:scale-110 group-hover:blur-[2px] opacity-80">

                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-90"></div>

                        <div class="absolute top-6 right-6 z-30">
                            <div class="relative flex items-center justify-center size-14 bg-green-500 rounded-full text-black shadow-[0_0_30px_rgba(34,197,94,0.5)] transition-all duration-500 transform group-hover:scale-110">
                                <i class="fa-solid fa-play text-xl"></i>
                                <span class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-20"></span>
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-8 pt-20 bg-gradient-to-t from-black to-transparent">
                            <span class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-[10px] uppercase tracking-widest text-green-400 border border-white/10 mb-3 inline-block">
                                Trending Now
                            </span>

                            <h3 class="text-white font-black text-2xl tracking-tight mb-1 group-hover:text-green-400 transition-colors">
                                ${row.music.title}
                            </h3>

                            <div class="flex items-center space-x-2">
                                <img src="${avatar}" class="size-6 rounded-full border border-white/30">
                                <p class="text-gray-400 text-sm font-medium">${row.user.name}</p>
                            </div>

                            <div class="mt-6 w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 w-0 group-hover:w-full transition-all duration-[3000ms] ease-linear"></div>
                            </div>
                        </div>
                    </div>
                </a>
                `;
            });

            $("#musicGrid").append(html);
        }
    });
});

