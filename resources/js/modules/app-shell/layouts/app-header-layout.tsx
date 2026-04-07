import { AppContent } from '@/modules/app-shell/components/app-content';
import { AppHeader } from '@/modules/app-shell/components/app-header';
import { AppShell } from '@/modules/app-shell/components/app-shell';
import type { AppLayoutProps } from '@/modules/app-shell/types';

export function AppHeaderLayout({ children, breadcrumbs }: AppLayoutProps) {
    return (
        <AppShell>
            <AppHeader breadcrumbs={breadcrumbs} />
            <AppContent>{children}</AppContent>
        </AppShell>
    );
}
