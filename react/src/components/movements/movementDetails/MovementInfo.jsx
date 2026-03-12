import React from "react";
import {
    Users,
    Globe2,
    ShieldCheck,
    CheckCircle2,
    MoreHorizontal,
} from "lucide-react";
import { decodeEscapedText } from "../../../utils/textDecoder";

const MovementInfo = ({ movement, isLoading, error }) => {
    if (isLoading) {
        return (
            <div className="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex justify-between items-center animate-pulse">
                <div className="space-y-3">
                    <div className="h-6 w-48 bg-gray-100 rounded-lg" />
                    <div className="h-4 w-32 bg-gray-50 rounded-lg" />
                    <div className="flex pt-2">
                        {[1, 2, 3, 4].map((i) => (
                            <div
                                key={i}
                                className="w-9 h-9 rounded-full -ml-3 border-4 border-white bg-gray-100"
                            />
                        ))}
                    </div>
                </div>
                <div className="h-12 w-32 bg-gray-100 rounded-2xl" />
            </div>
        );
    }

    if (error || !movement) {
        return error ? (
            <div className="bg-red-50 p-4 rounded-2xl border border-red-100 text-red-500 text-sm font-bold">
                {error}
            </div>
        ) : null;
    }

    const isJoined =
        String(movement.joinStatus || "").toLowerCase() === "active";

    const title = decodeEscapedText(movement.title) || "Untitled movement";

    const membersPreview = Array.isArray(movement.membersPreview)
        ? movement.membersPreview
        : [];
    const membersCount = Number(movement.members) || 0;

    return (
        <div className="bg-white p-8 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 group transition-all hover:shadow-md">
            {/* Left Content: Title & Members */}
            <div className="flex-1 space-y-4">
                <div className="space-y-1">
                    <div className="flex items-center gap-2 mb-1">
                        <span className="flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-[#8e6fb1] bg-[#8e6fb1]/5 px-2 py-0.5 rounded-full">
                            <SparkleIcon /> Featured Movement
                        </span>
                    </div>
                    <h2 className="text-2xl font-black text-gray-800 tracking-tight group-hover:text-[#8e6fb1] transition-colors">
                        {title}
                    </h2>
                </div>

                <div className="flex items-center gap-4">
                    {/* Member Stack */}
                    <div className="flex items-center">
                        <div className="flex -space-x-3 overflow-hidden">
                            {membersPreview.slice(0, 5).map((img, i) => (
                                <img
                                    key={i}
                                    src={img}
                                    className="inline-block h-10 w-10 rounded-full ring-4 ring-white object-cover"
                                    alt="Member"
                                />
                            ))}
                            {membersCount > 5 && (
                                <div className="flex items-center justify-center h-10 w-10 rounded-full bg-gray-50 ring-4 ring-white text-[10px] font-bold text-gray-400">
                                    +{membersCount - 5}
                                </div>
                            )}
                        </div>
                        <div className="ml-4">
                            <p className="text-sm font-bold text-gray-700 leading-none">
                                {membersCount.toLocaleString()}
                            </p>
                            <p className="text-[11px] text-gray-400 font-medium">
                                Global Members
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {/* Right Content: Status & Actions */}
            <div className="flex flex-row md:flex-col items-center md:items-end gap-3 w-full md:w-auto pt-4 md:pt-0 border-t md:border-t-0 border-gray-50">
                {/* Visibility Badge */}
                <div className="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-full border border-gray-100">
                    {movement.visibility?.toLowerCase() === "private" ? (
                        <ShieldCheck className="w-3.5 h-3.5 text-amber-500" />
                    ) : (
                        <Globe2 className="w-3.5 h-3.5 text-blue-500" />
                    )}
                    <span className="text-[11px] font-bold text-gray-600 capitalize">
                        {movement.visibility || "Public"}
                    </span>
                </div>

                {/* Join Status Button */}
                <button
                    className={`
            flex items-center gap-2 px-6 py-2.5 rounded-2xl text-sm font-black uppercase tracking-wider transition-all
            ${
                isJoined
                    ? "bg-emerald-50 text-emerald-600 border border-emerald-100"
                    : "bg-[#8e6fb1] text-white shadow-lg shadow-[#8e6fb1]/20 hover:scale-105"
            }
          `}
                >
                    {isJoined && <CheckCircle2 className="w-4 h-4" />}
                    {isJoined ? "Joined" : "Join Movement"}
                </button>

                <button className="md:hidden p-2 text-gray-400">
                    <MoreHorizontal className="w-5 h-5" />
                </button>
            </div>
        </div>
    );
};

// Simple Icon component for the badge
const SparkleIcon = () => (
    <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 1L14.39 8.26L22 9.27L16.13 14.14L17.82 22L12 17.77L6.18 22L7.87 14.14L2 9.27L9.61 8.26L12 1Z" />
    </svg>
);

export default MovementInfo;
