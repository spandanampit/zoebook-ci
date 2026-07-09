import React, { useState, useRef, useEffect, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import {
  X, Music, UploadCloud, Trash2, Image as ImageIcon,
  Disc3, FileAudio, Sparkles, Clock
} from 'lucide-react';
import { useUser } from '../../context/UserContext';
import { FALLBACK_IMAGE } from '../../config/siteConfig';
import { getFullProfileImageUrl } from '../../utils/imageUtils';
import { toast } from 'react-toastify';

/* ──────────────────────────────────────────────────────────────────────
   MusicUploadModal
   A premium modal for uploading music tracks with:
   - Audio file selector (with auto-duration detection)
   - Track title & description fields
   - Cover art uploader with preview
   - Animated waveform visualization
   ────────────────────────────────────────────────────────────────────── */

const MusicUploadModal = ({ isOpen, onClose, onSubmit, isSubmitting }) => {
  const { profile } = useUser();
  const avatarUrl = getFullProfileImageUrl(profile?.profileImage);

  // ── Form State ──────────────────────────────────────────────────────
  const [musicFile, setMusicFile] = useState(null);
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [duration, setDuration] = useState('');
  const [coverFile, setCoverFile] = useState(null);
  const [coverPreview, setCoverPreview] = useState(null);

  // ── Interaction State ───────────────────────────────────────────────
  const [isDragging, setIsDragging] = useState(false);

  // ── Refs ─────────────────────────────────────────────────────────────
  const musicInputRef = useRef(null);
  const coverInputRef = useRef(null);
  const titleRef = useRef(null);

  // Focus title field after a music file is selected
  useEffect(() => {
    if (musicFile && titleRef.current) {
      setTimeout(() => titleRef.current.focus(), 200);
    }
  }, [musicFile]);

  // Cleanup blob URLs on unmount
  useEffect(() => {
    return () => {
      if (coverPreview && coverPreview.startsWith('blob:')) {
        URL.revokeObjectURL(coverPreview);
      }
    };
  }, [coverPreview]);

  if (!isOpen) return null;

  // ── Helpers ─────────────────────────────────────────────────────────

  /** Format file size into human-readable string */
  const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  };

  /** Format seconds to mm:ss */
  const formatDuration = (seconds) => {
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs.toString().padStart(2, '0')}`;
  };

  // ── Audio File Handlers ─────────────────────────────────────────────

  const processAudioFile = (file) => {
    if (!file) return;

    const validTypes = [
      'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg',
      'audio/flac', 'audio/aac', 'audio/m4a', 'audio/x-m4a',
      'audio/mp4',
    ];

    if (!file.type.startsWith('audio/') && !validTypes.includes(file.type)) {
      toast.error('Please upload a valid audio file (MP3, WAV, OGG, FLAC, AAC).');
      return;
    }

    setMusicFile(file);

    // Auto-detect duration using the Web Audio API
    const audioEl = new Audio();
    audioEl.preload = 'metadata';

    const objectUrl = URL.createObjectURL(file);
    audioEl.src = objectUrl;

    audioEl.addEventListener('loadedmetadata', () => {
      if (audioEl.duration && isFinite(audioEl.duration)) {
        setDuration(formatDuration(audioEl.duration));
      }
      URL.revokeObjectURL(objectUrl);
    });

    audioEl.addEventListener('error', () => {
      URL.revokeObjectURL(objectUrl);
    });

    toast.success('Audio file loaded! 🎵');
  };

  const handleMusicFileChange = (e) => {
    const file = e.target.files?.[0];
    processAudioFile(file);
    // Reset input so re-selecting the same file triggers onChange
    if (e.target) e.target.value = '';
  };

  const handleRemoveMusicFile = () => {
    setMusicFile(null);
    setDuration('');
    if (musicInputRef.current) musicInputRef.current.value = '';
    toast.info('Audio file removed.');
  };

  // ── Drag & Drop ─────────────────────────────────────────────────────

  const handleDragOver = (e) => {
    e.preventDefault();
    setIsDragging(true);
  };

  const handleDragLeave = () => setIsDragging(false);

  const handleDrop = (e) => {
    e.preventDefault();
    setIsDragging(false);
    const file = e.dataTransfer.files?.[0];
    processAudioFile(file);
  };

  // ── Cover Art Handlers ──────────────────────────────────────────────

  const handleCoverChange = (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      toast.error('Cover art must be an image file!');
      return;
    }
    setCoverFile(file);
    setCoverPreview(URL.createObjectURL(file));
    toast.success('Cover art selected! 🎨');
    if (e.target) e.target.value = '';
  };

  const handleRemoveCover = () => {
    setCoverFile(null);
    if (coverPreview) URL.revokeObjectURL(coverPreview);
    setCoverPreview(null);
    if (coverInputRef.current) coverInputRef.current.value = '';
  };

  // ── Form Reset ──────────────────────────────────────────────────────

  const resetForm = () => {
    setMusicFile(null);
    setTitle('');
    setDescription('');
    setDuration('');
    setCoverFile(null);
    if (coverPreview) URL.revokeObjectURL(coverPreview);
    setCoverPreview(null);
    setIsDragging(false);
  };

  // ── Submit ──────────────────────────────────────────────────────────

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!musicFile) {
      toast.warn('Please upload an audio file.');
      return;
    }
    if (!title.trim()) {
      toast.warn('Please enter a track title.');
      return;
    }
    if (!coverFile) {
      toast.warn('Please upload cover art for your track.');
      return;
    }

    // Capture values before reset
    const payload = {
      musicFile,
      thumbnailFile: coverFile,
      title: title.trim(),
      description: description.trim(),
      duration,
    };

    resetForm();
    onClose();

    if (onSubmit) {
      onSubmit(payload);
    }
  };

  // ── Cancel ──────────────────────────────────────────────────────────

  const handleCancel = () => {
    resetForm();
    onClose();
  };

  // ═══════════════════════════════════════════════════════════════════
  // RENDER
  // ═══════════════════════════════════════════════════════════════════

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      style={{ backdropFilter: 'blur(12px)', backgroundColor: 'rgba(15, 23, 42, 0.45)' }}
      onClick={handleCancel}
    >
      <motion.div
        initial={{ scale: 0.92, opacity: 0, y: 40 }}
        animate={{ scale: 1, opacity: 1, y: 0 }}
        exit={{ scale: 0.92, opacity: 0, y: 40 }}
        transition={{ type: 'spring', stiffness: 350, damping: 28 }}
        onClick={(e) => e.stopPropagation()}
        className="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl md:max-w-2xl border border-slate-100/80 overflow-hidden relative flex flex-col max-h-[90vh]"
      >
        {/* ── Decorative Top Gradient (Indigo Theme) ───────────────── */}
        <div className="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-violet-500" />

        {/* ── Header ──────────────────────────────────────────────── */}
        <div className="flex items-center justify-between px-8 pt-7 pb-5 border-b border-slate-100">
          <div className="flex items-center gap-3 flex-1">
            <div className="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 shadow-inner">
              <Music size={18} className="stroke-[2.5]" />
            </div>
            <div>
              <h3 className="text-xl font-black text-slate-800 tracking-tight">New Release</h3>
              <p className="text-[11px] text-slate-400 font-medium">Share your music with the world.</p>
            </div>
          </div>

          <motion.button
            whileHover={{ scale: 1.1, rotate: 90 }}
            whileTap={{ scale: 0.9 }}
            onClick={handleCancel}
            className="w-10 h-10 rounded-full bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 text-slate-400 flex items-center justify-center transition-all cursor-pointer border border-transparent hover:border-indigo-100 shadow-sm"
          >
            <X size={18} className="stroke-[2.5]" />
          </motion.button>
        </div>

        {/* ── Scrollable Body ─────────────────────────────────────── */}
        <div className="flex-1 overflow-y-auto px-8 py-6 custom-scrollbar space-y-6">

          {/* Hidden file inputs */}
          <input
            ref={musicInputRef}
            type="file"
            accept="audio/*"
            onChange={handleMusicFileChange}
            className="hidden"
            disabled={isSubmitting}
          />
          <input
            ref={coverInputRef}
            type="file"
            accept="image/*"
            onChange={handleCoverChange}
            className="hidden"
            disabled={isSubmitting}
          />

          {/* ── Audio File Upload Zone (Indigo Theme) ──────────────── */}
          {!musicFile ? (
            <div
              onDragOver={handleDragOver}
              onDragLeave={handleDragLeave}
              onDrop={handleDrop}
              onClick={() => musicInputRef.current?.click()}
              className={`border-2 border-dashed rounded-3xl p-8 text-center cursor-pointer transition-all duration-300 group flex flex-col items-center justify-center gap-3 ${
                isDragging
                  ? 'border-indigo-400 bg-indigo-50/30'
                  : 'border-slate-200 bg-slate-50/50 hover:bg-indigo-50/20 hover:border-indigo-300'
              }`}
            >
              <div className="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                <UploadCloud size={28} className="stroke-[2.2]" />
              </div>
              <div className="space-y-1">
                <p className="font-extrabold text-slate-800 text-sm md:text-base">
                  Drop your audio file here
                </p>
                <p className="text-slate-400 text-xs md:text-sm font-medium">
                  Or <span className="text-indigo-600 font-extrabold group-hover:underline">browse files</span> from your computer
                </p>
              </div>
              <span className="text-[10px] text-slate-400 font-bold bg-white border border-slate-100 rounded-full px-4 py-1.5 shadow-sm uppercase tracking-wider">
                MP3 · WAV · OGG · FLAC · AAC
              </span>
            </div>
          ) : (
            /* ── Selected Audio File Card (Indigo Theme) ──────────── */
            <motion.div
              initial={{ opacity: 0, y: 12 }}
              animate={{ opacity: 1, y: 0 }}
              className="relative rounded-3xl overflow-hidden border border-slate-100 shadow-lg bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 p-5"
            >
              <div className="flex items-center gap-4">
                {/* Animated disc icon */}
                <div className="relative shrink-0">
                  <motion.div
                    animate={{ rotate: 360 }}
                    transition={{ duration: 4, repeat: Infinity, ease: 'linear' }}
                    className="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center shadow-xl shadow-indigo-500/20"
                  >
                    <div className="w-5 h-5 rounded-full bg-slate-900 border-2 border-slate-700" />
                  </motion.div>
                  <div className="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full bg-emerald-400 flex items-center justify-center">
                    <FileAudio size={9} className="text-white" />
                  </div>
                </div>

                {/* File info */}
                <div className="flex-1 min-w-0">
                  <p className="font-bold text-white text-sm truncate">{musicFile.name}</p>
                  <div className="flex items-center gap-2 mt-0.5">
                    <span className="text-slate-400 text-xs font-semibold">
                      {formatFileSize(musicFile.size)}
                    </span>
                    <span className="text-slate-600">•</span>
                    <span className="text-slate-400 text-xs font-semibold">Audio file</span>
                    {duration && (
                      <>
                        <span className="text-slate-600">•</span>
                        <span className="text-indigo-400 text-xs font-bold flex items-center gap-1">
                          <Clock size={10} />
                          {duration}
                        </span>
                      </>
                    )}
                  </div>
                </div>

                {/* Remove button */}
                <motion.button
                  whileHover={{ scale: 1.1 }}
                  whileTap={{ scale: 0.95 }}
                  type="button"
                  onClick={handleRemoveMusicFile}
                  className="w-9 h-9 rounded-xl bg-rose-500/20 hover:bg-rose-500/40 text-rose-400 flex items-center justify-center cursor-pointer transition-colors shrink-0"
                  title="Remove audio file"
                >
                  <Trash2 size={15} />
                </motion.button>
              </div>

              {/* Decorative waveform bars */}
              <div className="flex items-end justify-center gap-[3px] mt-4 h-8 opacity-40">
                {Array.from({ length: 40 }).map((_, i) => (
                  <motion.div
                    key={i}
                    className="w-[3px] rounded-full bg-gradient-to-t from-indigo-400 to-violet-300"
                    animate={{
                      height: [
                        `${Math.random() * 60 + 15}%`,
                        `${Math.random() * 80 + 20}%`,
                        `${Math.random() * 50 + 10}%`,
                      ],
                    }}
                    transition={{
                      duration: 1.2 + Math.random() * 0.8,
                      repeat: Infinity,
                      repeatType: 'reverse',
                      delay: Math.random() * 0.5,
                    }}
                  />
                ))}
              </div>
            </motion.div>
          )}

          {/* ── Track Title ────────────────────────────────────────── */}
          <div className="space-y-2">
            <label className="text-xs font-black text-slate-700 uppercase tracking-widest flex items-center gap-1.5">
              <Music size={12} className="text-indigo-500" />
              Track Title
              <span className="text-rose-400">*</span>
            </label>
            <input
              ref={titleRef}
              type="text"
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              placeholder="Give your track a name..."
              disabled={isSubmitting}
              className="w-full rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white px-5 py-3.5 text-sm font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-all duration-200"
            />
          </div>

          {/* ── Description ────────────────────────────────────────── */}
          <div className="space-y-2">
            <label className="text-xs font-black text-slate-700 uppercase tracking-widest flex items-center gap-1.5">
              <Sparkles size={12} className="text-indigo-500" />
              Description
            </label>
            <textarea
              rows={3}
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              placeholder="Tell the world about this track..."
              disabled={isSubmitting}
              className="w-full rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white focus:bg-white px-5 py-3.5 text-sm font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-all duration-200 resize-none"
            />
          </div>

          {/* ── Cover Art Upload ───────────────────────────────────── */}
          <div className="space-y-2">
            <label className="text-xs font-black text-slate-700 uppercase tracking-widest flex items-center gap-1.5">
              <ImageIcon size={12} className="text-indigo-500" />
              Cover Art
              <span className="text-rose-400">*</span>
            </label>

            {!coverFile ? (
              <div className="flex items-center gap-4">
                {/* Placeholder square */}
                <div
                  onClick={() => coverInputRef.current?.click()}
                  className="w-28 h-28 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-indigo-50/30 hover:border-indigo-300 flex flex-col items-center justify-center gap-1.5 cursor-pointer transition-all duration-200 group shrink-0"
                >
                  <ImageIcon size={22} className="text-slate-300 group-hover:text-indigo-400 transition-colors" />
                  <span className="text-[9px] font-bold text-slate-400 group-hover:text-indigo-500 uppercase tracking-wider">Upload</span>
                </div>

                <div className="space-y-1.5">
                  <button
                    type="button"
                    onClick={() => coverInputRef.current?.click()}
                    className="text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors cursor-pointer hover:underline"
                  >
                    Choose File
                  </button>
                  <p className="text-[11px] text-slate-400 font-medium">
                    Recommended: 1000×1000px · JPG, PNG, or WebP
                  </p>
                </div>
              </div>
            ) : (
              /* Cover Art Preview */
              <motion.div
                initial={{ opacity: 0, scale: 0.95 }}
                animate={{ opacity: 1, scale: 1 }}
                className="flex items-center gap-4"
              >
                <div className="relative w-28 h-28 rounded-2xl overflow-hidden border border-slate-100 shadow-md shrink-0 group">
                  <img
                    src={coverPreview}
                    alt="Cover art"
                    className="w-full h-full object-cover"
                  />
                  {/* Hover overlay */}
                  <div className="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-200 flex items-center justify-center">
                    <motion.button
                      whileHover={{ scale: 1.1 }}
                      whileTap={{ scale: 0.95 }}
                      type="button"
                      onClick={handleRemoveCover}
                      className="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center cursor-pointer shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                    >
                      <Trash2 size={13} />
                    </motion.button>
                  </div>
                </div>

                <div className="min-w-0 space-y-1">
                  <p className="text-xs font-bold text-slate-700 truncate max-w-[200px]">{coverFile.name}</p>
                  <p className="text-[10px] text-slate-400 font-semibold">{formatFileSize(coverFile.size)}</p>
                  <button
                    type="button"
                    onClick={() => coverInputRef.current?.click()}
                    className="text-[10px] font-black text-indigo-600 uppercase tracking-wider hover:text-indigo-800 transition-colors cursor-pointer"
                  >
                    Change
                  </button>
                </div>
              </motion.div>
            )}
          </div>

          {/* ── Duration Badge (read-only) ─────────────────────────── */}
          {duration && (
            <motion.div
              initial={{ opacity: 0, y: 8 }}
              animate={{ opacity: 1, y: 0 }}
              className="flex items-center gap-2.5 p-3 bg-indigo-50/50 rounded-2xl border border-indigo-100/50"
            >
              <div className="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                <Clock size={16} className="stroke-[2.5]" />
              </div>
              <div>
                <p className="text-xs font-bold text-indigo-700">Duration Detected</p>
                <p className="text-[10px] text-indigo-500 font-semibold">{duration}</p>
              </div>
            </motion.div>
          )}
        </div>

        {/* ── Footer ──────────────────────────────────────────────── */}
        <div className="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
          <motion.button
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            type="button"
            onClick={handleCancel}
            disabled={isSubmitting}
            className="py-3.5 px-6 rounded-2xl bg-white hover:bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-widest transition-all cursor-pointer border border-slate-100 hover:border-slate-200 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Cancel
          </motion.button>

          <motion.button
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            type="button"
            onClick={handleSubmit}
            disabled={isSubmitting}
            className="py-3.5 px-8 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-black text-sm uppercase tracking-widest shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed"
          >
            {isSubmitting ? (
              <>
                <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                Publishing…
              </>
            ) : (
              <>
                <Disc3 size={14} />
                Publish Track
              </>
            )}
          </motion.button>
        </div>
      </motion.div>
    </motion.div>
  );
};

export default MusicUploadModal;
