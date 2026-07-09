import React, { useState, useEffect, useRef, useCallback } from 'react';
import { MoreHorizontal, MessageCircle, Share2, Heart, Play, Pause, SkipBack, SkipForward, Volume2, Trash2, ListMusic, AlertTriangle, X, RefreshCw, Info } from 'lucide-react';
import { deletePost, addToPlaylist, sharePostInTimeline, likePost, likePostMedia } from '../../services/postService';
import { ACTIVE_USER_ID, FALLBACK_IMAGE, SITE_URL } from '../../config/siteConfig';
import { motion, AnimatePresence } from 'framer-motion';
import { useNavigate } from 'react-router-dom';
import { getFullProfileImageUrl } from '../../utils/imageUtils';
import PostCommentSection from '../comments/PostCommentSection';
import ModalPortal from '../common/ModalPortal';
import { toast } from 'react-toastify';

export const PostSkeleton = () => (
  <div className="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6 animate-pulse">
    <div className="flex items-center gap-3 mb-4">
      <div className="w-12 h-12 rounded-full bg-gray-200" />
      <div className="space-y-2">
        <div className="h-4 w-32 bg-gray-200 rounded" />
        <div className="h-3 w-20 bg-gray-200 rounded" />
      </div>
    </div>
    <div className="h-4 w-full bg-gray-100 rounded mb-2" />
    <div className="h-4 w-2/3 bg-gray-100 rounded mb-4" />
    <div className="h-48 w-full bg-gray-200 rounded-2xl mb-4" />
    <div className="flex gap-6 border-t border-gray-50 pt-4">
      <div className="h-6 w-16 bg-gray-100 rounded-full" />
      <div className="h-6 w-16 bg-gray-100 rounded-full" />
    </div>
  </div>
);

export const MusicPlayer = ({ track }) => {
    const [isPlaying, setIsPlaying] = useState(false);
    const [progress, setProgress] = useState(0);
    const audioRef = useRef(null);

    const togglePlay = () => {
        if (isPlaying) {
            audioRef.current.pause();
        } else {
            audioRef.current.play();
        }
        setIsPlaying(!isPlaying);
    };

    const onTimeUpdate = () => {
        const current = audioRef.current.currentTime;
        const duration = audioRef.current.duration;
        setProgress((current / duration) * 100);
    };

    const onScrub = (e) => {
        const time = (e.target.value / 100) * audioRef.current.duration;
        audioRef.current.currentTime = time;
        setProgress(e.target.value);
    };

    return (
        <div className="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl p-6 text-white shadow-lg overflow-hidden relative group">
            <audio 
                ref={audioRef} 
                src={track.audio_url} 
                onTimeUpdate={onTimeUpdate} 
                onEnded={() => setIsPlaying(false)}
            />
            
            {/* Background Decoration */}
            <div className="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-700" />
            
            <div className="relative flex flex-col gap-4">
                <div className="flex items-center gap-4">
                    <div className="w-16 h-16 rounded-2xl overflow-hidden shadow-md bg-white/20">
                        <img 
                            src={track.thumbnail_url || "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&q=80&w=100&h=100"} 
                            alt={track.title} 
                            className="w-full h-full object-cover"
                        />
                    </div>
                    <div className="flex-1">
                        <h4 className="font-bold text-lg truncate leading-tight">{track.title || "Unknown Track"}</h4>
                        <p className="text-white/70 text-sm">{track.duration ? `${track.duration} min` : "Music Track"}</p>
                    </div>
                    <div className="flex gap-1 items-center">
                        <div className={`w-1 h-3 bg-white/40 rounded-full ${isPlaying ? 'animate-bounce' : ''}`} style={{ animationDelay: '0ms' }} />
                        <div className={`w-1 h-5 bg-white/40 rounded-full ${isPlaying ? 'animate-bounce' : ''}`} style={{ animationDelay: '100ms' }} />
                        <div className={`w-1 h-3 bg-white/40 rounded-full ${isPlaying ? 'animate-bounce' : ''}`} style={{ animationDelay: '200ms' }} />
                    </div>
                </div>

                <div className="space-y-2">
                    <input 
                        type="range" 
                        value={progress} 
                        onChange={onScrub}
                        className="w-full h-1.5 bg-white/20 rounded-lg appearance-none cursor-pointer accent-white"
                        style={{ backgroundSize: `${progress}% 100%`, backgroundImage: 'linear-gradient(#fff, #fff)' }}
                    />
                    <div className="flex justify-between text-[10px] font-bold text-white/60 tracking-wider">
                        <span>00:00</span>
                        <span>{track.duration || "0:00"}</span>
                    </div>
                </div>

                <div className="flex items-center justify-center gap-8 -mt-2">
                    <button className="text-white/80 hover:text-white transition-colors">
                        <SkipBack size={24} fill="currentColor" />
                    </button>
                    <motion.button 
                        whileHover={{ scale: 1.1 }}
                        whileTap={{ scale: 0.9 }}
                        onClick={togglePlay}
                        className="w-14 h-14 bg-white text-indigo-600 rounded-full flex items-center justify-center shadow-xl hover:bg-gray-50 transition-colors"
                    >
                        {isPlaying ? <Pause size={28} fill="currentColor" /> : <Play size={28} fill="currentColor" className="ml-1" />}
                    </motion.button>
                    <button className="text-white/80 hover:text-white transition-colors">
                        <SkipForward size={24} fill="currentColor" />
                    </button>
                </div>
            </div>
        </div>
    );
};

