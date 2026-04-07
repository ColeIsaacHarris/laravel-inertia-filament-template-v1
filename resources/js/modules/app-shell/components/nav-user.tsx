import { MenuPopover, MenuTrigger } from '@/common/components/menu';
import { useIsMobile } from '@/common/hooks/use-mobile';
import type { SharedData } from '@/common/types/shared-data';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/modules/app-shell/components/sidebar/sidebar-menu';
import { UserInfo } from '@/modules/app-shell/components/user-info';
import { UserMenuContent } from '@/modules/app-shell/components/user-menu-content';
import { useSidebar } from '@/modules/app-shell/contexts/sidebar-context';
import { usePage } from '@inertiajs/react';
import { ChevronsUpDown } from 'lucide-react';

export function NavUser() {
    const { auth } = usePage<SharedData>().props;
    const { state } = useSidebar();
    const isMobile = useIsMobile();

    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <MenuTrigger>
                    <SidebarMenuButton
                        size="lg"
                        className="group text-sidebar-accent-foreground [aria-expanded=true]:bg-sidebar-accent"
                        data-test="sidebar-menu-button"
                    >
                        <UserInfo user={auth.user} />
                        <ChevronsUpDown className="ml-auto size-4" />
                    </SidebarMenuButton>
                    <MenuPopover
                        placement={
                            isMobile
                                ? 'bottom'
                                : state === 'collapsed'
                                  ? 'left'
                                  : 'bottom'
                        }
                        className="min-w-56"
                    >
                        <UserMenuContent user={auth.user} />
                    </MenuPopover>
                </MenuTrigger>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
