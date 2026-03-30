import React from "react";
import { SendHorizontal, MessageSquare, Sparkles } from "lucide-react";
import CommentItem from "./CommentItem";

const CommentSkeleton = () => (
    <div className="animate-pulse flex gap-3 p-3">
        <div className="w-10 h-10 rounded-2xl bg-gray-100" />
        <div className="flex-1 space-y-2">
            <div className="h-3 w-1/3 bg-gray-100 rounded-full" />
            <div className="h-8 w-full bg-gray-50 rounded-2xl" />
        </div>
    </div>
);

const MovementComments = ({
    postId = "",
    comments = [],
    isLoading = false,
    error = "",
    draftComment = "",
    isSubmitting = false,
    submitError = "",
    onDraftChange,
    onSubmit,
}) => {
    const hasComments = Array.isArray(comments) && comments.length > 0;
    const canSubmit = Boolean(draftComment.trim()) && !isSubmitting;

    return (
        <section className="h-full flex flex-col bg-[#F8FAFC] rounded-[2.5rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden">
            {/* Ultra-Minimal Header */}
            <div className="px-6 pt-6 pb-4 flex items-center justify-between">
                <div>
                    <h5 className="text-xl font-black text-slate-900 flex items-center gap-2">
                        Voices{" "}
                        <Sparkles className="w-5 h-5 text-amber-400 fill-amber-400" />
                    </h5>
                    <p className="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                        Community Interaction
                    </p>
                </div>
                {hasComments && (
                    <div className="flex -space-x-2">
                        {/* Static placeholder for 'active users' look */}
                        {[1, 2, 3].map((i) => (
                            <div
                                key={i}
                                className="w-7 h-7 rounded-full border-2 border-white bg-slate-200"
                            />
                        ))}
                        <div className="w-7 h-7 rounded-full border-2 border-white bg-slate-900 text-[8px] flex items-center justify-center text-white font-bold">
                            +{comments.length}
                        </div>
                    </div>
                )}
            </div>

            {/* Comment Feed with Floating Cards */}
            <div className="flex-1 overflow-y-auto px-4 space-y-1 custom-scrollbar">
                {isLoading ? (
                    <div className="space-y-2">
                        <CommentSkeleton />
                        <CommentSkeleton />
                    </div>
                ) : error ? (
                    <div className="m-4 p-4 rounded-3xl bg-rose-50 border border-rose-100 text-rose-600 text-xs font-bold flex items-center gap-3">
                        <div className="w-2 h-2 rounded-full bg-rose-500 animate-ping" />
                        {error}
                    </div>
                ) : !hasComments ? (
                    <div className="py-12 flex flex-col items-center justify-center text-center">
                        <div className="w-16 h-16 bg-white rounded-[2rem] shadow-sm flex items-center justify-center mb-4">
                            <MessageSquare className="w-6 h-6 text-slate-300" />
                        </div>
                        <p className="text-sm font-bold text-slate-400">
                            Be the first to speak
                        </p>
                    </div>
                ) : (
                    <div className="space-y-1">
                        {comments.map((comment) => (
                            <div
                                key={
                                    comment.post_comment_id ||
                                    `${comment.user_id}-${comment.added_date}`
                                }
                                className="p-1"
                            >
                                {/* We wrap the Item to give it a "floating" container style */}
                                <div className="bg-white rounded-[1.5rem] p-1 shadow-[0_2px_10px_rgba(0,0,0,0.02)] border border-transparent hover:border-slate-100 hover:shadow-md transition-all duration-300">
                                    <CommentItem comment={comment} postId={postId} />
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>

            {/* The "Command Center" Input */}
            <div className="p-6">
                {submitError && (
                    <div className="mb-3 p-3 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-xs font-semibold">
                        {submitError}
                    </div>
                )}
                <div className="relative flex items-center bg-white rounded-3xl p-2 shadow-[0_10px_25px_rgba(0,0,0,0.04)] border border-slate-100 transition-all focus-within:shadow-xl focus-within:ring-4 focus-within:ring-slate-100">
                    <div className="pl-4 pr-2">
                        <div className="w-2 h-2 rounded-full bg-green-400" />
                    </div>
                    <input
                        type="text"
                        placeholder="Add to the story..."
                        className="flex-1 py-3 text-sm font-bold text-slate-700 outline-none placeholder:text-slate-300"
                        value={draftComment}
                        onChange={(event) => onDraftChange?.(event.target.value)}
                        onKeyDown={(event) => {
                            if (event.key === "Enter") {
                                event.preventDefault();
                                onSubmit?.();
                            }
                        }}
                    />
                    <button
                        type="button"
                        onClick={() => onSubmit?.()}
                        disabled={!canSubmit}
                        className="h-11 px-5 rounded-2xl bg-slate-900 text-white flex items-center gap-2 font-bold text-xs transition-all hover:bg-slate-800 active:scale-95"
                    >
                        {isSubmitting ? "Posting..." : "Post"}
                        <SendHorizontal className="w-3.5 h-3.5" />
                    </button>
                </div>
            </div>
        </section>
    );
};

export default MovementComments;
