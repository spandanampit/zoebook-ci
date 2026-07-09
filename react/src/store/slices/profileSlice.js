import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import { fetchProfileAPI } from "../../services/movementService";
import { updateUserDetails, changePassword } from "../../services/userService";
import { fetchPostList } from "../../services/postService";
import { getFullProfileImageUrl } from "../../utils/imageUtils";

// ── Helpers ───────────────────────────────────────────────────────────

function mapRawProfileToState(rawData, fallbackUserId) {
    const posts = Number(rawData.post_count) || 0;
    const followers = Number(rawData.follower_count) || 0;
    const following = Number(rawData.following_count) || 0;

    return {
        id: rawData.u_users_id || fallbackUserId,
        name: rawData.u_name || "Unknown User",
        profileImage: getFullProfileImageUrl(
            rawData.u_profile_image || rawData.u_profile_image_firebase,
        ),
        coverPhoto: rawData.u_cover_photo || "",
        email: rawData.u_email || "",
        phone: rawData.u_phone || "",
        aboutMe: rawData.u_about_me || rawData.about_me || "",
        stats: { posts, followers, following },
        membership: `Posts ${posts} | Followers ${followers} | Following ${following}`,
        raw: rawData,
    };
}

// ── Async Thunks ──────────────────────────────────────────────────────

export const fetchProfile = createAsyncThunk(
    "profile/fetchProfile",
    async (_, { getState, rejectWithValue }) => {
        try {
            const userId = getState().auth.userId;
            const res = await fetchProfileAPI();
            const rawData = Array.isArray(res?.data)
                ? res.data[0]
                : res?.data;
            if (!rawData) return rejectWithValue("No profile data received");
            return mapRawProfileToState(rawData, userId);
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const updateProfile = createAsyncThunk(
    "profile/updateProfile",
    async (payload, { rejectWithValue }) => {
        try {
            const data = await updateUserDetails(payload);
            return data;
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const changeUserPassword = createAsyncThunk(
    "profile/changePassword",
    async ({ old_password, new_password }, { rejectWithValue }) => {
        try {
            const data = await changePassword({ old_password, new_password });
            return data;
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const fetchProfilePosts = createAsyncThunk(
    "profile/fetchPosts",
    async ({ profileUserId, isFeed = 0, pageIndex = 1 }, { rejectWithValue }) => {
        try {
            const response = await fetchPostList(profileUserId, isFeed, pageIndex);
            return { data: response?.data || [], pageIndex };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

// ── Slice ─────────────────────────────────────────────────────────────

const initialState = {
    data: null,
    loading: false,
    error: null,

    // Profile posts
    posts: [],
    postsLoading: false,
    postsError: null,
    postsPage: 1,
    postsHasMore: true,

    // Update status
    updating: false,
    updateError: null,
};

const profileSlice = createSlice({
    name: "profile",
    initialState,
    reducers: {
        clearProfile: () => initialState,
        resetProfilePosts: (state) => {
            state.posts = [];
            state.postsPage = 1;
            state.postsHasMore = true;
            state.postsError = null;
        },
        removeProfilePost: (state, action) => {
            state.posts = state.posts.filter(
                (p) => p.post_id !== action.payload,
            );
        },
    },
    extraReducers: (builder) => {
        builder
            // fetchProfile
            .addCase(fetchProfile.pending, (state) => {
                state.loading = true;
                state.error = null;
            })
            .addCase(fetchProfile.fulfilled, (state, action) => {
                state.loading = false;
                state.data = action.payload;
            })
            .addCase(fetchProfile.rejected, (state, action) => {
                state.loading = false;
                state.error = action.payload;
            })

            // updateProfile
            .addCase(updateProfile.pending, (state) => {
                state.updating = true;
                state.updateError = null;
            })
            .addCase(updateProfile.fulfilled, (state) => {
                state.updating = false;
            })
            .addCase(updateProfile.rejected, (state, action) => {
                state.updating = false;
                state.updateError = action.payload;
            })

            // fetchProfilePosts
            .addCase(fetchProfilePosts.pending, (state) => {
                state.postsLoading = true;
                state.postsError = null;
            })
            .addCase(fetchProfilePosts.fulfilled, (state, action) => {
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
            .addCase(fetchProfilePosts.rejected, (state, action) => {
                state.postsLoading = false;
                state.postsError = action.payload;
            });
    },
});

export const { clearProfile, resetProfilePosts, removeProfilePost } =
    profileSlice.actions;

// ── Selectors ─────────────────────────────────────────────────────────

export const selectProfile = (state) => state.profile.data;
export const selectProfileLoading = (state) => state.profile.loading;
export const selectProfileError = (state) => state.profile.error;
export const selectProfileUpdating = (state) => state.profile.updating;
export const selectProfilePosts = (state) => state.profile.posts;
export const selectProfilePostsLoading = (state) => state.profile.postsLoading;
export const selectProfilePostsHasMore = (state) => state.profile.postsHasMore;
export const selectProfilePostsPage = (state) => state.profile.postsPage;

export default profileSlice.reducer;
