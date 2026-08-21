import axios from "axios";
import { getPresignedUrls } from "../services/postService";

export async function uploadVideoToS3(file, onProgress) {
    if (!file) {
        throw new Error("No file provided for upload.");
    }

    let presignedData;
    try {
        presignedData = await getPresignedUrls({
            fileName: file.name,
            fileType: file.type,
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
