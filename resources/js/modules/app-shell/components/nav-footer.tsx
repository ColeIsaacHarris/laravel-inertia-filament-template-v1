import { toUrl } from '@/common/helpers/utils';
import type { NavItem } from '@/common/types/navigation';
import {
    SidebarGroup,
    SidebarGroupContent,
} from '@/modules/app-shell/components/sidebar/sidebar-group';
import {
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuLink,
} from '@/modules/app-shell/components/sidebar/sidebar-menu';
import type { ComponentPropsWithoutRef } from 'react';

export function NavFooter({
    items,
    className,
    ...props
}: ComponentPropsWithoutRef<typeof SidebarGroup> & {
    items: NavItem[];
}) {
    return (
        <SidebarGroup
            {...props}
            className={`group-data-[collapsible=icon]:p-0 ${className || ''}`}
        >
            <SidebarGroupContent>
                <SidebarMenu>
                    {items.map((item) => (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuLink
                                href={toUrl(item.href)}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-neutral-600 data-hovered:text-neutral-800 dark:text-neutral-300 dark:data-hovered:text-neutral-100"
                            >
                                {item.icon && <item.icon className="h-5 w-5" />}
                                <span>{item.title}</span>
                            </SidebarMenuLink>
                        </SidebarMenuItem>
                    ))}
                </SidebarMenu>
            </SidebarGroupContent>
        </SidebarGroup>
    );
}
