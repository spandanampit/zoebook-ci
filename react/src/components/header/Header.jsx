import React, { useState, useEffect } from "react";
import { Search, ChevronDown, Globe, Menu, Bell } from "lucide-react";

const FALLBACK_USER = {
    name: "User",
    profileImage: "https://zoebook.mydevfactory.com/public/images/noimage.gif",
};

const ZoebookHeader = ({ user }) => {
    const [isScrolled, setIsScrolled] = useState(false);
    const currentUser = user ?? FALLBACK_USER;

    useEffect(() => {
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 20);
        };
        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

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

                    <div className="relative hidden md:block w-full max-w-[280px] group">
                        <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-[#8e6fb1]" />
                        <input
                            type="text"
                            placeholder="Search everything..."
                            className="w-full bg-gray-100 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-[#8e6fb1]/20 transition-all outline-none"
                        />
                    </div>
                </div>

                <nav className="hidden lg:flex items-center gap-1">
                    {[
                        { label: "Home", href: "/home.html" },
                        { label: "Profile", href: "/my-profile.html" },
                        { label: "Viral Post", href: "/viral-posts.html" },
                        { label: "Videos", href: "/watchvideo.html" },
                    ].map((link) => (
                        <a
                            key={link.label}
                            href={link.href}
                            className="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-[#8e6fb1] rounded-full hover:bg-[#8e6fb1]/5 transition-all"
                        >
                            {link.label}
                        </a>
                    ))}
                    <button className="ml-2 bg-[#f39c12] text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-transform">
                        Movement
                    </button>
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

                    <div className="flex items-center gap-2 cursor-pointer group hover:bg-gray-50 p-1 pr-3 rounded-full transition-all">
                        <div className="relative">
                            <img
                                src={currentUser.profileImage}
                                alt={currentUser.name}
                                className="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm"
                            />
                            <span className="absolute bottom-0 right-0 w-2.5 h-2.5 bg-[#82c47a] border-2 border-white rounded-full"></span>
                        </div>
                        <span className="hidden xl:block text-sm font-bold text-gray-700">
                            {currentUser.name}
                        </span>
                        <ChevronDown className="w-4 h-4 text-gray-400" />
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
