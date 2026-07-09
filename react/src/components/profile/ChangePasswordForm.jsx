import React, { useState, useEffect } from 'react';
import { ShieldCheck, X, Eye, EyeOff, Loader2, Check, Lock } from 'lucide-react';
import { changePassword } from '../../services/userService';
import { toast } from 'react-toastify';
import { motion, AnimatePresence } from 'framer-motion';
import ModalPortal from '../common/ModalPortal';

const ChangePasswordForm = ({ onCancel }) => {
    const [formData, setFormData] = useState({
        old_password: "",
        new_password: "",
        confirm_password: ""
    });

    const [showPasswords, setShowPasswords] = useState({
        old: false,
        new: false,
        confirm: false
    });

    const [strength, setStrength] = useState({
        score: 0,
        label: "Very Weak",
        color: "bg-red-500"
    });

    const [isSubmitting, setIsSubmitting] = useState(false);

    const checkStrength = (pass) => {
        if (!pass) return { score: 0, label: "Very Weak", color: "bg-gray-200" };
        
        let score = 0;
        if (pass.length >= 6) score++;
        if (pass.length >= 10) score++;
        if (/[A-Z]/.test(pass)) score++;
        if (/[0-9]/.test(pass)) score++;
        if (/[^A-Za-z0-9]/.test(pass)) score++;

        if (score <= 1) return { score: 20, label: "Weak", color: "bg-red-400" };
        if (score <= 3) return { score: 60, label: "Medium", color: "bg-yellow-400" };
        return { score: 100, label: "Strong", color: "bg-green-500" };
    };

    useEffect(() => {
        setStrength(checkStrength(formData.new_password));
    }, [formData.new_password]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const togglePasswordVisibility = (field) => {
        setShowPasswords(prev => ({ ...prev, [field]: !prev[field] }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        
        if (formData.new_password !== formData.confirm_password) {
            toast.error("Confirm password does not match new password");
            return;
        }

        if (formData.new_password.length < 6) {
            toast.error("New password must be at least 6 characters long");
            return;
        }

        setIsSubmitting(true);
        try {
            const response = await changePassword({
                old_password: formData.old_password,
                new_password: formData.new_password
            });

            if (response?.settings?.success === "1" || response?.status === "1") {
                toast.success(response?.settings?.message || "Password updated successfully!");
                onCancel();
            } else {
                toast.error(response?.settings?.message || response?.message || "Failed to update password");
            }
        } catch (error) {
            console.error("Password update failed", error);
            toast.error("An error occurred while updating password");
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <ModalPortal>
        <div className="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <motion.div 
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                onClick={onCancel}
                className="absolute inset-0 bg-slate-900/60 backdrop-blur-xl"
            />

            <motion.div 
                initial={{ opacity: 0, scale: 0.9, y: 20 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.9, y: 20 }}
                className="bg-white rounded-[2.5rem] shadow-2xl border border-white/20 overflow-hidden w-full max-w-md relative z-10"
            >
                {/* Header */}
                <div className="p-8 border-b border-gray-50 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                    <div>
                        <h2 className="text-2xl font-black text-gray-800 tracking-tight">Security</h2>
                        <p className="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1 text-orange-500">Update your credentials</p>
                    </div>
                    <button 
                        onClick={onCancel}
                        className="p-2.5 hover:bg-gray-100 rounded-full transition-all text-gray-400 hover:text-gray-900 active:scale-90"
                    >
                        <X size={24} />
                    </button>
                </div>

                <form onSubmit={handleSubmit} className="p-8 space-y-6">
                    {/* Old Password */}
                    <div className="space-y-2">
                        <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                            <Lock size={12} className="text-gray-400" /> Current Password
                        </label>
                        <div className="relative">
                            <input 
                                type={showPasswords.old ? "text" : "password"}
                                name="old_password"
                                value={formData.old_password}
                                onChange={handleChange}
                                className="w-full bg-gray-50/50 border-gray-100 rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-4 focus:ring-slate-100 focus:bg-white transition-all outline-none border hover:border-gray-200"
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button"
                                onClick={() => togglePasswordVisibility('old')}
                                className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                {showPasswords.old ? <EyeOff size={18} /> : <Eye size={18} />}
                            </button>
                        </div>
                    </div>

                    {/* New Password */}
                    <div className="space-y-3">
                        <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                            <ShieldCheck size={12} className="text-orange-500" /> New Password
                        </label>
                        <div className="relative">
                            <input 
                                type={showPasswords.new ? "text" : "password"}
                                name="new_password"
                                value={formData.new_password}
                                onChange={handleChange}
                                className={`w-full bg-gray-50/50 border-gray-100 rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-4 focus:ring-orange-50 focus:bg-white transition-all outline-none border hover:border-gray-200 ${formData.new_password && 'border-orange-100'}`}
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button"
                                onClick={() => togglePasswordVisibility('new')}
                                className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                {showPasswords.new ? <EyeOff size={18} /> : <Eye size={18} />}
                            </button>
                        </div>
                        
                        {/* strength meter */}
                        <div className="px-1 space-y-2">
                            <div className="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                                <span className="text-gray-400">Difficulty</span>
                                <span className={strength.color.replace('bg-', 'text-')}>{strength.label}</span>
                            </div>
                            <div className="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                <motion.div 
                                    className={`h-full ${strength.color}`}
                                    initial={{ width: 0 }}
                                    animate={{ width: `${strength.score}%` }}
                                    transition={{ type: "spring", damping: 20, stiffness: 100 }}
                                />
                            </div>
                        </div>
                    </div>

                    {/* Confirm Password */}
                    <div className="space-y-2">
                        <label className="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] ml-1 flex items-center gap-2">
                            <Check size={12} className={formData.confirm_password && formData.new_password === formData.confirm_password ? "text-green-500" : "text-gray-400"} /> Confirm New Password
                        </label>
                        <div className="relative">
                            <input 
                                type={showPasswords.confirm ? "text" : "password"}
                                name="confirm_password"
                                value={formData.confirm_password}
                                onChange={handleChange}
                                className={`w-full bg-gray-50/50 border-gray-100 rounded-2xl px-5 py-4 text-sm font-semibold focus:ring-4 focus:ring-slate-100 focus:bg-white transition-all outline-none border hover:border-gray-200 ${formData.confirm_password && formData.new_password === formData.confirm_password ? 'border-green-200 ring-4 ring-green-50' : formData.confirm_password ? 'border-red-100 ring-4 ring-red-50' : ''}`}
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button"
                                onClick={() => togglePasswordVisibility('confirm')}
                                className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                {showPasswords.confirm ? <EyeOff size={18} /> : <Eye size={18} />}
                            </button>
                        </div>
                        {formData.confirm_password && formData.new_password !== formData.confirm_password && (
                            <p className="text-[10px] font-bold text-red-500 ml-1">Passwords do not match</p>
                        )}
                    </div>

                    <div className="pt-4 flex items-center gap-3">
                        <button
                            type="button"
                            onClick={onCancel}
                            className="flex-1 px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-all active:scale-95"
                        >
                            Back
                        </button>
                        <button
                            type="submit"
                            disabled={isSubmitting || !formData.old_password || !formData.new_password || formData.new_password !== formData.confirm_password}
                            className="flex-[2] px-6 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-white bg-slate-900 hover:bg-black shadow-xl shadow-slate-200 transition-all flex items-center justify-center gap-3 disabled:bg-slate-200 disabled:shadow-none disabled:text-gray-400 active:scale-95"
                        >
                            {isSubmitting ? (
                                <Loader2 size={18} className="animate-spin" />
                            ) : (
                                <>
                                    <ShieldCheck size={18} />
                                    Update Password
                                </>
                            )}
                        </button>
                    </div>
                </form>
            </motion.div>
        </div>
        </ModalPortal>
    );
};

export default ChangePasswordForm;
