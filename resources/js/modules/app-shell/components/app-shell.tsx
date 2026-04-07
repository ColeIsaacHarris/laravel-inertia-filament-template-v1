import type { SharedData } from '@/common/types/shared-data';
import { SidebarProvider } from '@/modules/app-shell/contexts/sidebar-context';
import { usePage } from '@inertiajs/react';
import type { ReactNode } from 'react';

type Props = {
    children: ReactNode;
    variant?: 'header' | 'sidebar';
};

export function AppShell({ children, variant = 'header' }: Props) {
    const isOpen = usePage<SharedData>().props.sidebarOpen;

    if (variant === 'header') {
        return (
            <div className="flex min-h-screen w-full flex-col">{children}</div>
        );
    }

    return <SidebarProvider defaultOpen={isOpen}>{children}</SidebarProvider>;
}
