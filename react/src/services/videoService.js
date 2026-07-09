import { API_ENDPOINTS, ACTIVE_USER_ID } from "../config/siteConfig";

/**
 * Fetch videos for the Watch Video section.
 * Calls WS/viral_plus_media_list with page_index, active user_id, and ad status settings.
 * 
 * @param {number} pageIndex - Index of the page to load (1-based).
 * @returns {Promise<object>} API JSON response containing settings and data array.
 */
export async function fetchWatchVideosAPI(pageIndex = 1) {
    const url = `${API_ENDPOINTS.watchVideos}?page_index=${pageIndex}&user_id=${ACTIVE_USER_ID}&is_ads_show=1`;
    const response = await fetch(url, {
        method: "GET",
    });

    if (!response.ok) {
        throw new Error("Failed to fetch watch videos");
    }

    return response.json();
}
