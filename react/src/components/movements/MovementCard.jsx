import { useEffect, useRef, useState } from "react";
import {
    ChevronLeft,
    ChevronRight,
    Image as ImageIcon,
    MoreVertical,
    PlusCircle,
    Users,
} from "lucide-react";

function MovementCard({
    movement,
    onToggleJoin,
    onOpenDetails,
    getPrimaryAction,
    getOwnerMenuOptions,
}) {
    const {
        leaderName,
        leaderImg,
        movementTitle,
        movementImg,
        movementImages,
        members,
        description,
        isJoined,
        status,
    } = movement;
    const customAction = getPrimaryAction?.(movement);
    const ownerMenuOptions = getOwnerMenuOptions?.(movement) || [];
    const hasOwnerMenu = ownerMenuOptions.length > 0;

    const slides =
        Array.isArray(movementImages) && movementImages.length > 0
            ? movementImages
            : movementImg
              ? [movementImg]
              : [];

    const [activeSlide, setActiveSlide] = useState(0);
    const [failedSlides, setFailedSlides] = useState({});
    const [isOwnerMenuOpen, setIsOwnerMenuOpen] = useState(false);
    const ownerMenuRef = useRef(null);

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

    useEffect(() => {
        if (!hasOwnerMenu) {
            return undefined;
        }

        const handleOutsideClick = (event) => {
            if (!ownerMenuRef.current?.contains(event.target)) {
                setIsOwnerMenuOpen(false);
            }
        };

        document.addEventListener("mousedown", handleOutsideClick);
        return () => {
            document.removeEventListener("mousedown", handleOutsideClick);
        };
    }, [hasOwnerMenu]);

    const handleOpenDetails = () => {
        onOpenDetails?.(movement);
    };

    const handleOpenKeyDown = (event) => {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            handleOpenDetails();
        }
    };

    const handlePrimaryAction = () => {
        if (typeof customAction?.onClick === "function") {
            customAction.onClick(movement);
            return;
        }

        onToggleJoin?.(movement);
    };

    const primaryActionLabel =
        customAction?.label || (isJoined ? "Leave Movement" : "Join Community");
    const primaryActionClassName = customAction?.className
        ? customAction.className
        : isJoined
          ? "bg-orange-500 text-white shadow-orange-200 hover:bg-orange-600 hover:shadow-orange-300"
          : "bg-[#A7D397] text-white shadow-green-100 hover:bg-[#92c381]";
    const isInactive = String(status || "").toLowerCase() === "inactive";

    return (
        <article className="relative bg-white/75 backdrop-blur-md rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white flex flex-col h-full transition-transform duration-300 hover:-translate-y-1">
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
                {hasOwnerMenu ? (
                    <div className="relative" ref={ownerMenuRef}>
                        <button
                            className="text-slate-400 hover:text-slate-600 transition rounded-full p-1"
                            type="button"
                            aria-label="Open movement options"
                            onClick={(event) => {
                                event.preventDefault();
                                event.stopPropagation();
                                setIsOwnerMenuOpen((prev) => !prev);
                            }}
                        >
                            <MoreVertical size={20} />
                        </button>

                        {isOwnerMenuOpen ? (
                            <div className="absolute right-0 top-9 z-30 min-w-[150px] rounded-xl border border-slate-100 bg-white shadow-xl py-1.5">
                                {ownerMenuOptions.map((option) => (
                                    <button
                                        key={option.label}
                                        type="button"
                                        className={`block w-full px-4 py-2 text-left text-sm transition ${
                                            option.variant === "danger"
                                                ? "text-red-600 hover:bg-red-50"
                                                : "text-slate-700 hover:bg-slate-50"
                                        }`}
                                        onClick={(event) => {
                                            event.preventDefault();
                                            event.stopPropagation();
                                            setIsOwnerMenuOpen(false);
                                            option.onClick?.(movement);
                                        }}
                                    >
                                        {option.label}
                                    </button>
                                ))}
                            </div>
                        ) : null}
                    </div>
                ) : (
                    <button
                        className="text-slate-300 hover:text-slate-500 transition"
                        type="button"
                    >
                        <PlusCircle size={20} />
                    </button>
                )}
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

                <div className="relative w-full h-64 rounded-[1.5rem] overflow-hidden bg-slate-100 shadow-inner">
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

                    {isInactive ? (
                        <div className="absolute inset-0 bg-slate-900/35 backdrop-grayscale-[0.5] flex items-center justify-center">
                            <span className="rounded-full border border-white/60 bg-white/20 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.18em] text-white">
                                Deactivated
                            </span>
                        </div>
                    ) : null}
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
                    className={`w-full py-4 rounded-2xl font-bold text-sm transition-all duration-300 shadow-lg ${primaryActionClassName}`}
                    type="button"
                    onClick={handlePrimaryAction}
                >
                    {primaryActionLabel}
                </button>
            </div>
        </article>
    );
}

export default MovementCard;
