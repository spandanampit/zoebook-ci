import React, { useState, useEffect, useRef } from "react";
import {
    Search,
    ChevronDown,
    Globe,
    Menu,
    Bell,
    MessageSquare,
    LogOut,
    LoaderCircle,
    Users,
    Compass,
    X,
} from "lucide-react";
import { Link, useNavigate } from "react-router-dom";
import { SITE_URL, FALLBACK_IMAGE } from "../../config/siteConfig";
import { searchEverything } from "../../services/userService";

const url = SITE_URL;
const MIN_SEARCH_LENGTH = 2;
const SEARCH_DELAY = 300;

const FALLBACK_USER = {
    name: "User",
    profileImage: FALLBACK_IMAGE,
};

function slugifyText(value = "") {
    const normalized = String(value)
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");

    const slug = normalized
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/^-+|-+$/g, "");

    return slug || "user";
}

const ZoebookHeader = ({ user }) => {
    const [isScrolled, setIsScrolled] = useState(false);
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);
    const [searchTerm, setSearchTerm] = useState("");
    const [searchState, setSearchState] = useState({
        friends: [],
        movements: [],
        total: 0,
    });
    const [isSearching, setIsSearching] = useState(false);
    const [searchError, setSearchError] = useState("");
    const [isSearchOpen, setIsSearchOpen] = useState(false);
    const dropdownRef = useRef(null);
    const searchRef = useRef(null);
    const navigate = useNavigate();
    const currentUser = user ?? FALLBACK_USER;
    const trimmedSearchTerm = searchTerm.trim();

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 20);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsDropdownOpen(false);
            }

            if (searchRef.current && !searchRef.current.contains(event.target)) {
                setIsSearchOpen(false);
            }
        };

        if (isDropdownOpen || isSearchOpen) {
            document.addEventListener("mousedown", handleClickOutside);
        }
        return () => {
            document.removeEventListener("mousedown", handleClickOutside);
        };
    }, [isDropdownOpen, isSearchOpen]);

    useEffect(() => {
        if (trimmedSearchTerm.length < MIN_SEARCH_LENGTH) {
            setSearchState({
                friends: [],
                movements: [],
                total: 0,
            });
            setSearchError("");
            setIsSearching(false);
            return undefined;
        }

        let isActive = true;

        const timeoutId = window.setTimeout(async () => {
            setIsSearching(true);
            setSearchError("");

            try {
                const results = await searchEverything(trimmedSearchTerm, {
                    userId: currentUser.id,
                    exclude: currentUser.id,
                });

                if (!isActive) {
                    return;
                }

                setSearchState(results);
                setIsSearchOpen(true);
            } catch (error) {
                if (!isActive) {
                    return;
                }

                setSearchState({
                    friends: [],
                    movements: [],
                    total: 0,
                });
                setSearchError(error.message || "Unable to search right now.");
            } finally {
                if (isActive) {
                    setIsSearching(false);
                }
            }
        }, SEARCH_DELAY);

        return () => {
            isActive = false;
            window.clearTimeout(timeoutId);
        };
    }, [currentUser.id, trimmedSearchTerm]);

    const handleSearchFocus = () => {
        if (
            trimmedSearchTerm.length >= MIN_SEARCH_LENGTH ||
            isSearching ||
            searchState.total > 0 ||
            searchError
        ) {
            setIsSearchOpen(true);
        }
    };

    const closeSearch = () => {
        setIsSearchOpen(false);
    };

    const handleMovementSelect = (movementId) => {
        closeSearch();
        setSearchTerm("");
        navigate(`/movement-details/${encodeURIComponent(movementId)}`);
    };

    const handleFriendSelect = (friend) => {
        closeSearch();
        setSearchTerm("");
        const profileSlug = slugifyText(friend.name);
        window.location.href = `${SITE_URL}/user-profile-${friend.id}-${profileSlug}.html`;
    };

    const renderSearchResults = () => {
        if (trimmedSearchTerm.length < MIN_SEARCH_LENGTH) {
            return (
                <div className="px-4 py-3 text-sm text-gray-500">
                    Type at least {MIN_SEARCH_LENGTH} characters to search friends and movements.
                </div>
            );
        }

        if (isSearching) {
            return (
                <div className="px-4 py-4 flex items-center gap-2 text-sm text-gray-500">
                    <LoaderCircle className="w-4 h-4 animate-spin" />
                    Searching...
                </div>
            );
        }

        if (searchError) {
            return (
                <div className="px-4 py-3 text-sm text-red-500">
                    {searchError}
                </div>
            );
        }

        if (!searchState.total) {
            return (
                <div className="px-4 py-3 text-sm text-gray-500">
                    No results found for "{trimmedSearchTerm}".
                </div>
            );
        }

        return (
            <div className="max-h-[420px] overflow-y-auto py-2">
                {searchState.friends.length > 0 && (
                    <div>
                        <div className="px-4 pb-2 pt-1 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                            Friends
                        </div>
                        {searchState.friends.map((friend) => (
                            <button
                                key={`friend-${friend.id}`}
                                type="button"
                                onClick={() => handleFriendSelect(friend)}
                                className="w-full px-4 py-3 flex items-center gap-3 hover:bg-[#8e6fb1]/5 transition-colors text-left"
                            >
                                <img
                                    src={friend.image || FALLBACK_IMAGE}
                                    alt={friend.name}
                                    className="w-11 h-11 rounded-full object-cover border border-gray-100"
                                    onError={(event) => {
                                        event.target.src = FALLBACK_IMAGE;
                                    }}
                                />
                                <div className="min-w-0 flex-1">
                                    <div className="text-sm font-semibold text-gray-800 truncate">
                                        {friend.name}
                                    </div>
                                    <div className="text-xs text-gray-500 truncate">
                                        {friend.subtitle || `${friend.followers} followers`}
                                    </div>
                                </div>
                                <div className="text-[11px] font-semibold text-[#8e6fb1] whitespace-nowrap">
                                    <Users className="w-4 h-4 inline mr-1" />
                                    {friend.posts} posts
                                </div>
                            </button>
                        ))}
                    </div>
                )}

                {searchState.movements.length > 0 && (
                    <div>
                        <div className="px-4 pb-2 pt-3 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                            Movements
                        </div>
                        {searchState.movements.map((movement) => (
                            <button
                                key={`movement-${movement.id}`}
                                type="button"
                                onClick={() => handleMovementSelect(movement.id)}
                                className="w-full px-4 py-3 flex items-center gap-3 hover:bg-[#f39c12]/5 transition-colors text-left"
                            >
                                <div className="w-11 h-11 rounded-2xl overflow-hidden bg-gray-100 shrink-0">
                                    {movement.image ? (
                                        <img
                                            src={movement.image}
                                            alt={movement.name}
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-[#f39c12]">
                                            <Compass className="w-5 h-5" />
                                        </div>
                                    )}
                                </div>
                                <div className="min-w-0 flex-1">
                                    <div className="text-sm font-semibold text-gray-800 truncate">
                                        {movement.name}
                                    </div>
                                    <div className="text-xs text-gray-500 truncate">
                                        {movement.subtitle || "Open movement"}
                                    </div>
                                </div>
                                <div className="text-[11px] font-semibold text-[#f39c12] whitespace-nowrap">
                                    {movement.members} members
                                </div>
                            </button>
                        ))}
                    </div>
                )}
            </div>
        );
    };

    return (
        <div
            className={`fixed top-0 left-0 right-0 z-50 flex justify-center transition-all duration-500 ease-in-out ${
                isScrolled ? "pt-3 px-4 sm:px-8" : "pt-0 px-0"
            }`}
        >
            <header
                className={`
          w-full flex items-center justify-between px-6 py-3
          transition-all duration-500 ease-in-out
          ${
              isScrolled
                  ? "max-w-[1440px] rounded-full bg-white/90 backdrop-blur-md shadow-lg border border-gray-200/50"
                  : "max-w-full rounded-none bg-white border-b border-gray-100 shadow-sm"
          }
        `}
            >
                <div className="flex items-center gap-8 flex-1">
                    <h1 className="text-2xl font-black text-[#8e6fb1] tracking-tighter shrink-0 cursor-pointer">
                        Zoebook
                    </h1>

                    <div
                        className="relative hidden md:block w-full max-w-[360px] group"
                        ref={searchRef}
                    >
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-[#8e6fb1]" />
                        <input
                            type="text"
                            placeholder="Search everything..."
                            value={searchTerm}
                            onChange={(event) => {
                                setSearchTerm(event.target.value);
                                setIsSearchOpen(true);
                            }}
                            onFocus={handleSearchFocus}
                            className="w-full bg-gray-100 border-none rounded-full py-2 pl-10 pr-10 text-sm focus:ring-2 focus:ring-[#8e6fb1]/20 transition-all outline-none"
                        />
                        {searchTerm && (
                            <button
                                type="button"
                                onClick={() => {
                                    setSearchTerm("");
                                    setIsSearchOpen(false);
                                }}
                                className="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-200/50 transition-colors"
                            >
                                <X className="w-3.5 h-3.5" />
                            </button>
                        )}
                        {isSearchOpen && (
                            <div className="absolute top-[calc(100%+10px)] left-0 right-0 rounded-3xl border border-gray-200 bg-white shadow-2xl overflow-hidden">
                                {renderSearchResults()}
                            </div>
                        )}
                    </div>
                </div>

                <nav className="hidden lg:flex items-center gap-1">
                    {[
                        { label: "Home", to: "/home" },
                        { label: "Profile", to: "/profile" },
                        {
                            label: "Viral Post",
                            href: url + "/viral-posts.html",
                        },
                        { label: "Videos", to: "/watchvideo" },
                    ].map((link) =>
                        link.href ? (
                            <a
                                key={link.label}
                                href={link.href}
                                className="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#8e6fb1] rounded-full hover:bg-[#8e6fb1]/5 transition-all"
                            >
                                {link.label}
                            </a>
                        ) : (
                            <Link
                                key={link.label}
                                to={link.to}
                                className="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#8e6fb1] rounded-full hover:bg-[#8e6fb1]/5 transition-all"
                            >
                                {link.label}
                            </Link>
                        ),
                    )}

                    <Link to="/popularmovement">
                        <button className="ml-2 bg-[#f39c12] text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-transform">
                            Movement
                        </button>
                    </Link>
                </nav>

                <div className="flex items-center gap-4 flex-1 justify-end">
                    <div className="hidden sm:flex items-center gap-3 mr-2">
                        <button className="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                            <Bell className="w-5 h-5" />
                            <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button className="bg-[#82c47a] text-white px-5 py-2 rounded-full text-xs font-bold hover:bg-[#71b369] transition-colors shadow-sm">
                            Go Live
                        </button>
                    </div>

                    <div className="h-8 w-[1px] bg-gray-200 hidden md:block" />

                    <div className="relative" ref={dropdownRef}>
                        <div
                            onClick={() => setIsDropdownOpen((prev) => !prev)}
                            className="flex items-center gap-2 cursor-pointer group hover:bg-gray-50 p-1 pr-3 rounded-full transition-all select-none"
                        >
                            <div className="relative">
                                <img
                                    src={currentUser.profileImage}
                                    alt={currentUser.name}
                                    className="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm"
                                    onError={(e) => {
                                        e.target.src = FALLBACK_IMAGE;
                                    }}
                                />
                                <span className="absolute bottom-0 right-0 w-2.5 h-2.5 bg-[#82c47a] border-2 border-white rounded-full"></span>
                            </div>
                            <span className="hidden xl:block text-sm font-bold text-gray-700">
                                {currentUser.name}
                            </span>
                            <ChevronDown className={`w-4 h-4 text-gray-400 transition-transform duration-200 ${isDropdownOpen ? 'rotate-180' : ''}`} />
                        </div>

                        {/* Dropdown Menu */}
                        {isDropdownOpen && (
                            <div className="absolute right-0 mt-2 w-48 rounded-2xl bg-white border border-gray-100 shadow-xl py-2 z-50 animate-in fade-in slide-in-from-top-3 duration-200">
                                <a
                                    href={SITE_URL + "/chat.html"}
                                    className="flex items-center px-4 py-3 text-sm font-semibold text-gray-600 hover:text-[#8e6fb1] hover:bg-[#8e6fb1]/5 transition-colors"
                                    onClick={() => setIsDropdownOpen(false)}
                                >
                                    <MessageSquare className="w-4 h-4 mr-3 text-gray-400 group-hover:text-[#8e6fb1]" />
                                    Chat
                                </a>
                                <div className="border-t border-gray-100 my-1"></div>
                                <a
                                    href={SITE_URL + "/user/user/logout"}
                                    className="flex items-center px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors"
                                    onClick={() => {
                                        setIsDropdownOpen(false);
                                        localStorage.removeItem("zoebook_profile_cache_v3");
                                    }}
                                >
                                    <LogOut className="w-4 h-4 mr-3 text-red-500" />
                                    Logout
                                </a>
                            </div>
                        )}
                    </div>

                    <button className="bg-[#8e6fb1] text-white px-3 py-2 rounded-full text-xs flex items-center gap-1 font-bold">
                        <Globe className="w-3.5 h-3.5" />
                        <span className="hidden sm:inline">EN</span>
                    </button>

                    <button className="lg:hidden p-1">
                        <Menu className="w-6 h-6 text-gray-600" />
                    </button>
                </div>
            </header>
        </div>
    );
};

export default ZoebookHeader;
