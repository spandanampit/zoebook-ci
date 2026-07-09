/**
 * Thumbnail Upload Utility
 *
 * Generates a thumbnail from a video file and uploads it to S3
 * via a presigned URL.  Returns the uploaded thumbnail's filename
 * so it can be stored in the database.
 *
 * Reusable across the entire React application wherever video
 * thumbnail upload is needed.
 *
 * @module utils/uploadThumbnail
 */

import { generateVideoThumbnail, isVideoFile } from "./videoThumbnail";
import { uploadFileToS3 } from "./uploadToS3";
import { extractFileName } from "./fileHelpers";

/**
 * Generate a video thumbnail, upload it to S3, and return the filename.
 *
 * @param {File}   videoFile                  - The original video File.
 * @param {object} [options]                  - Optional settings.
 * @param {number} [options.captureTime=1]    - Seek time in seconds.
 * @param {number} [options.quality=0.8]      - JPEG quality 0–1.
 * @param {number} [options.maxWidth]         - Max width in px.
 * @param {number} [options.maxHeight]        - Max height in px.
 * @returns {Promise<{ thumbnailFileName: string, thumbnailUrl: string, width: number, height: number }>}
 *   Resolves with the bare filename (for DB storage), the full URL,
 *   and the thumbnail's pixel dimensions.
 */
export async function generateAndUploadThumbnail(videoFile, options = {}) {
    if (!videoFile) {
        throw new Error("No video file provided.");
    }

    if (!isVideoFile(videoFile)) {
        throw new Error("Provided file is not a video.");
    }

    // 1. Capture a frame from the video
    const { file: thumbnailFile, width, height } = await generateVideoThumbnail(
        videoFile,
        options,
    );

    // 2. Upload the thumbnail image to S3 (no progress tracking needed)
    const thumbnailUrl = await uploadFileToS3(thumbnailFile);

    // 3. Extract just the filename from the full S3/CloudFront URL
    const thumbnailFileName = extractFileName(thumbnailUrl);

    return { thumbnailFileName, thumbnailUrl, width, height };
}
