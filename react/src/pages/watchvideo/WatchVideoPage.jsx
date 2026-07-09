import React, { useState, useEffect } from "react";
import { Compass, Flame, Clock, Sparkles } from "lucide-react";
import FeaturedBanner from "../../components/watchvideo/FeaturedBanner";
import VideoGrid from "../../components/watchvideo/VideoGrid";
import CategoryTabs from "../../components/watchvideo/CategoryTabs";
import { fetchWatchVideosAPI } from "../../services/videoService";
import { FALLBACK_IMAGE } from "../../config/siteConfig";
import { getFullProfileImageUrl } from "../../utils/imageUtils";

function WatchVideoPage() {
    const [trendingVideos, setTrendingVideos] = useState([]);
    const [recentVideos, setRecentVideos] = useState([]);
    const [vpVideos, setVpVideos] = useState([]);
    const [userinfo, setUserinfo] = useState(null);
    
    const [activeCategory, setActiveCategory] = useState("all");
    const [pageIndex, setPageIndex] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [isLoading, setIsLoading] = useState(true);
    const [isError, setIsError] = useState(false);

    // Map single API video item to page representation
    const mapVideoItem = (item, index, categoryName, uinfo) => {
        const details = Array.isArray(item.post_details) && item.post_details.length > 0 
            ? item.post_details[0] 
            : null;

        let creatorName = `User ${item.user_id}`;
        let creatorImg = "https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150";

        if (details?.vName) {
            creatorName = details.vName;
        } else if (uinfo && String(item.user_id) === String(uinfo.u_userid) && uinfo.u_name) {
            creatorName = uinfo.u_name;
        }

        if (details?.u_profile_image) {
            creatorImg = getFullProfileImageUrl(details.u_profile_image);
        } else if (uinfo && String(item.user_id) === String(uinfo.u_userid) && uinfo.u_profile_image) {
            creatorImg = getFullProfileImageUrl(uinfo.u_profile_image);
        }

        return {
            id: item.post_media_id || item.post_id || `${categoryName}-${index}-${Math.random()}`,
            postId: item.post_id,
            title: details?.tPostText || "Untitled Video",
            thumbnail: item.video_thumbnail || item.display_image || FALLBACK_IMAGE,
            videoUrl: item.upload_file,
            creatorName,
            creatorImg,
            views: item.views_count || "0",
            timeAgo: item.added_date || "Recently",
            duration: "Video",
            category: categoryName,
            isTrending: categoryName === "Trending" || Number(item.views_count) > 50,
            isNew: categoryName === "Recent" || index % 4 === 0
        };
    };

    // Reset pageIndex when activeCategory changes
    useEffect(() => {
        setPageIndex(1);
        setHasMore(true);
    }, [activeCategory]);

    // Fetch videos from the API
    useEffect(() => {
        const loadVideos = async () => {
            setIsLoading(true);
            setIsError(false);
            try {
                const res = await fetchWatchVideosAPI(pageIndex);
                
                const uinfo = res?.userinfo || null;
                if (uinfo && !userinfo) {
                    setUserinfo(uinfo);
                }

                const mostViewsRaw = res?.most_views_video || [];
                const recentRaw = res?.recent_videos || [];
                const vpRaw = res?.vp_video || [];

                const mappedMostViews = mostViewsRaw.map((item, index) => mapVideoItem(item, index, "Trending", uinfo));
                const mappedRecent = recentRaw.map((item, index) => mapVideoItem(item, index, "Recent", uinfo));
                const mappedVp = vpRaw.map((item, index) => mapVideoItem(item, index, "Suggested", uinfo));

                if (mappedMostViews.length === 0 && mappedRecent.length === 0 && mappedVp.length === 0) {
                    setHasMore(false);
                } else {
                    setTrendingVideos((prev) => {
                        if (pageIndex === 1) return mappedMostViews;
                        const existing = new Set(prev.map(v => v.id));
                        const unique = mappedMostViews.filter(v => !existing.has(v.id));
                        return [...prev, ...unique];
                    });

                    setRecentVideos((prev) => {
                        if (pageIndex === 1) return mappedRecent;
                        const existing = new Set(prev.map(v => v.id));
                        const unique = mappedRecent.filter(v => !existing.has(v.id));
                        return [...prev, ...unique];
                    });

                    setVpVideos((prev) => {
                        if (pageIndex === 1) return mappedVp;
                        const existing = new Set(prev.map(v => v.id));
                        const unique = mappedVp.filter(v => !existing.has(v.id));
                        return [...prev, ...unique];
                    });
                }
            } catch (error) {
                console.error("Failed to load videos from API:", error);
                setIsError(true);
            } finally {
                setIsLoading(false);
            }
        };

        loadVideos();
    }, [pageIndex]);

    const getActiveCategoryVideos = () => {
        switch (activeCategory) {
            case "trending":
                return trendingVideos;
            case "recent":
                return recentVideos;
            case "vp":
                return vpVideos;
            default:
                return [];
        }
    };

    // Format top trending videos for the hero banner
    const bannerSlides = trendingVideos.slice(0, 4).map(video => ({
        id: video.id,
        postId: video.postId,
        title: video.title,
        description: video.title,
        thumbnail: video.thumbnail,
        creator: video.creatorName,
        creatorImg: video.creatorImg,
        views: video.views,
        date: video.timeAgo,
        duration: video.duration,
        videoUrl: video.videoUrl
    }));

    return (
        <div className="flex flex-col gap-6 animate-in fade-in duration-500">
            {/* Header Title Row */}
            <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/75 backdrop-blur-md p-6 rounded-[2.5rem] border border-white shadow-xl shadow-slate-200/50">
                <div className="flex items-center gap-3">
                    <div className="p-3 bg-purple-50 rounded-2xl text-purple-600">
                        <Compass size={24} className="animate-spin-slow" />
                    </div>
                    <div>
                        <h2 className="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">
                            Watch Video
                        </h2>
                        <p className="text-xs font-semibold text-slate-400 mt-0.5">
                            Discover viral content and explore new visual stories
                        </p>
                    </div>
                </div>
            </div>

            {/* Category tabs */}
            <CategoryTabs activeCategory={activeCategory} onSelectCategory={setActiveCategory} />

            {/* Featured Video Hero Slider */}
            {activeCategory === "all" && <FeaturedBanner slides={bannerSlides} />}

            {/* Content Display */}
            {isError ? (
                <div className="text-center py-16 bg-red-50/50 backdrop-blur-sm rounded-[2.5rem] border border-red-100 shadow-sm mt-4">
                    <p className="text-red-600 font-bold text-base">An error occurred loading the videos.</p>
                    <p className="text-slate-500 text-sm mt-1">Please try again later or reload the page.</p>
                </div>
            ) : activeCategory === "all" ? (
                <div className="space-y-10 animate-in fade-in duration-300">
                    {/* Trending Section */}
                    {trendingVideos.length > 0 && (
                        <div className="space-y-4">
                            <div className="flex items-center justify-between px-1">
                                <div className="flex items-center gap-2">
                                    <div className="p-2 bg-amber-50 rounded-xl text-amber-500">
                                        <Flame size={18} />
                                    </div>
                                    <h3 className="text-lg font-extrabold text-slate-800 tracking-tight">
                                        Trending Videos
                                    </h3>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => setActiveCategory("trending")}
                                    className="text-xs font-bold text-purple-600 hover:text-purple-700 transition cursor-pointer"
                                >
                                    View All
                                </button>
                            </div>
                            <VideoGrid videos={trendingVideos.slice(0, 4)} isLoading={isLoading && pageIndex === 1} />
                        </div>
                    )}

                    {/* Recent Section */}
                    {recentVideos.length > 0 && (
                        <div className="space-y-4">
                            <div className="flex items-center justify-between px-1">
                                <div className="flex items-center gap-2">
                                    <div className="p-2 bg-blue-50 rounded-xl text-blue-500">
                                        <Clock size={18} />
                                    </div>
                                    <h3 className="text-lg font-extrabold text-slate-800 tracking-tight">
                                        Recent Videos
                                    </h3>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => setActiveCategory("recent")}
                                    className="text-xs font-bold text-purple-600 hover:text-purple-700 transition cursor-pointer"
                                >
                                    View All
                                </button>
                            </div>
                            <VideoGrid videos={recentVideos.slice(0, 4)} isLoading={isLoading && pageIndex === 1} />
                        </div>
                    )}

                    {/* Suggested Section */}
                    {vpVideos.length > 0 && (
                        <div className="space-y-4">
                            <div className="flex items-center justify-between px-1">
                                <div className="flex items-center gap-2">
                                    <div className="p-2 bg-purple-50 rounded-xl text-purple-500">
                                        <Sparkles size={18} />
                                    </div>
                                    <h3 className="text-lg font-extrabold text-slate-800 tracking-tight">
                                        Suggested Videos
                                    </h3>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => setActiveCategory("vp")}
                                    className="text-xs font-bold text-purple-600 hover:text-purple-700 transition cursor-pointer"
                                >
                                    View All
                                </button>
                            </div>
                            <VideoGrid videos={vpVideos.slice(0, 4)} isLoading={isLoading && pageIndex === 1} />
                        </div>
                    )}
                </div>
            ) : (
                <div className="space-y-6 animate-in fade-in duration-300">
                    <div className="flex items-center justify-between px-1">
                        <h3 className="text-lg font-extrabold text-slate-800 tracking-tight capitalize">
                            {activeCategory === "trending" ? "Trending Videos" : activeCategory === "recent" ? "Recent Videos" : "Suggested Videos"}
                        </h3>
                        <span className="text-xs font-bold text-slate-400">
                            {getActiveCategoryVideos().length} {getActiveCategoryVideos().length === 1 ? "Video" : "Videos"}
                        </span>
                    </div>

                    <VideoGrid videos={getActiveCategoryVideos()} isLoading={isLoading && pageIndex === 1} />

                    {/* Pagination control */}
                    {hasMore && !isLoading && (
                        <div className="flex justify-center pt-6">
                            <button
                                type="button"
                                onClick={() => setPageIndex((prev) => prev + 1)}
                                className="px-8 py-3.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 rounded-full font-bold text-sm shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer"
                            >
                                Load More Videos
                            </button>
                        </div>
                    )}
                    {isLoading && pageIndex > 1 && (
                        <div className="flex justify-center pt-6">
                            <div className="w-8 h-8 border-4 border-purple-600 border-t-transparent rounded-full animate-spin" />
                        </div>
                    )}
                </div>
            )}
        </div>
    );
}

export default WatchVideoPage;
