import type { NavItem } from '@/common/types/navigation';
import { NavFooter } from '@/modules/app-shell/components/nav-footer';
import { NavMain } from '@/modules/app-shell/components/nav-main';
import { NavUser } from '@/modules/app-shell/components/nav-user';
import { Sidebar } from '@/modules/app-shell/components/sidebar/sidebar';
import {
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/modules/app-shell/components/sidebar/sidebar-structural';
import { dashboard } from '@/routes';
import { LayoutGrid } from 'lucide-react';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <NavUser />
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
            </SidebarFooter>
        </Sidebar>
    );
}
