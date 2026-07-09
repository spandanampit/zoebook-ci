import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import { useNavigate, useParams, useSearchParams } from "react-router-dom";
import MovementCover from "../../components/movements/movementDetails/MovementCover";
import MovementInfo from "../../components/movements/movementDetails/MovementInfo";
import MovementPosts from "../../components/movements/movementDetails/MovementPosts";
import MovementRightPanel from "../../components/movements/movementDetails/MovementRightPanel";
import {
    fetchMovementDetailsAPI,
    toggleJoinMovementAPI,
    fetchMovementPosts,
} from "../../services/movementService";
import { likePostMedia } from "../../services/postService";
import { useCreateMovementPost } from "../../hooks/useCreateMovementPost";

const MovementDetailsPage = () => {
    const [details, setDetails] = useState(null);
    const [posts, setPosts] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [isPostsLoading, setIsPostsLoading] = useState(true);
    const [isLoadingMorePosts, setIsLoadingMorePosts] = useState(false);
    const [postsPage, setPostsPage] = useState(1);
    const [hasMorePosts, setHasMorePosts] = useState(true);
    const [isLeaving, setIsLeaving] = useState(false);
    const [error, setError] = useState("");
    const [postsError, setPostsError] = useState("");
    const [likingMediaKeys, setLikingMediaKeys] = useState({});
    const { movementId: pathMovementId } = useParams();
    const [searchParams] = useSearchParams();
    const navigate = useNavigate();
    const postsSentinelRef = useRef(null);

    const movementId = useMemo(() => {
        return (
            pathMovementId ||
            searchParams.get("movements_id") ||
            searchParams.get("movementId") ||
            searchParams.get("id") ||
            ""
        );
    }, [pathMovementId, searchParams]);

    useEffect(() => {
        if (!movementId) {
            setError("Movement id is missing.");
            setIsLoading(false);
            return;
        }

        let isMounted = true;

        const loadDetails = async () => {
            setIsLoading(true);
            setError("");

            try {
                const payload = await fetchMovementDetailsAPI(movementId);

                if (!isMounted) return;

                const data = payload?.data || {};
                const info = data.get_movements || {};
                const files = Array.isArray(data.get_movements_file)
                    ? data.get_movements_file
                    : [];
                const followers = Array.isArray(data.follower_users_details)
                    ? data.follower_users_details
                    : [];

                const cover =
                    files.find((file) => file.mi_media_type === "Image")
                        ?.mi_upload_file ||
                    files[0]?.mi_upload_file ||
                    "";

                const membersPreview = followers
                    .map((follower) => follower.f_profile_image)
                    .filter(Boolean);

                setDetails({
                    id: info.movements_id,
                    title: info.movement_name || "Untitled movement",
                    description: info.description || "",
                    members: Number(info.total_members) || 0,
                    joinStatus: info.join_status || "",
                    visibility: info.visibility || "",
                    theme: info.theme || "",
                    status: info.status || "",
                    addedDate: info.added_date || "",
                    leaderName: info.users_name || "",
                    leaderEmail: info.users_email || "",
                    leaderImage: info.users_profile_image || "",
                    isMovementActive: info.is_movement_active === "1",
                    cover,
                    membersPreview,
                    followers,
                    files,
                });
            } catch (err) {
                if (!isMounted) return;
                setError(err?.message || "Failed to load movement details.");
            } finally {
                if (isMounted) {
                    setIsLoading(false);
                }
            }
        };

        loadDetails();

        return () => {
            isMounted = false;
        };
    }, [movementId]);

    const loadPostsPage = useCallback(
        async (pageToLoad, { append = false } = {}) => {
            if (!movementId) return;

            if (append) {
                setIsLoadingMorePosts(true);
            } else {
                setIsPostsLoading(true);
                setPostsError("");
            }

            try {
                const payload = await fetchMovementPosts(
                    movementId,
                    pageToLoad,
                );
                const apiPosts = Array.isArray(payload?.data)
                    ? payload.data.map((post) => {
                          const rawIsLiked =
                              post?.isLiked ?? post?.is_like ?? 0;
                          const normalizedIsLiked =
                              Number(rawIsLiked) === 1 ? 1 : 0;

                          return {
                              ...post,
                              isLiked: normalizedIsLiked,
                          };
                      })
                    : [];
                const settings = payload?.settings || {};
                const apiTotalCount = Number(settings.count);

                setPosts((prevPosts) => {
                    const basePosts = append ? prevPosts : [];
                    const seen = new Set(
                        basePosts.map(
                            (post, index) =>
                                post.post_id ||
                                post.actual_post_id ||
                                `${pageToLoad}-${index}`,
                        ),
                    );

                    const nextPosts = [...basePosts];

                    apiPosts.forEach((post, index) => {
                        const postKey =
                            post.post_id ||
                            post.actual_post_id ||
                            `${pageToLoad}-${index}`;

                        if (seen.has(postKey)) {
                            return;
                        }

                        seen.add(postKey);
                        nextPosts.push(post);
                    });

                    if (
                        Number.isFinite(apiTotalCount) &&
                        apiTotalCount >= 0 &&
                        nextPosts.length >= apiTotalCount
                    ) {
                        setHasMorePosts(false);
                    } else {
                        setHasMorePosts(apiPosts.length > 0);
                    }

                    return nextPosts;
                });

                if (append) {
                    setPostsPage(pageToLoad);
                } else {
                    setPostsPage(1);
                }
            } catch (err) {
                const message =
                    err?.message || "Failed to load movement posts.";
                setPostsError(message);
            } finally {
                if (append) {
                    setIsLoadingMorePosts(false);
                } else {
                    setIsPostsLoading(false);
                }
            }
        },
        [movementId],
    );

    // ── Upload hook (shared between MovementInfo + MovementPosts) ──────
    const { submitPost, isSubmitting, uploadProgress } =
        useCreateMovementPost({
            movementId,
            onSuccess: () => {
                // Refresh the posts feed after a successful upload
                loadPostsPage(1, { append: false });
            },
        });

    useEffect(() => {
        if (!movementId) {
            setPosts([]);
            setPostsError("Movement id is missing.");
            setIsPostsLoading(false);
            setIsLoadingMorePosts(false);
            setHasMorePosts(false);
            return;
        }

        setPosts([]);
        setLikingMediaKeys({});
        setPostsPage(1);
        setHasMorePosts(true);
        loadPostsPage(1, { append: false });
    }, [movementId, loadPostsPage]);

    const loadMorePosts = useCallback(() => {
        if (
            !movementId ||
            isPostsLoading ||
            isLoadingMorePosts ||
            !hasMorePosts
        ) {
            return;
        }

        loadPostsPage(postsPage + 1, { append: true });
    }, [
        movementId,
        isPostsLoading,
        isLoadingMorePosts,
        hasMorePosts,
        loadPostsPage,
        postsPage,
    ]);

    useEffect(() => {
        const node = postsSentinelRef.current;

        if (!node || !hasMorePosts) {
            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                const [entry] = entries;

                if (entry?.isIntersecting) {
                    loadMorePosts();
                }
            },
            {
                root: null,
                rootMargin: "0px 0px 480px 0px",
                threshold: 0,
            },
        );

        observer.observe(node);

        return () => {
            observer.disconnect();
        };
    }, [loadMorePosts, hasMorePosts]);

    const handleLeaveMovement = useCallback(async () => {
        if (!details?.id || isLeaving) {
            return;
        }

        setIsLeaving(true);

        try {
            await toggleJoinMovementAPI({
                id: details.id,
                isJoined: true,
            });

            navigate("/popularmovement", { replace: true });
        } catch (err) {
            window.alert(
                err?.message ||
                    "Failed to leave this movement. Please try again.",
            );
        } finally {
            setIsLeaving(false);
        }
    }, [details, isLeaving, navigate]);

    const handleToggleMediaLike = useCallback(
        async (postId, mediaId) => {
            if (!postId || !mediaId) {
                return;
            }

            const mediaKey = `${postId}-${mediaId}`;
            if (likingMediaKeys[mediaKey]) {
                return;
            }

            const targetPost = posts.find(
                (post) => String(post.post_id) === String(postId),
            );
            if (!targetPost) {
                return;
            }

            const mediaList = Array.isArray(targetPost.get_post_media)
                ? targetPost.get_post_media
                : [];
            const targetMedia = mediaList.find(
                (media) => String(media.pm_post_media_id) === String(mediaId),
            );
            if (!targetMedia) {
                return;
            }

            const currentIsLiked =
                Number(targetMedia.is_media_like) === 1 ? 1 : 0;
            const nextIsLiked = currentIsLiked === 1 ? 0 : 1;
            const currentLikes = Number(targetMedia.media_like_count) || 0;
            const nextLikes =
                nextIsLiked === 1
                    ? currentLikes + 1
                    : Math.max(currentLikes - 1, 0);

            setLikingMediaKeys((prev) => ({ ...prev, [mediaKey]: true }));

            setPosts((prevPosts) =>
                prevPosts.map((post) => {
                    if (String(post.post_id) !== String(postId)) {
                        return post;
                    }

                    return {
                        ...post,
                        get_post_media: Array.isArray(post.get_post_media)
                            ? post.get_post_media.map((media) => {
                                  if (
                                      String(media.pm_post_media_id) !==
                                      String(mediaId)
                                  ) {
                                      return media;
                                  }

                                  return {
                                      ...media,
                                      is_media_like: String(nextIsLiked),
                                      media_like_count: String(nextLikes),
                                  };
                              })
                            : post.get_post_media,
                    };
                }),
            );

            try {
                await likePostMedia(mediaId, postId, nextIsLiked);
            } catch (err) {
                setPosts((prevPosts) =>
                    prevPosts.map((post) => {
                        if (String(post.post_id) !== String(postId)) {
                            return post;
                        }

                        return {
                            ...post,
                            get_post_media: Array.isArray(post.get_post_media)
                                ? post.get_post_media.map((media) => {
                                      if (
                                          String(media.pm_post_media_id) !==
                                          String(mediaId)
                                      ) {
                                          return media;
                                      }

                                      return {
                                          ...media,
                                          is_media_like: String(currentIsLiked),
                                          media_like_count:
                                              String(currentLikes),
                                      };
                                  })
                                : post.get_post_media,
                        };
                    }),
                );

                window.alert(
                    err?.message || "Failed to update media like status.",
                );
            } finally {
                setLikingMediaKeys((prev) => {
                    const next = { ...prev };
                    delete next[mediaKey];
                    return next;
                });
            }
        },
        [posts, likingMediaKeys],
    );

    return (
        <div className="grid grid-cols-12 gap-6">
            <div className="col-span-8 space-y-6">
                <MovementCover
                    cover={details?.cover}
                    title={details?.title}
                    isLoading={isLoading}
                />

                <MovementInfo
                    movement={details}
                    isLoading={isLoading}
                    error={error}
                    submitPost={submitPost}
                    isSubmitting={isSubmitting}
                    uploadProgress={uploadProgress}
                />

                <MovementPosts
                    posts={posts}
                    isLoading={isPostsLoading}
                    isLoadingMore={isLoadingMorePosts}
                    hasMore={hasMorePosts}
                    error={postsError}
                    sentinelRef={postsSentinelRef}
                    likingMediaKeys={likingMediaKeys}
                    onToggleMediaLike={handleToggleMediaLike}
                    isUploading={isSubmitting}
                    uploadProgress={uploadProgress}
                />
            </div>

            <div className="col-span-4">
                <MovementRightPanel
                    movement={details}
                    isLoading={isLoading}
                    error={error}
                    isLeaving={isLeaving}
                    onLeaveMovement={handleLeaveMovement}
                />
            </div>
        </div>
    );
};

export default MovementDetailsPage;
