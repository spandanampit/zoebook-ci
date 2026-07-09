import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    userId: window.APP_CONFIG?.userId || null,
    isAuthenticated: !!window.APP_CONFIG?.userId,
};

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        setUserId: (state, action) => {
            state.userId = action.payload;
            state.isAuthenticated = !!action.payload;
        },
        clearAuth: (state) => {
            state.userId = null;
            state.isAuthenticated = false;
        },
    },
});

export const { setUserId, clearAuth } = authSlice.actions;
export const selectUserId = (state) => state.auth.userId;
export const selectIsAuthenticated = (state) => state.auth.isAuthenticated;
export default authSlice.reducer;
