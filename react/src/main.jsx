import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import { Provider } from "react-redux";
import { store } from "./store";
import "./index.css";
import App from "./App.jsx";
import { UserProvider } from "../src/context/UserContext.jsx";
import ErrorBoundary from "./components/ErrorBoundary.jsx";

const basename =
    import.meta.env.VITE_PROJECT_ENVIRONMENT === "DEVELOPMENT" ||
    import.meta.env.VITE_PROJECT_ENVIRONMENT === "PRODUCTION"
        ? "/reactMovement"
        : "/";

createRoot(document.getElementById("root")).render(
    <StrictMode>
        <ErrorBoundary>
            <Provider store={store}>
                <BrowserRouter basename={basename}>
                    <UserProvider>
                        <App />
                    </UserProvider>
                </BrowserRouter>
            </Provider>
        </ErrorBoundary>
    </StrictMode>,
);

