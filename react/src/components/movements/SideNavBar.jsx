import { ChevronRight, PlusCircle, TrendingUp, UserCircle } from "lucide-react";
import { NavLink } from "react-router-dom";
import { FALLBACK_IMAGE, SITE_URL } from "../../config/siteConfig";

function SideNavBarSkeleton() {
    return (
        <div className="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/60 border border-white animate-pulse">
            <div className="w-28 h-28 rounded-[2rem] bg-slate-200 mx-auto mb-6" />
            <div className="h-6 w-40 bg-slate-200 rounded mx-auto mb-3" />
            <div className="h-3 w-28 bg-slate-200 rounded mx-auto mb-8" />
            <div className="w-full flex flex-col gap-4">
                <div className="h-14 rounded-2xl bg-slate-200" />
                <div className="h-14 rounded-2xl bg-slate-200" />
                <div className="h-14 rounded-2xl bg-slate-200" />
            </div>
        </div>
    );
}

const isProduction = import.meta.env.VITE_PROJECT_ENVIRONMENT === "PRODUCTION";

function SideNavBar({ user, isLoading = false }) {
    const currentUser = user ?? {
        name: "User",
        profileImage:
            FALLBACK_IMAGE,
        membership: "Profile unavailable",
    };

    if (isLoading) {
        return <SideNavBarSkeleton />;
    }

    const navItemClassName = ({ isActive }) =>
        `group flex items-center justify-between text-white p-4 rounded-2xl font-bold text-sm transition-all ${
            isActive ? "ring-2 ring-offset-2 ring-orange-200" : ""
        }`;

    return (
        <div className="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/60 flex flex-col items-center text-center border border-white">
            <div className="w-28 h-28 rounded-[2rem] overflow-hidden mb-6 rotate-3 shadow-2xl">
                <img
                    src={currentUser.profileImage}
                    alt={currentUser.name}
                    className="w-full h-full object-cover"
                    onError={(e) => {
                        e.target.src = FALLBACK_IMAGE;
                    }}
                />
            </div>

            <h2 className="text-2xl font-black text-slate-800 mb-1">
                {currentUser.name}
            </h2>

            <p className="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] mb-8">
                {currentUser.membership}
            </p>

            <nav className="w-full flex flex-col gap-4">
                <NavLink
                    to="/popularmovement"
                    className={({ isActive }) =>
                        `${navItemClassName({ isActive })} bg-orange-500 hover:bg-orange-600 shadow-xl shadow-orange-200`
                    }
                >
                    <span className="flex items-center gap-3">
                        <TrendingUp size={18} />
                        Popular
                    </span>
                    <ChevronRight
                        size={14}
                        className="opacity-50 group-hover:translate-x-1 transition-transform"
                    />
                </NavLink>

                {isProduction ? (
                    <a
                        href={SITE_URL + "/mymovement.html"}
                        className="group flex items-center justify-between text-white p-4 rounded-2xl font-bold text-sm transition-all bg-[#A7D397] hover:opacity-90 shadow-xl shadow-green-100"
                    >
                        <span className="flex items-center gap-3">
                            <UserCircle size={18} />
                            My Movements
                        </span>
                        <ChevronRight
                            size={14}
                            className="opacity-50 group-hover:translate-x-1 transition-transform"
                        />
                    </a>
                ) : (
                    <NavLink
                        to="/mymovements"
                        className={({ isActive }) =>
                            `${navItemClassName({ isActive })} bg-[#A7D397] hover:opacity-90 shadow-xl shadow-green-100`
                        }
                    >
                        <span className="flex items-center gap-3">
                            <UserCircle size={18} />
                            My Movements
                        </span>
                        <ChevronRight
                            size={14}
                            className="opacity-50 group-hover:translate-x-1 transition-transform"
                        />
                    </NavLink>
                )}

                <NavLink
                    to="/createmovement"
                    className={({ isActive }) =>
                        `${navItemClassName({ isActive })} bg-[#9071AF] hover:opacity-90 shadow-xl shadow-purple-100`
                    }
                >
                    <span className="flex items-center gap-3">
                        <PlusCircle size={18} />
                        Create New
                    </span>
                    <ChevronRight
                        size={14}
                        className="opacity-50 group-hover:translate-x-1 transition-transform"
                    />
                </NavLink>
            </nav>
        </div>
    );
}

export default SideNavBar;
