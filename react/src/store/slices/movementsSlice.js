import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import {
    fetchMovementsAPI,
    toggleJoinMovementAPI,
    fetchMyMovements,
    deactivateMovement,
} from "../../services/movementService";

// ── Async Thunks ──────────────────────────────────────────────────────

export const fetchMovements = createAsyncThunk(
    "movements/fetchMovements",
    async (pageIndex = 1, { rejectWithValue }) => {
        try {
            const response = await fetchMovementsAPI(pageIndex);
            return { data: response?.data || [], pageIndex };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const fetchMyMovementsList = createAsyncThunk(
    "movements/fetchMyMovements",
    async (pageIndex = 1, { rejectWithValue }) => {
        try {
            const response = await fetchMyMovements(pageIndex);
            return { data: response?.data || [], pageIndex };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const toggleJoinMovement = createAsyncThunk(
    "movements/toggleJoin",
    async (movement, { rejectWithValue }) => {
        try {
            await toggleJoinMovementAPI(movement);
            return { movementId: movement.id, isJoined: !movement.isJoined };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

export const deactivateMovementThunk = createAsyncThunk(
    "movements/deactivate",
    async ({ movementId, status }, { rejectWithValue }) => {
        try {
            await deactivateMovement(movementId, status);
            return { movementId, status };
        } catch (error) {
            return rejectWithValue(error.message);
        }
    },
);

// ── Slice ─────────────────────────────────────────────────────────────

const initialState = {
    // Popular movements
    items: [],
    loading: false,
    error: null,
    page: 1,
    hasMore: true,

    // My movements
    myItems: [],
    myLoading: false,
    myError: null,
    myPage: 1,
    myHasMore: true,
};

const movementsSlice = createSlice({
    name: "movements",
    initialState,
    reducers: {
        resetMovements: (state) => {
            state.items = [];
            state.page = 1;
            state.hasMore = true;
            state.error = null;
        },
        resetMyMovements: (state) => {
            state.myItems = [];
            state.myPage = 1;
            state.myHasMore = true;
            state.myError = null;
        },
        updateMovementInList: (state, action) => {
            const { movementId, updates } = action.payload;
            const index = state.items.findIndex((m) => m.id === movementId);
            if (index !== -1) {
                state.items[index] = { ...state.items[index], ...updates };
            }
            const myIndex = state.myItems.findIndex(
                (m) => m.id === movementId,
            );
            if (myIndex !== -1) {
                state.myItems[myIndex] = {
                    ...state.myItems[myIndex],
                    ...updates,
                };
            }
        },
    },
    extraReducers: (builder) => {
        builder
            // fetchMovements
            .addCase(fetchMovements.pending, (state) => {
                state.loading = true;
                state.error = null;
            })
            .addCase(fetchMovements.fulfilled, (state, action) => {
                state.loading = false;
                const { data, pageIndex } = action.payload;
                if (pageIndex === 1) {
                    state.items = data;
                } else {
                    state.items = [...state.items, ...data];
                }
                state.page = pageIndex;
                state.hasMore = data.length > 0;
            })
            .addCase(fetchMovements.rejected, (state, action) => {
                state.loading = false;
                state.error = action.payload;
            })

            // fetchMyMovements
            .addCase(fetchMyMovementsList.pending, (state) => {
                state.myLoading = true;
                state.myError = null;
            })
            .addCase(fetchMyMovementsList.fulfilled, (state, action) => {
                state.myLoading = false;
                const { data, pageIndex } = action.payload;
                if (pageIndex === 1) {
                    state.myItems = data;
                } else {
                    state.myItems = [...state.myItems, ...data];
                }
                state.myPage = pageIndex;
                state.myHasMore = data.length > 0;
            })
            .addCase(fetchMyMovementsList.rejected, (state, action) => {
                state.myLoading = false;
                state.myError = action.payload;
            })

            // toggleJoin
            .addCase(toggleJoinMovement.fulfilled, (state, action) => {
                const { movementId, isJoined } = action.payload;
                const item = state.items.find((m) => m.id === movementId);
                if (item) item.isJoined = isJoined;
                const myItem = state.myItems.find(
                    (m) => m.id === movementId,
                );
                if (myItem) myItem.isJoined = isJoined;
            })

            // deactivate
            .addCase(deactivateMovementThunk.fulfilled, (state, action) => {
                const { movementId } = action.payload;
                state.items = state.items.filter(
                    (m) => m.id !== movementId,
                );
                state.myItems = state.myItems.filter(
                    (m) => m.id !== movementId,
                );
            });
    },
});

export const { resetMovements, resetMyMovements, updateMovementInList } =
    movementsSlice.actions;

// ── Selectors ─────────────────────────────────────────────────────────

export const selectMovements = (state) => state.movements.items;
export const selectMovementsLoading = (state) => state.movements.loading;
export const selectMovementsError = (state) => state.movements.error;
export const selectMovementsPage = (state) => state.movements.page;
export const selectMovementsHasMore = (state) => state.movements.hasMore;

export const selectMyMovements = (state) => state.movements.myItems;
export const selectMyMovementsLoading = (state) => state.movements.myLoading;
export const selectMyMovementsHasMore = (state) => state.movements.myHasMore;

export default movementsSlice.reducer;
