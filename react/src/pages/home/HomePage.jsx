import React from 'react';
import HomePosts from "../../components/home/HomePosts";
import SuggestedReels from "../../components/common/SuggestedReels";
import { useUser } from "../../context/UserContext";

const HomePage = () => {
    const { isLoading } = useUser();

    if (isLoading) {
        return (
            <div className="flex items-center justify-center min-h-[400px]">
                <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
            </div>
        );
    }

    return (
        <div className="flex flex-col gap-6 animate-in fade-in duration-700">
            {/* Main Content Area */}
            <div className="flex flex-col lg:flex-row gap-6 xl:gap-10 lg:justify-center">
                {/* Posts Column */}
                <div className="w-full max-w-2xl xl:max-w-3xl order-2 lg:order-1 shrink-0">
                    <HomePosts />
                </div>

                {/* Suggested Reels Column */}
                <div className="order-1 lg:order-2 lg:w-80 xl:w-[350px] shrink-0 lg:sticky lg:top-24 self-start">
                    <SuggestedReels />
                </div>
            </div>
        </div>
    );
};

export default HomePage;
