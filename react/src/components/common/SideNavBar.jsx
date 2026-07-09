import React from 'react';
import { motion } from 'framer-motion';
import { NavLink } from 'react-router-dom';
import { FALLBACK_IMAGE, SITE_URL } from '../../config/siteConfig';
import { 
  Flame, 
  Music, 
  ListMusic, 
  EyeOff, 
  MessageSquare, 
  Bell, 
  UserMinus,
  User,
} from 'lucide-react';

const isProduction = import.meta.env.VITE_PROJECT_ENVIRONMENT === "PRODUCTION";

const SidebarMenu = ({ user, isLoading }) => {
  const currentUser = user ?? {
    name: "User",
    profileImage: "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=200&h=200"
  };

  const menuItems = [
    { icon: User,        label: 'Profile',               to: '/profile', isInternal: true },
    { icon: Flame,       label: 'Viral Post',            to: isProduction ? SITE_URL + '/viral-posts.html' : '/viral-posts',      isInternal: !isProduction ? true : false  },
    { icon: Music,       label: 'Music',                 to: isProduction ? SITE_URL + '/music.html' : '/music',      isInternal: !isProduction ? true : false },
    { icon: ListMusic,   label: 'My Playlist',           to: isProduction ? SITE_URL + '/my-playlist.html' : '/playlist',   isInternal: !isProduction ? true : false },
    { icon: Flame,       label: 'More Viral Posts',      to: '/watchvideo', isInternal: true},
    { icon: EyeOff,      label: 'Hidden Post',           to: isProduction ? SITE_URL + '/hidden-posts.html' : '/hidden-posts',     isInternal: !isProduction ? true : false },
    // { icon: MessageSquare, label: 'Chat',            to: !isProduction ? SITE_URL + '/chat.html' : '/chat',       isInternal: !isProduction ? true : false },
    // { icon: Bell,        label: 'Notification',      to: !isProduction ? SITE_URL + '/notification.html' : '/notifications', isInternal: !isProduction ? true : false, badge: 0 },
    // { icon: UserMinus,   label: 'Blocked Users',     to: !isProduction ? SITE_URL + '/blocked.html' : '/blocked',    isInternal: !isProduction ? true : false },
  ];

  return (
    <motion.div 
      initial={{ opacity: 0, x: -20 }}
      animate={{ opacity: 1, x: 0 }}
      className="w-full bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 overflow-hidden pb-8 border border-white"
    >
        {/* Header / Profile Section */}
        <div className="flex flex-col items-center pt-10 pb-6 px-6">
          <div className="relative mb-4">
            <div className="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-100 shadow-sm">
              <img 
                src={currentUser.profileImage} 
                alt="Profile" 
                className="w-full h-full object-cover"
                onError={(e) => {
                    e.target.src = FALLBACK_IMAGE;
                }}
              />
            </div>
          </div>
          <h2 className="text-xl font-bold text-slate-700 tracking-tight">
            {currentUser.name}
          </h2>
        </div>

        <div className="px-8">
          <hr className="border-gray-100 mb-6" />
        </div>

        {/* Navigation Items */}
        <nav className="px-6 space-y-1">
          {menuItems.map((item, index) => (
            item.isInternal ? (
              <NavLink
                key={index}
                to={item.to}
                className={({ isActive }) =>
                  `group flex items-center gap-4 px-4 py-3 rounded-lg transition-colors ${
                    isActive
                      ? 'bg-purple-50'
                      : 'hover:bg-gray-50'
                  }`
                }
              >
                {({ isActive }) => (
                  <>
                    <div className="relative">
                      <item.icon 
                        size={22} 
                        className={`${isActive ? 'text-purple-600' : 'text-gray-400'} group-hover:text-purple-500 transition-colors`} 
                      />
                      {item.badge !== undefined && (
                        <span className="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                          {item.badge}
                        </span>
                      )}
                    </div>
                    <span className={`text-[15px] font-medium ${
                      isActive ? 'text-purple-600' : 'text-gray-500'
                    } group-hover:text-gray-800`}>
                      {item.label}
                    </span>
                  </>
                )}
              </NavLink>
            ) : (
              <a
                key={index}
                href={item.to}
                className="group flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-gray-50"
              >
                <div className="relative">
                  <item.icon 
                    size={22} 
                    className="text-gray-400 group-hover:text-purple-500 transition-colors" 
                  />
                  {item.badge !== undefined && (
                    <span className="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                      {item.badge}
                    </span>
                  )}
                </div>
                <span className="text-[15px] font-medium text-gray-500 group-hover:text-gray-800">
                  {item.label}
                </span>
              </a>
            )
          ))}
        </nav>
      </motion.div>
  );
};

export default SidebarMenu;