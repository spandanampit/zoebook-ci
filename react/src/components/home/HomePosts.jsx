import React, { useState, useEffect, useRef, useCallback } from 'react';
import { fetchPostList, fetchViralPostList } from '../../services/postService';
import { uploadMusicPost } from '../../services/postService';
import { ACTIVE_USER_ID } from '../../config/siteConfig';
import { AnimatePresence } from 'framer-motion';
import PostCard, { PostSkeleton } from '../posts/PostCard';
import CreatePostCard from '../posts/CreatePostCard';
import CreatePostModal from '../posts/CreatePostModal';
import MusicUploadModal from '../posts/MusicUploadModal';
import ModalPortal from '../common/ModalPortal';
import { useCreateHomePost } from '../../hooks/useCreateHomePost';
import { Play } from 'lucide-react';
import TopPlaylists from './TopPlaylists';
import { toast } from 'react-toastify';

const HomePosts = ({ feedType = 'home' }) => {
  const [posts, setPosts] = useState([]);
  const [page, setPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const observerRef = useRef();
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [modalInitialTab, setModalInitialTab] = useState('text');

  // Music modal state
  const [isMusicModalOpen, setIsMusicModalOpen] = useState(false);
  const [isMusicSubmitting, setIsMusicSubmitting] = useState(false);

  const handleOpenModal = useCallback((tab = 'text') => {
    setModalInitialTab(tab);
    setIsModalOpen(true);
  }, []);

  const handleOpenMusicModal = useCallback(() => {
    setIsMusicModalOpen(true);
  }, []);

  const loadPosts = useCallback(async (pageNum) => {
    if (loading) return;
    setLoading(true);
    try {
      // isFeed is set to 1 to fetch Posts feed
      const fetchFn = feedType === 'viral' ? fetchViralPostList : fetchPostList;
      const response = await fetchFn(ACTIVE_USER_ID, 1, pageNum);
      const newPosts = response?.data || [];
      
      if (newPosts.length === 0) {
        setHasMore(false);
      } else {
        setPosts(prev => pageNum === 1 ? newPosts : [...prev, ...newPosts]);
        setHasMore(newPosts.length > 0);
      }
    } catch (error) {
      console.error("Error loading home posts:", error);
      setHasMore(false);
    } finally {
      setLoading(false);
    }
  }, [loading]);

  // Refresh feed after a successful post creation
  const handlePostCreated = useCallback(() => {
    setPosts([]);
    setPage(1);
    setHasMore(true);
    loadPosts(1);
  }, [loadPosts]);

  // useCreateHomePost hook — handles the full upload pipeline
  const { submitPost, isSubmitting, uploadProgress } = useCreateHomePost({
    onSuccess: handlePostCreated,
  });

  // ── Music Upload Handler ───────────────────────────────────────────
  const handleMusicSubmit = useCallback(async (payload) => {
    setIsMusicSubmitting(true);
    const toastId = toast.loading("Uploading your track...", {
      position: "bottom-right",
      closeOnClick: false,
      draggable: false,
    });

    try {
      const result = await uploadMusicPost(payload);

      if (result.success === false) {
        throw new Error(result.message || "Music upload failed.");
      }

      toast.update(toastId, {
        render: "🎵 Track published successfully!",
        type: "success",
        isLoading: false,
        autoClose: 4000,
        closeOnClick: true,
        draggable: true,
      });

      // Refresh the feed to show the new music post
      handlePostCreated();
    } catch (error) {
      console.error("Music upload failed:", error);
      toast.update(toastId, {
        render: error?.message || "Failed to upload track. Please try again.",
        type: "error",
        isLoading: false,
        autoClose: 5000,
        closeOnClick: true,
        draggable: true,
      });
    } finally {
      setIsMusicSubmitting(false);
    }
  }, [handlePostCreated]);

  useEffect(() => {
    loadPosts(1);
  }, []);

  const lastPostElementRef = useCallback(node => {
    if (loading) return;
    if (observerRef.current) observerRef.current.disconnect();
    
    observerRef.current = new IntersectionObserver(entries => {
      if (entries[0].isIntersecting && hasMore) {
        setPage(prevPage => {
            const nextPage = prevPage + 1;
            loadPosts(nextPage);
            return nextPage;
        });
      }
    }, {
        rootMargin: '400px'
    });
    
    if (node) observerRef.current.observe(node);
  }, [loading, hasMore, loadPosts]);

  const handleDeleteSuccess = useCallback((postId) => {
    setPosts(prev => prev.filter(p => p.post_id !== postId));
  }, []);

  return (
    <div className="w-full max-w-3xl">
      {/* Create Post Entry Card */}
      <CreatePostCard
        onOpenModal={handleOpenModal}
        onOpenMusicModal={handleOpenMusicModal}
      />

      {/* Top Playlists Section */}
      <TopPlaylists />

      <AnimatePresence mode="popLayout">
        {posts.map((post, index) => {
          const key = `post-${post.post_id}-${index}`;
          if (posts.length === index + 1) {
            return (
              <div ref={lastPostElementRef} key={key}>
                <PostCard post={post} onDeleteSuccess={handleDeleteSuccess} />
              </div>
            );
          } else {
            return <PostCard key={key} post={post} onDeleteSuccess={handleDeleteSuccess} />;
          }
        })}
      </AnimatePresence>

      {loading && (
        <div className="space-y-6">
          <PostSkeleton />
          <PostSkeleton />
        </div>
      )}

      {!hasMore && posts.length > 0 && (
        <div className="text-center py-12 flex flex-col items-center gap-2">
          <div className="w-1.5 h-1.5 bg-gray-300 rounded-full" />
          <p className="text-gray-400 font-bold text-xs uppercase tracking-[0.2em]">No more stories to show</p>
        </div>
      )}

      {!loading && posts.length === 0 && (
        <div className="bg-white rounded-[2.5rem] p-16 text-center border border-gray-100 shadow-xl shadow-slate-100/50">
          <div className="w-24 h-24 bg-orange-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-orange-400 shadow-inner">
            <Play size={40} className="ml-1" />
          </div>
          <h3 className="text-2xl font-black text-slate-800 mb-2">Start your journey!</h3>
          <p className="text-slate-500 max-w-xs mx-auto mb-8 font-medium">Your feed is waiting for your first creation. Share a photo, video, or your favorite music.</p>
          <button 
            onClick={() => handleOpenModal('media')}
            className="bg-orange-500 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-orange-200 cursor-pointer"
          >
            Create Post
          </button>
        </div>
      )}

      {/* Create Post Modal — with real upload via useCreateHomePost */}
      <AnimatePresence>
        {isModalOpen && (
          <ModalPortal>
            <CreatePostModal
              isOpen={isModalOpen}
              onClose={() => setIsModalOpen(false)}
              initialTab={modalInitialTab}
              submitPost={submitPost}
              isSubmitting={isSubmitting}
            />
          </ModalPortal>
        )}
      </AnimatePresence>

      {/* Music Upload Modal */}
      <AnimatePresence>
        {isMusicModalOpen && (
          <ModalPortal>
            <MusicUploadModal
              isOpen={isMusicModalOpen}
              onClose={() => setIsMusicModalOpen(false)}
              onSubmit={handleMusicSubmit}
              isSubmitting={isMusicSubmitting}
            />
          </ModalPortal>
        )}
      </AnimatePresence>
    </div>
  );
};

export default HomePosts;
