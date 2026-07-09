import { API_ENDPOINTS, ACTIVE_USER_ID } from "../config/siteConfig";
import { normalizeMovement } from "../mappers/movementMapper";
import { getFullProfileImageUrl } from "../utils/imageUtils";

const DEFAULT_SEARCH_OPTIONS = {
    exclude: "",
    keyword: "",
    latitude: "",
    longitude: "",
    user_id: ACTIVE_USER_ID,
};

function buildQuery(params = {}) {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== "") {
            searchParams.append(key, value);
        }
    });

    return searchParams.toString();
}

async function fetchSearchResults(url, params = {}) {
    const query = buildQuery(params);
    const response = await fetch(query ? `${url}?${query}` : url, {
        method: "GET",
    });

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        throw new Error(data?.settings?.message || data?.message || "Search failed");
    }

    if (String(data?.settings?.success ?? "1") !== "1") {
        throw new Error(data?.settings?.message || data?.message || "Search failed");
    }

    return data;
}

function normalizeFriend(item) {
    return {
        id: item.u_users_id,
        type: "friend",
        name: item.u_name || "Unknown user",
        subtitle: item.u_email || "",
        image: getFullProfileImageUrl(item.u_profile_image),
        isFollowing: item.is_follwing || "No",
        followers: Number(item.follower_count) || 0,
        following: Number(item.following_count) || 0,
        posts: Number(item.post_count) || 0,
        distance: item.distance_kms || "",
        raw: item,
    };
}

function normalizeMovementResult(item) {
    const normalizedMovement = normalizeMovement(item);

    return {
        id: normalizedMovement.id,
        type: "movement",
        name: normalizedMovement.movementTitle,
        subtitle: normalizedMovement.description || item.users_name || "",
        image: normalizedMovement.movementImg || normalizedMovement.leaderImg || "",
        members: item.total_members || "0",
        visibility: item.visibility || "",
        raw: item,
    };
}

export async function updateUserDetails(payload = {}) {
    const url = API_ENDPOINTS.editProfile;

    const bodyData = {
        user_id: ACTIVE_USER_ID,
    };

    const allowedFields = [
        "about_me",
        "covervideo_thumbnail",
        "cover_photo",
        "file_type",
        "platform",
        "profile_image",
        "user_email",
        "user_name",
        "user_phone",
    ];

    allowedFields.forEach((field) => {
        if (payload[field] !== undefined && payload[field] !== null) {
            bodyData[field] = payload[field];
        }
    });

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(bodyData),
    });

    const data = await response.json();
    return data;
}

export async function changePassword({ old_password, new_password }) {
    const url = API_ENDPOINTS.changePassword;
    const bodyData = {
        user_id: ACTIVE_USER_ID,
        old_password,
        new_password,
    };

    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(bodyData),
    });

    const data = await response.json();
    return data;
}

export async function searchFriends(params) {
    const url = API_ENDPOINTS.searchUsers;
    const response = await fetchSearchResults(url, {
        ...DEFAULT_SEARCH_OPTIONS,
        ...params,
    });

    return {
        ...response,
        data: Array.isArray(response?.data)
            ? response.data.map(normalizeFriend)
            : [],
    };
}

export async function searchMovements(params = {}) {
    const url = API_ENDPOINTS.searchMovements;
    const response = await fetchSearchResults(url, {
        keyword: "",
        user_id: ACTIVE_USER_ID,
        ...params,
    });

    return {
        ...response,
        data: Array.isArray(response?.data)
            ? response.data.map(normalizeMovementResult)
            : [],
    };
}

export async function searchEverything(keyword, options = {}) {
    const trimmedKeyword = keyword?.trim() || "";

    if (!trimmedKeyword) {
        return {
            friends: [],
            movements: [],
            total: 0,
        };
    }

    const userId = options.userId || ACTIVE_USER_ID;

    const [friendsResponse, movementsResponse] = await Promise.all([
        searchFriends({
            exclude: options.exclude ?? userId,
            latitude: options.latitude ?? "",
            longitude: options.longitude ?? "",
            keyword: trimmedKeyword,
            user_id: userId,
        }).catch((err) => {
            console.warn("searchFriends failed:", err);
            return { data: [] };
        }),
        searchMovements({
            keyword: trimmedKeyword,
            user_id: userId,
        }).catch((err) => {
            console.warn("searchMovements failed:", err);
            return { data: [] };
        }),
    ]);

    const friendsData = friendsResponse?.data || [];
    const movementsData = movementsResponse?.data || [];

    return {
        friends: friendsData,
        movements: movementsData,
        total: friendsData.length + movementsData.length,
    };
}

export async function followUser(followingUserId) {
    const url = API_ENDPOINTS.followRequest;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            following_user_id: followingUserId,
            user_id: ACTIVE_USER_ID,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to follow user");
    }

    return response.json();
}

export async function unfollowUser(followingUserId) {
    const url = API_ENDPOINTS.unfollowUser;
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            following_user_id: followingUserId,
            user_id: ACTIVE_USER_ID,
        }),
    });

    if (!response.ok) {
        throw new Error("Failed to unfollow user");
    }

    return response.json();
}
