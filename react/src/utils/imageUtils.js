import { FALLBACK_IMAGE } from "../config/siteConfig";

export const getDirectImageUrl = (url) => {
    if (!url) return url;
    
    // Check if it's an image_resize URL containing base64 pic parameter
    if (url.includes('image_resize') && url.includes('pic=')) {
        try {
            const picIndex = url.indexOf('pic=');
            let picValue = url.substring(picIndex + 4);
            const ampIndex = picValue.indexOf('&');
            if (ampIndex !== -1) {
                picValue = picValue.substring(0, ampIndex);
            }
            if (picValue) {
                const decoded = atob(picValue);
                if (decoded && decoded.startsWith('http')) {
                    return decoded;
                }
            }
        } catch (e) {
            console.error("Failed to decode image_resize URL:", e);
        }
    }
    return url;
};

export const getFullProfileImageUrl = (url) => {
    if (!url) return FALLBACK_IMAGE;
    
    // Resolve image_resize redirect/pic encoding if any
    url = getDirectImageUrl(url);
    
    if (url.startsWith('data:image')) {
        return url;
    }
    
    if (url.startsWith('http')) {
        return url;
    }
    
    const isBase64 = !url.includes('.') && url.length > 50;
    if (isBase64) {
        return `data:image/jpeg;base64,${url}`;
    }
    
    return `https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${url}`;
};
