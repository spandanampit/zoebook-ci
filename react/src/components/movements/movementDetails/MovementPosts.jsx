import React from "react";
import { Heart, MessageCircle, Share2, Eye } from "lucide-react";
import { decodeEscapedText } from "../../../utils/textDecoder";

const PostSkeleton = () => (
    <div className="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 animate-pulse">
        <div className="flex items-center gap-3 mb-4">
            <div className="w-11 h-11 rounded-full bg-gray-100" />
            <div className="space-y-2">
                <div className="h-3 w-28 bg-gray-100 rounded" />
                <div className="h-3 w-20 bg-gray-50 rounded" />
            </div>
        </div>
        <div className="h-4 w-11/12 bg-gray-100 rounded mb-2" />
        <div className="h-4 w-8/12 bg-gray-50 rounded mb-4" />
        <div className="h-56 w-full bg-gray-100 rounded-2xl" />
    </div>
);

const getMediaForPost = (post) => {
    const media = Array.isArray(post?.get_post_media)
        ? post.get_post_media
        : [];
    const firstMedia = media[0] || null;

    if (!firstMedia) {
        return { type: "none", src: "", poster: "" };
    }

    const mediaType = String(firstMedia.pm_media_type || "").toLowerCase();

    if (mediaType === "video") {
        return {
            type: "video",
            src: firstMedia.pm_upload_file || firstMedia.upload_file_org || "",
            poster:
                firstMedia.pm_video_thumbnail ||
                firstMedia.video_thumbnail_org ||
                firstMedia.display_image ||
                "",
        };
    }

    return {
        type: "image",
        src: firstMedia.pm_upload_file || firstMedia.display_image || "",
        poster: "",
    };
};

const MovementPosts = ({
    posts = [],
    isLoading = false,
    isLoadingMore = false,
    hasMore = false,
    totalPostsCount = null,
    error = "",
    sentinelRef = null,
    likingMediaKeys = {},
    onToggleMediaLike,
}) => {
    if (isLoading) {
        return (
            <div className="space-y-6">
                {[1, 2, 3].map((item) => (
                    <PostSkeleton key={`movement-post-skeleton-${item}`} />
                ))}
            </div>
        );
    }

    if (error) {
        return (
            <div className="bg-red-50 p-4 rounded-2xl border border-red-100 text-red-500 text-sm font-bold">
                {error}
            </div>
        );
    }

    if (!posts.length) {
        return (
            <div className="bg-white rounded-[2rem] border border-gray-100 p-8 text-center text-gray-500 font-semibold">
                No posts found for this movement.
            </div>
        );
    }

    return (
        <div className="space-y-6">
            {posts.map((post, index) => {
                const media = getMediaForPost(post);
                const postId =
                    post.post_id || post.actual_post_id || `post-${index}`;
                const author = decodeEscapedText(
                    post.user_name || "Unknown user",
                );
                const content = decodeEscapedText(
                    post.post_text_emoji || post.post_text || "",
                );
                const avatar = post.user_profile_image || "";
                const firstMedia = Array.isArray(post.get_post_media)
                    ? post.get_post_media[0]
                    : null;
                const mediaId = firstMedia?.pm_post_media_id || "";
                const mediaKey =
                    postId && mediaId ? `${postId}-${mediaId}` : "";
                const isLiked =
                    Number(firstMedia?.is_media_like) === 1;
                const likeCount = Number(firstMedia?.media_like_count) || 0;
                const isLikeUpdating =
                    Boolean(mediaKey) && Boolean(likingMediaKeys?.[mediaKey]);

                return (
                    <article
                        key={postId}
                        className="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6"
                    >
                        <div className="flex items-center gap-3 mb-4">
                            <img
                                src={
                                    avatar ||
                                    "https://ui-avatars.com/api/?name=User&background=eceff4&color=4b5563"
                                }
                                alt={author}
                                className="w-11 h-11 rounded-full object-cover bg-gray-100"
                            />
                            <div>
                                <h4 className="font-bold text-gray-800 leading-tight">
                                    {author}
                                </h4>
                                <p className="text-xs text-gray-500 font-medium">
                                    {post.added_date || ""}
                                </p>
                            </div>
                        </div>

                        {content ? (
                            <p className="text-sm text-gray-700 leading-relaxed mb-4 whitespace-pre-wrap break-words">
                                {content}
                            </p>
                        ) : null}

                        {media.type === "image" && media.src ? (
                            <img
                                src={media.src}
                                alt="Post media"
                                className="rounded-2xl w-full max-h-[420px] object-cover"
                            />
                        ) : null}

                        {media.type === "video" && media.src ? (
                            <div className="relative w-full rounded-2xl overflow-hidden flex justify-center items-center bg-black">
                                {media.poster && (
                                    <img
                                        src={media.poster}
                                        alt="video background"
                                        className="absolute inset-0 w-full h-full object-cover blur-2xl scale-110 opacity-70"
                                    />
                                )}

                                <div className="absolute inset-0 backdrop-blur-md bg-white/5"></div>

                                <video
                                    controls
                                    preload="metadata"
                                    poster={media.poster}
                                    className="relative max-h-[420px] w-auto object-contain z-10"
                                >
                                    <source src={media.src} />
                                </video>
                            </div>
                        ) : null}

                        <div className="mt-4 pt-4 border-t border-gray-100 flex items-center gap-4 text-xs text-gray-500 font-semibold flex-wrap">
                            <button
                                type="button"
                                onClick={() =>
                                    onToggleMediaLike?.(postId, mediaId)
                                }
                                disabled={isLikeUpdating || !mediaId}
                                className={`inline-flex items-center gap-1.5 transition-colors disabled:opacity-60 disabled:cursor-not-allowed ${
                                    isLiked
                                        ? "text-rose-600"
                                        : "text-gray-500 hover:text-rose-500"
                                }`}
                            >
                                <Heart
                                    className={`w-4 h-4 ${
                                        isLiked ? "fill-current" : ""
                                    }`}
                                />
                                {likeCount}
                            </button>
                            <span className="inline-flex items-center gap-1.5">
                                <MessageCircle className="w-4 h-4 text-sky-500" />
                                {Number(post.comment_count) || 0}
                            </span>
                            <span className="inline-flex items-center gap-1.5">
                                <Share2 className="w-4 h-4 text-violet-500" />
                                {Number(post.shared_count) || 0}
                            </span>
                            <span className="inline-flex items-center gap-1.5">
                                <Eye className="w-4 h-4 text-amber-500" />
                                {Number(post.impression_count) || 0}
                            </span>
                        </div>
                    </article>
                );
            })}

            {isLoadingMore ? (
                <div className="space-y-4">
                    {[1, 2].map((item) => (
                        <PostSkeleton key={`movement-post-more-skeleton-${item}`} />
                    ))}
                </div>
            ) : null}

            {sentinelRef && hasMore ? (
                <div
                    ref={sentinelRef}
                    className="h-8 w-full"
                    aria-hidden="true"
                />
            ) : null}

            {!hasMore &&
            !isLoadingMore &&
            !isLoading &&
            posts.length > 0 &&
            Number.isFinite(totalPostsCount) ? (
                <p className="text-center text-xs font-semibold text-gray-400 pt-2">
                    Showing all {totalPostsCount} posts
                </p>
            ) : null}
        </div>
    );
};

export default MovementPosts;
