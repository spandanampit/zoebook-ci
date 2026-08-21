import Header from "../header/Header";

function DashboardLayout({
    sidebar,
    children,
    headerUser,
    isHeaderLoading = false,
}) {
    return (
        <div className="min-h-screen bg-[#F8FAFC] w-full selection:bg-orange-100 selection:text-orange-600 pt-16">
            {/* Global Header */}
            <Header user={headerUser} isLoading={isHeaderLoading} />

            <div className="w-full px-6 py-10 max-w-[1800px] mx-auto flex flex-col lg:flex-row gap-10">
                <aside className="w-full lg:w-80 lg:sticky lg:top-24 self-start">
                    {sidebar}
                </aside>

                <main className="flex-1">{children}</main>
            </div>
        </div>
    );
}

export default DashboardLayout;
