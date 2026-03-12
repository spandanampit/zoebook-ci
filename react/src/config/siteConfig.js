export const ACTIVE_USER_ID = window.APP_CONFIG?.userId || 96470;
const url = "https://zoebook.mydevfactory.com";
export const API_ENDPOINTS = {
    movements: url + "/WS/popular_movements",
    profile: url + "/WS/my_profile",
    movementsJoin: url + "/WS/join_movements",
    movementDetails: url + "/WS/movements_details",
    movementPosts: url + "/WS/movements_post_list",
    postLike: url + "/WS/like_post",
    postMediaLike: url + "/WS/like_post_media",
};
