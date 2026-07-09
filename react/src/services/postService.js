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

export async function getPostDetail(postId) {
    const url = API_ENDPOINTS.postDetail;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            post_id: postId,
            user_id: ACTIVE_USER_ID,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to load profile");
    }

    return response.json();
}


export async function getPresignedUrls(fileNameOrData, fileTypeArg, typeArg) {
    const fileName =
        typeof fileNameOrData === "object" && fileNameOrData !== null
            ? fileNameOrData.fileName
            : fileNameOrData;
    const fileType =
        typeof fileNameOrData === "object" && fileNameOrData !== null
            ? fileNameOrData.fileType
            : fileTypeArg;
    const type =
        typeof fileNameOrData === "object" && fileNameOrData !== null
            ? fileNameOrData.type
            : typeArg;

    const url = API_ENDPOINTS.getPresignedUrl;
    const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            fileName,
            fileType,
            userId: ACTIVE_USER_ID,
            type: type || "post",
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
        if (params.user_id) formData.append("user_id", params.user_id);
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

export async function compressJob(filePath) {
    const url = API_ENDPOINTS.compressMedia;

    const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            s3Key: filePath,
        }),
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new Error(data?.message || "Failed to queue compression job");
    }

    return data;
}

export async function fetchPostList(profileUserId, isFeed, pageIndex = 1) {
    const url = `${API_ENDPOINTS.postLists}?profile_user_id=${profileUserId}&user_id=${ACTIVE_USER_ID}&is_feed=${isFeed}&page_index=${pageIndex}&device_type=web`;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load profile`);
    }

    return response.json();
}

export async function fetchViralPostList(profileUserId, isFeed, pageIndex = 1) {
    const url = `${API_ENDPOINTS.viralPostLists}?profile_user_id=${profileUserId}&user_id=${ACTIVE_USER_ID}&is_feed=${isFeed}&page_index=${pageIndex}&device_type=web`;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load viral posts`);
    }

    return response.json();
}


export async function fetchSuggestedPosts() {
    const url = API_ENDPOINTS.getSuggestions + "?user_id=" + ACTIVE_USER_ID;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load profile`);
    }

    return response.json();
}

export async function fetchOtherPosts(postId, pageIndex = 1) {
    const url = `${API_ENDPOINTS.otherPosts}?page_index=${pageIndex}&viral_feed=1&post_id=${postId}&user_id=${ACTIVE_USER_ID}`;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load other posts`);
    }

    return response.json();
}

export async function deletePost(postId) {
    const url = API_ENDPOINTS.deletePost;

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ post_id: postId, user_id: ACTIVE_USER_ID }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Something went wrong");
        }

        return data;
    } catch (error) {
        console.error("Delete Post API Error:", error);
        return {
            success: 0,
            message: error.message || "API failed",
        };
    }
}

export async function addToPlaylist(postId) {
    const url = API_ENDPOINTS.addToPlaylist;

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ post_id: postId, user_id: ACTIVE_USER_ID }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Something went wrong");
        }

        return data;
    } catch (error) {
        console.error("Add To Playlist API Error:", error);
        return {
            success: false,
            message: error.message || "API failed",
        };
    }
}

export async function fetchTopPlaylistPosts(pageIndex) {
    const url =
        API_ENDPOINTS.fetchTopPlaylist +
        "?user_id=" +
        ACTIVE_USER_ID +
        "&page_index=" +
        pageIndex;

    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load profile`);
    }

    return response.json();
}

export async function sharePostInTimeline(postId, sharePostText) {
    const url = API_ENDPOINTS.sharePostInTimeline;

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                post_id: postId,
                user_id: ACTIVE_USER_ID,
                share_text: sharePostText,
                visibility: "Public",
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Something went wrong");
        }

        return data;
    } catch (error) {
        console.error("Share Post In Timeline API Error:", error);
        return {
            success: false,
            message: error.message || "API failed",
        };
    }
}

/**
 * Upload a music post with audio file, thumbnail, title, description, and duration.
 * Uses FormData because the backend expects $_FILES for music_file and music_thumbnail.
 */
export async function uploadMusicPost({ musicFile, thumbnailFile, title, description, duration }) {
    const url = API_ENDPOINTS.uploadMusicPost;

    try {
        const formData = new FormData();
        formData.append("user_id", ACTIVE_USER_ID);
        formData.append("music_file", musicFile);
        formData.append("music_thumbnail", thumbnailFile);
        formData.append("title", title);
        formData.append("description", description || "");
        formData.append("duration", duration || "");

        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Music upload failed");
        }

        return data;
    } catch (error) {
        console.error("Upload Music Post API Error:", error);
        return {
            success: false,
            message: error.message || "Music upload failed",
        };
    }
}

export async function likePost(postId, isLiked) {
    const url = API_ENDPOINTS.postLike;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            post_id: postId,
            user_id: ACTIVE_USER_ID,
            status: isLiked ? 1 : 0,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to update like status");
    }

    return response.json().catch(() => null);
}
