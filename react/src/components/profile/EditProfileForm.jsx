import React, { useState } from 'react';
import { Camera, Image as ImageIcon, User, Phone, FileText, Loader2, X, Check } from 'lucide-react';
import { updateUserDetails } from '../../services/userService';
import { uploadFileToS3 } from '../../utils/uploadToS3';
import { extractFileName } from '../../utils/fileHelpers';
import { toast } from 'react-toastify';
import { motion } from 'framer-motion';
import ModalPortal from '../common/ModalPortal';
import { FALLBACK_IMAGE } from '../../config/siteConfig';

const EditProfileForm = ({ user, onCancel, onSaveSuccess }) => {
    const [formData, setFormData] = useState({
        user_name: user?.name || "",
        user_phone: user?.phone || "",
        about_me: user?.aboutMe || "",
        profile_image: extractFileName(user?.profileImage) || "",
        cover_photo: extractFileName(user?.coverPhoto) || "",
        platform: "web", // Default platform
        file_type: "image" // Default file type
    });

    const [isSubmitting, setIsSubmitting] = useState(false);
    const [selectedFiles, setSelectedFiles] = useState({
        profile: null,
        cover: null
    });
    const [previews, setPreviews] = useState({
        profile: user?.profileImage || "",
        cover: user?.coverPhoto || ""
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleFileChange = (e, type) => {
        const file = e.target.files[0];
        if (file) {
            setSelectedFiles(prev => ({ ...prev, [type]: file }));
            const reader = new FileReader();
            reader.onloadend = () => {
                setPreviews(prev => ({ ...prev, [type]: reader.result }));
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsSubmitting(true);
        try {
            let finalPayload = { ...formData };

            // Handle Profile Image Upload
            if (selectedFiles.profile) {
                const profileUrl = await uploadFileToS3(selectedFiles.profile, 'profile');
                if (profileUrl) {
                    finalPayload.profile_image = extractFileName(profileUrl);
                }
            }

            // Handle Cover Photo Upload
            if (selectedFiles.cover) {
                const coverUrl = await uploadFileToS3(selectedFiles.cover, 'cover');
                if (coverUrl) {
                    finalPayload.cover_photo = extractFileName(coverUrl);
                }
            }

            const response = await updateUserDetails(finalPayload);
            if (response?.settings?.success === "1" || response?.status === "1" || response?.message?.toLowerCase().includes("success")) {
                toast.success(response?.settings?.message || "Profile updated successfully!");
                onSaveSuccess();
            } else {
                toast.error(response?.settings?.message || response?.message || "Failed to update profile");
            }
        } catch (error) {
            console.error("Update failed", error);
            toast.error(error.message || "An error occurred while updating profile");
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <ModalPortal>
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            {/* Classy Frosted Backdrop */}
            <motion.div 
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                onClick={onCancel}
                className="absolute inset-0 bg-slate-900/40 backdrop-blur-md"
            />

            {/* Modal Container */}
            <motion.div 
                initial={{ opacity: 0, scale: 0.9, y: 20 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.9, y: 20 }}
                className="bg-white rounded-[2.5rem] shadow-2xl border border-white/20 overflow-hidden w-full max-w-2xl relative z-10 max-h-[90vh] flex flex-col"
            >
                {/* Header - Fixed */}
                <div className="p-8 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white shrink-0">
                    <div>
                        <h2 className="text-2xl font-black text-gray-800 tracking-tight">Edit Your Profile</h2>
                        <p className="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">Refine your public identity</p>
                    </div>
                    <button 
                        onClick={onCancel}
                        className="p-2.5 hover:bg-gray-100 rounded-full transition-all text-gray-400 hover:text-gray-900 active:scale-90"
                    >
                        <X size={24} />
                    </button>
                </div>

                {/* Scrollable Form Body */}
                <form onSubmit={handleSubmit} className="overflow-y-auto custom-scrollbar p-8 space-y-8 flex-1">
                    {/* Images Upload Section */}
                    <div className="space-y-6">
                        {/* Cover Photo Upload */}
                        <div className="relative group">
                            <p className="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Cover Landscape</p>
                            <div className="h-40 md:h-48 rounded-3xl overflow-hidden bg-gray-100 relative border-2 border-dashed border-gray-200 group-hover:border-orange-200 transition-colors shadow-inner">
                                <img 
                                    src={previews.cover} 
                                    alt="Cover Preview" 
                                    className="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity"
                                    onError={(e) => { e.target.src = "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=1600"; }}
                                />
                                <label className="absolute inset-0 flex flex-col items-center justify-center cursor-pointer bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity text-white">
                                    <div className="bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/30 mb-2">
                                        <ImageIcon size={24} />
                                    </div>
                                    <span className="text-xs font-bold tracking-wide">Replace Cover</span>
                                    <input 
                                        type="file" 
                                        className="hidden" 
                                        accept="image/*" 
                                        onChange={(e) => handleFileChange(e, 'cover')} 
                                    />
                                </label>
                            </div>
                        </div>

                        {/* Profile Photo Upload */}
                        <div className="flex flex-col items-center -mt-20 relative z-10">
                            <div className="relative group">
                                <div className="w-32 h-32 md:w-36 md:h-36 rounded-full border-8 border-white overflow-hidden shadow-2xl bg-white relative">
                                    <img 
                                        src={previews.profile} 
                                        alt="Profile Preview" 
                                        className="w-full h-full object-cover"
                                        onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
                                    />
                                    <label className="absolute inset-0 flex flex-col items-center justify-center cursor-pointer bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity text-white">
                                        <Camera size={20} />
                                        <input 
                                            type="file" 
                                            className="hidden" 
                                            accept="image/*" 
                                            onChange={(e) => handleFileChange(e, 'profile')} 
                                        />
                                    </label>
                                </div>
                                <div className="absolute bottom-0 right-0 p-2 bg-orange-500 rounded-full border-4 border-white shadow-lg text-white">
                                    <Camera size={14} />
                                </div>
                            </div>
                            <p className="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Profile Avatar</p>
                        </div>
                    </div>

                    {/* Form Fields Section */}
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                        <div className="space-y-2">
                            <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                                <User size={12} className="text-orange-500" /> Full Name
                            </label>
                            <input 
                                type="text" 
                                name="user_name"
                                value={formData.user_name}
                                onChange={handleChange}
                                className="w-full bg-gray-50/50 border-gray-100 rounded-2xl px-5 py-3 text-sm font-semibold focus:ring-4 focus:ring-orange-50 focus:bg-white transition-all outline-none border hover:border-gray-200"
                                placeholder="Display name"
                                required
                            />
                        </div>
                        <div className="space-y-2">
                            <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                                <Phone size={12} className="text-orange-500" /> Phone Number
                            </label>
                            <input 
                                type="tel" 
                                name="user_phone"
                                value={formData.user_phone}
                                onChange={handleChange}
                                className="w-full bg-gray-50/50 border-gray-100 rounded-2xl px-5 py-3 text-sm font-semibold focus:ring-4 focus:ring-orange-50 focus:bg-white transition-all outline-none border hover:border-gray-200"
                                placeholder="+1 (555) 000-0000"
                            />
                        </div>
                        <div className="md:col-span-2 space-y-2">
                            <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                                <FileText size={12} className="text-orange-500" /> About Me
                            </label>
                            <textarea 
                                name="about_me"
                                value={formData.about_me}
                                onChange={handleChange}
                                rows={4}
                                className="w-full bg-gray-50/50 border-gray-100 rounded-[1.5rem] px-5 py-4 text-sm font-semibold focus:ring-4 focus:ring-orange-50 focus:bg-white transition-all outline-none border hover:border-gray-200 resize-none"
                                placeholder="Write something classy about yourself..."
                            />
                        </div>
                    </div>
                </form>

                {/* Footer - Fixed */}
                <div className="p-8 border-t border-gray-50 flex items-center gap-4 bg-gray-50/30 shrink-0">
                    <button
                        type="button"
                        onClick={onCancel}
                        className="flex-1 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-gray-400 hover:text-gray-600 hover:bg-white transition-all border border-transparent hover:border-gray-200 active:scale-95"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        onClick={handleSubmit}
                        disabled={isSubmitting}
                        className="flex-[2] px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-white bg-slate-900 hover:bg-black shadow-xl shadow-slate-200 transition-all flex items-center justify-center gap-3 disabled:bg-slate-400 active:scale-95 translate-y-0 hover:-translate-y-1"
                    >
                        {isSubmitting ? (
                            <Loader2 size={18} className="animate-spin" />
                        ) : (
                            <>
                                <Check size={18} />
                                Save Changes
                            </>
                        )}
                    </button>
                </div>
            </motion.div>
        </div>
        </ModalPortal>
    );
};

export default EditProfileForm;
