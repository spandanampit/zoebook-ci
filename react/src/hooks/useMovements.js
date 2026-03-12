import { useCallback, useEffect, useRef, useState } from "react";
import { fetchMovementsAPI } from "../services/movementService";
import { normalizeMovement } from "../mappers/movementMapper";
import { toggleJoinMovementAPI } from "../services/movementService";

export default function useMovements() {
  const [items, setItems] = useState([]);
  const [currentPage, setCurrentPage] = useState(0);
  const [isInitialLoading, setIsInitialLoading] = useState(true);
  const [isLoadingMore, setIsLoadingMore] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const [error, setError] = useState("");

  const loadMoreRef = useRef(null);
  const isFetchingRef = useRef(false);

  const fetchMovements = useCallback(async (pageIndex) => {
    if (isFetchingRef.current) return;

    isFetchingRef.current = true;

    if (pageIndex === 1) {
      setIsInitialLoading(true);
    } else {
      setIsLoadingMore(true);
    }

    setError("");

    try {
      const payload = await fetchMovementsAPI(pageIndex);

      const rawItems = Array.isArray(payload?.data) ? payload.data : [];
      const normalizedItems = rawItems.map(normalizeMovement);

      setItems((prev) => {
        if (pageIndex === 1) return normalizedItems;

        const existingIds = new Set(prev.map((m) => m.id));
        const uniqueNext = normalizedItems.filter(
          (m) => !existingIds.has(m.id),
        );

        return [...prev, ...uniqueNext];
      });

      const count = Number(payload?.settings?.count);
      const perPage = Number(payload?.settings?.per_page);
      const currPage = Number(payload?.settings?.curr_page || pageIndex);

      if (!Number.isNaN(count) && !Number.isNaN(perPage) && perPage > 0) {
        setHasMore(currPage * perPage < count);
      } else {
        setHasMore(rawItems.length > 0);
      }

      setCurrentPage(currPage);
    } catch (err) {
      setError(err.message || "Failed to load movements.");
    } finally {
      setIsInitialLoading(false);
      setIsLoadingMore(false);
      isFetchingRef.current = false;
    }
  }, []);

  useEffect(() => {
    fetchMovements(1);
  }, [fetchMovements]);

  useEffect(() => {
    if (!loadMoreRef.current || !hasMore) return;
    if (typeof IntersectionObserver === "undefined") return;

    const observer = new IntersectionObserver(
      (entries) => {
        const first = entries[0];

        if (first.isIntersecting && !isInitialLoading && !isLoadingMore) {
          fetchMovements(currentPage + 1);
        }
      },
      {
        root: null,
        rootMargin: "300px",
        threshold: 0,
      },
    );

    observer.observe(loadMoreRef.current);

    return () => observer.disconnect();
  }, [currentPage, fetchMovements, hasMore, isInitialLoading, isLoadingMore]);

  const handleToggleJoin = async (movement) => {
    try {
      await toggleJoinMovementAPI(movement);
      setItems((prev) =>
        prev.map((item) =>
          item.id === movement.id
            ? { ...item, isJoined: !item.isJoined }
            : item,
        ),
      );
    } catch (e) {
      console.log(e);
    }
  };

  return {
    items,
    isInitialLoading,
    isLoadingMore,
    hasMore,
    error,
    loadMoreRef,
    handleToggleJoin,
  };
}
