import React, { useState, useEffect } from "react";
import { Play, Calendar, User, Eye, ChevronLeft, ChevronRight, Sparkles } from "lucide-react";
import { Link } from "react-router-dom";
import { ACTIVE_USER_ID, SITE_URL } from "../../config/siteConfig";


const FEATURED_SLIDES = [
    {
        id: "feat-1",
        title: "Nature's Untouched Paradise: The Majestic Waterfalls",
        description: "Embark on a breathtaking journey deep into the tropical rain forests. Experience the raw power, soothing sound, and unmatched beauty of the earth's most spectacular waterfalls captured in stunning ultra-high definition.",
        thumbnail: "https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&q=80&w=1200",
        creator: "Earth Explorer",
        creatorImg: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150",
        views: "1.2M",
        date: "2 days ago",
        duration: "12:45"
    },
    {
        id: "feat-2",
        title: "The Future of AI: Coding with Agents in 2026",
        description: "Join tech pioneers as they discuss the evolution of autonomous agents, live-coding helpers, and how development workflows are transforming. Witness a live demonstration of a multi-agent system building a full-stack project.",
        thumbnail: "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=1200",
        creator: "TechPulse",
        creatorImg: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150",
        views: "450K",
        date: "5 days ago",
        duration: "18:20"
    },
    {
        id: "feat-3",
        title: "Chilled Beats & Retro Lo-Fi: 24/7 Coding Session Mix",
        description: "The ultimate background soundtrack for developers, designers, and thinkers. A curated selection of relaxing retro synthwave, lo-fi hip hop, and smooth jazz to help you lock in and find your absolute flow state.",
        thumbnail: "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&q=80&w=1200",
        creator: "LoFi Cabin",
        creatorImg: "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=150",
        views: "890K",
        date: "1 week ago",
        duration: "1:24:00"
    }
];

