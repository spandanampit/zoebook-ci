import React, { useState } from "react";
import { Maximize2, X, ImageOff } from "lucide-react";

const MovementCover = ({ cover, title, isLoading }) => {
    const [isOpen, setIsOpen] = useState(false);

    if (isLoading) {
        return (
            <div className="relative w-full h-80 bg-gray-200 animate-pulse rounded-[2.5rem] overflow-hidden">
                <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent skeleton-wave" />
            </div>
        );
    }

    return (
        <>
            <div
                className="group relative w-full h-80 bg-white rounded-[2.5rem] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 cursor-pointer"
                onClick={() => cover && setIsOpen(true)}
            >
                {cover ? (
                    <>
                        <img
                            src={cover}
                            className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                            alt={title}
                        />

                        <div className="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-end p-8">
                            <div className="bg-white/20 backdrop-blur-md p-3 rounded-full border border-white/30 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <Maximize2 className="w-5 h-5 text-white" />
                            </div>
                        </div>
                    </>
                ) : (
                    <div className="w-full h-full bg-gray-50 flex flex-col items-center justify-center gap-3">
                        <ImageOff className="w-10 h-10 text-gray-200" />
                        <span className="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            No Cover Image
                        </span>
                    </div>
                )}
            </div>

            {isOpen && (
                <div
                    className="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm p-4 md:p-10"
                    onClick={() => setIsOpen(false)}
                >
                    <button
                        className="absolute top-6 right-6 p-3 bg-white/10 hover:bg-white/20 rounded-full transition-colors text-white"
                        onClick={(e) => {
                            e.stopPropagation();
                            setIsOpen(false);
                        }}
                    >
                        <X className="w-6 h-6" />
                    </button>

                    <img
                        src={cover}
                        className="max-w-full max-h-full rounded-2xl shadow-2xl animate-in zoom-in-95 duration-300"
                        alt="Fullscreen preview"
                        onClick={(e) => e.stopPropagation()}
                    />

                    <div className="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/60 text-sm font-medium">
                        {title} Cover Image
                    </div>
                </div>
            )}
        </>
    );
};

export default MovementCover;
