import { toUrl } from '@/common/helpers/utils';
import type { NavItem } from '@/common/types/navigation';
import {
    SidebarGroup,
    SidebarGroupLabel,
} from '@/modules/app-shell/components/sidebar/sidebar-group';
import {
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuLink,
} from '@/modules/app-shell/components/sidebar/sidebar-menu';
import { useCurrentUrl } from '@/modules/app-shell/hooks/use-current-url';

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const { isCurrentUrl } = useCurrentUrl();

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuLink
                            href={toUrl(item.href)}
                            isActive={isCurrentUrl(item.href)}
                            tooltip={{ children: item.title }}
                        >
                            {item.icon && <item.icon />}
                            <span>{item.title}</span>
                        </SidebarMenuLink>
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
