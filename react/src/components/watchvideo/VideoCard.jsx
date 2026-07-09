import React, { useState, useRef, useEffect } from "react";
import { Play, MoreVertical, Eye, Clock, Plus, Sparkles } from "lucide-react";
import { addToPlaylist } from "../../services/postService";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { ACTIVE_USER_ID, SITE_URL } from "../../config/siteConfig";


function VideoCard({ video }) {
    const navigate = useNavigate();
    const {
        postId,
        title,
        thumbnail,
        videoUrl,
        views,
        timeAgo,
        duration,
        isTrending,
        isNew
    } = video;

    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const [isHovered, setIsHovered] = useState(false);
    const menuRef = useRef(null);
    const videoRef = useRef(null);

    // Play/Pause video on hover changes
    useEffect(() => {
        if (!videoUrl || !videoRef.current) return;
        if (isHovered) {
            const playPromise = videoRef.current.play();
            if (playPromise !== undefined) {
                playPromise.catch((err) => {
                    console.log("Hover video play failed:", err);
                });
            }
        } else {
            videoRef.current.pause();
            videoRef.current.currentTime = 0;
        }
    }, [isHovered, videoUrl]);

    // Close menu when clicking outside
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (menuRef.current && !menuRef.current.contains(event.target)) {
                setIsMenuOpen(false);
            }
        };

        if (isMenuOpen) {
            document.addEventListener("mousedown", handleClickOutside);
        }
        return () => {
            document.removeEventListener("mousedown", handleClickOutside);
        };
    }, [isMenuOpen]);

    const handleAddToPlaylist = async () => {
        setIsMenuOpen(false);
        if (!postId) {
            toast.error("Invalid video post ID");
            return;
        }
        try {
            const result = await addToPlaylist(postId);
            if (result?.success === true || result?.success === 'true' || result?.success === 1 || result?.success === '1') {
                toast.success(result?.message || "Video added to playlist successfully! 🎵");
            } else {
                toast.error(result?.message || "Failed to add video to playlist.");
            }
        } catch (error) {
            console.error("Error adding to playlist:", error);
            toast.error("An error occurred while adding to playlist.");
        }
    };

    const handleWatchVideo = () => {
        if (!postId) {
            toast.error("Invalid video post ID");
            return;
        }
        navigate(`/postDetail/${postId}`);
    };

    return (
        <article className="relative bg-white/75 backdrop-blur-md rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white flex flex-col h-full transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-slate-300/40 group">
            {/* Thumbnail Wrapper */}
            <div 
                className="relative px-4 pt-4 cursor-pointer"
                onClick={handleWatchVideo}
                onMouseEnter={() => setIsHovered(true)}
                onMouseLeave={() => setIsHovered(false)}
            >
                <div className="relative w-full aspect-video rounded-[1.5rem] overflow-hidden bg-slate-100 shadow-inner">
                    {/* Hover Video Player */}
                    {videoUrl && (
                        <video
                            ref={videoRef}
                            src={videoUrl}
                            poster={thumbnail}
                            className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-350 ${
                                isHovered ? "opacity-100 z-10" : "opacity-0 z-0"
                            }`}
                            muted
                            loop
                            playsInline
                            preload="none"
                        />
                    )}

                    <img
                        src={thumbnail}
                        alt={title}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />

                    {/* Gradient overlay on hover */}
                    <div className="absolute inset-0 bg-slate-900/10 group-hover:bg-slate-900/30 transition-colors duration-300 flex items-center justify-center" />

                    {/* Floating Duration Badge */}
                    <span className="absolute bottom-3 right-3 bg-slate-950/70 backdrop-blur-md text-white text-[11px] font-bold px-2 py-0.5 rounded-md tracking-wider z-20">
                        {duration}
                    </span>

                    {/* Centered Play Button Overlay */}
                    <div className="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                        <div className="w-12 h-12 bg-white/95 rounded-full flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition-transform duration-300">
                            <Play size={20} className="text-purple-600 ml-1 fill-purple-600" />
                        </div>
                    </div>

                    {/* Left Badges */}
                    <div className="absolute top-3 left-3 flex flex-col gap-1.5 z-25">
                        {isTrending && (
                            <span className="flex items-center gap-1 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full shadow-md">
                                <Sparkles size={10} />
                                <span>Trending</span>
                            </span>
                        )}
                        {isNew && (
                            <span className="bg-purple-600 text-white text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full shadow-md w-fit">
                                New
                            </span>
                        )}
                    </div>
                </div>
            </div>

            {/* Video Meta Body */}
            <div className="p-5 flex-grow flex flex-col">
                <div className="flex items-start justify-between gap-3 mb-3">
                    {/* Title */}
                    <h3 
                        onClick={handleWatchVideo}
                        className="text-[15px] font-extrabold text-slate-800 leading-snug tracking-tight line-clamp-2 hover:text-purple-600 cursor-pointer transition-colors duration-200 flex-1"
                    >
                        {title}
                    </h3>

                    {/* Options Button */}
                    <div className="relative shrink-0" ref={menuRef}>
                        <button
                            type="button"
                            onClick={() => setIsMenuOpen(!isMenuOpen)}
                            className="text-slate-400 hover:text-slate-600 transition rounded-full p-1 hover:bg-slate-100/80 cursor-pointer"
                            aria-label="Video options"
                        >
                            <MoreVertical size={18} />
                        </button>

                        {isMenuOpen && (
                            <div className="absolute right-0 top-7 z-30 min-w-[170px] rounded-2xl border border-slate-100 bg-white shadow-xl py-2 animate-in fade-in slide-in-from-top-2 duration-200">
                                <button
                                    type="button"
                                    onClick={handleAddToPlaylist}
                                    className="flex items-center gap-2 w-full px-4 py-2 text-left text-sm text-slate-600 hover:text-slate-800 hover:bg-slate-50 transition cursor-pointer"
                                >
                                    <Plus size={16} />
                                    <span>Add to Playlist</span>
                                </button>
                            </div>
                        )}
                    </div>
                </div>

                {/* Footer details */}
                <div className="mt-auto flex items-center justify-between text-slate-400 text-[11px] font-semibold tracking-wide border-t border-slate-100/80 pt-3">
                    <div className="flex items-center gap-1">
                        <Eye size={12} />
                        <span>{views} Views</span>
                    </div>
                    <div className="flex items-center gap-1">
                        <Clock size={12} />
                        <span>{timeAgo}</span>
                    </div>
                </div>
            </div>
        </article>
    );
}

export default VideoCard;
