import React from 'react';
import { useUser } from "../../context/UserContext";
import ProfileHeader from "../../components/profile/ProfileHeader";
import ProfilePosts from "../../components/profile/ProfilePosts";
import EditProfileForm from "../../components/profile/EditProfileForm";
import ChangePasswordForm from "../../components/profile/ChangePasswordForm";
import SuggestedReels from "../../components/common/SuggestedReels";
import { AnimatePresence } from 'framer-motion';

const MyProfilePage = () => {
    const { profile, isLoading, refreshProfile } = useUser();
    const [isEditing, setIsEditing] = React.useState(false);
    const [isChangingPassword, setIsChangingPassword] = React.useState(false);

    if (isLoading) {
        return (
            <div className="flex items-center justify-center min-h-[400px]">
                <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
            </div>
        );
    }

    return (
        <div className="flex flex-col gap-6 animate-in fade-in duration-700">
            {/* Profile Header (Cover, Avatar, Name, Buttons) */}
            <ProfileHeader 
                user={profile} 
                onEditClick={() => setIsEditing(true)} 
                onChangePasswordClick={() => setIsChangingPassword(true)}
            />
            
            {/* Main Content Area */}
            <div className="flex flex-col lg:flex-row gap-6 xl:gap-10 lg:justify-center">
                {/* Posts Column */}
                <div className="w-full max-w-2xl xl:max-w-3xl order-2 lg:order-1 shrink-0">
                    <ProfilePosts user={profile} />
                </div>

                {/* Info Column -> Now Suggested Reels */}
                <div className="order-1 lg:order-2 lg:w-80 xl:w-[350px] shrink-0 lg:sticky lg:top-24 self-start">
                    <SuggestedReels />
                </div>
            </div>

            {/* Edit Profile Modal */}
            <AnimatePresence>
                {isEditing && (
                    <EditProfileForm 
                        user={profile} 
                        onCancel={() => setIsEditing(false)} 
                        onSaveSuccess={async () => {
                            await refreshProfile();
                            setIsEditing(false);
                        }}
                    />
                )}

                {isChangingPassword && (
                    <ChangePasswordForm 
                        onCancel={() => setIsChangingPassword(false)} 
                    />
                )}
            </AnimatePresence>
        </div>
    );
};

export default MyProfilePage;