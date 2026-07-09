/**
 * Video Thumbnail Utility
 *
 * Captures a frame from a video File (or Blob) and returns it as a File object.
 * Reusable across the entire React application wherever video thumbnail
 * generation is needed.
 *
 * @module utils/videoThumbnail
 */

/**
 * Default time (in seconds) at which to capture the thumbnail frame.
 * Using 1 second avoids the common blank first-frame problem.
 */
const DEFAULT_CAPTURE_TIME = 1;

/**
 * Default JPEG quality for the exported thumbnail (0 – 1).
 */
const DEFAULT_QUALITY = 0.8;

/**
 * Generate a thumbnail image from a video file.
 *
 * How it works:
 *  1. Creates an object URL from the video File/Blob.
 *  2. Loads the video in a hidden <video> element and seeks to `captureTime`.
 *  3. Draws the current frame onto an off-screen <canvas>.
 *  4. Exports the canvas as a JPEG Blob, then wraps it in a File.
 *
 * @param {File|Blob} videoFile     - The source video file.
 * @param {object}    [options]     - Optional configuration.
 * @param {number}    [options.captureTime=1]   - Seek position in seconds.
 * @param {number}    [options.quality=0.8]     - JPEG quality (0 – 1).
 * @param {number}    [options.maxWidth]        - Max thumbnail width (px). Keeps aspect ratio.
 * @param {number}    [options.maxHeight]       - Max thumbnail height (px). Keeps aspect ratio.
 * @returns {Promise<{ file: File, width: number, height: number }>}
 *   Resolves with the thumbnail File (JPEG), plus its pixel dimensions.
 */
export function generateVideoThumbnail(videoFile, options = {}) {
    const {
        captureTime = DEFAULT_CAPTURE_TIME,
        quality = DEFAULT_QUALITY,
        maxWidth,
        maxHeight,
    } = options;

    return new Promise((resolve, reject) => {
        if (!videoFile) {
            return reject(new Error("No video file provided for thumbnail generation."));
        }

        const objectUrl = URL.createObjectURL(videoFile);
        const video = document.createElement("video");

        // Required for cross-origin & iOS inline playback
        video.crossOrigin = "anonymous";
        video.playsInline = true;
        video.muted = true;
        video.preload = "auto";

        /** Clean up DOM resources after we're done. */
        const cleanup = () => {
            URL.revokeObjectURL(objectUrl);
            video.removeAttribute("src");
            video.load(); // release browser memory
        };

        video.addEventListener("error", () => {
            cleanup();
            reject(new Error("Failed to load video for thumbnail generation."));
        });

        video.addEventListener("loadedmetadata", () => {
            // Clamp seek time to the video's duration
            const seekTo = Math.min(captureTime, video.duration || 0);
            video.currentTime = seekTo;
        });

        video.addEventListener("seeked", () => {
            try {
                // ── Determine canvas size ──────────────────────────────
                let drawWidth = video.videoWidth;
                let drawHeight = video.videoHeight;

                if (maxWidth && drawWidth > maxWidth) {
                    drawHeight = Math.round(drawHeight * (maxWidth / drawWidth));
                    drawWidth = maxWidth;
                }
                if (maxHeight && drawHeight > maxHeight) {
                    drawWidth = Math.round(drawWidth * (maxHeight / drawHeight));
                    drawHeight = maxHeight;
                }

                // ── Draw frame to canvas ───────────────────────────────
                const canvas = document.createElement("canvas");
                canvas.width = drawWidth;
                canvas.height = drawHeight;

                const ctx = canvas.getContext("2d");
                ctx.drawImage(video, 0, 0, drawWidth, drawHeight);

                // ── Export as JPEG Blob → File ─────────────────────────
                canvas.toBlob(
                    (blob) => {
                        cleanup();

                        if (!blob) {
                            return reject(
                                new Error("Canvas toBlob returned null – thumbnail creation failed."),
                            );
                        }

                        // Build a descriptive filename based on the original video name
                        const baseName = videoFile.name
                            ? videoFile.name.replace(/\.[^.]+$/, "")
                            : "video";
                        const thumbnailFileName = `${baseName}_thumb_${Date.now()}.jpg`;

                        const thumbnailFile = new File([blob], thumbnailFileName, {
                            type: "image/jpeg",
                        });

                        resolve({
                            file: thumbnailFile,
                            width: drawWidth,
                            height: drawHeight,
                        });
                    },
                    "image/jpeg",
                    quality,
                );
            } catch (err) {
                cleanup();
                reject(err);
            }
        });

        video.src = objectUrl;
    });
}

/**
 * Check whether a given File/Blob is a video type.
 *
 * @param {File|Blob} file
 * @returns {boolean}
 */
export function isVideoFile(file) {
    if (!file) return false;
    return file.type?.startsWith("video/");
}
