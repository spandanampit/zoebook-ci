import { useState, useCallback, useRef } from "react";
import { toast } from "react-toastify";
import { ACTIVE_USER_ID } from "../config/siteConfig";
import { uploadVideoToS3 } from "../utils/uploadToS3";
import { addPost, addPostMedia, compressJob } from "../services/postService";
import { extractFileName } from "../utils/fileHelpers";
import { isVideoFile } from "../utils/videoThumbnail";
import { generateAndUploadThumbnail } from "../utils/uploadThumbnail";

/**
 * Custom hook that orchestrates the full movement-post creation workflow:
 *   1. Close modal immediately and start background upload
 *   2. Upload the file to S3 via presigned URL (with progress)
 *   3. If the file is a video, generate & upload a thumbnail to S3
 *   4. Call addPost → get the new post_id
 *   5. Call addPostMedia with the post_id + uploaded filename + thumbnail
 *   6. Show a persistent toast with progress that survives navigation
 *
 * @param {object}   options
 * @param {string|number} options.movementId - Current movement ID.
 * @param {function} [options.onSuccess]     - Callback after everything succeeds.
 * @returns {{ submitPost, isSubmitting, uploadProgress }}
 */
export function useCreateMovementPost({ movementId, onSuccess } = {}) {
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [uploadProgress, setUploadProgress] = useState(0);
    const toastIdRef = useRef(null);

    const submitPost = useCallback(
        async ({ file, description }) => {
            if (!file && !description?.trim()) return;

            setIsSubmitting(true);
            setUploadProgress(0);

            // ── Show a persistent progress toast ──────────────────
            toastIdRef.current = toast.loading("Preparing upload...", {
                position: "bottom-right",
                closeOnClick: false,
                draggable: false,
            });

            // Wrap the entire pipeline in a promise so we can catch & toast errors
            const uploadPipeline = (async () => {
                // ── Step 1: Upload file to S3 ──────────────────────────
                let uploadedFileUrl = "";
                if (file) {
                    uploadedFileUrl = await uploadVideoToS3(file, (progress) => {
                        setUploadProgress(progress);

                        // Live-update the toast text with progress percentage
                        if (toastIdRef.current !== null) {
                            toast.update(toastIdRef.current, {
                                render: `Uploading file... ${progress}%`,
                            });
                        }
                    });

                    if (isVideoFile(file) && uploadedFileUrl) {
                        try {
                            const urlObj = new URL(uploadedFileUrl);
                            const s3Key = urlObj.pathname.startsWith("/") 
                                ? urlObj.pathname.substring(1) 
                                : urlObj.pathname;
                            
                            await compressJob(s3Key);
                        } catch (err) {
                            console.warn("Failed to queue compression job:", err);
                        }
                    }
                }

                // Update toast — file uploaded, now processing
                if (toastIdRef.current !== null) {
                    toast.update(toastIdRef.current, {
                        render: "Processing post...",
                    });
                }

                // ── Step 2: Generate & upload thumbnail (video only) ───
                let thumbnailFileName = "";
                if (file && isVideoFile(file)) {
                    try {
                        if (toastIdRef.current !== null) {
                            toast.update(toastIdRef.current, {
                                render: "Generating thumbnail...",
                            });
                        }
                        const thumbResult = await generateAndUploadThumbnail(file);
                        thumbnailFileName = thumbResult.thumbnailFileName;
                    } catch (thumbError) {
                        // Thumbnail failure should NOT block the post creation
                        console.warn(
                            "Thumbnail generation/upload failed (continuing without thumbnail):",
                            thumbError,
                        );
                    }
                }

                const postType = file ? "Media" : "Text";
                const trimmedDescription = (description || "").trim();

                // ── Step 3: Create post record in DB ───────────────────
                if (toastIdRef.current !== null) {
                    toast.update(toastIdRef.current, {
                        render: "Saving post...",
                    });
                }

                const addPostResponse = await addPost({
                    user_id: ACTIVE_USER_ID,
                    post_type: postType,
                    post_text: trimmedDescription,
                    visibility: "Movement",
                    post_text_emoji: trimmedDescription,
                    movement_id: Number(movementId),
                });

                if (!addPostResponse || addPostResponse.success !== 1) {
                    throw new Error(
                        addPostResponse?.message ||
                            "Failed to create post in database.",
                    );
                }

                // Extract the post_id from the response data array
                const insertRow = Array.isArray(addPostResponse.data)
                    ? addPostResponse.data[0]
                    : null;

                const postId = insertRow
                    ? Object.values(insertRow)[0]
                    : null;

                if (!postId) {
                    throw new Error(
                        "Post created but no post ID was returned from the server.",
                    );
                }

                // ── Step 4: Link media to post ─────────────────────────
                if (file && uploadedFileUrl) {
                    const fileName = extractFileName(uploadedFileUrl);
                    const fileType = isVideoFile(file) ? "Video" : "Image";

                    const mediaParams = {
                        post_id: postId,
                        user_id: ACTIVE_USER_ID,
                        file_type: fileType,
                        upload_file: fileName,
                    };

                    // Attach thumbnail filename for video posts
                    if (thumbnailFileName) {
                        mediaParams.video_thumbnail = thumbnailFileName;
                    }

                    const mediaResponse = await addPostMedia(mediaParams);

                    if (!mediaResponse || mediaResponse.success !== 1) {
                        console.warn(
                            "Post created but media linking failed:",
                            mediaResponse?.message,
                        );
                    }
                }

                return { postId, fileUrl: uploadedFileUrl };
            })();

            try {
                const result = await uploadPipeline;

                // ── Success toast ──────────────────────────────────────
                if (toastIdRef.current !== null) {
                    toast.update(toastIdRef.current, {
                        render: "🎉 Post published successfully!",
                        type: "success",
                        isLoading: false,
                        autoClose: 4000,
                        closeOnClick: true,
                        draggable: true,
                    });
                    toastIdRef.current = null;
                }

                if (typeof onSuccess === "function") {
                    onSuccess(result);
                }
            } catch (error) {
                console.error("Movement post submission failed:", error);

                // ── Error toast ────────────────────────────────────────
                if (toastIdRef.current !== null) {
                    toast.update(toastIdRef.current, {
                        render: error?.message || "Post upload failed. Please try again.",
                        type: "error",
                        isLoading: false,
                        autoClose: 5000,
                        closeOnClick: true,
                        draggable: true,
                    });
                    toastIdRef.current = null;
                }
            } finally {
                setIsSubmitting(false);
                setUploadProgress(0);
            }
        },
        [movementId, onSuccess],
    );

    return { submitPost, isSubmitting, uploadProgress };
}
