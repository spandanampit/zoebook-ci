import React from "react";
import VideoCard from "./VideoCard";

function VideoCardSkeleton() {
    return (
        <div className="bg-white/75 backdrop-blur-md rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-4 animate-pulse">
            <div className="w-full aspect-video rounded-[1.5rem] bg-slate-200 mb-4" />
            <div className="flex items-center justify-between mb-4">
                <div className="flex items-center gap-3">
                    <div className="w-9 h-9 rounded-full bg-slate-200" />
                    <div className="space-y-1.5">
                        <div className="h-3 w-16 rounded bg-slate-200" />
                        <div className="h-2 w-10 rounded bg-slate-200" />
                    </div>
                </div>
                <div className="w-4 h-6 rounded bg-slate-200" />
            </div>
            <div className="space-y-2 mb-4">
                <div className="h-4 w-11/12 rounded bg-slate-200" />
                <div className="h-4 w-4/5 rounded bg-slate-200" />
            </div>
            <div className="border-t border-slate-100/80 pt-3 flex justify-between">
                <div className="h-2.5 w-12 rounded bg-slate-200" />
                <div className="h-2.5 w-12 rounded bg-slate-200" />
            </div>
        </div>
    );
}

function VideoGrid({ videos, isLoading }) {
    if (isLoading) {
        return (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {Array.from({ length: 8 }).map((_, idx) => (
                    <VideoCardSkeleton key={`video-skeleton-${idx}`} />
                ))}
            </div>
        );
    }

    if (!videos || videos.length === 0) {
        return (
            <div className="text-center py-16 bg-white/50 backdrop-blur-sm rounded-[2.5rem] border border-white/60 shadow-sm mt-4">
                <p className="text-slate-500 font-bold text-base">No videos found matching this filter.</p>
                <p className="text-slate-400 text-sm mt-1">Try selecting another category or check back later.</p>
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {videos.map((video) => (
                <VideoCard key={video.id} video={video} />
            ))}
        </div>
    );
}

export default VideoGrid;
