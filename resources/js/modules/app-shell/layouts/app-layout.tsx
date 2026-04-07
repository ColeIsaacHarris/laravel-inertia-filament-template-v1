import { AppSidebarLayout as AppLayoutTemplate } from '@/modules/app-shell/layouts/app-sidebar-layout';
import type { AppLayoutProps } from '@/modules/app-shell/types';

export function AppLayout({ children, breadcrumbs, ...props }: AppLayoutProps) {
    return (
        <AppLayoutTemplate breadcrumbs={breadcrumbs} {...props}>
            {children}
        </AppLayoutTemplate>
    );
}
