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
import { BookOpen, Folder, LayoutGrid } from 'lucide-react';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <NavUser />
                {/* <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuLink size="lg" href={String(dashboard())}>
                            <AppLogo />
                        </SidebarMenuLink>
                    </SidebarMenuItem>
                </SidebarMenu> */}
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                {/* <NavUser /> */}
            </SidebarFooter>
        </Sidebar>
    );
}
