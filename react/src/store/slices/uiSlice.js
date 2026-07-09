import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    // Modal state management
    activeModal: null, // e.g. 'share', 'delete', 'addToPlaylist', 'invite'
    modalData: null, // Data passed to the active modal

    // Sidebar state
    sidebarCollapsed: false,

    // Global loading overlay
    globalLoading: false,
    globalLoadingMessage: "",
};

const uiSlice = createSlice({
    name: "ui",
    initialState,
    reducers: {
        openModal: (state, action) => {
            state.activeModal = action.payload.modalType;
            state.modalData = action.payload.data || null;
        },
        closeModal: (state) => {
            state.activeModal = null;
            state.modalData = null;
        },
        toggleSidebar: (state) => {
            state.sidebarCollapsed = !state.sidebarCollapsed;
        },
        setSidebarCollapsed: (state, action) => {
            state.sidebarCollapsed = action.payload;
        },
        setGlobalLoading: (state, action) => {
            state.globalLoading = action.payload.loading;
            state.globalLoadingMessage = action.payload.message || "";
        },
    },
});

export const {
    openModal,
    closeModal,
    toggleSidebar,
    setSidebarCollapsed,
    setGlobalLoading,
} = uiSlice.actions;

export const selectActiveModal = (state) => state.ui.activeModal;
export const selectModalData = (state) => state.ui.modalData;
export const selectSidebarCollapsed = (state) => state.ui.sidebarCollapsed;
export const selectGlobalLoading = (state) => state.ui.globalLoading;

export default uiSlice.reducer;
