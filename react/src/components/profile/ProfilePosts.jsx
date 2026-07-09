import React, { useState, useEffect, useRef, useCallback } from 'react';
import { fetchPostList } from '../../services/postService';
import { ACTIVE_USER_ID } from '../../config/siteConfig';
import { AnimatePresence } from 'framer-motion';
import PostCard, { PostSkeleton } from '../posts/PostCard';
import { Play } from 'lucide-react';

const ProfilePosts = ({ user }) => {
  const [posts, setPosts] = useState([]);
  const [page, setPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const observerRef = useRef();

  const loadPosts = useCallback(async (pageNum) => {
    if (loading) return;
    setLoading(true);
    try {
      const response = await fetchPostList(ACTIVE_USER_ID, 0, pageNum);
      const newPosts = response?.data || [];
      
      if (newPosts.length === 0) {
        setHasMore(false);
      } else {
        setPosts(prev => pageNum === 1 ? newPosts : [...prev, ...newPosts]);
        setHasMore(newPosts.length > 0);
      }
    } catch (error) {
      console.error("Error loading posts:", error);
      setHasMore(false);
    } finally {
      setLoading(false);
    }
  }, [loading]);

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
          <h3 className="text-2xl font-black text-slate-800 mb-2">No posts yet</h3>
          <p className="text-slate-500 max-w-xs mx-auto font-medium">Posts you create will appear here on your profile.</p>
        </div>
      )}
    </div>
  );
};

export default ProfilePosts;
