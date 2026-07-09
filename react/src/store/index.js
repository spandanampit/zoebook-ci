import { configureStore } from "@reduxjs/toolkit";
import authReducer from "./slices/authSlice";
import movementsReducer from "./slices/movementsSlice";
import movementDetailsReducer from "./slices/movementDetailsSlice";
import profileReducer from "./slices/profileSlice";
import uiReducer from "./slices/uiSlice";

export const store = configureStore({
    reducer: {
        auth: authReducer,
        movements: movementsReducer,
        movementDetails: movementDetailsReducer,
        profile: profileReducer,
        ui: uiReducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware({
            // Allow non-serializable data in profile.raw if needed
            serializableCheck: {
                ignoredPaths: ["profile.data.raw"],
            },
        }),
    devTools: import.meta.env.VITE_PROJECT_ENVIRONMENT !== "PRODUCTION",
});

export default store;
