export const ACTIVE_USER_ID = window.APP_CONFIG?.userId || 96470;
const url = "https://zoebook.mydevfactory.com";
const mediaServerUrl = "https://media.zoebook.com/node/";
export const API_ENDPOINTS = {
    movements: url + "/WS/popular_movements",
    profile: url + "/WS/my_profile",
    movementsJoin: url + "/WS/join_movements",
    movementDetails: url + "/WS/movements_details",
    movementPosts: url + "/WS/movements_post_list",
    postLike: url + "/WS/like_post",
    postMediaLike: url + "/WS/like_post_media",
    postCommentList: url + "/WS/comments_list",
    commentOnPost: url + "/WS/comment_on_post",
    likeComment: url + "/WS/like_comment",
    createMovement: url + "/WS/add_movement",
    editMovement: url + "/WS/edit_movement",
    uploadMovementImage: url + "/WS/add_movement_image",
    myMovements: url + "/WS/my_movements",
    inactiveMovement: url + "/WS/movement_active_inactive",

    addPost: url + "/WS/insert_post",
    addPostMedia: url + "WS/add_post_media_laravel",
    //node API
    getPresignedUrl: mediaServerUrl + "/upload/presigned-url",
};
