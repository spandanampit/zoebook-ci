import React, { useState, useEffect, useRef, useCallback } from "react";
import { fetchTopPlaylistPosts } from "../../services/postService";
import {
    FALLBACK_IMAGE,
    SITE_URL,
    ACTIVE_USER_ID,
} from "../../config/siteConfig";
import { motion, AnimatePresence } from "framer-motion";
import { ChevronLeft, ChevronRight, ListMusic, Plus, Play } from "lucide-react";
import { getFullProfileImageUrl } from "../../utils/imageUtils";

const PlaylistCardSkeleton = () => (
    <div className="shrink-0 w-44 md:w-52 animate-pulse">
        <div className="relative rounded-2xl overflow-hidden bg-slate-100 aspect-[3/4] border border-slate-100/50" />
        <div className="flex items-center gap-2 mt-2.5 px-1">
            <div className="w-6 h-6 rounded-full bg-slate-100" />
            <div className="h-3 bg-slate-100 rounded w-16" />
        </div>
    </div>
);

const PlaylistCard = ({ item, index }) => {
    const playlist = item.playlist;
    const firstMedia =
        item.media && item.media.length > 0 ? item.media[0] : null;
    const thumbnailUrl = firstMedia?.full_thumbnail_url || null;
    const videoUrl = firstMedia?.full_video_url || null;
    const isVideo = firstMedia?.eMediaType === "Video" && videoUrl;
    const profileImage = getFullProfileImageUrl(playlist.user_profile_image);
    const postText =
        item.post && item.post.length > 0 ? item.post[0].tPostText : "";
    const videoRef = useRef(null);
    const [isPlaying, setIsPlaying] = useState(false);

    const handleMouseEnter = useCallback(() => {
        if (!videoRef.current) return;
        const playPromise = videoRef.current.play();
        if (playPromise !== undefined) {
            playPromise
                .then(() => setIsPlaying(true))
                .catch(() => setIsPlaying(false));
        }
    }, []);

    const handleMouseLeave = useCallback(() => {
        if (!videoRef.current) return;
        videoRef.current.pause();
        videoRef.current.currentTime = 0;
        setIsPlaying(false);
    }, []);

    const handlePlaylistClick = useCallback(() => {
        const playlistId = playlist?.id;
        if (playlistId) {
            window.location.href = `${SITE_URL}/playlistshare.html?playlistId=${playlistId}&userId=${ACTIVE_USER_ID}`;
        }
    }, [playlist?.id]);

    return (
        <motion.div
            initial={{ opacity: 0, y: 15 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{
                delay: index * 0.05,
                duration: 0.45,
                ease: [0.16, 1, 0.3, 1],
            }}
            className="shrink-0 w-44 md:w-52 group cursor-pointer"
            onClick={handlePlaylistClick}
        >
            {/* Thumbnail / Video Card (Glassmorphic Border & Soft Hover Shadows) */}
            <div
                className="relative rounded-2xl overflow-hidden aspect-[3/4] shadow-[0_8px_20px_-6px_rgba(15,23,42,0.06)] border border-slate-100/70 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_12px_24px_-6px_rgba(99,102,241,0.15)] group/card bg-slate-50"
                onMouseEnter={isVideo ? handleMouseEnter : undefined}
                onMouseLeave={isVideo ? handleMouseLeave : undefined}
            >
                {/* Video or Image Background */}
                {isVideo ? (
                    <video
                        ref={videoRef}
                        src={videoUrl}
                        poster={thumbnailUrl || undefined}
                        className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-105"
                        muted
                        loop
                        playsInline
                        preload="metadata"
                    />
                ) : thumbnailUrl ? (
                    <img
                        src={thumbnailUrl}
                        alt={playlist.name}
                        className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-105"
                        loading="lazy"
                    />
                ) : (
                    <div className="absolute inset-0 bg-slate-900" />
                )}

                {/* Elegant Subtle Dark Gradient Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent" />

                {/* Glassmorphic Play Button Overlay */}
                <div
                    className={`absolute inset-0 flex items-center justify-center transition-all duration-300 ${
                        isPlaying
                            ? "opacity-0"
                            : "opacity-0 group-hover/card:opacity-100"
                    }`}
                >
                    <div className="w-10 h-10 rounded-full bg-white/35 backdrop-blur-md flex items-center justify-center border border-white/35 shadow-lg scale-90 group-hover/card:scale-100 transition-all duration-300">
                        <Play
                            size={15}
                            className="text-white ml-0.5"
                            fill="currentColor"
                        />
                    </div>
                </div>

                {/* Glassmorphic Post Count Badge */}
                {firstMedia && (
                    <div className="absolute top-2.5 right-2.5 bg-slate-900/40 backdrop-blur-md rounded-full px-2 py-0.5 flex items-center gap-1 border border-white/10">
                        <Play size={8} className="text-white" fill="white" />
                        <span className="text-[9px] font-bold text-white tracking-wide">
                            {item.post?.length || 0}
                        </span>
                    </div>
                )}

                {/* Bottom Content - Post Text */}
                {postText && (
                    <div className="absolute bottom-2.5 left-2.5 right-2.5">
                        <p className="text-white text-[11px] font-semibold line-clamp-2 leading-normal drop-shadow-md">
                            {postText}
                        </p>
                    </div>
                )}
            </div>

            {/* Profile Info Below Card */}
            <div className="flex items-center gap-2 mt-2.5 px-1">
                {/* Double-Ringed Avatar */}
                <div className="relative shrink-0 p-[1.5px] rounded-full ring-2 ring-slate-100 bg-white">
                    <img
                        src={profileImage}
                        alt={playlist.name}
                        className="w-6 h-6 rounded-full object-cover border border-transparent shadow-sm"
                        onError={(e) => {
                            e.target.src = FALLBACK_IMAGE;
                        }}
                    />
                    <span className="absolute bottom-0 right-0 w-2 h-2 bg-emerald-500 border border-white rounded-full shadow-sm" />
                </div>
                <span className="text-[13px] font-extrabold text-slate-700 truncate group-hover:text-indigo-600 transition-colors duration-250">
                    {playlist.name}
                </span>
            </div>
        </motion.div>
    );
};

const AUTO_SLIDE_INTERVAL = 2000; // 2 seconds

// Helper: compute one card width + gap based on viewport
const getCardWidth = () => (window.innerWidth >= 768 ? 208 : 176) + 16; // w-52 / w-44 + gap-4

const TopPlaylists = () => {
    const [playlists, setPlaylists] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [canScrollLeft, setCanScrollLeft] = useState(false);
    const [canScrollRight, setCanScrollRight] = useState(false);
    const [isHovered, setIsHovered] = useState(false);
    const scrollContainerRef = useRef(null);
    const autoSlideTimerRef = useRef(null);
    const pageIndexRef = useRef(1);
    const isFetchingRef = useRef(false);
    const hasMoreRef = useRef(true);

    // Fetch a page of playlists and append to the list
    const loadPage = useCallback(async (pageNum) => {
        if (isFetchingRef.current) return;
        isFetchingRef.current = true;
        try {
            const response = await fetchTopPlaylistPosts(pageNum);
            const newItems = response?.data || [];
            if (newItems.length === 0) {
                hasMoreRef.current = false;
            } else {
                setPlaylists((prev) => {
                    // Deduplicate by playlist id
                    const existingIds = new Set(
                        prev.map((p) => p.playlist?.id),
                    );
                    const unique = newItems.filter(
                        (p) => !existingIds.has(p.playlist?.id),
                    );
                    return unique.length > 0 ? [...prev, ...unique] : prev;
                });
            }
        } catch (error) {
            console.error("Failed to fetch top playlists:", error);
            hasMoreRef.current = false;
        } finally {
            isFetchingRef.current = false;
        }
    }, []);

    // Initial load
    useEffect(() => {
        const init = async () => {
            await loadPage(1);
            setIsLoading(false);
        };
        init();
    }, [loadPage]);

    const checkScrollability = useCallback(() => {
        const container = scrollContainerRef.current;
        if (!container) return;
        setCanScrollLeft(container.scrollLeft > 5);
        setCanScrollRight(
            container.scrollLeft <
                container.scrollWidth - container.clientWidth - 5,
        );
    }, []);

    useEffect(() => {
        const container = scrollContainerRef.current;
        if (!container) return;

        checkScrollability();
        container.addEventListener("scroll", checkScrollability, {
            passive: true,
        });
        window.addEventListener("resize", checkScrollability);

        return () => {
            container.removeEventListener("scroll", checkScrollability);
            window.removeEventListener("resize", checkScrollability);
        };
    }, [playlists, checkScrollability]);

    // Scroll by exactly one card in the given direction
    const scrollByOneCard = useCallback((direction) => {
        const container = scrollContainerRef.current;
        if (!container) return;
        const cardWidth = getCardWidth();
        container.scrollBy({
            left: direction === "left" ? -cardWidth : cardWidth,
            behavior: "smooth",
        });
    }, []);

    // When the user clicks the arrows
    const scroll = useCallback(
        (direction) => {
            scrollByOneCard(direction);
        },
        [scrollByOneCard],
    );

    // Auto-slide: advance one card every 2s, fetch next page at end, cycle
    useEffect(() => {
        if (isLoading || playlists.length <= 1 || isHovered) {
            clearInterval(autoSlideTimerRef.current);
            return;
        }

        autoSlideTimerRef.current = setInterval(async () => {
            const container = scrollContainerRef.current;
            if (!container) return;

            const atEnd =
                container.scrollLeft >=
                container.scrollWidth - container.clientWidth - 5;

            if (atEnd) {
                if (hasMoreRef.current && !isFetchingRef.current) {
                    // Fetch next page and let the carousel keep scrolling into new cards
                    pageIndexRef.current += 1;
                    await loadPage(pageIndexRef.current);
                    // After new data is appended, scroll one card forward on next tick
                    requestAnimationFrame(() => {
                        scrollByOneCard("right");
                    });
                } else {
                    // No more pages — cycle back to start
                    container.scrollTo({ left: 0, behavior: "smooth" });
                }
            } else {
                scrollByOneCard("right");
            }
        }, AUTO_SLIDE_INTERVAL);

        return () => clearInterval(autoSlideTimerRef.current);
    }, [isLoading, playlists.length, isHovered, loadPage, scrollByOneCard]);

    if (!isLoading && playlists.length === 0) {
        return null;
    }

    return (
        <motion.div
            initial={{ opacity: 0, y: 15 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, ease: [0.16, 1, 0.3, 1] }}
            className="relative bg-white/70 backdrop-blur-xl rounded-[2rem] p-6 shadow-[0_20px_50px_rgba(15,23,42,0.03)] border border-slate-100/80 mb-6 w-full max-w-3xl overflow-hidden group"
        >
            {/* Elegant Floating Ambient Glow */}
            <div className="absolute right-0 top-0 w-36 h-36 bg-indigo-400/5 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-400/10 transition-colors duration-500" />

            {/* Premium Sophisticated Header */}
            <div className="flex items-center justify-between mb-5">
                <div className="flex items-center gap-2">
                    <span className="w-1.5 h-3.5 bg-indigo-500 rounded-full" />
                    <h3 className="text-xs font-black uppercase tracking-[0.15em] text-slate-800 flex items-center gap-1.5">
                        Top Playlists
                        <ListMusic
                            size={12}
                            className="text-indigo-500 stroke-[2.5]"
                        />
                    </h3>
                </div>
                <button
                    onClick={() =>
                        (window.location.href = SITE_URL + "/reels.html")
                    }
                    className="flex items-center gap-1 text-xs font-black uppercase tracking-[0.1em] text-indigo-500 hover:text-indigo-600 transition-colors cursor-pointer"
                >
                    <Plus size={12} className="stroke-[2.5]" />
                    Create
                </button>
            </div>

            {/* Carousel Container */}
            <div
                className="relative -mx-2"
                onMouseEnter={() => setIsHovered(true)}
                onMouseLeave={() => setIsHovered(false)}
            >
                {/* Left Scroll Button */}
                <AnimatePresence>
                    {canScrollLeft && (
                        <motion.button
                            initial={{ opacity: 0, x: 5 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: 5 }}
                            onClick={() => scroll("left")}
                            className="absolute left-1 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-md shadow-lg border border-slate-100/80 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-white transition-all cursor-pointer"
                        >
                            <ChevronLeft size={16} className="stroke-[2.5]" />
                        </motion.button>
                    )}
                </AnimatePresence>

                {/* Right Scroll Button */}
                <AnimatePresence>
                    {canScrollRight && (
                        <motion.button
                            initial={{ opacity: 0, x: -5 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: -5 }}
                            onClick={() => scroll("right")}
                            className="absolute right-1 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-md shadow-lg border border-slate-100/80 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-white transition-all cursor-pointer"
                        >
                            <ChevronRight size={16} className="stroke-[2.5]" />
                        </motion.button>
                    )}
                </AnimatePresence>

                {/* Left Fade Edge */}
                {canScrollLeft && (
                    <div className="absolute left-0 top-0 bottom-0 w-10 bg-gradient-to-r from-white via-white/85 to-transparent z-[5] pointer-events-none rounded-l-2xl" />
                )}

                {/* Right Fade Edge */}
                {canScrollRight && (
                    <div className="absolute right-0 top-0 bottom-0 w-10 bg-gradient-to-l from-white via-white/85 to-transparent z-[5] pointer-events-none rounded-r-2xl" />
                )}

                {/* Scrollable Content */}
                <div
                    ref={scrollContainerRef}
                    className="flex gap-4 overflow-x-auto px-2 pb-1 scroll-smooth"
                    style={{
                        scrollbarWidth: "none",
                        msOverflowStyle: "none",
                        WebkitOverflowScrolling: "touch",
                    }}
                >
                    {isLoading ? (
                        <>
                            <PlaylistCardSkeleton />
                            <PlaylistCardSkeleton />
                            <PlaylistCardSkeleton />
                            <PlaylistCardSkeleton />
                        </>
                    ) : (
                        playlists.map((item, index) => (
                            <PlaylistCard
                                key={item.playlist?.id || index}
                                item={item}
                                index={index}
                            />
                        ))
                    )}
                </div>
            </div>
        </motion.div>
    );
};

export default TopPlaylists;
