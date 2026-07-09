import React from "react";
import { Compass, Flame, Clock, Sparkles } from "lucide-react";

const CATEGORIES = [
    { id: "all", label: "All Videos", icon: Compass },
    { id: "trending", label: "Trending", icon: Flame },
    { id: "recent", label: "Recent Videos", icon: Clock },
    { id: "vp", label: "Suggested Videos", icon: Sparkles }
];

function CategoryTabs({ activeCategory, onSelectCategory }) {
    return (
        <div className="w-full overflow-x-auto no-scrollbar py-2 mb-6">
            <div className="flex items-center gap-3 px-1">
                {CATEGORIES.map((category) => {
                    const Icon = category.icon;
                    const isActive = activeCategory === category.id;
                    return (
                        <button
                            key={category.id}
                            type="button"
                            onClick={() => onSelectCategory(category.id)}
                            className={`flex items-center gap-2 px-5 py-3 rounded-full text-sm font-semibold tracking-wide transition-all duration-300 whitespace-nowrap border ${
                                isActive
                                    ? "bg-gradient-to-r from-purple-600 to-indigo-600 text-white border-transparent shadow-lg shadow-purple-200/50 scale-105"
                                    : "bg-white/80 hover:bg-white text-slate-600 border-slate-100 hover:border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5"
                            }`}
                        >
                            <Icon size={16} className={isActive ? "animate-pulse" : ""} />
                            <span>{category.label}</span>
                        </button>
                    );
                })}
            </div>
        </div>
    );
}

export default CategoryTabs;
