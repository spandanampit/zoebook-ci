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

export async function createMovement(
    movementName,
    description,
    theme = "dark",
    visibility,
) {
    const url = API_ENDPOINTS.createMovement;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            movement_name: movementName,
            user_id: ACTIVE_USER_ID,
            description: description,
            theme: theme,
            visibility: visibility,
        }),
    });

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Failed to create movement");
    }

    const movementId = data?.data?.[0]?.movement_id;

    return {
        movementId,
        fullResponse: data,
    };
}

export async function updateMovement({
    movementId,
    movementName,
    description,
    visibility,
    theme = "dark",
}) {
    const url = API_ENDPOINTS.editMovement;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            description,
            movements_id: movementId,
            movement_image_id: "",
            movement_name: movementName,
            theme,
            user_id: ACTIVE_USER_ID,
            visibility,
        }),
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new Error(data?.message || "Failed to update movement");
    }

    return data;
}

export async function uploadMovementImage({ file, movementId }) {
    const url = API_ENDPOINTS.uploadMovementImage;

    const formData = new FormData();

    formData.append("upload_file", file);
    formData.append("movements_id", movementId);
    formData.append("media_type", file.type);
    formData.append("platform", "aws");
    formData.append("user_id", ACTIVE_USER_ID);
    formData.append("video_tumbnail", "");

    const response = await fetch(url, {
        method: "POST",
        body: formData,
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new Error(data?.message || "Image upload failed");
    }

    return data;
}

export async function fetchMyMovements(pageIndex = 1) {
    const url = `${API_ENDPOINTS.myMovements}?user_id=${ACTIVE_USER_ID}&page_index=${pageIndex}`;

    const response = await fetch(url, {
        method: "GET",
    });

    if (!response.ok) {
        throw new Error("Failed to fetch movement posts");
    }

    return response.json().catch(() => null);
}

export async function deactivateMovement(movementId, status) {
    const url = API_ENDPOINTS.inactiveMovement;

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            movement_id: movementId,
            status: status ?? "Inactive",
            user_id: ACTIVE_USER_ID,
        }),
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new Error(data?.message || "Failed to deactivate movement");
    }

    return data;
}
