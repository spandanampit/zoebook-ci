import { ChevronRight, PlusCircle, TrendingUp, UserCircle } from "lucide-react";

function SideNavBarSkeleton() {
  return (
    <div className="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/60 border border-white animate-pulse">
      <div className="w-28 h-28 rounded-[2rem] bg-slate-200 mx-auto mb-6" />
      <div className="h-6 w-40 bg-slate-200 rounded mx-auto mb-3" />
      <div className="h-3 w-28 bg-slate-200 rounded mx-auto mb-8" />
      <div className="w-full flex flex-col gap-4">
        <div className="h-14 rounded-2xl bg-slate-200" />
        <div className="h-14 rounded-2xl bg-slate-200" />
        <div className="h-14 rounded-2xl bg-slate-200" />
      </div>
    </div>
  );
}

function SideNavBar({ user, isLoading = false }) {
  const currentUser = user ?? {
    name: "User",
    profileImage: "https://zoebook.mydevfactory.com/public/images/noimage.gif",
    membership: "Profile unavailable",
  };

  if (isLoading) {
    return <SideNavBarSkeleton />;
  }

  return (
    <div className="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/60 flex flex-col items-center text-center border border-white">
      <div className="w-28 h-28 rounded-[2rem] overflow-hidden mb-6 rotate-3 shadow-2xl">
        <img
          src={currentUser.profileImage}
          alt={currentUser.name}
          className="w-full h-full object-cover"
        />
      </div>

      <h2 className="text-2xl font-black text-slate-800 mb-1">
        {currentUser.name}
      </h2>

      <p className="text-xs text-slate-400 font-bold uppercase tracking-[0.2em] mb-8">
        {currentUser.membership}
      </p>

      <nav className="w-full flex flex-col gap-4">
        <a
          href="https://zoebook.mydevfactory.com/popularmovement"
          className="group flex items-center justify-between bg-orange-500 text-white p-4 rounded-2xl font-bold text-sm hover:bg-orange-600 transition-all shadow-xl shadow-orange-200"
        >
          <span className="flex items-center gap-3">
            <TrendingUp size={18} />
            Popular
          </span>
          <ChevronRight
            size={14}
            className="opacity-50 group-hover:translate-x-1 transition-transform"
          />
        </a>

        <a
          href="https://zoebook.mydevfactory.com/mymovement.html"
          className="group flex items-center justify-between bg-[#A7D397] text-white p-4 rounded-2xl font-bold text-sm hover:opacity-90 transition-all"
        >
          <span className="flex items-center gap-3">
            <UserCircle size={18} />
            My Movements
          </span>
          <ChevronRight
            size={14}
            className="opacity-50 group-hover:translate-x-1 transition-transform"
          />
        </a>

        <a
          href="https://zoebook.mydevfactory.com/addmovement.html"
          className="group flex items-center justify-between bg-[#9071AF] text-white p-4 rounded-2xl font-bold text-sm hover:opacity-90 transition-all shadow-xl shadow-purple-100"
        >
          <span className="flex items-center gap-3">
            <PlusCircle size={18} />
            Create New
          </span>
          <ChevronRight
            size={14}
            className="opacity-50 group-hover:translate-x-1 transition-transform"
          />
        </a>
      </nav>
    </div>
  );
}

export default SideNavBar;
