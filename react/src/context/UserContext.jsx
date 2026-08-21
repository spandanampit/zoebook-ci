/* eslint-disable react-refresh/only-export-components */
import { createContext, useContext, useEffect, useState } from "react";
import { ACTIVE_USER_ID } from "../config/siteConfig";
import { fetchProfileAPI } from "../services/movementService";

const UserContext = createContext();

export const UserProvider = ({ children }) => {
    const [profile, setProfile] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const loadProfile = async () => {
            try {
                const res = await fetchProfileAPI();
                const data = Array.isArray(res?.data) ? res.data[0] : res?.data;
                const posts = Number(data?.post_count) || 0;
                const followers = Number(data?.follower_count) || 0;
                const following = Number(data?.following_count) || 0;
                setProfile(
                    !data
                        ? null
                        : {
                              id: data.u_users_id || ACTIVE_USER_ID,
                              name: data.u_name || "Unknown User",
                              profileImage:
                                  data.u_profile_image ||
                                  data.u_profile_image_firebase ||
                                  "",
                              membership: `Posts ${posts} | Followers ${followers} | Following ${following}`,
                              email: data.u_email || "",
                              phone: data.u_phone || "",
                              coverPhoto: data.u_cover_photo || "",
                          },
                );
            } catch {
                console.error("Failed to load profile");
            } finally {
                setIsLoading(false);
            }
        };

        loadProfile();
    }, []);

    return (
        <UserContext.Provider value={{ profile, isLoading }}>
            {children}
        </UserContext.Provider>
    );
};

export const useUser = () => useContext(UserContext);
