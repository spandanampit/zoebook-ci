import React, { useEffect, useState } from "react";
import { decodeEscapedText } from "../../../utils/textDecoder";
import { Heart } from "lucide-react";
import { likePostComment } from "../../../services/commentService";

const formatCommentDate = (value) => {
    if (!value) return "";

    const normalized = value.replace(" ", "T");
    const parsed = new Date(normalized);

    if (Number.isNaN(parsed.getTime())) {
        return value;
    }

    return parsed.toLocaleString(undefined, {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "2-digit",
    });
};

const URL_REGEX = /(https?:\/\/[^\s]+)/gi;
const IMAGE_EXT_REGEX = /\.(gif|png|jpe?g|webp|bmp|avif|svg)(\?|#|$)/i;

const getImageUrlsFromComment = (text) => {
    if (!text) return [];

    const matches = text.match(URL_REGEX) || [];

    return matches.filter((rawUrl) => {
        const cleanUrl = rawUrl.replace(/[),.;!?]+$/, "");

        try {
            const parsed = new URL(cleanUrl);
            return IMAGE_EXT_REGEX.test(parsed.pathname + parsed.search);
        } catch {
            return false;
        }
    });
};

const stripUrlsFromText = (text) => {
    if (!text) return "";
    return text
        .replace(URL_REGEX, "")
        .replace(/\s{2,}/g, " ")
        .trim();
};

const CommentItem = ({ comment, postId }) => {
    const name = decodeEscapedText(comment?.user_name || "Unknown user");
    const text = decodeEscapedText(comment?.comment || "").trim();
    const imageUrls = getImageUrlsFromComment(text);
    const textWithoutUrls = stripUrlsFromText(text);
    const avatar =
        comment?.profile_image_url ||
        `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=eef2ff&color=334155`;
    const likes = Number(comment?.count_comment_likes) || 0;
    const replies = Number(comment?.reply_count) || 0;
    const initialLikeStatus =
        Number(
            comment?.is_comment_like ??
                comment?.is_like ??
                comment?.is_liked ??
                0,
        ) === 1;

    const [isLiked, setIsLiked] = useState(initialLikeStatus);
    const [likeCount, setLikeCount] = useState(likes);
    const [isLikeUpdating, setIsLikeUpdating] = useState(false);

    useEffect(() => {
        setIsLiked(initialLikeStatus);
        setLikeCount(likes);
    }, [comment?.post_comment_id, initialLikeStatus, likes]);

    const handleLike = async () => {
        const commentId = comment?.post_comment_id;
        const resolvedPostId = postId || comment?.post_id;

        if (!commentId || !resolvedPostId || isLikeUpdating) {
            return;
        }

        const nextStatus = isLiked ? 0 : 1;
        const currentLikeCount = likeCount;
        const nextLikeCount =
            nextStatus === 1
                ? currentLikeCount + 1
                : Math.max(currentLikeCount - 1, 0);

        setIsLikeUpdating(true);
        setIsLiked(nextStatus === 1);
        setLikeCount(nextLikeCount);

        try {
            await likePostComment(commentId, resolvedPostId, nextStatus);
        } catch {
            setIsLiked(isLiked);
            setLikeCount(currentLikeCount);
        } finally {
            setIsLikeUpdating(false);
        }
    };

    return (
        <article className="group bg-white hover:bg-gray-50 rounded-2xl border border-gray-100 p-4 transition-colors duration-200">
            <div className="flex items-start gap-3">
                <img
                    src={avatar}
                    alt={name}
                    className="w-9 h-9 rounded-full object-cover bg-gray-100 ring-2 ring-white shadow-sm"
                />
                <div className="min-w-0 flex-1">
                    {/* Header: Name and Date */}
                    <div className="flex items-center justify-between gap-2">
                        <h6 className="text-sm font-bold text-gray-900 truncate">
                            {name}
                        </h6>
                        <span className="text-[11px] font-medium text-gray-400 whitespace-nowrap">
                            {formatCommentDate(comment?.added_date)}
                        </span>
                    </div>

                    {/* Comment Text */}
                    {textWithoutUrls && (
                        <p className="text-sm text-gray-700 whitespace-pre-wrap break-words mt-1 leading-relaxed">
                            {textWithoutUrls}
                        </p>
                    )}

                    {/* Media Content */}
                    {imageUrls.length > 0 && (
                        <div className="mt-3 space-y-2">
                            {imageUrls.map((url) => (
                                <img
                                    key={url}
                                    src={url}
                                    alt="Comment media"
                                    loading="lazy"
                                    className="w-full max-h-80 object-cover rounded-xl border border-gray-200 bg-gray-50 hover:opacity-95 transition-opacity cursor-pointer"
                                    onError={(e) =>
                                        (e.currentTarget.style.display = "none")
                                    }
                                />
                            ))}
                        </div>
                    )}

                    {/* Action Bar */}
                    <div className="mt-3 flex items-center gap-4">
                        <button
                            type="button"
                            onClick={handleLike}
                            disabled={isLikeUpdating}
                            className={`flex items-center gap-1.5 transition-all duration-200 active:scale-90 ${
                                isLiked
                                    ? "text-rose-500"
                                    : "text-gray-400 hover:text-gray-600"
                            }`}
                        >
                            <Heart
                                size={16}
                                fill={isLiked ? "currentColor" : "none"}
                                strokeWidth={2.5}
                            />
                            <span className="text-xs font-bold">
                                {likeCount}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </article>
    );
};

export default CommentItem;
