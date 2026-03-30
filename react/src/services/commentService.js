import { API_ENDPOINTS, ACTIVE_USER_ID } from "../config/siteConfig";

export async function fetchCommentList(postId, postMediaId) {
    try {
        const params = new URLSearchParams({
            post_id: postId,
            post_media_id: postMediaId,
            user_id: ACTIVE_USER_ID,
        });

        const url = `${API_ENDPOINTS.postCommentList}?${params.toString()}`;

        const response = await fetch(url, {
            method: "GET",
        });

        if (!response.ok) {
            throw new Error("Failed to fetch comments");
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error fetching comments:", error);
        throw error;
    }
}

export async function postComment(
    postId,
    postMediaId,
    comment,
    postCommentId = null,
) {
    try {
        const response = await fetch(API_ENDPOINTS.commentOnPost, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                comment: comment,
                post_comment_id: postCommentId,
                post_id: postId,
                post_media_id: postMediaId,
                user_id: ACTIVE_USER_ID,
            }),
        });

        if (!response.ok) {
            throw new Error("Failed to post comment");
        }

        return response.json().catch(() => null);
    } catch (error) {
        console.error("Error posting comment:", error);
        throw error;
    }
}

export async function likePostComment(commentId, postId, status) {
    try {
        const response = await fetch(API_ENDPOINTS.likeComment, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                post_comment_id: commentId,
                post_id: postId,
                status: status,
                user_id: ACTIVE_USER_ID,
            }),
        });

        if (!response.ok) {
            throw new Error("Failed to update comment like status");
        }

        return response.json().catch(() => null);
    } catch (error) {
        console.error("Error updating comment like status:", error);
        throw error;
    }
}
