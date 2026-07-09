import React from "react";
import { motion } from "framer-motion";
import { Image, Music, Flame } from "lucide-react";
import { useUser } from "../../context/UserContext";
import { FALLBACK_IMAGE } from "../../config/siteConfig";
import { getFullProfileImageUrl } from "../../utils/imageUtils";

const CreatePostCard = ({ onOpenModal, onOpenMusicModal }) => {
    const { profile } = useUser();
    const avatarUrl = getFullProfileImageUrl(profile?.profileImage);

    // Advanced touch: Dynamic first-name greeting
    const firstName = profile?.name ? profile.name.trim().split(" ")[0] : "";

    return (
        <motion.div
            initial={{ opacity: 0, y: 12 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.4, ease: [0.215, 0.61, 0.355, 1.0] }}
            className="w-full max-w-3xl bg-white border border-slate-100 rounded-2xl p-4 md:p-5 shadow-[0_2px_12px_rgba(15,23,42,0.02),0_16px_32px_-8px_rgba(15,23,42,0.04)] mb-6"
        >
            {/* Main Interactive Row */}
            <div className="flex items-center gap-3.5">
                {/* Clean, Non-bulky Avatar */}
                <div className="relative shrink-0 group">
                    <img
                        src={avatarUrl}
                        alt={profile?.name || "User profile"}
                        className="w-10 h-10 rounded-full object-cover ring-2 ring-slate-50 group-hover:ring-slate-100 transition-all duration-300"
                        onError={(e) => {
                            e.target.src = FALLBACK_IMAGE;
                        }}
                    />
                    <span className="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 ring-2 ring-white rounded-full" />
                </div>

                {/* Minimalist Mimic Input Box */}
                <div
                    onClick={() => onOpenModal && onOpenModal("text")}
                    className="flex-1 min-h-[42px] rounded-xl bg-slate-50/70 hover:bg-slate-50 border border-slate-100/50 hover:border-slate-200/80 transition-all duration-200 flex items-center px-4 cursor-pointer text-slate-400 hover:text-slate-500 text-sm select-none"
                >
                    <span>
                        What's on your mind{firstName ? `, ${firstName}` : ""}?
                    </span>
                </div>
            </div>

            {/* Subtle Divider line to anchor actions without taking heavy real estate */}
            <div className="h-px w-full bg-slate-100/60 my-4" />

            {/* Split Grid Quick Actions */}
            <div className="grid grid-cols-2 gap-2">
                {/* Photo / Video Button */}
                <button
                    onClick={() => onOpenModal && onOpenModal("image")} // Fixed handler target
                    className="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-slate-900 font-medium text-xs md:text-sm transition-all duration-150 cursor-pointer group active:scale-[0.98]"
                >
                    <Image
                        size={16}
                        className="text-slate-400 group-hover:text-emerald-500 transition-colors duration-200"
                    />
                    <span>Media</span>
                </button>

                {/* Music Button */}
                <button
                    onClick={() => onOpenMusicModal && onOpenMusicModal()}
                    className="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl hover:bg-slate-50 text-slate-600 hover:text-slate-900 font-medium text-xs md:text-sm transition-all duration-150 cursor-pointer group active:scale-[0.98]"
                >
                    <Music
                        size={16}
                        className="text-slate-400 group-hover:text-rose-500 transition-colors duration-200"
                    />
                    <span>Audio / Music</span>
                </button>
            </div>
        </motion.div>
    );
};

export default CreatePostCard;
