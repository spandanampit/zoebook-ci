import React from "react";
import {
    Users,
    ShieldCheck,
    Sparkles,
    CalendarDays,
    CircleDot,
    ArrowUpRight,
    Fingerprint,
    Mail,
} from "lucide-react";
import { decodeEscapedText } from "../../../utils/textDecoder";

const MovementRightPanel = ({
    movement,
    isLoading,
    error,
    isLeaving = false,
    onLeaveMovement,
}) => {
    if (isLoading) {
        return (
            <div className="bg-white rounded-[2.5rem] p-8 space-y-6 animate-pulse shadow-sm border border-gray-100">
                <div className="h-4 w-1/3 bg-gray-100 rounded-full" />
                <div className="space-y-2">
                    <div className="h-4 w-full bg-gray-50 rounded-md" />
                    <div className="h-4 w-3/4 bg-gray-50 rounded-md" />
                </div>
                <div className="grid grid-cols-2 gap-3">
                    <div className="h-20 bg-gray-50 rounded-2xl" />
                    <div className="h-20 bg-gray-50 rounded-2xl" />
                </div>
            </div>
        );
    }

    if (error || !movement) return null;

    const description = decodeEscapedText(
        movement.description || "No description provided.",
    );

    return (
        <div className="bg-white rounded-[2.5rem] p-2 shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-gray-100 sticky top-24">
            <div className="p-6">
                {/* Header Tag */}
                <div className="flex items-center gap-2 mb-6">
                    <span className="px-3 py-1 bg-[#8e6fb1]/10 text-[#8e6fb1] text-[10px] font-black uppercase tracking-widest rounded-full border border-[#8e6fb1]/10">
                        About Movement
                    </span>
                    <div className="h-[1px] flex-1 bg-gray-100" />
                </div>

                {/* Description Section */}
                <div className="mb-8">
                    <p className="text-[15px] text-gray-600 leading-relaxed font-medium">
                        {description}
                    </p>
                </div>

                {/* Bento Grid */}
                <div className="grid grid-cols-2 gap-3 mb-8">
                    {/* Members */}
                    <div className="bg-blue-50/50 p-4 rounded-[2rem] border border-blue-100/50 group hover:bg-blue-50 transition-colors">
                        <div className="flex justify-between items-center mb-1">
                            <Users className="w-5 h-5 text-blue-500" />
                            <ArrowUpRight className="w-3 h-3 text-blue-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" />
                        </div>
                        <p className="text-[10px] text-blue-600/70 font-black uppercase">
                            Members
                        </p>
                        <p className="text-xl font-bold text-blue-900">
                            {movement.members || "0"}
                        </p>
                    </div>

                    {/* Visibility */}
                    <div className="bg-emerald-50/50 p-4 rounded-[2rem] border border-emerald-100/50 group hover:bg-emerald-50 transition-colors">
                        <div className="flex justify-between items-center mb-1">
                            <ShieldCheck className="w-5 h-5 text-emerald-500" />
                        </div>
                        <p className="text-[10px] text-emerald-600/70 font-black uppercase">
                            Privacy
                        </p>
                        <p className="text-xl font-bold text-emerald-900">
                            {movement.visibility || "Public"}
                        </p>
                    </div>

                    {/* Status & Theme (Full Width) */}
                    <div className="col-span-2 bg-gray-50/80 p-5 rounded-[2rem] border border-gray-100 flex items-center justify-between">
                        <div className="flex items-center gap-3">
                            <div className="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-sm">
                                <CircleDot
                                    className={`w-5 h-5 ${movement.status === "Active" ? "text-green-500 animate-pulse" : "text-[#8e6fb1]"}`}
                                />
                            </div>
                            <div>
                                <p className="text-[10px] text-gray-400 font-black uppercase leading-none mb-1">
                                    Status
                                </p>
                                <p className="text-sm font-bold text-gray-700">
                                    {movement.status || "Live"}
                                </p>
                            </div>
                        </div>
                        <div className="text-right">
                            <p className="text-[10px] text-gray-400 font-black uppercase leading-none mb-1">
                                Theme
                            </p>
                            <p className="text-sm font-bold text-[#8e6fb1]">
                                {movement.theme || "Modern"}
                            </p>
                        </div>
                    </div>
                </div>

                {/* Leader Profile Card */}
                <div className="bg-[#8e6fb1]/5 rounded-[2.2rem] p-5 border border-[#8e6fb1]/10">
                    <div className="flex items-center gap-4 mb-4">
                        <div className="relative">
                            <img
                                src={
                                    movement.leaderImage ||
                                    "https://ui-avatars.com/api/?name=Leader"
                                }
                                className="w-14 h-14 rounded-full border-4 border-white shadow-md object-cover"
                                alt="Leader"
                            />
                            <div className="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                                <Fingerprint className="w-3.5 h-3.5 text-[#8e6fb1]" />
                            </div>
                        </div>
                        <div className="flex-1 min-w-0">
                            <p className="text-[10px] font-black text-[#8e6fb1] uppercase tracking-tighter leading-none mb-1">
                                Movement Founder
                            </p>
                            <h4 className="text-base font-bold text-gray-800 truncate">
                                {movement.leaderName}
                            </h4>
                            <div className="flex items-center gap-1 text-gray-400">
                                <Mail className="w-3 h-3" />
                                <p className="text-xs truncate">
                                    {movement.leaderEmail ||
                                        "official@movement.com"}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="flex items-center justify-between text-[11px] text-gray-500 pt-4 border-t border-[#8e6fb1]/10">
                        <div className="flex items-center gap-1.5 font-medium">
                            <CalendarDays className="w-3.5 h-3.5 text-gray-400" />
                            <span>Est. {movement.addedDate || "2024"}</span>
                        </div>
                        <button className="px-4 py-1.5 bg-white text-[#8e6fb1] rounded-full text-[10px] font-black uppercase border border-[#8e6fb1]/20 hover:bg-[#8e6fb1] hover:text-white transition-all">
                            Message
                        </button>
                    </div>
                </div>

                {/* Action Button */}
                <button
                    className="w-full mt-4 py-4 bg-[#ff6900] text-white rounded-[1.5rem] text-[11px] font-black uppercase tracking-[0.2em] hover:bg-[#f21818] transition-all shadow-lg shadow-[#8e6fb1]/20 disabled:opacity-70 disabled:cursor-not-allowed"
                    type="button"
                    onClick={onLeaveMovement}
                    disabled={isLeaving}
                >
                    {isLeaving ? "Leaving..." : "Leave This Movement"}
                </button>
            </div>
        </div>
    );
};

export default MovementRightPanel;
