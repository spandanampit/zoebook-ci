/* eslint-disable react-refresh/only-export-components */
import { createContext, useContext, useEffect, useState } from "react";
import { ACTIVE_USER_ID } from "../config/siteConfig";
import { fetchProfileAPI } from "../services/movementService";
import { getFullProfileImageUrl } from "../utils/imageUtils";

const UserContext = createContext();

const CACHE_KEY = "zoebook_profile_cache_v3"; // Incremented version to force refresh
const CACHE_DURATION = 12 * 60 * 60 * 1000; // 12 hours in milliseconds

export const UserProvider = ({ children }) => {
    const [profile, setProfile] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const loadProfile = async () => {
            try {
                // Fetch fresh from API every time on load (Cache disabled as per request)
                // But we still cache the result for other components
                const res = await fetchProfileAPI();
                const rawData = Array.isArray(res?.data) ? res.data[0] : res?.data;

                if (rawData) {
                    const posts = Number(rawData.post_count) || 0;
                    const followers = Number(rawData.follower_count) || 0;
                    const following = Number(rawData.following_count) || 0;
                    
                    const profileData = {
                        id: rawData.u_users_id || ACTIVE_USER_ID,
                        name: rawData.u_name || "Unknown User",
                        profileImage: getFullProfileImageUrl(rawData.u_profile_image || rawData.u_profile_image_firebase),
                        coverPhoto: rawData.u_cover_photo || "",
                        email: rawData.u_email || "",
                        phone: rawData.u_phone || "",
                        aboutMe: rawData.u_about_me || rawData.about_me || "",
                        stats: {
                            posts,
                            followers,
                            following
                        },
                        membership: `Posts ${posts} | Followers ${followers} | Following ${following}`,
                        raw: rawData
                    };

                    // Update State and Refresh Cache
                    setProfile(profileData);
                    localStorage.setItem(CACHE_KEY, JSON.stringify({
                        data: profileData,
                        timestamp: Date.now()
                    }));
                }
            } catch (error) {
                console.error("Failed to load profile", error);
            } finally {
                setIsLoading(false);
            }
        };

        loadProfile();
    }, []);

    const refreshProfile = async () => {
        setIsLoading(true);
        try {
            const res = await fetchProfileAPI();
            const rawData = Array.isArray(res?.data) ? res.data[0] : res?.data;

            if (rawData) {
                const posts = Number(rawData.post_count) || 0;
                const followers = Number(rawData.follower_count) || 0;
                const following = Number(rawData.following_count) || 0;
                
                const profileData = {
                    id: rawData.u_users_id || ACTIVE_USER_ID,
                    name: rawData.u_name || "Unknown User",
                    profileImage: getFullProfileImageUrl(rawData.u_profile_image || rawData.u_profile_image_firebase),
                    coverPhoto: rawData.u_cover_photo || "",
                    email: rawData.u_email || "",
                    phone: rawData.u_phone || "",
                    aboutMe: rawData.u_about_me || rawData.about_me || "",
                    stats: {
                        posts,
                        followers,
                        following
                    },
                    membership: `Posts ${posts} | Followers ${followers} | Following ${following}`,
                    raw: rawData
                };

                setProfile(profileData);
                localStorage.setItem(CACHE_KEY, JSON.stringify({
                    data: profileData,
                    timestamp: Date.now()
                }));
            }
        } catch (error) {
            console.error("Failed to refresh profile", error);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <UserContext.Provider value={{ profile, isLoading, refreshProfile }}>
            {children}
        </UserContext.Provider>
    );
};

export const useUser = () => useContext(UserContext);