export const PlaylistConfirmModal = ({ onConfirm, onCancel, isAdding }) => (
  <AnimatePresence>
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      style={{ backdropFilter: 'blur(6px)', backgroundColor: 'rgba(0,0,0,0.45)' }}
      onClick={onCancel}
    >
      <motion.div
        initial={{ scale: 0.85, opacity: 0, y: 30 }}
        animate={{ scale: 1, opacity: 1, y: 0 }}
        exit={{ scale: 0.85, opacity: 0, y: 30 }}
        transition={{ type: 'spring', stiffness: 320, damping: 28 }}
        onClick={e => e.stopPropagation()}
        className="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 relative overflow-hidden"
      >
        {/* Decorative gradient blob */}
        <div className="absolute -top-10 -right-10 w-36 h-36 bg-indigo-100 rounded-full blur-2xl opacity-60 pointer-events-none" />

        {/* Close button */}
        <button
          onClick={onCancel}
          className="absolute top-4 right-4 text-gray-300 hover:text-gray-500 transition-colors p-1 rounded-full hover:bg-gray-50"
        >
          <X size={18} />
        </button>

        {/* Icon */}
        <div className="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
          <ListMusic size={32} className="text-indigo-500" />
        </div>

        <h3 className="text-xl font-black text-gray-800 text-center mb-2">Add to Playlist?</h3>
        <p className="text-sm text-gray-400 text-center mb-7 leading-relaxed">
          This post will be saved to your playlist.
          You can access it anytime from your profile.
        </p>

        <div className="flex gap-3">
          <button
            onClick={onCancel}
            disabled={isAdding}
            className="flex-1 py-3 px-4 rounded-2xl border-2 border-gray-100 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-all disabled:opacity-50"
          >
            Cancel
          </button>
          <motion.button
            whileTap={{ scale: 0.96 }}
            onClick={onConfirm}
            disabled={isAdding}
            className="flex-1 py-3 px-4 rounded-2xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-black text-sm shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all flex items-center justify-center gap-2 disabled:opacity-70"
          >
            {isAdding ? (
              <>
                <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                Adding…
              </>
            ) : (
              <>
                <ListMusic size={15} />
                Add to Playlist
              </>
            )}
          </motion.button>
        </div>
      </motion.div>
    </motion.div>
  </AnimatePresence>
);

