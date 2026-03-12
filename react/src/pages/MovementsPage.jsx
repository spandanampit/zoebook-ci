import { useCallback } from "react";
import { useNavigate } from "react-router-dom";
import MovementsGrid from "../components/movements/MovementsGrid";
import useMovements from "../hooks/useMovements";

const MovementsPage = () => {
    const {
        items,
        isInitialLoading,
        isLoadingMore,
        hasMore,
        error,
        loadMoreRef,
        handleToggleJoin,
    } = useMovements();
    const navigate = useNavigate();

    const handleOpenDetails = useCallback(
        (movement) => {
            if (!movement?.isJoined) {
                window.alert(
                    "Please join the movement first to view its details.",
                );
                return;
            }

            const movementId = movement?.id;
            if (!movementId) {
                window.alert("Movement id is missing.");
                return;
            }

            navigate(`movement-details/${encodeURIComponent(movementId)}`);
        },
        [navigate],
    );

    return (
        <MovementsGrid
            items={items}
            isInitialLoading={isInitialLoading}
            isLoadingMore={isLoadingMore}
            hasMore={hasMore}
            error={error}
            loadMoreRef={loadMoreRef}
            onToggleJoin={handleToggleJoin}
            onOpenDetails={handleOpenDetails}
        />
    );
};

export default MovementsPage;
