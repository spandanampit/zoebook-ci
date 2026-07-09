/**
 * Extracts just the filename from a full CloudFront/S3 URL.
 *
 * Example:
 *   Input:  "https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/bob-20241125024419981365.jpg"
 *   Output: "bob-20241125024419981365.jpg"
 *
 * @param {string} url - The full file URL (CloudFront, S3, etc.)
 * @returns {string} The bare filename without path or query params.
 */
export function extractFileName(url) {
    if (!url || typeof url !== "string") return "";

    try {
        const parsed = new URL(url);
        const pathname = parsed.pathname; // e.g. "/compress_profile_image/bob-202411.jpg"
        const segments = pathname.split("/").filter(Boolean);
        return segments.length > 0 ? segments[segments.length - 1] : "";
    } catch {
        // Fallback for non-URL strings: take everything after last "/"
        const lastSlash = url.lastIndexOf("/");
        return lastSlash >= 0 ? url.substring(lastSlash + 1) : url;
    }
}
