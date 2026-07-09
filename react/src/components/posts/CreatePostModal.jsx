import React, { useState, useRef, useEffect, useMemo } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { X, Image as ImageIcon, Smile, UploadCloud, Trash2, Sparkles, Film, Camera, SkipForward, Globe, Lock, Zap, ChevronDown } from 'lucide-react';
import { useUser } from '../../context/UserContext';
import { FALLBACK_IMAGE } from '../../config/siteConfig';
import { getFullProfileImageUrl } from '../../utils/imageUtils';
import { toast } from 'react-toastify';

const CreatePostModal = ({ isOpen, onClose, initialTab = 'text', submitPost, isSubmitting }) => {
  const { profile } = useUser();
  const avatarUrl = getFullProfileImageUrl(profile?.profileImage);

  // Form states
  const [postText, setPostText] = useState('');
  const [selectedFile, setSelectedFile] = useState(null);
  const [filePreview, setFilePreview] = useState(null);
  const [fileType, setFileType] = useState(null); // 'image' | 'video'

  // Visibility state
  const [visibility, setVisibility] = useState('Public');
  const [isVisibilityOpen, setIsVisibilityOpen] = useState(false);

  // Thumbnail states (for video only)
  const [showThumbnailModal, setShowThumbnailModal] = useState(false);
  const [thumbnailFile, setThumbnailFile] = useState(null);
  const [thumbnailPreview, setThumbnailPreview] = useState(null);

  // Interaction states
  const [isDragging, setIsDragging] = useState(false);
  const [isEmojiOpen, setIsEmojiOpen] = useState(false);

  const fileInputRef = useRef(null);
  const thumbnailInputRef = useRef(null);
  const textareaRef = useRef(null);

  // Focus textarea when modal opens (same behavior for both 'text' and 'media' tabs)
  useEffect(() => {
    if (isOpen && textareaRef.current) {
      setTimeout(() => textareaRef.current.focus(), 150);
    }
  }, [isOpen]);

  // Handle textarea auto-resize
  useEffect(() => {
    if (textareaRef.current) {
      textareaRef.current.style.height = 'auto';
      textareaRef.current.style.height = `${textareaRef.current.scrollHeight}px`;
    }
  }, [postText]);

  // Clean up object URLs to prevent memory leaks
  useEffect(() => {
    return () => {
      if (filePreview && filePreview.startsWith('blob:')) {
        URL.revokeObjectURL(filePreview);
      }
      if (thumbnailPreview && thumbnailPreview.startsWith('blob:')) {
        URL.revokeObjectURL(thumbnailPreview);
      }
    };
  }, [filePreview, thumbnailPreview]);

  if (!isOpen) return null;

  // File Handlers
  const processFile = (file) => {
    if (!file) return;

    const isImage = file.type.startsWith('image/');
    const isVideo = file.type.startsWith('video/');

    if (!isImage && !isVideo) {
      toast.error('Unsupported file format! Please upload an image or a video file.');
      return;
    }

    setSelectedFile(file);
    setFileType(isImage ? 'image' : 'video');
    
    // Create preview URL
    const previewUrl = URL.createObjectURL(file);
    setFilePreview(previewUrl);

    if (isVideo) {
      // Open thumbnail modal for video files
      setShowThumbnailModal(true);
      toast.success('Video selected! You can now add a custom thumbnail. ✨');
    } else {
      toast.success('Image selected successfully! ✨');
    }
  };

  const handleFileChange = (e) => {
    const file = e.target.files?.[0];
    processFile(file);
  };

  const handleDragOver = (e) => {
    e.preventDefault();
    setIsDragging(true);
  };

  const handleDragLeave = () => {
    setIsDragging(false);
  };

  const handleDrop = (e) => {
    e.preventDefault();
    setIsDragging(false);
    const file = e.dataTransfer.files?.[0];
    processFile(file);
  };

  const handleRemoveFile = (e) => {
    e.stopPropagation();
    setSelectedFile(null);
    setFilePreview(null);
    setFileType(null);
    setThumbnailFile(null);
    setThumbnailPreview(null);
    if (fileInputRef.current) {
      fileInputRef.current.value = '';
    }
    toast.info('File selection cleared.');
  };

  // Thumbnail Handlers
  const handleThumbnailChange = (e) => {
    const file = e.target.files?.[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
      toast.error('Thumbnail must be an image file!');
      return;
    }

    setThumbnailFile(file);
    const previewUrl = URL.createObjectURL(file);
    setThumbnailPreview(previewUrl);
    toast.success('Thumbnail selected! ✨');
  };

  const handleRemoveThumbnail = () => {
    setThumbnailFile(null);
    if (thumbnailPreview) {
      URL.revokeObjectURL(thumbnailPreview);
    }
    setThumbnailPreview(null);
    if (thumbnailInputRef.current) {
      thumbnailInputRef.current.value = '';
    }
  };

  const handleSkipThumbnail = () => {
    handleRemoveThumbnail();
    setShowThumbnailModal(false);
    toast.info('Thumbnail skipped — it will be auto-generated.');
  };

  const handleConfirmThumbnail = () => {
    setShowThumbnailModal(false);
  };

  // Visibility options
  const visibilityOptions = [
    { value: 'Public', label: 'Public', icon: Globe, color: 'emerald', description: 'Anyone can see this post' },
    { value: 'Private', label: 'Private', icon: Lock, color: 'amber', description: 'Only you can see this post' },
    { value: 'Viral', label: 'Viral', icon: Zap, color: 'violet', description: 'Boost reach across the platform' },
  ];

  const activeVisibility = visibilityOptions.find(v => v.value === visibility);

  // Emojis
  const quickEmojis = ['😀', '🔥', '✨', '💖', '🙌', '🎉', '💡', '😍', '👀', '🍿'];
  const handleEmojiClick = (emoji) => {
    setPostText(prev => prev + emoji);
    setIsEmojiOpen(false);
  };

  // Format File Size
  const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const decimals = 2;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(decimals)) + ' ' + sizes[i];
  };

  // Submit Handler — delegates to the useCreateHomePost hook
  const handleSubmit = (e) => {
    e.preventDefault();
    if (!postText.trim() && !selectedFile) {
      toast.warn('Please write a message or upload media before posting.');
      return;
    }

    // Capture refs before resetting
    const fileToUpload = selectedFile;
    const thumbToUpload = thumbnailFile;
    const descToUpload = postText.trim();
    const visibilityToUpload = visibility;

    // Reset form states
    setPostText('');
    setSelectedFile(null);
    setFilePreview(null);
    setFileType(null);
    setThumbnailFile(null);
    setThumbnailPreview(null);
    setShowThumbnailModal(false);
    setVisibility('Public');
    setIsVisibilityOpen(false);

    // Close modal immediately
    onClose();

    // Fire-and-forget: the hook's toast handles success/error messaging
    if (submitPost) {
      submitPost({
        file: fileToUpload,
        description: descToUpload,
        thumbnailFile: thumbToUpload,
        visibility: visibilityToUpload,
      });
    }
  };

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      style={{ backdropFilter: 'blur(12px)', backgroundColor: 'rgba(15, 23, 42, 0.45)' }}
      onClick={onClose}
    >
      <motion.div
        initial={{ scale: 0.92, opacity: 0, y: 40 }}
        animate={{ scale: 1, opacity: 1, y: 0 }}
        exit={{ scale: 0.92, opacity: 0, y: 40 }}
        transition={{ type: 'spring', stiffness: 350, damping: 28 }}
        onClick={(e) => e.stopPropagation()}
        className="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl md:max-w-2xl border border-slate-100/80 overflow-hidden relative flex flex-col max-h-[90vh]"
      >
        {/* Decorative Top Gradient Highlight */}
        <div className="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-violet-500 via-purple-500 to-indigo-500" />

        {/* Modal Header */}
        <div className="flex items-center justify-between px-8 pt-7 pb-5 border-b border-slate-100">
          <h3 className="text-xl font-black text-slate-800 tracking-tight flex-1 text-center pl-8">
            Create Post
          </h3>
          <motion.button
            whileHover={{ scale: 1.1, rotate: 90 }}
            whileTap={{ scale: 0.9 }}
            onClick={onClose}
            className="w-10 h-10 rounded-full bg-slate-50 hover:bg-violet-50 hover:text-violet-600 text-slate-400 flex items-center justify-center transition-all cursor-pointer border border-transparent hover:border-violet-100 shadow-sm"
          >
            <X size={18} className="stroke-[2.5]" />
          </motion.button>
        </div>

        {/* Scrollable Container */}
        <div className="flex-1 overflow-y-auto px-8 py-6 custom-scrollbar space-y-6">
          
          {/* User Row */}
          <div className="flex items-center gap-3.5">
            <div className="relative shrink-0">
              <img
                src={avatarUrl}
                alt={profile?.name || "User"}
                className="w-12 h-12 rounded-full object-cover border-2 border-slate-100 shadow-sm"
                onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
              />
              <span className="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
              <h4 className="font-extrabold text-slate-800 text-[15px] leading-tight">
                {profile?.name || "Abhisek Saha"}
              </h4>
              {/* Visibility Selector Dropdown */}
              <div className="relative mt-1">
                <motion.button
                  whileTap={{ scale: 0.97 }}
                  type="button"
                  onClick={() => setIsVisibilityOpen(!isVisibilityOpen)}
                  className={`flex items-center gap-1.5 px-3 py-1 rounded-full border transition-all duration-200 cursor-pointer text-[11px] font-bold uppercase tracking-widest ${
                    visibility === 'Public'
                      ? 'bg-emerald-50 border-emerald-200 text-emerald-600 hover:bg-emerald-100'
                      : visibility === 'Private'
                      ? 'bg-amber-50 border-amber-200 text-amber-600 hover:bg-amber-100'
                      : 'bg-violet-50 border-violet-200 text-violet-600 hover:bg-violet-100'
                  }`}
                >
                  {activeVisibility && <activeVisibility.icon size={11} className="stroke-[2.5]" />}
                  <span>{visibility}</span>
                  <ChevronDown size={11} className={`stroke-[2.5] transition-transform duration-200 ${isVisibilityOpen ? 'rotate-180' : ''}`} />
                </motion.button>

                <AnimatePresence>
                  {isVisibilityOpen && (
                    <motion.div
                      initial={{ opacity: 0, scale: 0.92, y: -4 }}
                      animate={{ opacity: 1, scale: 1, y: 0 }}
                      exit={{ opacity: 0, scale: 0.92, y: -4 }}
                      transition={{ duration: 0.15 }}
                      className="absolute left-0 top-full mt-1.5 bg-white border border-slate-100 shadow-2xl rounded-2xl p-1.5 z-50 min-w-[200px]"
                    >
                      {visibilityOptions.map((opt) => {
                        const Icon = opt.icon;
                        const isActive = visibility === opt.value;
                        return (
                          <button
                            key={opt.value}
                            type="button"
                            onClick={() => { setVisibility(opt.value); setIsVisibilityOpen(false); }}
                            className={`w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-150 cursor-pointer ${
                              isActive
                                ? opt.color === 'emerald' ? 'bg-emerald-50 text-emerald-700'
                                : opt.color === 'amber' ? 'bg-amber-50 text-amber-700'
                                : 'bg-violet-50 text-violet-700'
                                : 'text-slate-600 hover:bg-slate-50'
                            }`}
                          >
                            <div className={`w-8 h-8 rounded-xl flex items-center justify-center shrink-0 ${
                              opt.color === 'emerald' ? 'bg-emerald-100 text-emerald-500'
                              : opt.color === 'amber' ? 'bg-amber-100 text-amber-500'
                              : 'bg-violet-100 text-violet-500'
                            }`}>
                              <Icon size={14} className="stroke-[2.5]" />
                            </div>
                            <div className="text-left">
                              <p className="text-xs font-extrabold leading-tight">{opt.label}</p>
                              <p className="text-[10px] font-medium text-slate-400 leading-tight">{opt.description}</p>
                            </div>
                            {isActive && (
                              <div className={`ml-auto w-2 h-2 rounded-full ${
                                opt.color === 'emerald' ? 'bg-emerald-500'
                                : opt.color === 'amber' ? 'bg-amber-500'
                                : 'bg-violet-500'
                              }`} />
                            )}
                          </button>
                        );
                      })}
                    </motion.div>
                  )}
                </AnimatePresence>
              </div>
            </div>
          </div>

          {/* Description Textarea Field */}
          <div className="relative">
            <textarea
              ref={textareaRef}
              rows={2}
              value={postText}
              onChange={(e) => setPostText(e.target.value)}
              placeholder="What's on your mind?"
              className="w-full text-slate-700 font-medium placeholder:text-slate-400 text-base md:text-lg border-0 focus:ring-0 outline-none resize-none bg-transparent min-h-[90px] pr-10"
              disabled={isSubmitting}
            />

            {/* Quick Emoji Toggler & Menu */}
            <div className="absolute right-1 top-1">
              <motion.button
                whileHover={{ scale: 1.1, y: -1 }}
                whileTap={{ scale: 0.95 }}
                type="button"
                onClick={() => setIsEmojiOpen(!isEmojiOpen)}
                className="text-slate-400 hover:text-violet-500 transition-colors p-1.5 rounded-full hover:bg-slate-50 cursor-pointer"
              >
                <Smile size={20} className="stroke-[2.2]" />
              </motion.button>
              
              <AnimatePresence>
                {isEmojiOpen && (
                  <motion.div
                    initial={{ opacity: 0, scale: 0.85, y: 10 }}
                    animate={{ opacity: 1, scale: 1, y: 0 }}
                    exit={{ opacity: 0, scale: 0.85, y: 10 }}
                    className="absolute right-0 top-10 bg-white border border-slate-100 shadow-2xl rounded-2xl p-2.5 z-40 flex gap-1.5"
                  >
                    {quickEmojis.map((emoji) => (
                      <button
                        key={emoji}
                        type="button"
                        onClick={() => handleEmojiClick(emoji)}
                        className="text-lg hover:scale-125 transition-transform duration-200 cursor-pointer"
                      >
                        {emoji}
                      </button>
                    ))}
                  </motion.div>
                )}
              </AnimatePresence>
            </div>
          </div>

          {/* Media Uploader */}
          <div className="space-y-4">
            <input
              ref={fileInputRef}
              type="file"
              accept="image/*,video/*"
              onChange={handleFileChange}
              className="hidden"
              disabled={isSubmitting}
            />

            {!selectedFile ? (
              <div
                onDragOver={handleDragOver}
                onDragLeave={handleDragLeave}
                onDrop={handleDrop}
                onClick={() => fileInputRef.current?.click()}
                className={`border-2 border-dashed rounded-3xl p-8 text-center cursor-pointer transition-all duration-300 group flex flex-col items-center justify-center gap-3 ${
                  isDragging
                    ? 'border-indigo-500 bg-indigo-50/20'
                    : 'border-slate-200 bg-slate-50/50 hover:bg-slate-50 hover:border-violet-300'
                }`}
              >
                <div className="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                  <UploadCloud size={28} className="stroke-[2.2]" />
                </div>
                <div className="space-y-1">
                  <p className="font-extrabold text-slate-800 text-sm md:text-base">
                    Drag & drop your files here
                  </p>
                  <p className="text-slate-400 text-xs md:text-sm font-medium">
                    Or <span className="text-violet-600 font-extrabold group-hover:underline">browse files</span> from your computer
                  </p>
                </div>
                <span className="text-[10px] text-slate-400 font-bold bg-white border border-slate-100 rounded-full px-4 py-1.5 shadow-sm uppercase tracking-wider">
                  Supports Images & Videos — Any Size
                </span>
              </div>
            ) : (
              /* Selected File Preview Box */
              <div className="relative rounded-3xl overflow-hidden border border-slate-100 shadow-lg bg-slate-50 group/preview max-h-72 flex items-center justify-center">
                
                {fileType === 'image' && (
                  <img
                    src={filePreview}
                    alt="Uploaded media"
                    className="w-full object-cover max-h-72"
                  />
                )}

                {fileType === 'video' && (
                  <video
                    src={filePreview}
                    controls
                    className="w-full max-h-72 bg-black object-contain"
                  />
                )}

                {/* Glassmorphic File Info Overlay */}
                <div className="absolute bottom-4 left-4 right-4 bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl p-4 flex items-center justify-between shadow-lg text-white">
                  <div className="flex items-center gap-3 min-w-0">
                    <div className="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                      {fileType === 'image' ? <ImageIcon size={16} /> : <Film size={16} />}
                    </div>
                    <div className="min-w-0">
                      <p className="font-bold text-xs truncate max-w-[180px] sm:max-w-[300px]">
                        {selectedFile.name}
                      </p>
                      <p className="text-[10px] text-white/80 font-semibold">
                        {formatFileSize(selectedFile.size)}
                      </p>
                    </div>
                  </div>

                  <div className="flex items-center gap-2">
                    {/* Edit thumbnail button for videos */}
                    {fileType === 'video' && (
                      <motion.button
                        whileHover={{ scale: 1.1 }}
                        whileTap={{ scale: 0.95 }}
                        type="button"
                        onClick={(e) => { e.stopPropagation(); setShowThumbnailModal(true); }}
                        className="w-9 h-9 rounded-xl bg-indigo-500/90 hover:bg-indigo-500 text-white flex items-center justify-center cursor-pointer shadow-md transition-colors"
                        title="Edit thumbnail"
                      >
                        <Camera size={15} />
                      </motion.button>
                    )}

                    <motion.button
                      whileHover={{ scale: 1.1 }}
                      whileTap={{ scale: 0.95 }}
                      type="button"
                      onClick={handleRemoveFile}
                      className="w-9 h-9 rounded-xl bg-rose-500/90 hover:bg-rose-500 text-white flex items-center justify-center cursor-pointer shadow-md transition-colors"
                      title="Remove file"
                    >
                      <Trash2 size={15} />
                    </motion.button>
                  </div>
                </div>
              </div>
            )}
          </div>

          {/* Thumbnail indicator (if video + thumbnail selected) */}
          {fileType === 'video' && thumbnailFile && (
            <div className="flex items-center gap-3 p-3 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
              <img
                src={thumbnailPreview}
                alt="Thumbnail preview"
                className="w-12 h-12 rounded-xl object-cover border border-indigo-100"
              />
              <div className="flex-1 min-w-0">
                <p className="text-xs font-bold text-indigo-700 truncate">{thumbnailFile.name}</p>
                <p className="text-[10px] text-indigo-400 font-semibold">Custom Thumbnail</p>
              </div>
              <button
                type="button"
                onClick={() => { setShowThumbnailModal(true); }}
                className="text-[10px] font-black text-indigo-600 uppercase tracking-wider hover:text-indigo-800 transition-colors cursor-pointer"
              >
                Change
              </button>
            </div>
          )}

          {fileType === 'video' && !thumbnailFile && selectedFile && (
            <div className="flex items-center gap-3 p-3 bg-slate-50/50 rounded-2xl border border-slate-100/50">
              <div className="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                <Camera size={18} />
              </div>
              <div className="flex-1 min-w-0">
                <p className="text-xs font-bold text-slate-500">No custom thumbnail</p>
                <p className="text-[10px] text-slate-400 font-semibold">Will be auto-generated</p>
              </div>
              <button
                type="button"
                onClick={() => { setShowThumbnailModal(true); }}
                className="text-[10px] font-black text-violet-600 uppercase tracking-wider hover:text-violet-800 transition-colors cursor-pointer"
              >
                Add
              </button>
            </div>
          )}

        </div>

        {/* Modal Footer (Submit Button) */}
        <div className="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between gap-4">
          <div className="hidden sm:flex items-center gap-2 text-xs font-bold">
            {activeVisibility && (
              <div className={`flex items-center gap-1.5 px-3 py-1.5 rounded-full ${
                visibility === 'Public' ? 'bg-emerald-50 text-emerald-600'
                : visibility === 'Private' ? 'bg-amber-50 text-amber-600'
                : 'bg-violet-50 text-violet-600'
              }`}>
                <activeVisibility.icon size={12} className="stroke-[2.5]" />
                <span>{visibility}</span>
              </div>
            )}
          </div>

          <motion.button
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            onClick={handleSubmit}
            disabled={isSubmitting}
            className="flex-1 sm:flex-initial sm:min-w-[160px] py-4 px-6 rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 text-white font-black text-sm uppercase tracking-widest shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed ml-auto"
          >
            {isSubmitting ? (
              <>
                <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                Publishing…
              </>
            ) : (
              <>
                <Sparkles size={14} />
                Post Now
              </>
            )}
          </motion.button>
        </div>

      </motion.div>

      {/* ═══════════════════════════════════════════════════════════════════
          Video Thumbnail Modal — appears on top of the CreatePostModal
          ═══════════════════════════════════════════════════════════════════ */}
      <AnimatePresence>
        {showThumbnailModal && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 z-[60] flex items-center justify-center p-4"
            style={{ backdropFilter: 'blur(8px)', backgroundColor: 'rgba(15, 23, 42, 0.5)' }}
            onClick={() => setShowThumbnailModal(false)}
          >
            <motion.div
              initial={{ scale: 0.9, opacity: 0, y: 30 }}
              animate={{ scale: 1, opacity: 1, y: 0 }}
              exit={{ scale: 0.9, opacity: 0, y: 30 }}
              transition={{ type: 'spring', stiffness: 400, damping: 30 }}
              onClick={(e) => e.stopPropagation()}
              className="bg-white rounded-[2rem] shadow-2xl w-full max-w-md border border-slate-100/80 overflow-hidden relative"
            >
              {/* Decorative gradient */}
              <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500" />

              <div className="p-6 space-y-5">
                {/* Header */}
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 shadow-inner">
                      <Camera size={18} className="stroke-[2.5]" />
                    </div>
                    <div>
                      <h4 className="text-base font-black text-slate-800 tracking-tight">Video Thumbnail</h4>
                      <p className="text-[11px] text-slate-400 font-medium">Upload a cover image for your video</p>
                    </div>
                  </div>
                  <motion.button
                    whileHover={{ scale: 1.1, rotate: 90 }}
                    whileTap={{ scale: 0.9 }}
                    onClick={() => setShowThumbnailModal(false)}
                    className="w-8 h-8 rounded-full bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-500 flex items-center justify-center transition-all cursor-pointer"
                  >
                    <X size={14} className="stroke-[2.5]" />
                  </motion.button>
                </div>

                {/* Thumbnail Upload Area */}
                <input
                  ref={thumbnailInputRef}
                  type="file"
                  accept="image/*"
                  onChange={handleThumbnailChange}
                  className="hidden"
                />

                {!thumbnailFile ? (
                  <div
                    onClick={() => thumbnailInputRef.current?.click()}
                    className="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center cursor-pointer transition-all hover:border-indigo-300 hover:bg-indigo-50/20 group flex flex-col items-center justify-center gap-2.5"
                  >
                    <div className="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                      <UploadCloud size={22} className="stroke-[2.2]" />
                    </div>
                    <div className="space-y-0.5">
                      <p className="font-extrabold text-slate-700 text-sm">Choose thumbnail image</p>
                      <p className="text-slate-400 text-xs font-medium">PNG, JPG, or WebP</p>
                    </div>
                  </div>
                ) : (
                  <div className="relative rounded-2xl overflow-hidden border border-slate-100 shadow-md">
                    <img
                      src={thumbnailPreview}
                      alt="Thumbnail preview"
                      className="w-full h-48 object-cover"
                    />
                    <div className="absolute bottom-3 left-3 right-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-2.5 flex items-center justify-between text-white">
                      <div className="flex items-center gap-2 min-w-0">
                        <ImageIcon size={12} />
                        <p className="text-xs font-bold truncate max-w-[200px]">{thumbnailFile.name}</p>
                      </div>
                      <motion.button
                        whileHover={{ scale: 1.1 }}
                        whileTap={{ scale: 0.95 }}
                        type="button"
                        onClick={handleRemoveThumbnail}
                        className="w-7 h-7 rounded-lg bg-rose-500/90 hover:bg-rose-500 text-white flex items-center justify-center cursor-pointer shadow-md transition-colors shrink-0"
                      >
                        <Trash2 size={12} />
                      </motion.button>
                    </div>
                  </div>
                )}

                {/* Action Buttons */}
                <div className="flex items-center gap-3">
                  <button
                    type="button"
                    onClick={handleSkipThumbnail}
                    className="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-slate-50 hover:bg-slate-100 text-slate-500 font-bold text-xs uppercase tracking-widest transition-all cursor-pointer border border-slate-100"
                  >
                    <SkipForward size={13} />
                    Skip
                  </button>

                  {thumbnailFile && (
                    <motion.button
                      whileHover={{ scale: 1.02 }}
                      whileTap={{ scale: 0.98 }}
                      type="button"
                      onClick={handleConfirmThumbnail}
                      className="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 transition-all cursor-pointer"
                    >
                      <Camera size={13} />
                      Use Thumbnail
                    </motion.button>
                  )}
                </div>
              </div>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </motion.div>
  );
};

export default CreatePostModal;
