import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import {
    fetchMovementDetailsAPI,
    fetchMovementPosts,
    likeMovementPost,
} from "../../services/movementService";

// ── Async Thunks ──────────────────────────────────────────────────────

export const fetchMovementDetails = createAsyncThunk(
    "movementDetails/fetchDetails",
    async (movementId, { rejectWithValue }) => {
        try {
            const response = await fetchMovementDetailsAPI(movementId);
            return response?.data || null;
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const fetchMovementPostsList = createAsyncThunk(
    "movementDetails/fetchPosts",
    async ({ movementId, pageIndex = 1 }, { rejectWithValue }) => {
        try {
            const response = await fetchMovementPosts(movementId, pageIndex);
            return { data: response?.data || [], pageIndex };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const togglePostLike = createAsyncThunk(
    "movementDetails/togglePostLike",
    async ({ postId, isLiked }, { rejectWithValue }) => {
        try {
            await likeMovementPost(postId, isLiked);
            return { postId, isLiked };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

// ── Slice ─────────────────────────────────────────────────────────────

const initialState = {
    movement: null,
    posts: [],
    postsLoading: false,
    postsError: null,
    postsPage: 1,
    postsHasMore: true,

    loading: false,
    error: null,
};

const movementDetailsSlice = createSlice({
    name: "movementDetails",
    initialState,
    reducers: {
        clearMovementDetails: () => initialState,
        resetPosts: (state) => {
            state.posts = [];
            state.postsPage = 1;
            state.postsHasMore = true;
            state.postsError = null;
        },
        removePost: (state, action) => {
            state.posts = state.posts.filter(
                (p) => p.post_id !== action.payload,
            );
        },
        addPostToFront: (state, action) => {
            state.posts = [action.payload, ...state.posts];
        },
    },
    extraReducers: (builder) => {
        builder
            // fetchMovementDetails
            .addCase(fetchMovementDetails.pending, (state) => {
                state.loading = true;
                state.error = null;
            })
            .addCase(fetchMovementDetails.fulfilled, (state, action) => {
                state.loading = false;
                state.movement = action.payload;
            })
            .addCase(fetchMovementDetails.rejected, (state, action) => {
                state.loading = false;
                state.error = action.payload;
            })

            // fetchMovementPosts
            .addCase(fetchMovementPostsList.pending, (state) => {
                state.postsLoading = true;
                state.postsError = null;
            })
            .addCase(fetchMovementPostsList.fulfilled, (state, action) => {
                state.postsLoading = false;
                const { data, pageIndex } = action.payload;
                if (pageIndex === 1) {
                    state.posts = data;
                } else {
                    state.posts = [...state.posts, ...data];
                }
                state.postsPage = pageIndex;
                state.postsHasMore = data.length > 0;
            })
            .addCase(fetchMovementPostsList.rejected, (state, action) => {
                state.postsLoading = false;
                state.postsError = action.payload;
            })

            // togglePostLike
            .addCase(togglePostLike.fulfilled, (state, action) => {
                const { postId, isLiked } = action.payload;
                const post = state.posts.find((p) => p.post_id === postId);
                if (post) {
                    post.is_post_like = isLiked ? 1 : 0;
                    post.like_count = isLiked
                        ? (Number(post.like_count) || 0) + 1
                        : Math.max((Number(post.like_count) || 0) - 1, 0);
                }
            });
    },
});

export const { clearMovementDetails, resetPosts, removePost, addPostToFront } =
    movementDetailsSlice.actions;

// ── Selectors ─────────────────────────────────────────────────────────

export const selectMovementDetail = (state) => state.movementDetails.movement;
export const selectMovementDetailLoading = (state) =>
    state.movementDetails.loading;
export const selectMovementDetailError = (state) =>
    state.movementDetails.error;
export const selectMovementPosts = (state) => state.movementDetails.posts;
export const selectMovementPostsLoading = (state) =>
    state.movementDetails.postsLoading;
export const selectMovementPostsHasMore = (state) =>
    state.movementDetails.postsHasMore;
export const selectMovementPostsPage = (state) =>
    state.movementDetails.postsPage;

export default movementDetailsSlice.reducer;
