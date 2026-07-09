import React, { useState, useEffect, useCallback } from "react";
import { useParams, useNavigate, Link } from "react-router-dom";
import { toast } from "react-toastify";
import {
    Heart,
    Share2,
    ListPlus,
    Eye,
    Clock,
    MessageCircle,
    User,
    Loader2,
    Sparkles,
    ThumbsUp,
    ChevronRight,
    UserCheck,
    UserPlus,
    CornerDownRight,
    ArrowLeft
} from "lucide-react";
import {
    getPostDetail,
    fetchOtherPosts,
    addToPlaylist,
    likePost
} from "../../services/postService";
import { fetchProfileAPI } from "../../services/movementService";
import { followUser, unfollowUser } from "../../services/userService";
import { getFullProfileImageUrl } from "../../utils/imageUtils";
import { FALLBACK_IMAGE, SITE_URL, ACTIVE_USER_ID } from "../../config/siteConfig";
import PostCommentSection from "../../components/comments/PostCommentSection";

function PostDetailPage() {
    const { postId } = useParams();
    const navigate = useNavigate();

    // Main States
    const [postData, setPostData] = useState(null);
    const [creatorProfile, setCreatorProfile] = useState(null);
    const [suggestedPosts, setSuggestedPosts] = useState([]);

    // Paginated Other Posts States
    const [pageIndex, setPageIndex] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [isLoadingMore, setIsLoadingMore] = useState(false);
    const [lastPostId, setLastPostId] = useState(postId);

    // UI Interaction States
    const [isLoading, setIsLoading] = useState(true);
    const [isError, setIsError] = useState(false);

    const [isLiked, setIsLiked] = useState(false);
    const [likesCount, setLikesCount] = useState(0);
    const [isLiking, setIsLiking] = useState(false);

    const [isFollowing, setIsFollowing] = useState(false);
    const [followerCount, setFollowerCount] = useState(0);
    const [isFollowingApiCall, setIsFollowingApiCall] = useState(false);

    const [isAddingPlaylist, setIsAddingPlaylist] = useState(false);
    const [showFullDescription, setShowFullDescription] = useState(false);

    // Fetch Main Post Details
    useEffect(() => {
        const loadPostData = async () => {
            setIsLoading(true);
            setIsError(false);
            try {
                const res = await getPostDetail(postId);
                const dataObj = res?.data;
                if (dataObj) {
                    setPostData(dataObj);
                    setIsLiked(dataObj.is_like === "1" || dataObj.is_like === 1);
                    setLikesCount(Number(dataObj.likes_count) || 0);
                } else {
                    setIsError(true);
                    toast.error("Post details not found.");
                }
            } catch (error) {
                console.error("Error loading post detail:", error);
                setIsError(true);
                toast.error("Failed to load post details.");
            } finally {
                setIsLoading(false);
            }
        };

        if (postId) {
            loadPostData();
        }
    }, [postId]);

    // Update Open Graph and Twitter Card metadata in the document head when postData changes
    useEffect(() => {
        if (!postData) return;

        const mediaItem = Array.isArray(postData.get_post_media) && postData.get_post_media.length > 0
            ? postData.get_post_media[0]
            : null;

        const postText = postData.post_text_emoji || postData.post_text || "";
        const titleText = postText ? postText.substring(0, 60) : "Zoebook Post";
        const descText = postData.p_post_meta_data || postText || "Check out this post on Zoebook!";
        const imageToUse = mediaItem?.pm_media_type === "Video"
            ? (mediaItem?.pm_video_thumbnail || FALLBACK_IMAGE)
            : (mediaItem?.upload_file || mediaItem?.display_image || postData.user_profile_image || FALLBACK_IMAGE);

        const currentUrl = postData.share_postdetail_url || window.location.href;
        const isVideo = mediaItem?.pm_media_type === "Video";

        const updateMeta = (nameOrProperty, value, attr = "property") => {
            if (!value) return;
            let el = document.querySelector(`meta[${attr}="${nameOrProperty}"]`);
            if (!el) {
                el = document.createElement("meta");
                el.setAttribute(attr, nameOrProperty);
                document.head.appendChild(el);
            }
            el.setAttribute("content", value);
        };

        // Update document title
        document.title = `${titleText} | Zoebook`;

        // Update standard description
        updateMeta("description", descText, "name");

        // Update Open Graph tags
        updateMeta("og:title", titleText);
        updateMeta("og:description", descText);
        updateMeta("og:image", imageToUse);
        updateMeta("og:url", currentUrl);
        updateMeta("og:type", isVideo ? "video.other" : "website");

        // Update Twitter Card tags
        updateMeta("twitter:card", isVideo ? "player" : "summary_large_image", "name");
        updateMeta("twitter:title", titleText, "name");
        updateMeta("twitter:description", descText, "name");
        updateMeta("twitter:image", imageToUse, "name");

        return () => {
            document.title = "Zoebook";
        };
    }, [postData]);

    // Fetch Creator's Profile Details once we have the posted_user_id
    useEffect(() => {
        const loadCreatorProfile = async () => {
            if (!postData?.posted_user_id) return;
            try {
                const profileRes = await fetchProfileAPI(postData.posted_user_id);
                const rawProfile = Array.isArray(profileRes?.data) ? profileRes.data[0] : profileRes?.data;
                if (rawProfile) {
                    setCreatorProfile(rawProfile);
                    setIsFollowing(rawProfile.is_follwing === "Yes" || rawProfile.is_follwing === "1");
                    setFollowerCount(Number(rawProfile.follower_count) || 0);
                }
            } catch (error) {
                console.error("Failed to fetch creator profile:", error);
            }
        };

        loadCreatorProfile();
    }, [postData?.posted_user_id]);

    // Fetch Suggested Posts (Other Posts) with pagination
    useEffect(() => {
        if (!postId) return;

        // If the postId has changed, reset state variables and clear the list
        if (postId !== lastPostId) {
            setLastPostId(postId);
            setPageIndex(1);
            setSuggestedPosts([]);
            setHasMore(true);
            setIsLoadingMore(false);
            return;
        }

        let isCurrent = true;
        const loadOtherPosts = async () => {
            setIsLoadingMore(true);
            try {
                const res = await fetchOtherPosts(postId, pageIndex);
                if (!isCurrent) return;

                const dataList = Array.isArray(res?.data) ? res.data : [];

                if (dataList.length === 0) {
                    setHasMore(false);
                } else {
                    setSuggestedPosts((prev) => {
                        // Filter out the current post
                        const filteredNew = dataList.filter(
                            (item) => String(item.p_post_id) !== String(postId)
                        );
                        if (pageIndex === 1) {
                            return filteredNew;
                        }
                        const existingIds = new Set(prev.map((p) => String(p.p_post_id)));
                        const uniqueNew = filteredNew.filter((p) => !existingIds.has(String(p.p_post_id)));
                        return [...prev, ...uniqueNew];
                    });

                    const nextPageValue = res?.settings?.next_page;
                    const hasNext = nextPageValue && String(nextPageValue) !== "0" && String(nextPageValue) !== "";
                    setHasMore(!!hasNext);
                }
            } catch (error) {
                console.error("Failed to load other posts:", error);
                if (isCurrent) {
                    setHasMore(false);
                }
            } finally {
                if (isCurrent) {
                    setIsLoadingMore(false);
                }
            }
        };

        loadOtherPosts();

        return () => {
            isCurrent = false;
        };
    }, [postId, pageIndex, lastPostId]);

    // Handle Infinite Scroll
    useEffect(() => {
        const handleScroll = () => {
            if (!hasMore || isLoadingMore) return;

            const threshold = 300; // Trigger load when 300px from the bottom
            const windowHeight = window.innerHeight;
            const scrollY = window.scrollY || window.pageYOffset;
            const documentHeight = document.documentElement.scrollHeight;

            if (windowHeight + scrollY >= documentHeight - threshold) {
                setPageIndex((prev) => prev + 1);
            }
        };

        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, [hasMore, isLoadingMore]);

    // Handle Like Toggle
    const handleLikeToggle = async () => {
        if (isLiking || !postId) return;
        setIsLiking(true);

        const targetStatus = isLiked ? 0 : 1;

        // Optimistic Update
        setIsLiked(!isLiked);
        setLikesCount(prev => targetStatus ? prev + 1 : prev - 1);

        try {
            const result = await likePost(postId, targetStatus);
            if (result && (result.success === true || result.success === 1 || String(result.success) === "1")) {
                // Success - keep optimistic states
            } else {
                // Revert if API indicates failure
                setIsLiked(isLiked);
                setLikesCount(prev => isLiked ? prev + 1 : prev - 1);
                toast.error(result?.message || "Failed to update like status.");
            }
        } catch (error) {
            console.error("Like toggle failed:", error);
            // Revert on network/API exception
            setIsLiked(isLiked);
            setLikesCount(prev => isLiked ? prev + 1 : prev - 1);
            toast.error("An error occurred while liking the post.");
        } finally {
            setIsLiking(false);
        }
    };

    // Handle Follow/Unfollow Toggle
    const handleFollowToggle = async () => {
        const creatorId = postData?.posted_user_id;
        if (isFollowingApiCall || !creatorId) return;
        setIsFollowingApiCall(true);

        const willFollow = !isFollowing;

        // Optimistic Update
        setIsFollowing(willFollow);
        setFollowerCount(prev => willFollow ? prev + 1 : Math.max(0, prev - 1));

        try {
            let res;
            if (willFollow) {
                res = await followUser(creatorId);
            } else {
                res = await unfollowUser(creatorId);
            }

            if (res && (res.success === true || res.success === 1 || String(res.success) === "1" || String(res.settings?.success) === "1")) {
                toast.success(res.message || res.settings?.message || (willFollow ? "Followed creator!" : "Unfollowed creator."));
            } else {
                // Rollback
                setIsFollowing(!willFollow);
                setFollowerCount(prev => !willFollow ? prev + 1 : Math.max(0, prev - 1));
                toast.error(res?.message || res?.settings?.message || "Action failed.");
            }
        } catch (error) {
            console.error("Follow/Unfollow API error:", error);
            // Rollback
            setIsFollowing(!willFollow);
            setFollowerCount(prev => !willFollow ? prev + 1 : Math.max(0, prev - 1));
            toast.error("Failed to connect to the follow service.");
        } finally {
            setIsFollowingApiCall(false);
        }
    };

    // Handle Add to Playlist
    const handleAddToPlaylist = async () => {
        if (isAddingPlaylist || !postId) return;
        setIsAddingPlaylist(true);
        try {
            const res = await addToPlaylist(postId);
            if (res && (res.success === true || res.success === 1 || String(res.success) === "1" || String(res.success) === "true")) {
                toast.success(res.message || "Added to playlist successfully! 🎵");
            } else {
                toast.error(res?.message || "Failed to add to playlist.");
            }
        } catch (error) {
            console.error("Playlist API error:", error);
            toast.error("An error occurred while adding to playlist.");
        } finally {
            setIsAddingPlaylist(false);
        }
    };

    // Handle Copy Share Link
    const handleShare = async () => {
        const shareUrl = postData?.share_postdetail_url || window.location.href;
        if (navigator.share) {
            try {
                await navigator.share({
                    title: postData?.post_text || "Check out this post on Zoebook!",
                    url: shareUrl
                });
            } catch (error) {
                console.error("Error sharing:", error);
            }
        } else {
            try {
                await navigator.clipboard.writeText(shareUrl);
                toast.success("Post link copied to clipboard! 📋");
            } catch (error) {
                toast.error("Failed to copy link.");
            }
        }
    };

    // Render Skeletons during Loading
    if (isLoading) {
        return (
            <div className="max-w-[1440px] mx-auto px-4 py-8 animate-pulse space-y-6">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div className="lg:col-span-8 space-y-6">
                        <div className="w-full aspect-video rounded-3xl bg-slate-200" />
                        <div className="h-6 w-3/4 rounded bg-slate-200" />
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-full bg-slate-200" />
                                <div className="space-y-2">
                                    <div className="h-4 w-32 rounded bg-slate-200" />
                                    <div className="h-3 w-20 rounded bg-slate-200" />
                                </div>
                            </div>
                            <div className="h-10 w-24 rounded-full bg-slate-200" />
                        </div>
                    </div>
                    <div className="lg:col-span-4 space-y-4">
                        <div className="h-5 w-1/3 rounded bg-slate-200 mb-4" />
                        {Array.from({ length: 4 }).map((_, i) => (
                            <div key={i} className="flex gap-3">
                                <div className="w-28 aspect-video rounded-xl bg-slate-200 shrink-0" />
                                <div className="flex-1 space-y-2 py-1">
                                    <div className="h-3.5 w-full rounded bg-slate-200" />
                                    <div className="h-3 w-1/2 rounded bg-slate-200" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }

    // Render Error State
    if (isError || !postData) {
        return (
            <div className="max-w-md mx-auto my-20 text-center bg-white border border-slate-100 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/50">
                <div className="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <Heart size={40} className="stroke-[1.5]" />
                </div>
                <h2 className="text-2xl font-black text-slate-800 tracking-tight mb-2">Failed to Load Post</h2>
                <p className="text-slate-500 text-sm mb-6 leading-relaxed">
                    We couldn't retrieve the details for this post. It may have been deleted, or you might be experiencing connectivity issues.
                </p>
                <button
                    onClick={() => navigate("/watchvideo")}
                    className="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm rounded-full transition-all duration-300 shadow-lg shadow-purple-200 hover:shadow-purple-300"
                >
                    Back to Videos
                </button>
            </div>
        );
    }

    const handleCommentAdded = () => {
        setPostData((prev) => {
            if (!prev) return prev;
            return {
                ...prev,
                comment_count: (Number(prev.comment_count) || 0) + 1,
            };
        });
    };

    // Media resolution helpers
    const mediaItem = Array.isArray(postData.get_post_media) && postData.get_post_media.length > 0
        ? postData.get_post_media[0]
        : null;
    const videoUrl = mediaItem?.pm_media_type === "Video" ? mediaItem?.upload_file : null;
    const imageUrl = mediaItem?.pm_media_type === "Image" ? mediaItem?.upload_file || mediaItem?.display_image : postData.user_profile_image;
    const thumbnailUrl = mediaItem?.pm_video_thumbnail || mediaItem?.display_image || FALLBACK_IMAGE;

    const creatorName = postData.user_name || creatorProfile?.u_name || "Zoebook Creator";
    const creatorImg = getFullProfileImageUrl(postData.user_profile_image || creatorProfile?.u_profile_image);
    const postText = postData.post_text_emoji || postData.post_text || "";

    // Show follow button only if the post creator is not the active user
    const isOwnPost = String(postData.posted_user_id) === String(ACTIVE_USER_ID);

    return (
        <div className="max-w-[1440px] mx-auto px-4 py-6 animate-in fade-in duration-500">
            {/* Back Button */}
            <div className="mb-4">
                <button
                    type="button"
                    onClick={() => navigate(-1)}
                    className="group flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200/80 hover:border-slate-300 font-bold text-sm rounded-full shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer"
                >
                    <ArrowLeft size={16} className="group-hover:-translate-x-0.5 transition-transform" />
                    <span>Back</span>
                </button>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {/* ── LEFT COLUMN: MAIN CONTENT ────────────────────────────────── */}
                <div className="lg:col-span-8 space-y-6">

                    {/* Premium Video Player Container */}
                    <div className="relative w-full aspect-video rounded-3xl overflow-hidden bg-slate-950 shadow-2xl border border-white/10 group">
                        {videoUrl ? (
                            <video
                                key={videoUrl}
                                src={videoUrl}
                                poster={thumbnailUrl}
                                className="w-full h-full object-contain"
                                controls
                                autoPlay
                                playsInline
                            />
                        ) : imageUrl ? (
                            <div className="w-full h-full flex items-center justify-center bg-slate-900">
                                <img
                                    src={imageUrl}
                                    alt={postText}
                                    className="max-h-full max-w-full object-contain"
                                    onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                                />
                            </div>
                        ) : (
                            <div className="w-full h-full flex flex-col items-center justify-center bg-slate-900 text-slate-400 p-6 text-center">
                                <Sparkles size={48} className="text-slate-600 mb-4 animate-pulse" />
                                <span className="text-sm font-semibold">{postText || "Media Post details"}</span>
                            </div>
                        )}
                    </div>

                    {/* Post Title */}
                    <div>
                        <h1 className="text-xl sm:text-2xl font-black text-slate-800 leading-snug tracking-tight">
                            {postText || "Untitled Media Post"}
                        </h1>
                    </div>

                    {/* Creator Info & Action Buttons row (YouTube Style) */}
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">

                        {/* Left Side: Creator Profile */}
                        <div className="flex items-center gap-3">
                            <img
                                src={creatorImg}
                                alt={creatorName}
                                className="w-12 h-12 rounded-full object-cover border border-slate-100 shadow-sm shrink-0"
                                onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                            />
                            <div className="flex flex-col min-w-0">
                                <span className="font-extrabold text-slate-800 text-base leading-tight truncate hover:text-purple-600">
                                    {creatorName}
                                </span>
                                <span className="text-xs font-semibold text-slate-400 mt-0.5">
                                    {followerCount} {followerCount === 1 ? "follower" : "followers"}
                                </span>
                            </div>

                            {/* Follow Button */}
                            {!isOwnPost && (
                                <button
                                    type="button"
                                    onClick={handleFollowToggle}
                                    disabled={isFollowingApiCall}
                                    className={`ml-4 px-5 py-2.5 rounded-full font-bold text-xs shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-1.5 cursor-pointer hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-70 ${isFollowing
                                            ? "bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200"
                                            : "bg-slate-900 hover:bg-slate-800 text-white"
                                        }`}
                                >
                                    {isFollowing ? (
                                        <>
                                            <UserCheck size={13} />
                                            <span>Following</span>
                                        </>
                                    ) : (
                                        <>
                                            <UserPlus size={13} />
                                            <span>Follow</span>
                                        </>
                                    )}
                                </button>
                            )}
                        </div>

                        {/* Right Side: Action pill buttons */}
                        <div className="flex items-center flex-wrap gap-2.5">

                            {/* Like Pill */}
                            <button
                                type="button"
                                onClick={handleLikeToggle}
                                disabled={isLiking}
                                className={`flex items-center gap-2 px-5 py-2.5 rounded-full font-extrabold text-sm shadow-sm transition-all duration-300 cursor-pointer hover:-translate-y-0.5 active:translate-y-0 ${isLiked
                                        ? "bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-100"
                                        : "bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-100"
                                    }`}
                            >
                                <Heart size={16} className={isLiked ? "fill-rose-600 text-rose-600" : "text-slate-500"} />
                                <span>{likesCount}</span>
                            </button>

                            {/* Share Pill */}
                            <button
                                type="button"
                                onClick={handleShare}
                                className="flex items-center gap-2 px-5 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-extrabold text-sm border border-slate-100 rounded-full shadow-sm transition-all duration-300 cursor-pointer hover:-translate-y-0.5 active:translate-y-0"
                            >
                                <Share2 size={16} className="text-slate-500" />
                                <span>Share</span>
                            </button>

                            {/* Playlist Pill */}
                            <button
                                type="button"
                                onClick={handleAddToPlaylist}
                                disabled={isAddingPlaylist}
                                className="flex items-center gap-2 px-5 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 font-extrabold text-sm border border-slate-100 rounded-full shadow-sm transition-all duration-300 cursor-pointer hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-75"
                            >
                                {isAddingPlaylist ? (
                                    <Loader2 size={16} className="animate-spin text-purple-600" />
                                ) : (
                                    <ListPlus size={16} className="text-slate-500" />
                                )}
                                <span>Save</span>
                            </button>
                        </div>
                    </div>

                    {/* YouTube-like Description Box */}
                    <div className="bg-slate-100/60 hover:bg-slate-100/80 p-5 rounded-2xl transition-colors duration-200">
                        <div className="flex items-center gap-4 text-xs font-extrabold text-slate-700 mb-3 tracking-wide">
                            <div className="flex items-center gap-1.5">
                                <Eye size={14} className="text-slate-500" />
                                <span>{postData.impression_count || "0"} Impressions</span>
                            </div>
                            <span className="text-slate-300 font-normal">|</span>
                            <div className="flex items-center gap-1.5">
                                <Clock size={14} className="text-slate-500" />
                                <span>Posted {postData.added_date}</span>
                            </div>
                        </div>

                        <div className="text-sm text-slate-600 leading-relaxed font-normal whitespace-pre-wrap break-words">
                            {showFullDescription
                                ? (postData.p_post_meta_data || postText || "No detailed description available.")
                                : `${(postData.p_post_meta_data || postText || "No detailed description available.").substring(0, 200)}...`
                            }

                            {(postData.p_post_meta_data || postText || "").length > 200 && (
                                <button
                                    type="button"
                                    onClick={() => setShowFullDescription(!showFullDescription)}
                                    className="block font-bold text-slate-800 hover:text-purple-600 mt-2 text-xs transition cursor-pointer"
                                >
                                    {showFullDescription ? "Show Less" : "Show More"}
                                </button>
                            )}
                        </div>
                    </div>

                    {/* Comments Area using standard comments section */}
                    <div className="pt-4">
                        <div className="flex items-center gap-2 border-b border-slate-100 pb-4 mb-4">
                            <MessageCircle size={20} className="text-slate-700" />
                            <h3 className="text-lg font-black text-slate-800 tracking-tight">
                                Comments
                            </h3>
                            <span className="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-bold ml-1">
                                {postData.comment_count || "0"}
                            </span>
                        </div>
                        <PostCommentSection postId={postId} postMediaId={postData.post_media_id} onCommentAdded={handleCommentAdded} />
                    </div>

                </div>

                {/* ── RIGHT COLUMN: SUGGESTED SIDEBAR ────────────────────────────── */}
                <div className="lg:col-span-4 space-y-5">
                    <h3 className="text-base font-black text-slate-800 tracking-tight mb-3">
                        Up Next
                    </h3>

                    <div className="space-y-4">
                        {suggestedPosts.length > 0 ? (
                            <>
                                {suggestedPosts.map((video) => {
                                    const vThumbnail = video.p_video_thumbnail || video.um_upload_file || FALLBACK_IMAGE;
                                    const vTitle = video.p_post_text || "Suggested Video";
                                    const vCreatorName = video.u_name || "Zoebook Creator";
                                    const vViews = video.views_count || video.p_impression_count || "0";
                                    const vDate = video.p_added_date || "Recently";

                                    return (
                                        <Link
                                            key={video.p_post_id}
                                            to={`/postDetail/${video.p_post_id}`}
                                            className="flex gap-3 hover:bg-slate-50 p-2 rounded-2xl transition duration-200 group cursor-pointer"
                                        >
                                            {/* Thumbnail preview */}
                                            <div className="relative w-28 sm:w-32 aspect-video rounded-xl overflow-hidden bg-slate-100 shrink-0 shadow-sm border border-slate-100">
                                                <img
                                                    src={vThumbnail}
                                                    alt={vTitle}
                                                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                                    onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                                                />
                                            </div>

                                            {/* Meta text details */}
                                            <div className="flex-grow min-w-0 flex flex-col justify-center">
                                                <h4 className="text-xs sm:text-sm font-extrabold text-slate-800 group-hover:text-purple-600 transition leading-snug line-clamp-2">
                                                    {vTitle}
                                                </h4>
                                                <span className="text-[11px] text-slate-400 font-semibold mt-1 truncate">
                                                    {vCreatorName}
                                                </span>
                                                <div className="flex items-center gap-1.5 text-[10px] text-slate-400 font-medium mt-0.5 truncate">
                                                    <span>{vViews} Views</span>
                                                    <span>•</span>
                                                    <span>{vDate}</span>
                                                </div>
                                            </div>
                                        </Link>
                                    );
                                })}
                                {isLoadingMore && (
                                    <div className="flex justify-center py-4">
                                        <Loader2 className="w-6 h-6 animate-spin text-purple-600" />
                                    </div>
                                )}
                            </>
                        ) : (isLoadingMore && pageIndex === 1) ? (
                            <div className="space-y-4">
                                {Array.from({ length: 4 }).map((_, i) => (
                                    <div key={i} className="flex gap-3 animate-pulse">
                                        <div className="w-28 sm:w-32 aspect-video rounded-xl bg-slate-200 shrink-0" />
                                        <div className="flex-1 space-y-2 py-1">
                                            <div className="h-3.5 w-full rounded bg-slate-200" />
                                            <div className="h-3 w-1/2 rounded bg-slate-200" />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-10 bg-slate-50/50 rounded-2xl border border-slate-100">
                                <Sparkles size={24} className="text-slate-300 mx-auto mb-2" />
                                <p className="text-xs text-slate-400 font-semibold">No recommendations available</p>
                            </div>
                        )}
                    </div>
                </div>

            </div>
        </div>
    );
}

export default PostDetailPage;