function FeaturedBanner({ slides = [] }) {
    const displaySlides = slides.length > 0 ? slides : FEATURED_SLIDES;
    const [currentSlide, setCurrentSlide] = useState(0);

    // Auto-advance slides every 8 seconds
    useEffect(() => {
        if (displaySlides.length <= 1) return;
        const timer = setInterval(() => {
            setCurrentSlide((prev) => (prev + 1) % displaySlides.length);
        }, 8000);
        return () => clearInterval(timer);
    }, [displaySlides.length]);

    const nextSlide = () => {
        if (displaySlides.length <= 1) return;
        setCurrentSlide((prev) => (prev + 1) % displaySlides.length);
    };

    const prevSlide = () => {
        if (displaySlides.length <= 1) return;
        setCurrentSlide((prev) => (prev - 1 + displaySlides.length) % displaySlides.length);
    };

    if (displaySlides.length === 0) return null;

    const slide = displaySlides[currentSlide];

    return (
        <div className="relative w-full h-[400px] sm:h-[450px] lg:h-[480px] rounded-[2.5rem] overflow-hidden shadow-2xl mb-8 group">
            {/* Background Image with Smooth Crossfade */}
            <div className="absolute inset-0 z-0">
                <img
                    src={slide.thumbnail}
                    alt={slide.title}
                    className="w-full h-full object-cover transition-all duration-1000 transform scale-105 group-hover:scale-100"
                />
                {/* Visual Overlays for depth and text readability */}
                <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-slate-950/20" />
                <div className="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/40 to-transparent" />
            </div>

            {/* Slide Navigation Arrows */}
            {displaySlides.length > 1 && (
                <>
                    <button
                        type="button"
                        onClick={prevSlide}
                        className="absolute left-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-3 rounded-full shadow-lg border border-white/10 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110"
                        aria-label="Previous Slide"
                    >
                        <ChevronLeft size={24} />
                    </button>
                    <button
                        type="button"
                        onClick={nextSlide}
                        className="absolute right-6 top-1/2 -translate-y-1/2 z-20 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white p-3 rounded-full shadow-lg border border-white/10 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110"
                        aria-label="Next Slide"
                    >
                        <ChevronRight size={24} />
                    </button>
                </>
            )}

            {/* Badge Indicator */}
            <div className="absolute top-6 left-6 sm:left-10 z-10 flex items-center gap-1.5 bg-orange-500 text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full shadow-lg shadow-orange-500/30 animate-pulse">
                <Sparkles size={14} />
                <span>Featured Video</span>
            </div>

            {/* Slide Information */}
            <div className="absolute bottom-0 inset-x-0 p-6 sm:p-10 z-10 flex flex-col justify-end h-full max-w-3xl">
                <div className="space-y-4">
                    {/* Channel / Author row */}
                    <div className="flex items-center gap-3">
                        {slide.creatorImg && (
                            <img
                                src={slide.creatorImg}
                                alt={slide.creator}
                                className="w-8 h-8 rounded-full border border-white/20 object-cover"
                            />
                        )}
                        <span className="text-white font-semibold text-sm drop-shadow">
                            {slide.creator}
                        </span>
                        <span className="text-slate-300/80 text-xs">•</span>
                        <div className="flex items-center gap-1 text-slate-300/90 text-xs font-medium">
                            <Eye size={12} />
                            <span>{slide.views} Views</span>
                        </div>
                    </div>

                    {/* Title */}
                    <h1 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight drop-shadow-md">
                        {slide.postId ? (
                            <Link 
                                to={`/postDetail/${slide.postId}`}
                                className="hover:text-orange-400 transition-colors duration-200"
                            >
                                {slide.title}
                            </Link>
                        ) : (
                            slide.title
                        )}
                    </h1>

                    {/* Description */}
                    {slide.description && (
                        <p className="text-sm sm:text-base text-slate-200/95 line-clamp-2 sm:line-clamp-3 leading-relaxed max-w-2xl font-normal drop-shadow">
                            {slide.description}
                        </p>
                    )}

                    {/* Action buttons */}
                    <div className="flex flex-wrap items-center gap-4 pt-2">
                        {(slide.postId || slide.videoUrl) && (
                            slide.postId ? (
                                <Link
                                    to={`/postDetail/${slide.postId}`}
                                    className="flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-sm font-bold tracking-wide rounded-2xl shadow-xl shadow-orange-500/25 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 active:scale-95"
                                >
                                    <Play size={18} fill="currentColor" />
                                    <span>Watch Now</span>
                                    <span className="text-xs bg-black/20 text-orange-100 px-2 py-0.5 rounded-md font-semibold ml-1">
                                        {slide.duration || "Video"}
                                    </span>
                                </Link>
                            ) : (
                                <a
                                    href={slide.videoUrl}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-sm font-bold tracking-wide rounded-2xl shadow-xl shadow-orange-500/25 transition-all duration-300 hover:scale-105 hover:-translate-y-0.5 active:scale-95"
                                >
                                    <Play size={18} fill="currentColor" />
                                    <span>Watch Now</span>
                                    <span className="text-xs bg-black/20 text-orange-100 px-2 py-0.5 rounded-md font-semibold ml-1">
                                        {slide.duration || "Video"}
                                    </span>
                                </a>
                            )
                        )}
                    </div>
                </div>
            </div>

            {/* Pagination dot indicators */}
            {displaySlides.length > 1 && (
                <div className="absolute bottom-6 right-10 z-10 hidden sm:flex items-center gap-2">
                    {displaySlides.map((_, idx) => (
                        <button
                            key={idx}
                            type="button; hover:scale-110"
                            onClick={() => setCurrentSlide(idx)}
                            className={`h-2 rounded-full transition-all duration-500 ${
                                idx === currentSlide ? "w-8 bg-orange-500" : "w-2 bg-white/40 hover:bg-white/70"
                            }`}
                            aria-label={`Go to slide ${idx + 1}`}
                        />
                    ))}
                </div>
            )}
        </div>
    );
}

export default FeaturedBanner;
