import axios from "axios";
import { getPresignedUrls } from "../services/postService";

/**
 * Core upload helper — gets a presigned URL and PUTs the file to S3.
 *
 * This is the low-level, reusable function used by every upload path.
 *
 * @param {File|Blob} file         - The file to upload.
 * @param {function}  [onProgress] - Optional upload-progress callback (0-100).
 * @returns {Promise<string>} The public file URL (e.g. CloudFront URL).
 */
export async function uploadFileToS3(file, typeOrProgress, onProgressArg) {
    if (!file) {
        throw new Error("No file provided for upload.");
    }

    // Handle polyfill for old signature: (file, onProgress)
    let type = "post";
    let onProgress = onProgressArg;

    if (typeof typeOrProgress === "string") {
        type = typeOrProgress;
    } else if (typeof typeOrProgress === "function") {
        onProgress = typeOrProgress;
    }

    let presignedData;
    try {
        presignedData = await getPresignedUrls({
            fileName: file.name,
            fileType: file.type,
            type: type,
        });
    } catch (error) {
        console.error("Failed to get presigned URL for S3 upload:", error);
        throw new Error("Unable to get upload URL. Please try again.");
    }

    const uploadUrl = presignedData?.uploadUrl;
    const fileUrl = presignedData?.fileUrl;

    if (!uploadUrl || !fileUrl) {
        console.error("Invalid presigned URL response:", presignedData);
        throw new Error("Received invalid upload data from server.");
    }

    try {
        await axios.put(uploadUrl, file, {
            onUploadProgress: (progressEvent) => {
                if (!progressEvent?.total || typeof onProgress !== "function") {
                    return;
                }

                const percent = Math.round(
                    (progressEvent.loaded * 100) / progressEvent.total,
                );
                onProgress(percent);
            },
        });
    } catch (error) {
        console.error("Failed to upload file to S3:", error);

        if (error?.message === "Network Error") {
            throw new Error(
                "Upload blocked by S3 CORS policy. Allow your frontend origin and PUT method in bucket CORS.",
            );
        }

        if (error?.response?.status === 403) {
            throw new Error(
                "S3 rejected upload (403). Presigned URL may be expired or signature settings do not match.",
            );
        }

        throw new Error("S3 upload failed. Please try again.");
    }

    return fileUrl;
}

/**
 * Upload a video (or any file) to S3 — backwards-compatible wrapper.
 *
 * Existing call-sites that import `uploadVideoToS3` keep working with
 * zero changes.
 *
 * @param {File}     file         - The file to upload.
 * @param {function} [onProgress] - Optional progress callback (0-100).
 * @returns {Promise<string>} The public file URL.
 */
export async function uploadVideoToS3(file, onProgress) {
    return uploadFileToS3(file, "post", onProgress);
}
