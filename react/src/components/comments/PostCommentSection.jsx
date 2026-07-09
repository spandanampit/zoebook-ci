import React, { useState, useEffect, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Send, 
    MessageCircle, 
    Heart, 
    MoreHorizontal, 
    Smile, 
    Camera, 
    Image as ImageIcon,
    Loader2,
    CornerDownRight
} from 'lucide-react';
import { fetchCommentList, postComment, likePostComment } from '../../services/commentService';
import { useUser } from '../../context/UserContext';
import { getFullProfileImageUrl } from '../../utils/imageUtils';
import { FALLBACK_IMAGE } from '../../config/siteConfig';

const CommentItem = ({ comment, postId, onReply }) => {
    const [isLiked, setIsLiked] = useState(comment.is_like === "1" || comment.is_liked === "1");
    const [likesCount, setLikesCount] = useState(Number(comment.likes_count) || Number(comment.count_comment_likes) || 0);
    const [isLiking, setIsLiking] = useState(false);

    const handleLike = async () => {
        if (isLiking) return;
        setIsLiking(true);
        const newStatus = isLiked ? 0 : 1;
        
        // Optimistic update
        setIsLiked(!isLiked);
        setLikesCount(prev => newStatus ? prev + 1 : prev - 1);

        try {
            await likePostComment(comment.post_comment_id, postId, newStatus);
        } catch (error) {
            // Rollback
            setIsLiked(isLiked);
            setLikesCount(prev => isLiked ? prev + 1 : prev - 1);
            console.error("Failed to like comment", error);
        } finally {
            setIsLiking(false);
        }
    };

    return (
        <motion.div 
            initial={{ opacity: 0, x: -10 }}
            animate={{ opacity: 1, x: 0 }}
            className="flex gap-3 py-3 group"
        >
            <img 
                src={getFullProfileImageUrl(comment.user_profile_image || comment.profile_image_url)} 
                alt={comment.user_name} 
                className="w-8 h-8 rounded-full object-cover shrink-0 border border-gray-100"
                onError={(e) => { e.target.src = FALLBACK_IMAGE; }}
            />
            <div className="flex-1 min-w-0">
                <div className="bg-white rounded-2xl px-4 py-2 relative group-hover:shadow-sm transition-all border border-slate-100/50">
                    <div className="flex justify-between items-start mb-0.5">
                        <span className="font-bold text-gray-900 text-[13px]">{comment.user_name}</span>
                        <span className="text-[10px] text-gray-400 font-medium">{comment.added_date}</span>
                    </div>
                    <p className="text-gray-700 text-[13.5px] leading-relaxed break-words whitespace-pre-wrap">
                        {comment.comment}
                    </p>
                    
                    {likesCount > 0 && (
                        <div className="absolute -right-2 -bottom-1 bg-white shadow-sm border border-gray-100 rounded-full px-1.5 py-0.5 flex items-center gap-1 scale-90">
                            <div className="w-3.5 h-3.5 bg-rose-500 rounded-full flex items-center justify-center">
                                <Heart size={8} className="fill-white text-white" />
                            </div>
                            <span className="text-[10px] font-bold text-gray-500">{likesCount}</span>
                        </div>
                    )}
                </div>
                
                <div className="flex items-center gap-4 mt-1.5 ml-2">
                    <button 
                        onClick={handleLike}
                        className={`text-[11px] font-bold transition-colors ${isLiked ? 'text-rose-500' : 'text-gray-500 hover:text-gray-700'}`}
                    >
                        Like
                    </button>
                    <button 
                        onClick={() => onReply(comment)}
                        className="text-[11px] font-bold text-gray-500 hover:text-gray-700 transition-colors"
                    >
                        Reply
                    </button>
                </div>

                {/* Nested Replies Rendering (if available in future) */}
                {comment.replies && comment.replies.length > 0 && (
                    <div className="mt-2 space-y-1">
                        {comment.replies.map(reply => (
                            <div key={reply.post_comment_id} className="flex gap-2">
                                <CornerDownRight size={14} className="text-gray-300 mt-2" />
                                <CommentItem comment={reply} postId={postId} onReply={onReply} />
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </motion.div>
    );
};

const PostCommentSection = ({ postId, postMediaId, onCommentAdded }) => {
    const { profile } = useUser();
    const [comments, setComments] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [newComment, setNewComment] = useState("");
    const [replyingTo, setReplyingTo] = useState(null);

    const loadComments = useCallback(async () => {
        setIsLoading(true);
        try {
            const response = await fetchCommentList(postId, postMediaId || "");
            if (response && response.data) {
                setComments(response.data);
            }
        } catch (error) {
            console.error("Failed to load comments", error);
        } finally {
            setIsLoading(false);
        }
    }, [postId, postMediaId]);

    useEffect(() => {
        loadComments();
    }, [loadComments]);

    const handlePostComment = async () => {
        if (!newComment.trim() || isSubmitting) return;

        setIsSubmitting(true);
        try {
            await postComment(
                postId, 
                postMediaId || "", 
                newComment, 
                replyingTo ? replyingTo.post_comment_id : null
            );
            setNewComment("");
            setReplyingTo(null);
            if (onCommentAdded) {
                onCommentAdded();
            }
            await loadComments();
        } catch (error) {
            console.error("Failed to post comment", error);
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <div className="mt-2 bg-slate-50/50 rounded-[2rem] p-4 border border-slate-100/50 shadow-inner">
            {/* Contextual Header */}
            <div className="flex items-center justify-between mb-4 px-2">
                <div className="flex items-center gap-2">
                    <span className="flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                    <h5 className="text-[11px] font-black text-slate-400 uppercase tracking-widest">Active Discussion</h5>
                </div>
                {comments.length > 0 && (
                    <span className="text-[10px] font-bold text-slate-400 bg-white px-2 py-0.5 rounded-full border border-slate-100">
                        {comments.length} Thoughts
                    </span>
                )}
            </div>

            {/* Comment List with Thread Line */}
            <div className="relative">
                {comments.length > 1 && (
                    <div className="absolute left-4 top-2 bottom-20 w-px bg-gradient-to-b from-slate-200 via-slate-100 to-transparent z-0" />
                )}
                
                <div className="max-h-[400px] overflow-y-auto custom-scrollbar pr-2 mb-4 space-y-1 relative z-10">
                    {isLoading ? (
                        <div className="flex flex-col items-center justify-center py-12 gap-3">
                            <div className="relative">
                                <Loader2 size={24} className="text-orange-500 animate-spin" />
                                <div className="absolute inset-0 bg-orange-500/20 blur-xl rounded-full animate-pulse" />
                            </div>
                            <span className="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Synchronizing...</span>
                        </div>
                    ) : comments.length > 0 ? (
                        comments.map((comment) => (
                            <CommentItem 
                                key={comment.post_comment_id} 
                                comment={comment} 
                                postId={postId}
                                onReply={(c) => {
                                    setReplyingTo(c);
                                    const input = document.getElementById(`comment-input-${postId}`);
                                    if (input) {
                                        input.focus();
                                        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                }}
                            />
                        ))
                    ) : (
                        <div className="text-center py-10 bg-white/50 rounded-3xl border border-dashed border-slate-200">
                            <div className="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-sm">
                                <MessageCircle size={20} className="text-slate-300" />
                            </div>
                            <p className="text-xs font-bold text-slate-400">No one has spoken yet.</p>
                            <p className="text-[10px] text-slate-300 font-medium">Be the first to share your thoughts!</p>
                        </div>
                    )}
                </div>
            </div>

            {/* Comment Input Area */}
            <div className="flex flex-col gap-3 bg-white p-4 rounded-[1.5rem] shadow-sm border border-slate-100 transition-all focus-within:shadow-md focus-within:border-orange-100">
                {replyingTo && (
                    <div className="flex items-center justify-between bg-orange-50 px-3 py-1.5 rounded-lg">
                        <span className="text-[11px] font-bold text-orange-600">
                            Replying to <span className="underline">{replyingTo.user_name}</span>
                        </span>
                        <button 
                            onClick={() => setReplyingTo(null)}
                            className="text-[10px] font-black uppercase text-orange-400 hover:text-orange-500"
                        >
                            Cancel
                        </button>
                    </div>
                )}
                
                <div className="flex items-start gap-3">
                    <img 
                        src={profile?.profileImage} 
                        alt="Current user" 
                        className="w-8 h-8 rounded-full object-cover shrink-0 border-2 border-orange-100 shadow-sm"
                    />
                    <div className="flex-1 relative group/input">
                        <textarea
                            id={`comment-input-${postId}`}
                            rows={1}
                            placeholder="Share your perspective..."
                            className="w-full bg-slate-50/50 border-none rounded-2xl px-4 py-2 text-[13.5px] text-gray-700 placeholder:text-slate-300 focus:ring-2 focus:ring-orange-100 transition-all resize-none overflow-hidden min-h-[40px]"
                            value={newComment}
                            onChange={(e) => {
                                setNewComment(e.target.value);
                                e.target.style.height = 'auto';
                                e.target.style.height = e.target.scrollHeight + 'px';
                            }}
                            onKeyDown={(e) => {
                                if (e.key === 'Enter' && !e.shiftKey) {
                                    e.preventDefault();
                                    handlePostComment();
                                }
                            }}
                        />
                        <div className="absolute right-2 bottom-1.5 flex items-center gap-1 opacity-0 group-focus-within/input:opacity-100 transition-opacity">
                            <button className="p-1.5 text-slate-300 hover:text-orange-500 transition-colors">
                                <Smile size={16} />
                            </button>
                        </div>
                    </div>
                    <button
                        onClick={handlePostComment}
                        disabled={!newComment.trim() || isSubmitting}
                        className={`mt-0.5 h-10 px-4 rounded-xl font-bold text-xs flex items-center gap-2 transition-all ${
                            newComment.trim() && !isSubmitting 
                            ? 'bg-slate-900 text-white shadow-lg shadow-slate-200 hover:bg-black active:scale-95' 
                            : 'bg-slate-50 text-slate-300 cursor-not-allowed'
                        }`}
                    >
                        {isSubmitting ? (
                            <Loader2 size={16} className="animate-spin" />
                        ) : (
                            <>
                                <span className="hidden sm:inline">Submit</span>
                                <Send size={14} />
                            </>
                        )}
                    </button>
                </div>
            </div>
        </div>
    );
};

export default PostCommentSection;
