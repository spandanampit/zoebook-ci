<script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .custom-shadow { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05); }
    </style>
<main class="max-w-7xl mx-auto p-6">
        
        <section class="mb-10">
            <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden custom-shadow">
                <img src="https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&w=1200" class="w-full h-full object-cover" alt="Featured">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex flex-col justify-center px-12 text-white">
                    <span class="uppercase tracking-widest text-sm font-semibold text-purple-400 mb-2">Now Trending</span>
                    <h2 class="text-4xl font-bold mb-2">Kevin Gates</h2>
                    <p class="text-lg opacity-90 mb-6">"This Song Is On Fire" — Listen Now</p>
                    <button class="w-fit bg-white text-black px-8 py-3 rounded-full font-bold hover:scale-105 transition-transform">Play Now</button>
                </div>
            </div>
        </section>

        <section class="mb-12">
            <div class="flex justify-between items-end mb-6">
                <h3 class="text-2xl font-bold">Trending Hits</h3>
                <a href="#" class="text-purple-600 font-semibold hover:underline">View All</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="group cursor-pointer">
                    <div class="relative aspect-square rounded-2xl overflow-hidden mb-3 custom-shadow">
                        <img src="https://via.placeholder.com/200" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Song cover">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">▶</div>
                        </div>
                    </div>
                    <h4 class="font-bold truncate">Song Title</h4>
                    <p class="text-sm text-slate-500">Artist Name</p>
                </div>
                <div class="group cursor-pointer"><div class="aspect-square bg-slate-200 rounded-2xl mb-3 custom-shadow"></div><h4 class="font-bold">Next Hit</h4><p class="text-sm text-slate-500">Artist Name</p></div>
                <div class="group cursor-pointer"><div class="aspect-square bg-slate-200 rounded-2xl mb-3 custom-shadow"></div><h4 class="font-bold">Vibe City</h4><p class="text-sm text-slate-500">Artist Name</p></div>
                <div class="group cursor-pointer"><div class="aspect-square bg-slate-200 rounded-2xl mb-3 custom-shadow"></div><h4 class="font-bold">Summer 24</h4><p class="text-sm text-slate-500">Artist Name</p></div>
                <div class="group cursor-pointer"><div class="aspect-square bg-slate-200 rounded-2xl mb-3 custom-shadow"></div><h4 class="font-bold">Late Night</h4><p class="text-sm text-slate-500">Artist Name</p></div>
                <div class="group cursor-pointer"><div class="aspect-square bg-slate-200 rounded-2xl mb-3 custom-shadow"></div><h4 class="font-bold">Deep Bass</h4><p class="text-sm text-slate-500">Artist Name</p></div>
            </div>
        </section>

        <section class="mb-12">
            <h3 class="text-2xl font-bold mb-6">All Playlists</h3>
            <div class="flex gap-6 overflow-x-auto pb-6 scrollbar-hide">
                <div class="min-w-[280px] h-40 bg-gradient-to-br from-orange-400 to-rose-500 rounded-3xl p-6 text-white flex flex-col justify-end custom-shadow">
                    <h4 class="text-xl font-bold">Global Beats</h4>
                    <p class="text-sm opacity-80">50 Songs</p>
                </div>
                <div class="min-w-[280px] h-40 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl p-6 text-white flex flex-col justify-end custom-shadow">
                    <h4 class="text-xl font-bold">Summer Vibes</h4>
                    <p class="text-sm opacity-80">32 Songs</p>
                </div>
                <div class="min-w-[280px] h-40 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-3xl p-6 text-white flex flex-col justify-end custom-shadow">
                    <h4 class="text-xl font-bold">Lo-Fi Study</h4>
                    <p class="text-sm opacity-80">120 Songs</p>
                </div>
            </div>
        </section>

    </main>