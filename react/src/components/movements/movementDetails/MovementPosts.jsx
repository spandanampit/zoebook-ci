import React, { useCallback, useState } from "react";
import { Heart, MessageCircle, Share2, Eye } from "lucide-react";
import { decodeEscapedText } from "../../../utils/textDecoder";
import { fetchCommentList, postComment } from "../../../services/commentService";
import MovementComments from "./MovementComments";

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
        <div className="aspect-[9/16] w-full bg-gray-100 rounded-2xl" />
    </div>
);

const getMediaForPost = (post) => {
    const media = Array.isArray(post?.get_post_media)
        ? post.get_post_media
        : [];
    const firstMedia = media[0] || null;

    if (!firstMedia) return { type: "none", src: "", poster: "" };

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

const getCommentKey = (postId, mediaId) => `${postId}-${mediaId || "nomedia"}`;

const MovementPosts = ({
    posts = [],
    isLoading = false,
    isLoadingMore = false,
    hasMore = false,
    error = "",
    sentinelRef = null,
    likingMediaKeys = {},
    onToggleMediaLike,
}) => {
    const [openComments, setOpenComments] = useState({});
    const [commentsByKey, setCommentsByKey] = useState({});
    const [commentDraftByKey, setCommentDraftByKey] = useState({});
    const [postingCommentByKey, setPostingCommentByKey] = useState({});
    const [commentSubmitErrorByKey, setCommentSubmitErrorByKey] = useState({});
    const hasOpenComments = Object.values(openComments).some(Boolean);

    const loadComments = useCallback(async (postId, mediaId, force = false) => {
        const commentKey = getCommentKey(postId, mediaId);

        if (!force) {
            const currentState = commentsByKey[commentKey];
            if (
                currentState?.isLoading ||
                Array.isArray(currentState?.data)
            ) {
                return;
            }
        }

        setCommentsByKey((prev) => ({
            ...prev,
            [commentKey]: {
                isLoading: true,
                error: "",
                data: force ? prev[commentKey]?.data || [] : null,
            },
        }));

        try {
            const response = await fetchCommentList(postId, mediaId || "");
            const nextComments = Array.isArray(response?.data)
                ? response.data
                : [];

            setCommentsByKey((prev) => ({
                ...prev,
                [commentKey]: {
                    isLoading: false,
                    error: "",
                    data: nextComments,
                },
            }));
        } catch (error) {
            setCommentsByKey((prev) => ({
                ...prev,
                [commentKey]: {
                    isLoading: false,
                    error: error?.message || "Failed to load comments.",
                    data: prev[commentKey]?.data || [],
                },
            }));
            throw error;
        }
    }, [commentsByKey]);

    const handleToggleComments = useCallback(
        async (postId, mediaId) => {
            const commentKey = getCommentKey(postId, mediaId);
            const isCurrentlyOpen = Boolean(openComments[commentKey]);

            setOpenComments((prev) => ({
                ...prev,
                [commentKey]: !isCurrentlyOpen,
            }));

            if (isCurrentlyOpen) return;
            try {
                await loadComments(postId, mediaId, false);
            } catch (error) {
                console.error("Unable to load comments:", error);
            }
        },
        [loadComments, openComments],
    );

    const handleSubmitComment = useCallback(
        async (postId, mediaId) => {
            const commentKey = getCommentKey(postId, mediaId);
            const draftComment = (commentDraftByKey[commentKey] || "").trim();

            if (!draftComment || postingCommentByKey[commentKey]) {
                return;
            }

            setPostingCommentByKey((prev) => ({
                ...prev,
                [commentKey]: true,
            }));
            setCommentSubmitErrorByKey((prev) => ({
                ...prev,
                [commentKey]: "",
            }));

            try {
                await postComment(postId, mediaId || "", draftComment);

                setCommentDraftByKey((prev) => ({
                    ...prev,
                    [commentKey]: "",
                }));

                await loadComments(postId, mediaId, true);
            } catch (error) {
                setCommentSubmitErrorByKey((prev) => ({
                    ...prev,
                    [commentKey]:
                        error?.message || "Failed to post comment. Try again.",
                }));
            } finally {
                setPostingCommentByKey((prev) => ({
                    ...prev,
                    [commentKey]: false,
                }));
            }
        },
        [commentDraftByKey, loadComments, postingCommentByKey],
    );

    if (isLoading) {
        return (
            <div className="space-y-6 max-w-md mx-auto">
                {[1, 2].map((item) => (
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
        <div
            className={`space-y-6 mx-auto transition-all duration-500 ${
                hasOpenComments ? "max-w-5xl" : "max-w-md"
            }`}
        >
            {/* Max-width ensures vertical posts don't look huge on desktop */}
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
                const commentKey = getCommentKey(postId, mediaId);
                const commentState = commentsByKey[commentKey] || {};
                const isCommentOpen = Boolean(openComments[commentKey]);
                const isLiked = Number(firstMedia?.is_media_like) === 1;
                const likeCount = Number(firstMedia?.media_like_count) || 0;
                const loadedCommentCount = Array.isArray(commentState.data)
                    ? commentState.data.length
                    : null;
                const mediaCommentCount = Number(firstMedia?.media_comment_count);
                const postCommentCount = Number(post.comment_count);
                const commentCount =
                    loadedCommentCount ??
                    (Number.isFinite(mediaCommentCount)
                        ? mediaCommentCount
                        : null) ??
                    (Number.isFinite(postCommentCount) ? postCommentCount : null) ??
                    0;
                const isLikeUpdating =
                    Boolean(mediaKey) && Boolean(likingMediaKeys?.[mediaKey]);

                return (
                    <article
                        key={postId}
                        className="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-5 overflow-hidden"
                    >
                        <div className="relative lg:min-h-[32rem]">
                            <div
                                className={`transition-all duration-500 ease-out ${
                                    isCommentOpen
                                        ? "lg:mr-[calc(50%+0.75rem)] lg:-translate-x-4 lg:pl-4"
                                        : ""
                                }`}
                            >
                                {/* User Header */}
                                <div className="flex items-center gap-3 mb-4">
                                    <img
                                        src={
                                            avatar ||
                                            "https://ui-avatars.com/api/?name=User&background=eceff4&color=4b5563"
                                        }
                                        alt={author}
                                        className="w-10 h-10 rounded-full object-cover bg-gray-100"
                                    />
                                    <div>
                                        <h4 className="font-bold text-gray-800 text-sm leading-tight">
                                            {author}
                                        </h4>
                                        <p className="text-[10px] text-gray-400 font-medium">
                                            {post.added_date || ""}
                                        </p>
                                    </div>
                                </div>

                                {/* Caption */}
                                {content && (
                                    <p className="text-sm text-gray-700 leading-snug mb-4 whitespace-pre-wrap break-words">
                                        {content}
                                    </p>
                                )}

                                {/* Media Container - The "Full Post" Fix */}
                                <div className="relative rounded-2xl overflow-hidden bg-gray-50 border border-gray-50">
                                    {media.type === "image" && media.src && (
                                        <img
                                            src={media.src}
                                            alt="Post media"
                                            className="w-full h-auto block object-contain"
                                            loading="lazy"
                                        />
                                    )}

                                    {media.type === "video" && media.src && (
                                        <div className="relative w-full bg-black flex items-center justify-center">
                                            {/* Ambient background for vertical videos */}
                                            {media.poster && (
                                                <img
                                                    src={media.poster}
                                                    alt=""
                                                    className="absolute inset-0 w-full h-full object-cover blur-3xl opacity-30 scale-110"
                                                />
                                            )}
                                            <video
                                                controls
                                                playsInline
                                                preload="metadata"
                                                poster={media.poster}
                                                className="relative z-10 w-full h-auto max-h-[80vh] object-contain"
                                            >
                                                <source src={media.src} />
                                            </video>
                                        </div>
                                    )}
                                </div>

                                {/* Action Bar */}
                                <div className="mt-4 flex items-center justify-between px-1">
                                    <div className="flex items-center gap-4 text-xs font-bold">
                                        <button
                                            type="button"
                                            onClick={() =>
                                                onToggleMediaLike?.(
                                                    postId,
                                                    mediaId,
                                                )
                                            }
                                            disabled={
                                                isLikeUpdating || !mediaId
                                            }
                                            className={`flex items-center gap-1.5 transition-all ${
                                                isLiked
                                                    ? "text-rose-600 scale-110"
                                                    : "text-gray-500"
                                            }`}
                                        >
                                            <Heart
                                                className={`w-5 h-5 ${isLiked ? "fill-current" : ""}`}
                                            />
                                            {likeCount}
                                        </button>
                                        <button
                                            type="button"
                                            onClick={() =>
                                                handleToggleComments(
                                                    postId,
                                                    mediaId,
                                                )
                                            }
                                            aria-expanded={isCommentOpen}
                                            aria-controls={`post-comments-${postId}`}
                                            className={`flex items-center gap-1.5 transition-colors ${
                                                isCommentOpen
                                                    ? "text-sky-600"
                                                    : "text-gray-500"
                                            }`}
                                        >
                                            <MessageCircle
                                                className={`w-5 h-5 ${
                                                    isCommentOpen
                                                        ? "text-sky-600"
                                                        : "text-gray-400"
                                                }`}
                                            />
                                            {commentCount}
                                        </button>
                                        <span className="flex items-center gap-1.5 text-gray-500">
                                            <Share2 className="w-5 h-5 text-gray-400" />
                                            {Number(post.shared_count) || 0}
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-1 text-[10px] font-bold text-gray-400">
                                        <Eye className="w-3.5 h-3.5" />
                                        {Number(post.impression_count) || 0}
                                    </div>
                                </div>
                            </div>

                            <aside
                                id={`post-comments-${postId}`}
                                className={`mt-4 lg:mt-0 lg:absolute lg:top-0 lg:right-0 lg:bottom-0 lg:w-[calc(50%-0.5rem)] transition-all duration-500 ease-out ${
                                    isCommentOpen
                                        ? "block opacity-100 translate-x-0"
                                        : "hidden lg:block opacity-0 pointer-events-none lg:translate-x-10"
                                }`}
                                aria-hidden={!isCommentOpen}
                            >
                                <MovementComments
                                    postId={postId}
                                    comments={commentState.data}
                                    isLoading={Boolean(commentState.isLoading)}
                                    error={commentState.error || ""}
                                    draftComment={
                                        commentDraftByKey[commentKey] || ""
                                    }
                                    isSubmitting={Boolean(
                                        postingCommentByKey[commentKey],
                                    )}
                                    submitError={
                                        commentSubmitErrorByKey[commentKey] ||
                                        ""
                                    }
                                    onDraftChange={(value) => {
                                        setCommentDraftByKey((prev) => ({
                                            ...prev,
                                            [commentKey]: value,
                                        }));
                                        if (
                                            commentSubmitErrorByKey[commentKey]
                                        ) {
                                            setCommentSubmitErrorByKey(
                                                (prev) => ({
                                                    ...prev,
                                                    [commentKey]: "",
                                                }),
                                            );
                                        }
                                    }}
                                    onSubmit={() =>
                                        handleSubmitComment(postId, mediaId)
                                    }
                                />
                            </aside>
                        </div>
                    </article>
                );
            })}
            {/* Pagination Loaders & Sentinel */}
            {isLoadingMore && (
                <div className="space-y-4">
                    <PostSkeleton />
                </div>
            )}
            {sentinelRef && hasMore && (
                <div ref={sentinelRef} className="h-10 w-full" />
            )}
            {!hasMore && posts.length > 0 && (
                <p className="text-center text-[10px] font-bold text-gray-300 py-4 uppercase tracking-widest">
                    End of Feed
                </p>
            )}
        </div>
    );
};

export default MovementPosts;
