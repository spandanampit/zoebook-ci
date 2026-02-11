<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
.custom-text {
    font-size: 1.5rem;
    line-height: 2rem;
}
</style>
<main class="bg-white min-h-screen p-14 font-sans">

  <section class="flex space-x-8 overflow-x-auto pb-10 pt-4 no-scrollbar px-4 items-center">

    <%foreach item=artist from=$musicArtists%>
    <a href="<%$this->general->setdiplayprofileurl($artist.iUsersId, $artist.vName)%>" 
       class="group relative flex-shrink-0 flex flex-col items-center transition-all duration-500">
        
        <div class="relative transform transition-transform duration-500 group-hover:-translate-y-2">
            
            <div class="absolute -inset-1 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-600 rounded-full opacity-75 blur-[2px] group-hover:opacity-100 group-hover:animate-spin transition-all duration-700" style="animation-duration: 3s;"></div>
            
            <div class="relative w-28 h-28 bg-white p-1 rounded-full shadow-xl">
                <div class="w-full h-full rounded-full overflow-hidden border-2 border-gray-50">
                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$artist.vProfileImage%>" 
                         alt="<%$artist.vName%>" 
                         class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-125">
                </div>
                
                
            </div>

            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="bg-black/20 backdrop-blur-sm p-3 rounded-full">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <h4 class="text-gray-800 font-black text-xs uppercase tracking-tighter group-hover:text-purple-600 transition-colors">
                <%$artist.vName%>
            </h4>
            <div class="overflow-hidden h-4">
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em] transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    View Profile
                </p>
            </div>
        </div>
        
    </a>
    <%/foreach%>

</section>

  <section class="mb-8">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-purple-700 font-bold text-lg italic">Most Popular Music</h2>
    </div>
    
<!--<pre>
    <%$music_posts|print_r%>
</pre>-->

    <div  id="musicGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        <%foreach item=row from=$music_posts%>
            <a href="<%$this->url->make('music/music/musicDetails')%>?postId=<%$row['iPostId']%>">
                <div class="relative w-full h-96 rounded-[2rem] overflow-hidden shadow-2xl group cursor-pointer bg-black">
                        <img src="<%$row.music.thumbnail_url%>" 
                            class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 ease-out group-hover:scale-110 group-hover:blur-[2px] opacity-80" 
                            alt="Music Thumbnail">

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-90"></div>

                    <div class="absolute top-6 right-6 z-30">
                        <div class="relative flex items-center justify-center size-14 bg-green-500 rounded-full text-black shadow-[0_0_30px_rgba(34,197,94,0.5)] transition-all duration-500 transform group-hover:scale-110">
                            <i class="fa-solid fa-play text-xl"></i>
                            <span class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-20"></span>
                        </div>
                    </div>

                    <div class="absolute top-10 left-8 flex items-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <div class="w-1 bg-green-400 animate-[bounce_1s_infinite_0.1s]" style="height: 12px;"></div>
                        <div class="w-1 bg-green-400 animate-[bounce_1s_infinite_0.3s]" style="height: 20px;"></div>
                        <div class="w-1 bg-green-400 animate-[bounce_1s_infinite_0.5s]" style="height: 16px;"></div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-8 pt-20 bg-gradient-to-t from-black to-transparent">
                        <div class="flex items-end justify-between">
                            <div class="flex-1">
                                <span class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-[10px] uppercase tracking-widest text-green-400 border border-white/10 mb-3 inline-block">
                                    Trending Now
                                </span>
                                
                                <h3 class="text-white font-black text-2xl tracking-tight mb-1 group-hover:text-green-400 transition-colors">
                                    <%$row.music.title%>
                                </h3>

                                <div class="flex items-center space-x-2">
                                    <img src="<%$row.user.avatar%>" class="size-6 rounded-full border border-white/30" alt="">
                                    <p class="text-gray-400 text-sm font-medium"><%$row.user.name%></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 w-full h-1 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 w-0 group-hover:w-full transition-all duration-[3000ms] ease-linear"></div>
                        </div>
                    </div>
                </div>
            </a>
        <%/foreach%>
    </div>

    <div class="text-center mt-8 p-12"> <button class="group relative px-10 py-4 overflow-hidden rounded-2xl bg-white/40 backdrop-blur-md border border-white shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] transition-all duration-300 hover:shadow-[0_8px_32px_0_rgba(168,85,247,0.2)] hover:bg-white/60 active:scale-95">
            
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

    <section class="relative px-6 py-4">
        <h2 class="text-yellow-500 font-semibold text-lg mb-4 italic">
            All Playlists
        </h2>

        <div class="relative">

            <!-- LEFT ARROW -->
            <button class="playlist-left absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 hover:bg-white p-2 rounded-full shadow-lg">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- SLIDER -->
            <div class="playlist-scroll flex space-x-4 overflow-x-hidden scroll-smooth scrollbar-hide px-10" id="playlistScroll" data-page="1" data-loading="0">

                <%foreach item=row from=$playlist_post%>

                <a href="<%$this->url->make('content/content/playlistshare')%>?playlistId=<%$row.playlist_id%>&userId=<%$row.playlist_userId%>"
                class="group relative w-[220px] h-[320px] rounded-xl overflow-hidden flex-shrink-0 shadow-xl">

                    <!-- Background -->
                    <%if $row.main_media[0].full_thumbnail_url%>
                        <img src="<%$row.main_media[0].full_thumbnail_url%>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <%else%>
                        <video class="w-full h-full object-cover" muted preload="auto">
                            <source src="<%$row.main_media[0].vUploadFile%>" type="video/mp4">
                        </video>
                    <%/if%>

                    <!-- Dark gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                    <!-- User -->
                    <div class="absolute bottom-3 left-0 right-0 flex flex-col items-center z-10">
                        <div class="w-12 h-12 rounded-full border-2 border-yellow-400 overflow-hidden mb-1">
                            <img src="<%$row.main_media[0].u_profile_image%>" class="w-full h-full object-cover">
                        </div>

                        <p class="text-white text-xs font-semibold text-center px-2 truncate max-w-full">
                            <%$row.main_media[0].u_name%>
                        </p>
                    </div>

                </a>

                <%/foreach%>

            </div>
            <div id="playlistLoader" class="hidden text-center py-4 text-white">
                Loading more…
            </div>


            <!-- RIGHT ARROW -->
            <button class="playlist-right absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white/90 hover:bg-white p-2 rounded-full shadow-lg">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

        </div>
    </section>


</main>
<%$this->js->add_js("front/music.js")%>
