import { useState } from "react";
import {
    ChevronLeft,
    ChevronRight,
    Image as ImageIcon,
    PlusCircle,
    Users,
} from "lucide-react";

function MovementCard({ movement, onToggleJoin, onOpenDetails }) {
    const {
        leaderName,
        leaderImg,
        movementTitle,
        movementImg,
        movementImages,
        members,
        description,
        isJoined,
    } = movement;

    const slides =
        Array.isArray(movementImages) && movementImages.length > 0
            ? movementImages
            : movementImg
              ? [movementImg]
              : [];

    const [activeSlide, setActiveSlide] = useState(0);
    const [failedSlides, setFailedSlides] = useState({});

    const hasMultipleSlides = slides.length > 1;
    const currentSlide = slides[activeSlide] || "";
    const isCurrentSlideInvalid = !currentSlide || failedSlides[currentSlide];

    const showPrevSlide = () => {
        if (!hasMultipleSlides) {
            return;
        }

        setActiveSlide((prev) => (prev - 1 + slides.length) % slides.length);
    };

    const showNextSlide = () => {
        if (!hasMultipleSlides) {
            return;
        }

        setActiveSlide((prev) => (prev + 1) % slides.length);
    };

    const handleSlideError = (url) => {
        setFailedSlides((prev) => ({ ...prev, [url]: true }));
    };

    const handleOpenDetails = () => {
        onOpenDetails?.(movement);
    };

    const handleOpenKeyDown = (event) => {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            handleOpenDetails();
        }
    };

    return (
        <article className="bg-white/75 backdrop-blur-md rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white flex flex-col h-full transition-transform duration-300 hover:-translate-y-1">
            <header className="p-5 flex items-center justify-between">
                <div className="flex items-center gap-3">
                    <div className="relative">
                        <img
                            src={leaderImg}
                            alt={leaderName}
                            className="w-10 h-10 rounded-full object-cover ring-2 ring-slate-100"
                        />
                        <span className="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full" />
                    </div>
                    <div className="flex flex-col">
                        <span className="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                            Leader
                        </span>
                        <span className="text-sm font-bold text-slate-700">
                            {leaderName}
                        </span>
                    </div>
                </div>
                <button
                    className="text-slate-300 hover:text-slate-500 transition"
                    type="button"
                >
                    <PlusCircle size={20} />
                </button>
            </header>

            <div
                className="relative group px-4 cursor-pointer"
                role="button"
                tabIndex={0}
                onClick={handleOpenDetails}
                onKeyDown={handleOpenKeyDown}
            >
                {hasMultipleSlides ? (
                    <div className="absolute inset-y-0 left-6 flex items-center z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            className="bg-white/90 p-1.5 rounded-full shadow-lg text-slate-600 hover:bg-white"
                            type="button"
                            onClick={showPrevSlide}
                            aria-label="Previous movement image"
                        >
                            <ChevronLeft size={16} />
                        </button>
                    </div>
                ) : null}

                <div className="w-full h-64 rounded-[1.5rem] overflow-hidden bg-slate-100 shadow-inner">
                    {!isCurrentSlideInvalid ? (
                        <img
                            src={currentSlide}
                            alt={movementTitle}
                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            onError={() => handleSlideError(currentSlide)}
                        />
                    ) : (
                        <div className="w-full h-full flex flex-col items-center justify-center text-slate-300">
                            <ImageIcon size={40} strokeWidth={1.5} />
                            <span className="text-[10px] mt-2 font-bold uppercase tracking-widest text-slate-400">
                                Preview Unavailable
                            </span>
                        </div>
                    )}
                </div>

                {hasMultipleSlides ? (
                    <div className="absolute inset-y-0 right-6 flex items-center z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            className="bg-white/90 p-1.5 rounded-full shadow-lg text-slate-600 hover:bg-white"
                            type="button"
                            onClick={showNextSlide}
                            aria-label="Next movement image"
                        >
                            <ChevronRight size={16} />
                        </button>
                    </div>
                ) : null}
            </div>

            <div
                className="p-6 flex-grow cursor-pointer"
                role="button"
                tabIndex={0}
                onClick={handleOpenDetails}
                onKeyDown={handleOpenKeyDown}
            >
                <div className="flex justify-between items-start mb-3 gap-3">
                    <h3 className="text-lg font-extrabold text-slate-800 leading-tight">
                        {movementTitle}
                    </h3>
                    <div className="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-full shrink-0">
                        <Users size={12} className="text-slate-500" />
                        <span className="text-[10px] text-slate-600 font-bold">
                            {members}
                        </span>
                    </div>
                </div>
                <p className="text-xs text-slate-500 leading-relaxed line-clamp-2">
                    {description ||
                        "Join this thriving community to engage with like-minded individuals and share your journey."}
                </p>
            </div>

            <div className="p-6 pt-0">
                <button
                    className={`w-full py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-lg ${
                        isJoined
                            ? "bg-orange-500 text-white shadow-orange-200 hover:bg-orange-600 hover:shadow-orange-300"
                            : "bg-[#A7D397] text-white shadow-green-100 hover:bg-[#92c381]"
                    }`}
                    type="button"
                    onClick={() => onToggleJoin?.(movement)}
                >
                    {isJoined ? "Leave Movement" : "Join Community"}
                </button>
            </div>
        </article>
    );
}

export default MovementCard;
