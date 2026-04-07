import { AppContent } from '@/modules/app-shell/components/app-content';
import { AppShell } from '@/modules/app-shell/components/app-shell';
import { AppSidebar } from '@/modules/app-shell/components/app-sidebar';
import { AppSidebarHeader } from '@/modules/app-shell/components/app-sidebar-header';
import type { AppLayoutProps } from '@/modules/app-shell/types';

export function AppSidebarLayout({
    children,
    breadcrumbs = [],
}: AppLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar" className="overflow-x-hidden">
                <AppSidebarHeader breadcrumbs={breadcrumbs} />
                {children}
            </AppContent>
        </AppShell>
    );
}
