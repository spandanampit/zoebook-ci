import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import "./index.css";
import App from "./App.jsx";
import { UserProvider } from "../src/context/UserContext.jsx";
import ErrorBoundary from "./components/ErrorBoundary.jsx";

const basename =
    import.meta.env.VITE_PROJECT_ENVIRONMENT === "DEVELOPMENT"
        ? "/reactMovement"
        : "/";

createRoot(document.getElementById("root")).render(
    <StrictMode>
        <ErrorBoundary>
            <BrowserRouter basename={basename}>
                <UserProvider>
                    <App />
                </UserProvider>
            </BrowserRouter>
        </ErrorBoundary>
    </StrictMode>,
);
