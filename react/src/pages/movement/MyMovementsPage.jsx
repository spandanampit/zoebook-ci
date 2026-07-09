import { useCallback, useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import { toast } from "react-toastify";
import MovementsGrid from "../../components/movements/MovementsGrid";
import useMyMovements from "../../hooks/useMyMovements";
import { ACTIVE_USER_ID } from "../../config/siteConfig";
import { deactivateMovement } from "../../services/movementService";
import ModalPortal from "../../components/common/ModalPortal";

const MyMovementsPage = () => {
    const {
        items,
        isInitialLoading,
        isLoadingMore,
        hasMore,
        error,
        loadMoreRef,
        handleToggleJoin,
        refreshMovements,
    } = useMyMovements();
    const navigate = useNavigate();
    const location = useLocation();
    const [pendingStatusChange, setPendingStatusChange] = useState(null);
    const [isUpdatingStatus, setIsUpdatingStatus] = useState(false);

    useEffect(() => {
        const message = location.state?.toastMessage;
        if (!message) {
            return;
        }

        toast.success(message);
        navigate(location.pathname, { replace: true, state: null });
    }, [location.pathname, location.state, navigate]);

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

            navigate(`/movement-details/${encodeURIComponent(movementId)}`);
        },
        [navigate],
    );

    const getPrimaryAction = useCallback(
        (movement) => {
            if (String(movement?.usersId) === String(ACTIVE_USER_ID)) {
                const isInactive =
                    String(movement?.status || "").toLowerCase() ===
                    "inactive";

                return {
                    label: isInactive ? "Activate" : "Edit",
                    className: isInactive
                        ? "bg-emerald-500 text-white shadow-emerald-200 hover:bg-emerald-600 hover:shadow-emerald-300"
                        : "bg-sky-500 text-white shadow-sky-200 hover:bg-sky-600 hover:shadow-sky-300",
                    onClick: () => {
                        if (isInactive) {
                            setPendingStatusChange({
                                movement,
                                nextStatus: "Active",
                                actionLabel: "activate",
                            });
                            return;
                        }

                        const movementId = movement?.id;
                        if (!movementId) {
                            window.alert("Movement id is missing.");
                            return;
                        }

                        navigate(`/editmovement/${encodeURIComponent(movementId)}`);
                    },
                };
            }

            return null;
        },
        [navigate],
    );

    const getOwnerMenuOptions = useCallback(
        (movement) => {
            if (String(movement?.usersId) !== String(ACTIVE_USER_ID)) {
                return [];
            }
            const isInactive =
                String(movement?.status || "").toLowerCase() === "inactive";

            return [
                {
                    label: "Edit",
                    onClick: () => {
                        const movementId = movement?.id;

                        if (!movementId) {
                            window.alert("Movement id is missing.");
                            return;
                        }

                        navigate(`/editmovement/${encodeURIComponent(movementId)}`);
                    },
                },
                {
                    label: isInactive ? "Activate" : "Deactivate",
                    variant: isInactive ? "success" : "danger",
                    onClick: () => {
                        setPendingStatusChange({
                            movement,
                            nextStatus: isInactive ? "Active" : "Inactive",
                            actionLabel: isInactive ? "activate" : "deactivate",
                        });
                    },
                },
            ];
        },
        [navigate],
    );

    const handleConfirmStatusChange = useCallback(async () => {
        const movementId = pendingStatusChange?.movement?.id;
        const nextStatus = pendingStatusChange?.nextStatus;
        if (!movementId || !nextStatus || isUpdatingStatus) {
            return;
        }

        setIsUpdatingStatus(true);

        try {
            await deactivateMovement(movementId, nextStatus);
            const isActivating = nextStatus === "Active";
            toast.success(
                isActivating
                    ? "Movement activated successfully."
                    : "Movement deactivated successfully.",
            );
            setPendingStatusChange(null);
            await refreshMovements();
        } catch (err) {
            toast.error(err?.message || "Failed to update movement status.");
        } finally {
            setIsUpdatingStatus(false);
        }
    }, [isUpdatingStatus, pendingStatusChange, refreshMovements]);

    return (
        <>

            <MovementsGrid
                items={items}
                isInitialLoading={isInitialLoading}
                isLoadingMore={isLoadingMore}
                hasMore={hasMore}
                error={error}
                loadMoreRef={loadMoreRef}
                onToggleJoin={handleToggleJoin}
                onOpenDetails={handleOpenDetails}
                getPrimaryAction={getPrimaryAction}
                getOwnerMenuOptions={getOwnerMenuOptions}
            />

            {pendingStatusChange ? (
                <ModalPortal>
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 px-4">
                    <div className="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                        <h3 className="text-lg font-bold text-slate-800">
                            {pendingStatusChange.nextStatus === "Active"
                                ? "Activate Movement"
                                : "Deactivate Movement"}
                        </h3>
                        <p className="mt-2 text-sm text-slate-600">
                            Are you sure you want to{" "}
                            <span className="font-semibold text-slate-800">
                                {pendingStatusChange.actionLabel}
                            </span>{" "}
                            <span className="font-semibold text-slate-800">
                                {pendingStatusChange.movement?.movementTitle ||
                                    "this movement"}
                            </span>
                            ?
                        </p>

                        <div className="mt-6 flex justify-end gap-3">
                            <button
                                type="button"
                                className="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                                disabled={isUpdatingStatus}
                                onClick={() => setPendingStatusChange(null)}
                            >
                                No
                            </button>
                            <button
                                type="button"
                                className={`rounded-xl px-4 py-2 text-sm font-semibold text-white disabled:opacity-70 ${
                                    pendingStatusChange.nextStatus === "Active"
                                        ? "bg-emerald-500 hover:bg-emerald-600"
                                        : "bg-red-500 hover:bg-red-600"
                                }`}
                                disabled={isUpdatingStatus}
                                onClick={handleConfirmStatusChange}
                            >
                                {isUpdatingStatus
                                    ? pendingStatusChange.nextStatus === "Active"
                                        ? "Activating..."
                                        : "Deactivating..."
                                    : pendingStatusChange.nextStatus === "Active"
                                      ? "Yes, Activate"
                                      : "Yes, Deactivate"}
                            </button>
                        </div>
                    </div>
                </div>
                </ModalPortal>
            ) : null}
        </>
    );
};

export default MyMovementsPage;
