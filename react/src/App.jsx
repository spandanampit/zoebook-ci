import { Outlet, Route, Routes, useLocation } from "react-router-dom";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import DashboardLayout from "./components/layout/DashboardLayout";
import SideNavBarMovements from "./components/movements/SideNavBar";
import SideNavBarCommon from "./components/common/SideNavBar";
import { useUser } from "./context/UserContext";
import MovementsPage from "./pages/movement/MovementsPage";
import MovementDetailsPage from "./pages/movement/MovementDetailsPage";
import AddMovementPage from "./pages/movement/AddMovementPage";
import MyMovementsPage from "./pages/movement/MyMovementsPage";
import EditMovementPage from "./pages/movement/EditMovementPage";
import MyProfilePage from "./pages/profile/MyProfilePage";
import HomePage from "./pages/home/HomePage";
import WatchVideoPage from "./pages/watchvideo/WatchVideoPage";
import ViralPostsPage from "./pages/viralposts/ViralPostsPage";
import PostDetailPage from "./pages/postdetail/PostDetailPage";


function DashboardShell() {
    const { profile, isLoading } = useUser();
    const location = useLocation();

    const isCommonSidebarPage =
        location.pathname.startsWith("/profile") ||
        location.pathname.startsWith("/home") ||
        location.pathname.startsWith("/viral-posts") ||
        location.pathname.startsWith("/watchvideo") ||
        location.pathname.startsWith("/postDetail");

    const sidebar = isCommonSidebarPage ? (
        <SideNavBarCommon user={profile} isLoading={isLoading} />
    ) : (
        <SideNavBarMovements user={profile} isLoading={isLoading} />
    );

    return (
        <DashboardLayout
            sidebar={sidebar}
            headerUser={profile}
            isHeaderLoading={isLoading}
        >
            <Outlet />
        </DashboardLayout>
    );
}

function App() {
    return (
        <>
            <ToastContainer
                position="bottom-right"
                autoClose={4000}
                hideProgressBar={false}
                newestOnTop
                closeOnClick
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="colored"
            />
            <Routes>
                <Route element={<DashboardShell />}>
                    <Route path="/" element={<MovementsPage />} />
                    <Route path="/popularmovement" element={<MovementsPage />} />
                    <Route path="/mymovements" element={<MyMovementsPage />} />
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
                    <Route path="/createmovement" element={<AddMovementPage />} />
                    <Route
                        path="/editmovement/:movementId"
                        element={<EditMovementPage />}
                    />
                    <Route path="/profile" element={<MyProfilePage />} />
                    <Route path="/home" element={<HomePage />} />
                    <Route path="/viral-posts" element={<ViralPostsPage />} />
                    <Route path="/watchvideo" element={<WatchVideoPage />} />
                    <Route path="/postDetail/:postId" element={<PostDetailPage />} />
                    <Route path="*" element={<MovementsPage />} />
                </Route>
            </Routes>
        </>
    );
}

export default App;