export const DeleteConfirmModal = ({ onConfirm, onCancel, isDeleting }) => (
  <AnimatePresence>
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 z-50 flex items-center justify-center p-4"
      style={{ backdropFilter: 'blur(6px)', backgroundColor: 'rgba(0,0,0,0.45)' }}
      onClick={onCancel}
    >
      <motion.div
        initial={{ scale: 0.85, opacity: 0, y: 30 }}
        animate={{ scale: 1, opacity: 1, y: 0 }}
        exit={{ scale: 0.85, opacity: 0, y: 30 }}
        transition={{ type: 'spring', stiffness: 320, damping: 28 }}
        onClick={e => e.stopPropagation()}
        className="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 relative overflow-hidden"
      >
        {/* Decorative gradient blob */}
        <div className="absolute -top-10 -right-10 w-36 h-36 bg-red-100 rounded-full blur-2xl opacity-60 pointer-events-none" />

        {/* Close button */}
        <button
          onClick={onCancel}
          className="absolute top-4 right-4 text-gray-300 hover:text-gray-500 transition-colors p-1 rounded-full hover:bg-gray-50"
        >
          <X size={18} />
        </button>

        {/* Icon */}
        <div className="w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
          <AlertTriangle size={32} className="text-red-500" />
        </div>

        <h3 className="text-xl font-black text-gray-800 text-center mb-2">Delete Post?</h3>
        <p className="text-sm text-gray-400 text-center mb-7 leading-relaxed">
          This action is permanent and cannot be undone.
          Are you sure you want to delete this post?
        </p>

        <div className="flex gap-3">
          <button
            onClick={onCancel}
            disabled={isDeleting}
            className="flex-1 py-3 px-4 rounded-2xl border-2 border-gray-100 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-all disabled:opacity-50"
          >
            Cancel
          </button>
          <motion.button
            whileTap={{ scale: 0.96 }}
            onClick={onConfirm}
            disabled={isDeleting}
            className="flex-1 py-3 px-4 rounded-2xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-black text-sm shadow-lg shadow-red-200 hover:shadow-red-300 transition-all flex items-center justify-center gap-2 disabled:opacity-70"
          >
            {isDeleting ? (
              <>
                <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                Deleting…
              </>
            ) : (
              <>
                <Trash2 size={15} />
                Delete
              </>
            )}
          </motion.button>
        </div>
      </motion.div>
    </motion.div>
  </AnimatePresence>
);

export const SharePostModal = ({ onConfirm, onCancel, isSharing }) => {
  const [description, setDescription] = useState("");

  return (
    <AnimatePresence>
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        exit={{ opacity: 0 }}
        className="fixed inset-0 z-50 flex items-center justify-center p-4"
        style={{ backdropFilter: 'blur(6px)', backgroundColor: 'rgba(0,0,0,0.45)' }}
        onClick={onCancel}
      >
        <motion.div
          initial={{ scale: 0.85, opacity: 0, y: 30 }}
          animate={{ scale: 1, opacity: 1, y: 0 }}
          exit={{ scale: 0.85, opacity: 0, y: 30 }}
          transition={{ type: 'spring', stiffness: 320, damping: 28 }}
          onClick={e => e.stopPropagation()}
          className="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden"
        >
          {/* Decorative gradient blob */}
          <div className="absolute -top-10 -right-10 w-36 h-36 bg-green-100 rounded-full blur-2xl opacity-60 pointer-events-none" />

          {/* Close button */}
          <button
            onClick={onCancel}
            className="absolute top-4 right-4 text-gray-300 hover:text-gray-500 transition-colors p-1 rounded-full hover:bg-gray-50"
          >
            <X size={18} />
          </button>

          {/* Icon */}
          <div className="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
            <Share2 size={32} className="text-green-500" />
          </div>

          <h3 className="text-xl font-black text-gray-800 text-center mb-2">Share this Post</h3>
          <p className="text-sm text-gray-400 text-center mb-6 leading-relaxed">
            Share this post on your timeline. You can add a description below.
          </p>

          <textarea
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            placeholder="Write a description... (optional)"
            className="w-full h-24 p-4 mb-6 bg-gray-50 border border-gray-200 rounded-2xl resize-none focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:bg-white transition-all text-sm text-gray-700"
          />

          <div className="flex gap-3">
            <button
              onClick={onCancel}
              disabled={isSharing}
              className="flex-1 py-3 px-4 rounded-2xl border-2 border-gray-100 text-gray-500 font-bold text-sm hover:bg-gray-50 transition-all disabled:opacity-50"
            >
              Cancel
            </button>
            <motion.button
              whileTap={{ scale: 0.96 }}
              onClick={() => onConfirm(description)}
              disabled={isSharing}
              className="flex-1 py-3 px-4 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-black text-sm shadow-lg shadow-green-200 hover:shadow-green-300 transition-all flex items-center justify-center gap-2 disabled:opacity-70"
            >
              {isSharing ? (
                <>
                  <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                  Sharing…
                </>
              ) : (
                <>
                  <Share2 size={15} />
                  Share Now
                </>
              )}
            </motion.button>
          </div>
        </motion.div>
      </motion.div>
    </AnimatePresence>
  );
};

