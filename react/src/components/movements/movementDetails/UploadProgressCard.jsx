import React from "react";
import { Loader2, Upload } from "lucide-react";

/**
 * UploadProgressCard
 *
 * Displays a sleek inline card at the top of the posts feed to indicate
 * an ongoing upload. Shows a progress bar with percentage and a pulsing
 * status message.
 *
 * @param {object} props
 * @param {number} props.progress - Upload percentage (0–100).
 * @param {boolean} props.visible - Whether to render the card.
 */
const UploadProgressCard = ({ progress = 0, visible = false }) => {
    if (!visible) return null;

    const clampedProgress = Math.min(Math.max(progress, 0), 100);

    return (
        <div className="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 mb-6 overflow-hidden relative">
            {/* Ambient glow */}
            <div className="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-[#8e6fb1]/8 blur-3xl pointer-events-none" />

            <div className="relative flex items-center gap-4">
                {/* Icon */}
                <div className="flex-shrink-0 w-12 h-12 rounded-2xl bg-[#8e6fb1]/10 flex items-center justify-center">
                    {clampedProgress < 100 ? (
                        <Upload className="w-5 h-5 text-[#8e6fb1] animate-bounce" />
                    ) : (
                        <Loader2 className="w-5 h-5 text-[#8e6fb1] animate-spin" />
                    )}
                </div>

                {/* Content */}
                <div className="flex-1 min-w-0">
                    <div className="flex items-center justify-between mb-2">
                        <p className="text-sm font-bold text-gray-800">
                            {clampedProgress < 100
                                ? "Uploading your post..."
                                : "Finishing up..."}
                        </p>
                        <span className="text-xs font-black text-[#8e6fb1] tabular-nums">
                            {clampedProgress}%
                        </span>
                    </div>

                    {/* Progress bar */}
                    <div className="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div
                            className="h-full rounded-full transition-all duration-500 ease-out"
                            style={{
                                width: `${clampedProgress}%`,
                                background:
                                    "linear-gradient(90deg, #8e6fb1 0%, #b08dd4 50%, #8e6fb1 100%)",
                                backgroundSize: "200% 100%",
                                animation: "shimmer 2s ease-in-out infinite",
                            }}
                        />
                    </div>

                    <p className="mt-1.5 text-[10px] font-medium text-gray-400 uppercase tracking-widest">
                        Your post will appear here once ready
                    </p>
                </div>
            </div>

            {/* Shimmer keyframes injected via style tag */}
            <style>{`
                @keyframes shimmer {
                    0% { background-position: 200% 0; }
                    100% { background-position: -200% 0; }
                }
            `}</style>
        </div>
    );
};

export default UploadProgressCard;
