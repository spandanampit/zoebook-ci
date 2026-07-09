import React, { useEffect, useMemo } from "react";
import { X, UploadCloud, Loader2 } from "lucide-react";
import { motion as Motion, AnimatePresence } from "framer-motion";
import ModalPortal from "../../../common/ModalPortal";

const CreateMovementPostModal = ({
    isOpen,
    selectedFile,
    description,
    isSubmitting,
    uploadProgress = 0,
    onClose,
    onFileChange,
    onDescriptionChange,
    onSubmit,
}) => {
    const preview = useMemo(() => {
        if (!selectedFile) {
            return { url: "", isVideo: false };
        }

        const isVideo = selectedFile.type.startsWith("video/");
        const isImage = selectedFile.type.startsWith("image/");

        if (!isVideo && !isImage) {
            return { url: "", isVideo: false };
        }

        return {
            url: URL.createObjectURL(selectedFile),
            isVideo,
        };
    }, [selectedFile]);

    useEffect(() => {
        return () => {
            if (preview.url) {
                URL.revokeObjectURL(preview.url);
            }
        };
    }, [preview.url]);

    useEffect(() => {
        if (!isOpen) return;
        const handleEscape = (e) => e.key === "Escape" && onClose?.();
        document.addEventListener("keydown", handleEscape);
        return () => document.removeEventListener("keydown", handleEscape);
    }, [isOpen, onClose]);

    return (
        <AnimatePresence>
            {isOpen && (
                <ModalPortal>
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 mb-0">
                    <Motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        onClick={onClose}
                        className="absolute inset-0 bg-slate-900/40 backdrop-blur-md"
                    />

                    <Motion.div
                        initial={{ opacity: 0, scale: 0.9, y: 20 }}
                        animate={{ opacity: 1, scale: 1, y: 0 }}
                        exit={{ opacity: 0, scale: 0.95, y: 10 }}
                        transition={{
                            type: "spring",
                            duration: 0.5,
                            bounce: 0.3,
                        }}
                        className="relative z-10 w-full max-w-lg overflow-hidden rounded-[2.5rem] border border-white/20 bg-white/90 shadow-[0_20px_50px_rgba(0,0,0,0.1)] backdrop-blur-2xl"
                    >
                        <div className="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#8e6fb1]/10 blur-3xl" />

                        <div className="relative p-8">
                            <div className="mb-8 flex items-start justify-between">
                                <div>
                                    <h3 className="text-2xl font-black tracking-tight text-gray-900">
                                        Create Movement
                                    </h3>
                                    <p className="mt-1 text-sm font-medium text-gray-500">
                                        Share your progress with the community.
                                    </p>
                                </div>
                                <button
                                    onClick={onClose}
                                    className="group rounded-full bg-gray-100 p-2 transition-all hover:bg-red-50"
                                >
                                    <X className="h-5 w-5 text-gray-500 transition-colors group-hover:text-red-500" />
                                </button>
                            </div>

                            <form className="space-y-6" onSubmit={onSubmit}>
                                <div>
                                    <label className="mb-3 block text-[11px] font-black uppercase tracking-widest text-gray-400">
                                        Attachment
                                    </label>
                                    <label className="group relative flex min-h-[140px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50/50 transition-all hover:border-[#8e6fb1] hover:bg-white">
                                        {preview.url ? (
                                            preview.isVideo ? (
                                                <video
                                                    src={preview.url}
                                                    controls
                                                    className="h-full w-full object-cover"
                                                />
                                            ) : (
                                                <img
                                                    src={preview.url}
                                                    alt="Preview"
                                                    className="h-full w-full object-cover"
                                                />
                                            )
                                        ) : (
                                            <div className="flex flex-col items-center p-6 text-center">
                                                <div className="mb-3 rounded-2xl bg-[#8e6fb1]/10 p-3 text-[#8e6fb1] transition-transform group-hover:scale-110">
                                                    <UploadCloud className="h-6 w-6" />
                                                </div>
                                                <span className="text-sm font-bold text-gray-700">
                                                    {selectedFile
                                                        ? selectedFile.name
                                                        : "Drop your file here"}
                                                </span>
                                                <span className="mt-1 text-xs text-gray-400">
                                                    PNG, JPG or MP4 up to 10MB
                                                </span>
                                            </div>
                                        )}
                                        <input
                                            type="file"
                                            className="hidden"
                                            onChange={onFileChange}
                                            accept="image/*,video/*"
                                        />
                                    </label>
                                </div>

                                <div>
                                    <label className="mb-3 block text-[11px] font-black uppercase tracking-widest text-gray-400">
                                        Description
                                    </label>
                                    <textarea
                                        value={description}
                                        onChange={onDescriptionChange}
                                        rows={4}
                                        placeholder="What's happening?"
                                        className="w-full resize-none rounded-3xl border-none bg-gray-100/50 p-5 text-sm text-gray-800 placeholder-gray-400 outline-none ring-2 ring-transparent transition-all focus:bg-white focus:ring-[#8e6fb1]/20"
                                    />
                                </div>

                                <div className="flex items-center justify-end gap-3">
                                    <button
                                        type="button"
                                        onClick={onClose}
                                        className="rounded-2xl px-6 py-3 text-sm font-bold text-gray-400 transition hover:text-gray-600"
                                    >
                                        Discard
                                    </button>
                                    <Motion.button
                                        whileHover={{ scale: 1.02 }}
                                        whileTap={{ scale: 0.98 }}
                                        disabled={isSubmitting || !selectedFile}
                                        type="submit"
                                        className="flex items-center gap-2 rounded-2xl bg-[#8e6fb1] px-8 py-3 text-sm font-bold text-white shadow-lg shadow-[#8e6fb1]/30 transition hover:brightness-110 disabled:opacity-50 disabled:grayscale"
                                    >
                                        {isSubmitting ? (
                                            <>
                                                <Loader2 className="h-4 w-4 animate-spin" />
                                                <span>
                                                    {uploadProgress > 0
                                                        ? `Uploading ${uploadProgress}%`
                                                        : "Uploading..."}
                                                </span>
                                            </>
                                        ) : (
                                            "Publish Post"
                                        )}
                                    </Motion.button>
                                </div>
                            </form>
                        </div>
                    </Motion.div>
                </div>
                </ModalPortal>
            )}
        </AnimatePresence>
    );
};

export default CreateMovementPostModal;
