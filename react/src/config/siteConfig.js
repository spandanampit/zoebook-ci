export const ACTIVE_USER_ID = window.APP_CONFIG?.userId || 96470;
export const SITE_URL =
    import.meta.env.VITE_PROJECT_ENVIRONMENT === "PRODUCTION"
        ? "https://zoebook.com"
        : "https://zoebook.mydevfactory.com";
const url = SITE_URL;
export const FALLBACK_IMAGE = SITE_URL + "/public/images/noimage.gif";
const mediaServerUrl = "https://media.zoebook.com/node";
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
    postLists: url + "/WS/post_list",
    viralPostLists: url + "/WS/viral_post_list",
    sharePostInTimeline: url + "/WS/share_post",
    followRequest: url + "/WS/follow_request",
    unfollowUser: url + "/WS/unfollow_user",


    deletePost: url + "/WS/delete_post",
    addToPlaylist: url + "/WS/addToPlaylist_post",

    fetchTopPlaylist: url + "/WS/get_top_playlist",

    addPost: url + "/WS/insert_post",
    addPostMedia: url + "/WS/add_post_media_laravel",
    uploadMusicPost: url + "/WS/upload_music_posts",
    postDetail: url + "/WS/post_detail",
    otherPosts: url + "/WS/other_post",

    searchUsers: url + "/WS/search_friends",
    searchMovements: url + "/WS/search_movements",

    watchVideos: url + "/WS/get_videos_new",

    //get suggestions
    getSuggestions: url + "/WS/suggestions",

    //user
    editProfile: url + "/WS/update_user_profile",
    changePassword: url + "/WS/change_password",

    //node API
    getPresignedUrl: mediaServerUrl + "/upload/presigned-url",
    compressMedia: mediaServerUrl + "/api/general/compress-post",
};
