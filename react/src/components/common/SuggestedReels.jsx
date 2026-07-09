import React, { useEffect, useState } from 'react';
import { fetchSuggestedPosts } from '../../services/postService';
import { FALLBACK_IMAGE } from '../../config/siteConfig';
import { getFullProfileImageUrl, getDirectImageUrl } from '../../utils/imageUtils';

const SuggestedReels = () => {
    const [reels, setReels] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const loadSuggestedReels = async () => {
            try {
                const response = await fetchSuggestedPosts();
                if (response && response.settings && response.settings.success === "1") {
                    setReels(response.data || []);
                }
            } catch (error) {
                console.error("Failed to fetch suggested reels:", error);
            } finally {
                setIsLoading(false);
            }
        };

        loadSuggestedReels();
    }, []);

    if (isLoading) {
        return (
            <div className="bg-white rounded-2xl p-5 shadow-sm w-full animate-pulse flex flex-col gap-6">
                <div className="h-6 bg-gray-200 rounded w-1/3"></div>
                {[1, 2, 3].map(i => (
                    <div key={i} className="flex flex-col gap-3">
                        <div className="flex items-center gap-2">
                            <div className="w-8 h-8 rounded-full bg-gray-200"></div>
                            <div className="h-4 bg-gray-200 rounded w-24"></div>
                        </div>
                        <div className="h-48 bg-gray-200 rounded-xl w-full"></div>
                    </div>
                ))}
            </div>
        );
    }

    if (!reels.length) {
        return null;
    }

    return (
        <div className="bg-white rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] p-5 w-full flex flex-col gap-4 max-h-[calc(100vh-120px)]">
            <h3 className="font-semibold text-gray-800 text-lg shrink-0">Suggested</h3>
            <div className="flex flex-col gap-6 overflow-y-auto pr-2 pb-2" style={{ scrollbarWidth: 'thin' }}>
                {reels.map((reel) => {
                    // Try to get a valid image, fallback to displaying empty or black if no valid image.
                    let posterImage = getDirectImageUrl(reel.final_video_image);
                    if (!posterImage || posterImage.includes('noimage.gif')) {
                        posterImage = getDirectImageUrl(reel.final_display_image);
                    }
                    if (posterImage && posterImage.includes('noimage.gif')) {
                        posterImage = undefined;
                    }

                    const isVideo = reel.final_media_type === 'Video' && 
                                    typeof reel.final_upload_file === 'string' && 
                                    reel.final_upload_file.trim() !== '' &&
                                    !reel.final_upload_file.includes('undefined') &&
                                    !reel.final_upload_file.includes('null');

                    return (
                        <div key={reel.post_id} className="flex flex-col gap-3 group shrink-0">
                            <div className="flex items-center justify-between px-1">
                                <div className="flex items-center gap-2 cursor-pointer">
                                    <img 
                                        src={getFullProfileImageUrl(reel.user_profile_image)} 
                                        alt={reel.user_name} 
                                        className="w-8 h-8 rounded-full object-cover border border-gray-100 shadow-sm"
                                        onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                                    />
                                    <span className="text-sm font-medium text-gray-700 group-hover:text-orange-500 transition-colors line-clamp-1">
                                        {reel.user_name}
                                    </span>
                                </div>
                                <span className="text-[11px] text-gray-400 font-medium bg-gray-50 px-2 py-1 rounded-full">
                                    {reel.final_views_count || 0} views
                                </span>
                            </div>
                            
                            <div className="relative rounded-xl overflow-hidden bg-gray-900 aspect-video shadow-sm group-hover:shadow-md transition-all duration-300 transform group-hover:-translate-y-1 cursor-pointer">
                                {isVideo ? (
                                    <video 
                                        src={posterImage ? reel.final_upload_file : `${reel.final_upload_file}#t=0.1`}
                                        poster={posterImage}
                                        preload="metadata"
                                        className="w-full h-full object-cover transition-opacity duration-300"
                                        muted
                                        loop
                                        playsInline
                                        onMouseEnter={(e) => {
                                            const playPromise = e.target.play();
                                            if (playPromise !== undefined) {
                                                playPromise.catch(error => {
                                                    if (error.name !== 'AbortError') {
                                                        console.log('Video auto-play blocked:', error);
                                                    }
                                                });
                                            }
                                        }}
                                        onMouseLeave={(e) => {
                                            e.target.pause();
                                            e.target.currentTime = posterImage ? 0 : 0.1;
                                        }}
                                    />
                                ) : (
                                    <img 
                                        src={reel.final_display_image || reel.final_upload_file || FALLBACK_IMAGE}
                                        alt={reel.post_text || "Suggestion preview"}
                                        className="w-full h-full object-cover transition-opacity duration-300"
                                        onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                                    />
                                )}
                                
                                {/* Hover overlay for play icon */}
                                <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 flex items-center justify-center pointer-events-none">
                                    <div className="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 scale-90 group-hover:scale-100 shadow-lg border border-white/20">
                                        <svg className="w-4 h-4 text-white ml-1 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>

                                {/* Post text overlay at bottom */}
                                {reel.post_text && (
                                    <div className="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                        <p className="text-white text-xs line-clamp-2 drop-shadow-md">
                                            {reel.post_text}
                                        </p>
                                    </div>
                                )}
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
};

export default SuggestedReels;
