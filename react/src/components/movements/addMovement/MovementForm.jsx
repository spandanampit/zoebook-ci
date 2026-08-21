import React, { useEffect, useMemo, useState } from "react";
import { Camera, Globe, Lock, Save } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import {
    createMovement,
    updateMovement,
    uploadMovementImage,
} from "../../../services/movementService";

const MovementForm = ({
    mode = "create",
    initialData = null,
    isPrefillLoading = false,
    prefillError = "",
}) => {
    const isEditMode = mode === "edit";
    const navigate = useNavigate();
    const [isPublic, setIsPublic] = useState(true);
    const [movementName, setMovementName] = useState("");
    const [description, setDescription] = useState("");
    const [coverFile, setCoverFile] = useState(null);
    const [existingCoverUrl, setExistingCoverUrl] = useState("");
    const [dragActive, setDragActive] = useState(false);
    const [isSaving, setIsSaving] = useState(false);

    useEffect(() => {
        if (!initialData) {
            return;
        }

        setMovementName(initialData.movementName || "");
        setDescription(initialData.description || "");
        setIsPublic((initialData.visibility || "Public") !== "Private");
        setExistingCoverUrl(initialData.coverImage || "");
        setCoverFile(null);
    }, [initialData]);

    const resetForm = () => {
        setMovementName("");
        setDescription("");
        setCoverFile(null);
        setExistingCoverUrl("");
        setIsPublic(true);
    };

    const coverPreviewUrl = useMemo(
        () => (coverFile ? URL.createObjectURL(coverFile) : ""),
        [coverFile],
    );

    useEffect(() => {
        return () => {
            if (coverPreviewUrl) {
                URL.revokeObjectURL(coverPreviewUrl);
            }
        };
    }, [coverPreviewUrl]);

    const showMovementCreatedToast = (movementId) => {
        toast.success(
            ({ closeToast }) => (
                <div className="flex items-center justify-between gap-3">
                    <span>New movement created successfully.</span>
                    <button
                        type="button"
                        className="rounded-lg bg-orange-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-orange-600 w-[50px]"
                        onClick={() => {
                            closeToast?.();
                            console.log("View movement clicked:", movementId);
                            navigate("/mymovements");
                        }}
                    >
                        Go
                    </button>
                </div>
            ),
            { autoClose: 10000 },
        );
    };

    const handleSubmit = async (event) => {
        event.preventDefault();

        if (!movementName.trim()) {
            toast.error("Please enter movement name.");
            return;
        }

        if (!description.trim()) {
            toast.error("Please enter goal or objective.");
            return;
        }

        if (isEditMode && !initialData?.movementId) {
            toast.error("Movement id is missing.");
            return;
        }

        setIsSaving(true);

        const savePromise = (async () => {
            if (isEditMode) {
                await updateMovement({
                    movementId: initialData.movementId,
                    movementName: movementName.trim(),
                    description: description.trim(),
                    theme: "dark",
                    visibility: isPublic ? "Public" : "Private",
                });

                if (coverFile) {
                    await uploadMovementImage({
                        file: coverFile,
                        movementId: initialData.movementId,
                    });
                }

                return initialData.movementId;
            }

            const { movementId } = await createMovement(
                movementName.trim(),
                description.trim(),
                "dark",
                isPublic ? "Public" : "Private",
            );

            if (!movementId) {
                throw new Error(
                    "Movement created but movement ID was missing.",
                );
            }

            if (coverFile) {
                await uploadMovementImage({ file: coverFile, movementId });
            }

            return movementId;
        })();

        try {
            const movementId = await toast.promise(savePromise, {
                pending: isEditMode
                    ? "Updating movement..."
                    : "Saving movement...",
                success: isEditMode ? "Movement updated." : "Movement saved.",
                error: {
                    render({ data }) {
                        return (
                            data?.message ||
                            (isEditMode
                                ? "Failed to update movement. Try again."
                                : "Failed to create movement. Try again.")
                        );
                    },
                },
            });

            if (isEditMode) {
                navigate("/mymovements", {
                    replace: true,
                    state: { toastMessage: "Movement updated successfully." },
                });
                return;
            }

            showMovementCreatedToast(movementId);
            resetForm();
        } finally {
            setIsSaving(false);
        }
    };

    const displayedCoverUrl = coverPreviewUrl || existingCoverUrl;

    return (
        <section className="rounded-[2rem] border border-white bg-gradient-to-br from-[#fff7ef] via-white to-[#fff2f7] shadow-xl shadow-orange-100/60">
            <ToastContainer position="top-right" />
            <div className="px-6 py-8 sm:px-8 lg:px-10">
                <div className="mb-8">
                    <h1 className="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">
                        {isEditMode ? "Edit Movement" : "Create Movement"}
                    </h1>
                    <p className="text-slate-500 mt-2 text-sm sm:text-base">
                        {isEditMode
                            ? "Update your movement details and keep your community informed."
                            : "Start a new community and share a clear goal people can rally behind."}
                    </p>
                </div>

                {isPrefillLoading ? (
                    <div className="mb-5 rounded-xl border border-orange-100 bg-orange-50/60 px-4 py-3 text-sm text-slate-600">
                        Loading movement details...
                    </div>
                ) : null}

                {prefillError ? (
                    <div className="mb-5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-600">
                        {prefillError}
                    </div>
                ) : null}

                <form className="space-y-6" onSubmit={handleSubmit}>
                    <div className="space-y-2">
                        <label className="text-sm font-bold text-slate-700 ml-1">
                            Movement Name
                        </label>
                        <input
                            type="text"
                            placeholder="e.g. Environmental Awareness 2026"
                            value={movementName}
                            onChange={(event) =>
                                setMovementName(event.target.value)
                            }
                            className="w-full px-4 py-3 rounded-xl border border-orange-100 bg-white/90 focus:ring-2 focus:ring-orange-300 focus:border-transparent transition-all outline-none"
                        />
                    </div>

                    <div className="space-y-2">
                        <label className="text-sm font-bold text-slate-700 ml-1">
                            Goal or Objective
                        </label>
                        <textarea
                            placeholder="Describe the purpose of this movement..."
                            rows="4"
                            value={description}
                            onChange={(event) =>
                                setDescription(event.target.value)
                            }
                            className="w-full px-4 py-3 rounded-xl border border-orange-100 bg-white/90 focus:ring-2 focus:ring-orange-300 focus:border-transparent transition-all outline-none resize-none"
                        />
                    </div>

                    <div className="space-y-2">
                        <label className="text-sm font-bold text-slate-700 ml-1">
                            Upload Cover Photo
                        </label>
                        <label
                            className={`relative flex flex-col items-center justify-center w-full h-40 overflow-hidden border-2 border-dashed rounded-xl cursor-pointer transition-colors ${
                                dragActive
                                    ? "border-orange-500 bg-orange-50"
                                    : "border-orange-200 bg-white/80 hover:bg-orange-50"
                            }`}
                            onDragEnter={(event) => {
                                event.preventDefault();
                                setDragActive(true);
                            }}
                            onDragOver={(event) => {
                                event.preventDefault();
                                setDragActive(true);
                            }}
                            onDragLeave={(event) => {
                                event.preventDefault();
                                setDragActive(false);
                            }}
                            onDrop={(event) => {
                                event.preventDefault();
                                setDragActive(false);
                                const file =
                                    event.dataTransfer?.files?.[0] || null;
                                if (file && file.type.startsWith("image/")) {
                                    setCoverFile(file);
                                } else {
                                    toast.error(
                                        "Please drop a valid image file.",
                                    );
                                }
                            }}
                        >
                            {displayedCoverUrl ? (
                                <>
                                    <img
                                        src={displayedCoverUrl}
                                        alt="Movement cover preview"
                                        className="absolute inset-0 h-full w-full object-cover"
                                    />
                                    {coverFile ? (
                                        <div className="absolute inset-x-0 bottom-0 bg-black/50 px-3 py-2 text-xs text-white truncate">
                                            {coverFile.name}
                                        </div>
                                    ) : null}
                                </>
                            ) : (
                                <div className="flex flex-col items-center justify-center pt-5 pb-6">
                                    <Camera className="w-8 h-8 text-orange-400 mb-2" />
                                    <p className="text-sm text-slate-500">
                                        <span className="font-semibold text-orange-600">
                                            Click to upload
                                        </span>{" "}
                                        or drag and drop
                                    </p>
                                </div>
                            )}
                            <input
                                type="file"
                                className="hidden"
                                accept="image/*"
                                onChange={(event) => {
                                    const file =
                                        event.target.files?.[0] || null;
                                    if (
                                        file &&
                                        !file.type.startsWith("image/")
                                    ) {
                                        toast.error(
                                            "Please select a valid image file.",
                                        );
                                        return;
                                    }
                                    setCoverFile(file);
                                }}
                            />
                        </label>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button
                            type="button"
                            onClick={() => setIsPublic(true)}
                            disabled={isSaving}
                            className={`flex items-center justify-center gap-3 p-4 rounded-xl border-2 transition-all ${
                                isPublic
                                    ? "border-orange-500 bg-orange-50 text-orange-700"
                                    : "border-orange-100 bg-white text-slate-500 hover:border-orange-200"
                            }`}
                        >
                            <Globe size={20} />
                            <span className="font-semibold">Public</span>
                        </button>

                        <button
                            type="button"
                            onClick={() => setIsPublic(false)}
                            disabled={isSaving}
                            className={`flex items-center justify-center gap-3 p-4 rounded-xl border-2 transition-all ${
                                !isPublic
                                    ? "border-orange-500 bg-orange-50 text-orange-700"
                                    : "border-orange-100 bg-white text-slate-500 hover:border-orange-200"
                            }`}
                        >
                            <Lock size={20} />
                            <span className="font-semibold">Private</span>
                        </button>
                    </div>

                    <button
                        type="submit"
                        disabled={isSaving || (isEditMode && isPrefillLoading)}
                        className="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-orange-200 transition-transform active:scale-[0.98] flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <Save size={20} />
                        {isSaving
                            ? isEditMode
                                ? "Updating..."
                                : "Saving..."
                            : isEditMode
                              ? "Update Movement"
                              : "Save Movement"}
                    </button>
                </form>
            </div>
        </section>
    );
};

export default MovementForm;
