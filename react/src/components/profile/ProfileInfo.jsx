import React from 'react';
import { Mail, Phone, Shield, Bell, MapPin, Calendar } from 'lucide-react';

const ProfileInfo = ({ user }) => {
  const details = [
    { icon: Mail, label: 'Email', value: user?.email || 'Not provided' },
    { icon: Phone, label: 'Phone', value: user?.phone || 'Not provided' },
    { icon: Shield, label: 'Privacy', value: user?.raw?.u_privacy === "0" ? 'Public' : 'Private' },
    { icon: Bell, label: 'Notifications', value: user?.raw?.u_notification_pref === "1" ? 'Enabled' : 'Disabled' },
  ];

  return (
    <div className="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col gap-6 h-fit shrink-0 w-full lg:w-80">
      <h3 className="text-xl font-bold text-gray-800 px-2">Info</h3>
      
      <div className="flex flex-col gap-4">
        {details.map((detail, idx) => (
          <div key={idx} className="flex items-start gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors">
            <div className="bg-orange-50 text-orange-500 p-2.5 rounded-xl">
              <detail.icon size={20} />
            </div>
            <div className="flex flex-col">
              <span className="text-xs text-gray-400 font-semibold uppercase">{detail.label}</span>
              <span className="text-sm text-gray-700 font-medium break-all">{detail.value}</span>
            </div>
          </div>
        ))}
      </div>

      <div className="px-2 pt-2">
        <button className="w-full py-3 bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-2xl text-sm font-bold transition-all">
          View Detailed Profile
        </button>
      </div>
    </div>
  );
};

export default ProfileInfo;
