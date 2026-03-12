import { Outlet, Route, Routes } from "react-router-dom";
import DashboardLayout from "./components/layout/DashboardLayout";
import SideNavBar from "./components/sidebar";
import { useUser } from "./context/UserContext";
import MovementsPage from "./pages/MovementsPage";
import MovementDetailsPage from "./pages/MovementDetailsPage";

function DashboardShell() {
    const { profile, isLoading } = useUser();

    return (
        <DashboardLayout
            sidebar={<SideNavBar user={profile} isLoading={isLoading} />}
            headerUser={profile}
            isHeaderLoading={isLoading}
        >
            <Outlet />
        </DashboardLayout>
    );
}

function App() {
    return (
        <Routes>
            <Route element={<DashboardShell />}>
                <Route path="/" element={<MovementsPage />} />
                <Route path="/popularmovement" element={<MovementsPage />} />
                <Route
                    path="/movement-details/:movementId"
                    element={<MovementDetailsPage />}
                />
                <Route
                    path="/movement-details"
                    element={<MovementDetailsPage />}
                />
                <Route
                    path="/popularmovement/movement-details/:movementId"
                    element={<MovementDetailsPage />}
                />
                <Route
                    path="/popularmovement/movement-details"
                    element={<MovementDetailsPage />}
                />
                <Route path="*" element={<MovementsPage />} />
            </Route>
        </Routes>
    );
}

export default App;
