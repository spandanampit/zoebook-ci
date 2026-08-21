import { API_ENDPOINTS, ACTIVE_USER_ID } from "../config/siteConfig";

export async function likePostMedia(mediaId, postId, isLiked) {
    const url = API_ENDPOINTS.postMediaLike;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            media_id: mediaId,
            post_id: postId,
            user_id: ACTIVE_USER_ID,
            status: isLiked ?? 0,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to update media like status");
    }

    return response.json().catch(() => null);
}

export async function getPresignedUrls(fileNameOrData, fileTypeArg) {
    const fileName =
        typeof fileNameOrData === "object" && fileNameOrData !== null
            ? fileNameOrData.fileName
            : fileNameOrData;
    const fileType =
        typeof fileNameOrData === "object" && fileNameOrData !== null
            ? fileNameOrData.fileType
            : fileTypeArg;

    const url = API_ENDPOINTS.getPresignedUrl;
    const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            fileName,
            fileType,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to generate presigned URL");
    }

    return response.json().catch(() => null);
}

export async function addPost(params) {
    const url = API_ENDPOINTS.addPost;

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(params),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Something went wrong");
        }

        return data;
    } catch (error) {
        console.error("Add Post API Error:", error);
        return {
            success: 0,
            message: error.message || "API failed",
        };
    }
}

export async function addPostMedia(params) {
    const url = API_ENDPOINTS.addPostMedia;

    try {
        const formData = new FormData();

        if (params.post_id) formData.append("post_id", params.post_id);
        if (params.user_id) formData.append("user_id", params.ACTIVE_USER_ID);
        if (params.file_type) formData.append("file_type", params.file_type);

        if (params.upload_file) {
            formData.append("upload_file", params.upload_file);
        }

        if (params.video_thumbnail) {
            formData.append("video_thumbnail", params.video_thumbnail);
        }

        if (params.width) formData.append("width", params.width);
        if (params.height) formData.append("height", params.height);

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Media upload failed");
        }

        return data;
    } catch (error) {
        console.error("Add Post Media API Error:", error);
        return {
            success: 0,
            message: error.message || "API failed",
        };
    }
}
