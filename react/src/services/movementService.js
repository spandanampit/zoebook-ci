import { API_ENDPOINTS, ACTIVE_USER_ID } from "../config/siteConfig";

export async function fetchMovementsAPI(pageIndex) {
    const url = `${API_ENDPOINTS.movements}?page_index=${pageIndex}&user_id=${ACTIVE_USER_ID}`;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load movements`);
    }

    return response.json();
}

export async function fetchProfileAPI() {
    const url = `${API_ENDPOINTS.profile}?profile_user_id=${ACTIVE_USER_ID}&user_id=${ACTIVE_USER_ID}`;
    const response = await fetch(url);

    if (!response.ok) {
        throw new Error(`Failed to load profile`);
    }

    return response.json();
}

export async function toggleJoinMovementAPI(movement) {
    const type = movement.isJoined ? "leave" : "join";
    const response = await fetch(API_ENDPOINTS.movementsJoin, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            movements_id: movement.id,
            user_id: ACTIVE_USER_ID,
            type: type,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to update movement membership");
    }

    return response.json().catch(() => null);
}

export async function fetchMovementDetailsAPI(movementId) {
    const url = `${API_ENDPOINTS.movementDetails}?user_id=${ACTIVE_USER_ID}&movements_id=${movementId}`;
    const response = await fetch(url, {
        method: "GET",
    });

    if (!response.ok) {
        throw new Error("Failed to fetch movement details");
    }

    return response.json().catch(() => null);
}

export async function fetchMovementPosts(movementId, pageIndex = 1) {
    const url = `${API_ENDPOINTS.movementPosts}?user_id=${ACTIVE_USER_ID}&movement_id=${movementId}&page_index=${pageIndex}`;
    const response = await fetch(url, {
        method: "GET",
    });

    if (!response.ok) {
        throw new Error("Failed to fetch movement posts");
    }

    return response.json().catch(() => null);
}

export async function likeMovementPost(postId, isLiked) {
    const url = API_ENDPOINTS.postLike;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            post_id: postId,
            user_id: ACTIVE_USER_ID,
            status: isLiked ?? 0,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to update like status");
    }

    return response.json().catch(() => null);
}

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
