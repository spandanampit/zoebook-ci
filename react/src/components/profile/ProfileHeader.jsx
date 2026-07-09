import React from 'react';
import { motion } from 'framer-motion';
import { Pencil, Plus, Settings, ShieldCheck, User, Info } from 'lucide-react';
import ProfileInfo from './ProfileInfo';
import { FALLBACK_IMAGE } from '../../config/siteConfig';

const ProfileHeader = ({ user, onEditClick, onChangePasswordClick }) => {
  const stats = [
    { label: 'Post', count: user?.stats?.posts || 0 },
    { label: 'Followers', count: user?.stats?.followers || 0 },
    { label: 'Following', count: user?.stats?.following || 0 },
  ];

  return (
    <div className="w-full bg-white rounded-3xl shadow-sm mb-8 border border-gray-100 relative z-10">
      {/* Cover Image Section */}
      <div className="relative h-64 md:h-80 w-full group rounded-t-3xl overflow-hidden">
        <img
          src={user?.coverPhoto || "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=1600"}
          alt="Cover"
          className="w-full h-full object-cover"
          onError={(e) => {
              e.target.src = "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=1600";
          }}
        />
        <div className="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors" />
        
        {/* Edit Cover Button */}
        <button className="absolute top-4 right-4 bg-orange-400 hover:bg-orange-500 text-white p-2.5 rounded-full shadow-lg transition-all hover:scale-110">
          <Pencil size={18} />
        </button>

        {/* Back Button (matching the arrow in the image) */}
        <button className="absolute top-4 left-4 bg-white/20 backdrop-blur-md hover:bg-white/40 text-white p-2.5 rounded-full transition-all">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7" />
          </svg>
        </button>
      </div>

      {/* Profile Info Section */}
      <div className="px-8 pb-8">
        <div className="relative flex flex-col md:flex-row items-end -translate-y-12 gap-6">
          {/* Profile Image */}
          <motion.div 
            initial={{ scale: 0.9, opacity: 0 }}
            animate={{ scale: 1, opacity: 1 }}
            transition={{ delay: 0.2 }}
            className="relative"
          >
            <div className="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white overflow-hidden shadow-xl bg-white">
              <img
                src={user?.profileImage || FALLBACK_IMAGE}
                alt={user?.name}
                className="w-full h-full object-cover"
                onError={(e) => {
                    e.target.src = FALLBACK_IMAGE;
                }}
              />
            </div>
            <motion.button 
                whileHover={{ scale: 1.1 }}
                whileTap={{ scale: 0.9 }}
                className="absolute bottom-2 right-2 bg-orange-500 text-white p-1.5 rounded-full border-2 border-white shadow-md transition-transform"
            >
              <Plus size={16} />
            </motion.button>
          </motion.div>

          {/* Name and Stats */}
          <div className="flex-1 pb-2">
            <motion.h2 
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ delay: 0.3 }}
                className="text-3xl font-bold text-gray-800 mb-2"
            >
                {user?.name || "Abhisek Saha"}
            </motion.h2>
            <div className="flex items-center gap-6">
              {stats.map((stat, idx) => (
                <motion.div 
                    key={idx} 
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    transition={{ delay: 0.4 + (idx * 0.1) }}
                    className="flex items-center gap-2"
                >
                  <span className="text-orange-500 text-sm font-bold">•</span>
                  <p className="text-gray-500 text-sm">
                    <span className="font-semibold text-gray-700">{stat.label}</span> {stat.count}
                  </p>
                </motion.div>
              ))}
            </div>
          </div>
        </div>

        {/* Action Buttons */}
        <div className="flex flex-wrap gap-4 -mt-6 items-center">
          {[
            { icon: Pencil, label: "Edit profile", action: onEditClick, color: "text-gray-500" },
            { icon: ShieldCheck, label: "Change password", action: onChangePasswordClick, color: "text-gray-500" },
            { icon: User, label: "About Me", color: "text-gray-500", isAboutMe: true }
          ].map((btn, idx) => {
            const buttonElement = (
              <motion.button
                key={btn.isAboutMe ? `btn-${idx}` : idx}
                onClick={btn.action}
                initial={{ opacity: 0, y: 10 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.6 + (idx * 0.1) }}
                whileHover={{ y: -2, backgroundColor: '#f3f4f6' }}
                whileTap={{ scale: 0.98 }}
                className="flex items-center gap-2 bg-gray-100 text-gray-700 px-8 py-3 rounded-full font-semibold transition-all border border-transparent hover:border-gray-200"
              >
                <btn.icon size={18} className={btn.color} />
                {btn.label}
              </motion.button>
            );

            if (btn.isAboutMe) {
              return (
                <div key={idx} className="relative group flex items-center gap-2">
                  {buttonElement}
                  <div className="cursor-pointer p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-500 flex items-center justify-center">
                    <Info size={22} />
                  </div>
                  {/* Hover dropdown for ProfileInfo */}
                  <div className="absolute top-full left-0 mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 w-80 shadow-2xl rounded-3xl">
                    <ProfileInfo user={user} />
                  </div>
                </div>
              );
            }

            return buttonElement;
          })}
        </div>
      </div>
    </div>
  );
};

export default ProfileHeader;