export const PostCard = ({ post, onDeleteSuccess }) => {
  const navigate = useNavigate();
  const [isLiked, setIsLiked] = useState(post.is_like === "1");
  const [likesCount, setLikesCount] = useState(Number(post.likes_count) || 0);
  const [showComments, setShowComments] = useState(false);
  const [commentCount, setCommentCount] = useState(Number(post.comment_count) || 0);

  useEffect(() => {
    setCommentCount(Number(post.comment_count) || 0);
  }, [post.comment_count]);
  const [menuOpen, setMenuOpen] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [isDeleting, setIsDeleting] = useState(false);
  const [showPlaylistModal, setShowPlaylistModal] = useState(false);
  const [isAddingToPlaylist, setIsAddingToPlaylist] = useState(false);
  const [showShareModal, setShowShareModal] = useState(false);
  const [isSharing, setIsSharing] = useState(false);
  const [videoEnded, setVideoEnded] = useState(false);
  const videoRef = useRef(null);
  const [videoElement, setVideoElement] = useState(null);
  const videoRefCallback = useCallback((node) => {
    videoRef.current = node;
    setVideoElement(node);
  }, []);
  const menuRef = useRef(null);

  // Determine if this post is a video post
  const firstMedia = post.get_post_media?.[0];
  const isVideoPost = post.post_type === "Media" && (firstMedia?.pm_media_type === "Video" || firstMedia?.pm_media_type_1 === "Video");

  // Auto-play / Pause video on viewport visibility
  useEffect(() => {
    if (!videoElement) return;

    // Force muted mode for autoplay compatibility
    videoElement.muted = true;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            // Play video in muted mode
            videoElement.muted = true;
            const playPromise = videoElement.play();
            if (playPromise !== undefined) {
              playPromise.catch((err) => {
                console.log("Autoplay failed/interrupted:", err);
              });
            }
          } else {
            // Pause video when out of viewport
            videoElement.pause();
          }
        });
      },
      {
        // 60% visibility threshold is ideal for feed autoplay
        threshold: 0.6,
      }
    );

    observer.observe(videoElement);

    return () => {
      observer.unobserve(videoElement);
    };
  }, [videoElement]);

  const handleVideoReplay = useCallback(() => {
    if (videoRef.current) {
      videoRef.current.currentTime = 0;
      videoRef.current.play();
      setVideoEnded(false);
    }
  }, []);

  const handleSeeMoreInVideo = useCallback(() => {
    navigate(`/postDetail/${post.post_id}`);
  }, [navigate, post.post_id]);

  // Close dropdown when clicking outside
  useEffect(() => {
    if (!menuOpen) return;
    const handler = (e) => {
      if (menuRef.current && !menuRef.current.contains(e.target)) {
        setMenuOpen(false);
      }
    };
    document.addEventListener('mousedown', handler);
    return () => document.removeEventListener('mousedown', handler);
  }, [menuOpen]);

  const handleDeleteConfirm = async () => {
    setIsDeleting(true);
    try {
      const result = await deletePost(post.post_id);
      if (result?.settings?.success === '1' || result?.settings?.success === 1) {
        toast.success(result?.settings?.message || 'Post deleted successfully! 🗑️');
        setShowDeleteModal(false);
        onDeleteSuccess(post.post_id);
      } else {
        toast.error(result?.settings?.message || result?.message || 'Failed to delete post. Please try again.');
      }
    } catch (err) {
      toast.error('Something went wrong. Please try again.');
    } finally {
      setIsDeleting(false);
    }
  };

  const handleAddToPlaylist = async () => {
    setIsAddingToPlaylist(true);
    try {
      const result = await addToPlaylist(post.post_id);
      if (result?.success === true || result?.success === 'true' || result?.success === 1 || result?.success === '1') {
        toast.success(result?.message || 'Video added to playlist successfully! 🎵');
        setShowPlaylistModal(false);
      } else {
        toast.error(result?.message || 'Failed to add to playlist. Please try again.');
      }
    } catch (err) {
      toast.error('Something went wrong. Please try again.');
    } finally {
      setIsAddingToPlaylist(false);
    }
  };

  const handleShare = async (description) => {
    setIsSharing(true);
    try {
      const result = await sharePostInTimeline(post.post_id, description);
      if (result?.settings?.success === '1' || result?.settings?.success === 1 || result?.success === true || result?.success === 'true' || result?.success === 1 || result?.success === '1') {
        toast.success(result?.message || result?.settings?.message || 'Post shared to timeline successfully! ✨');
        setShowShareModal(false);
      } else {
        toast.error(result?.message || result?.settings?.message || 'Failed to share post. Please try again.');
      }
    } catch (err) {
      toast.error('Something went wrong. Please try again.');
    } finally {
      setIsSharing(false);
    }
  };

  const handleLike = async () => {
    try {
      const newLikeStatus = !isLiked;
      setIsLiked(newLikeStatus);
      setLikesCount(prev => newLikeStatus ? prev + 1 : prev - 1);
      
      const media = post.get_post_media?.[0];
      const mediaId = media?.pm_post_media_id_1 || media?.pm_post_media_id || media?.post_media_id;
      
      if (post.post_type === "Media" && mediaId) {
        await likePostMedia(mediaId, post.post_id, newLikeStatus ? 1 : 0);
      } else {
        await likePost(post.post_id, newLikeStatus ? 1 : 0);
      }
    } catch (error) {
      console.error("Failed to like post", error);
      setIsLiked(post.is_like === "1");
      setLikesCount(Number(post.likes_count) || 0);
    }
  };

  const renderContent = () => {
      // 1. Handle Music Type
      if (post.post_type === "Music" && post.music_track) {
          return <MusicPlayer track={post.music_track} />;
      }

      // 2. Handle Media Type (Image/Video)
      if (post.post_type === "Media") {
          const media = post.get_post_media && post.get_post_media.length > 0 
            ? post.get_post_media[0] 
            : null;

          if (!media) return null;

          const mediaType = media.pm_media_type || media.pm_media_type_1;
          const uploadFile = media.pm_upload_file || media.pm_upload_file_1;
          const videoThumbnail = media.pm_video_thumbnail || media.pm_video_thumbnail_1;

          if (mediaType === "Image") {
              return (
                <div className="rounded-2xl overflow-hidden mb-4 border border-gray-50 bg-gray-50 aspect-video flex items-center justify-center group/img relative">
                    <img 
                        src={uploadFile || media.display_image} 
                        alt="Post content" 
                        className="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-105" 
                        loading="lazy"
                    />
                </div>
              );
          }

          if (mediaType === "Video") {
              return (
                <div className="rounded-2xl overflow-hidden mb-4 border border-gray-50 bg-black aspect-video flex items-center justify-center relative group/vid">
                    <video 
                        ref={videoRefCallback}
                        src={uploadFile} 
                        className="w-full h-full object-contain"
                        controls
                        muted
                        playsInline
                        poster={videoThumbnail}
                        onEnded={() => setVideoEnded(true)}
                        onPlay={() => setVideoEnded(false)}
                    />

                    {/* Video Ended Overlay */}
                    <AnimatePresence>
                      {videoEnded && (
                        <motion.div
                          initial={{ opacity: 0 }}
                          animate={{ opacity: 1 }}
                          exit={{ opacity: 0 }}
                          transition={{ duration: 0.35 }}
                          className="absolute inset-0 z-10 flex items-center justify-center gap-10"
                          style={{ backgroundColor: 'rgba(0,0,0,0.55)', backdropFilter: 'blur(4px)' }}
                        >
                          {/* See More in Video */}
                          <motion.button
                            initial={{ y: 20, opacity: 0 }}
                            animate={{ y: 0, opacity: 1 }}
                            transition={{ delay: 0.1, type: 'spring', stiffness: 300, damping: 24 }}
                            whileHover={{ scale: 1.08 }}
                            whileTap={{ scale: 0.95 }}
                            onClick={handleSeeMoreInVideo}
                            className="flex flex-col items-center gap-2 cursor-pointer group/btn"
                          >
                            <div className="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center shadow-xl group-hover/btn:bg-white/25 transition-all duration-300">
                              <Play size={24} className="text-white ml-0.5" fill="white" />
                            </div>
                            <span className="text-white text-xs font-bold tracking-wide drop-shadow-lg">See More in Video</span>
                          </motion.button>

                          {/* Replay */}
                          <motion.button
                            initial={{ y: 20, opacity: 0 }}
                            animate={{ y: 0, opacity: 1 }}
                            transition={{ delay: 0.2, type: 'spring', stiffness: 300, damping: 24 }}
                            whileHover={{ scale: 1.08 }}
                            whileTap={{ scale: 0.95 }}
                            onClick={handleVideoReplay}
                            className="flex flex-col items-center gap-2 cursor-pointer group/btn"
                          >
                            <div className="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md border border-white/25 flex items-center justify-center shadow-xl group-hover/btn:bg-white/25 transition-all duration-300">
                              <RefreshCw size={24} className="text-white" />
                            </div>
                            <span className="text-white text-xs font-bold tracking-wide drop-shadow-lg">Replay</span>
                          </motion.button>
                        </motion.div>
                      )}
                    </AnimatePresence>
                </div>
              );
          }
      }

      // 3. Text Type (or default)
      return null;
  };

  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      className="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-6"
    >
      <div className="flex items-center justify-between mb-4">
        <div className="flex items-center gap-3">
          <div className="relative">
            <img 
              src={getFullProfileImageUrl(post.user_profile_image)} 
              alt={post.user_name} 
              className="w-12 h-12 rounded-full object-cover border-2 border-orange-100"
              onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
            />
            <span className="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
          </div>
          <div>
            <h4 className="font-bold text-gray-800 text-sm md:text-base leading-tight">{post.user_name}</h4>
            <p className="text-[10px] md:text-xs text-gray-400 font-bold uppercase tracking-wider">{post.added_date}</p>
          </div>
        </div>
        {/* 3-dots menu */}
        <div className="relative" ref={menuRef}>
          <motion.button
            whileTap={{ scale: 0.9 }}
            onClick={() => setMenuOpen(prev => !prev)}
            className={`text-gray-400 hover:bg-gray-100 p-2 rounded-full transition-colors ${menuOpen ? 'bg-gray-100 text-gray-600' : ''}`}
          >
            <MoreHorizontal size={20} />
          </motion.button>

          <AnimatePresence>
            {menuOpen && (
              <motion.div
                initial={{ opacity: 0, scale: 0.88, y: -6 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.88, y: -6 }}
                transition={{ type: 'spring', stiffness: 340, damping: 26 }}
                className="absolute right-0 top-11 z-30 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden w-48 py-1"
              >
                {/* Delete Post */}
                <button
                  onClick={() => { setMenuOpen(false); setShowDeleteModal(true); }}
                  className="w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors group"
                >
                  <div className="w-7 h-7 rounded-xl bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors">
                    <Trash2 size={13} className="text-red-500" />
                  </div>
                  Delete Post
                </button>

                {/* Divider */}
                <div className="h-px bg-gray-50 mx-3" />

                {/* Add to Playlist */}
                <button
                  onClick={() => { setMenuOpen(false); setShowPlaylistModal(true); }}
                  className="w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors group"
                >
                  <div className="w-7 h-7 rounded-xl bg-indigo-50 group-hover:bg-indigo-100 flex items-center justify-center transition-colors">
                    <ListMusic size={13} className="text-indigo-500" />
                  </div>
                  Add to Playlist
                </button>
              </motion.div>
            )}
          </AnimatePresence>
        </div>
      </div>
      
      {post.post_text && (
        <p className="text-gray-600 mb-4 leading-relaxed whitespace-pre-wrap text-[15px]">
          {post.post_text}
        </p>
      )}

      {renderContent()}

      <div className="flex items-center gap-6 pt-4 border-t border-gray-50 mt-4">
        <button 
          onClick={handleLike}
          className={`flex items-center gap-2 transition-all group ${isLiked ? 'text-rose-500' : 'text-gray-400 hover:text-rose-500'}`}
        >
          <motion.div whileTap={{ scale: 1.4 }}>
            <Heart size={20} className={isLiked ? "fill-rose-500" : "group-hover:fill-rose-500/10"} />
          </motion.div>
          <span className="text-sm font-bold">{likesCount}</span>
        </button>
        
        <button 
          onClick={() => setShowComments(!showComments)}
          className={`flex items-center gap-2 transition-all group ${showComments ? 'text-blue-500' : 'text-gray-400 hover:text-blue-500'}`}
        >
          <MessageCircle size={20} className={showComments ? "fill-blue-500/10" : "group-hover:fill-blue-500/10"} />
          <span className="text-sm font-bold">{commentCount}</span>
        </button>
        
        <button 
          onClick={() => setShowShareModal(true)}
          className="flex items-center gap-2 text-gray-400 hover:text-green-500 transition-all ml-auto group"
        >
          <Share2 size={20} />
          <span className="text-sm font-bold group-hover:underline">Share</span>
        </button>

        {/* Video Details Icon — only for video posts */}
        {isVideoPost && (
          <motion.button
            whileTap={{ scale: 0.9 }}
            onClick={handleSeeMoreInVideo}
            className="flex items-center gap-1 text-indigo-400 hover:text-indigo-600 transition-all group"
            title="Video Details"
          >
            <Info size={20} />
          </motion.button>
        )}
      </div>

      <AnimatePresence>
        {showComments && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            className="overflow-hidden"
          >
            {/* Elegant Separator Line */}
            <div className="relative h-px w-full bg-gradient-to-r from-transparent via-gray-200 to-transparent my-4">
              <div className="absolute left-1/2 -top-1.5 -translate-x-1/2 bg-white px-2">
                <div className="w-1 h-1 rounded-full bg-gray-300" />
              </div>
            </div>

            <PostCommentSection 
              postId={post.post_id} 
              postMediaId={post.get_post_media?.[0]?.pm_post_media_id_1 || post.get_post_media?.[0]?.pm_post_media_id || post.get_post_media?.[0]?.post_media_id} 
              onCommentAdded={() => setCommentCount(prev => prev + 1)}
            />
          </motion.div>
        )}
      </AnimatePresence>

      {/* Delete Confirmation Modal */}
      {showDeleteModal && (
        <ModalPortal>
          <DeleteConfirmModal
            onConfirm={handleDeleteConfirm}
            onCancel={() => !isDeleting && setShowDeleteModal(false)}
            isDeleting={isDeleting}
          />
        </ModalPortal>
      )}

      {/* Playlist Confirmation Modal */}
      {showPlaylistModal && (
        <ModalPortal>
          <PlaylistConfirmModal
            onConfirm={handleAddToPlaylist}
            onCancel={() => !isAddingToPlaylist && setShowPlaylistModal(false)}
            isAdding={isAddingToPlaylist}
          />
        </ModalPortal>
      )}

      {/* Share Confirmation Modal */}
      {showShareModal && (
        <ModalPortal>
          <SharePostModal
            onConfirm={handleShare}
            onCancel={() => !isSharing && setShowShareModal(false)}
            isSharing={isSharing}
          />
        </ModalPortal>
      )}
    </motion.div>
  );
};

export default PostCard;
