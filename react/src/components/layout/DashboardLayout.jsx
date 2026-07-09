import Header from "../header/Header";

function DashboardLayout({
    sidebar,
    children,
    headerUser,
    isHeaderLoading = false,
    rightSidebar,
}) {
    return (
        <div className="min-h-screen bg-[#F8FAFC] w-full selection:bg-orange-100 selection:text-orange-600 pt-16">
            {/* Global Header */}
            <Header user={headerUser} isLoading={isHeaderLoading} />

            <div className="w-full px-4 sm:px-6 py-10 max-w-[1800px] mx-auto flex flex-col lg:flex-row gap-6 xl:gap-10">
                {/* Left Sidebar */}
                <aside className="w-full lg:w-72 xl:w-80 lg:sticky lg:top-24 self-start flex-shrink-0">
                    {sidebar}
                </aside>

                {/* Main Content */}
                <main className="flex-1 min-w-0">
                    {children}
                </main>

                {/* Right Sidebar - Optional */}
                {rightSidebar && (
                    <aside className="hidden xl:block w-80 2xl:w-[350px] sticky top-24 self-start flex-shrink-0">
                        {rightSidebar}
                    </aside>
                )}
            </div>
        </div>
    );
}

export default DashboardLayout;
