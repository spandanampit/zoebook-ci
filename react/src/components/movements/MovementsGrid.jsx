import MovementCard from "./MovementCard";

function MovementCardSkeleton() {
    return (
        <article className="bg-white/75 backdrop-blur-md rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-5 animate-pulse">
            <div className="flex items-center justify-between mb-5">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-full bg-slate-200" />
                    <div className="space-y-2">
                        <div className="h-2.5 w-12 rounded bg-slate-200" />
                        <div className="h-3 w-24 rounded bg-slate-200" />
                    </div>
                </div>
                <div className="w-5 h-5 rounded-full bg-slate-200" />
            </div>
            <div className="w-full h-64 rounded-[1.5rem] bg-slate-200 mb-5" />
            <div className="space-y-3 mb-6">
                <div className="h-5 w-3/4 rounded bg-slate-200" />
                <div className="h-3 w-full rounded bg-slate-200" />
                <div className="h-3 w-4/5 rounded bg-slate-200" />
            </div>
            <div className="h-12 rounded-2xl bg-slate-200" />
        </article>
    );
}

function MovementsSkeleton({ count = 8 }) {
    return (
        <section className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
            {Array.from({ length: count }).map((_, index) => (
                <MovementCardSkeleton key={`movement-skeleton-${index}`} />
            ))}
        </section>
    );
}

function MovementsGrid({
  items,
  isInitialLoading,
  isLoadingMore,
  hasMore,
  error,
  loadMoreRef,
  onToggleJoin,
  onOpenDetails,
  getPrimaryAction,
  getOwnerMenuOptions,
}) {
    if (isInitialLoading && items.length === 0) {
        return <MovementsSkeleton />;
    }

    if (!isInitialLoading && items.length === 0 && !error) {
        return (
            <section className="py-14 text-center">
                <p className="text-slate-500 text-sm font-semibold">
                    No movements found.
                </p>
            </section>
        );
    }

    return (
        <section>
            <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
        {items.map((movement) => (
          <MovementCard
            key={movement.id}
            movement={movement}
            onToggleJoin={onToggleJoin}
            onOpenDetails={onOpenDetails}
            getPrimaryAction={getPrimaryAction}
            getOwnerMenuOptions={getOwnerMenuOptions}
          />
        ))}
      </div>

            {error ? (
                <p className="text-center text-red-500 text-sm font-semibold mt-8">
                    {error}
                </p>
            ) : null}

            {isLoadingMore ? (
                <div className="mt-8">
                    <MovementsSkeleton count={4} />
                </div>
            ) : null}

            {hasMore && !error ? (
                <div ref={loadMoreRef} className="h-4 mt-8" />
            ) : null}
        </section>
    );
}

export default MovementsGrid;
