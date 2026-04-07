import { Tooltip, TooltipTrigger } from '@/common/components/tooltip';
import { useSidebar } from '@/modules/app-shell/contexts/sidebar-context';
import * as React from 'react';
import {
    Button,
    type ButtonProps as RACButtonProps,
    Link as RACLink,
    type LinkProps as RACLinkProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv, type VariantProps } from 'tailwind-variants';

function SidebarMenu({ className, ...props }: React.ComponentProps<'ul'>) {
    return (
        <ul
            data-slot="sidebar-menu"
            data-sidebar="menu"
            className={twMerge('flex w-full min-w-0 flex-col gap-1', className)}
            {...props}
        />
    );
}

function SidebarMenuItem({ className, ...props }: React.ComponentProps<'li'>) {
    return (
        <li
            data-slot="sidebar-menu-item"
            data-sidebar="menu-item"
            className={twMerge('group/menu-item relative', className)}
            {...props}
        />
    );
}

const sidebarMenuButtonStyles = tv({
    base: 'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition-[width,height,padding] data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground focus-visible:ring-2 data-pressed:bg-sidebar-accent data-pressed:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 group-has-data-[sidebar=menu-action]/menu-item:pr-8 aria-disabled:pointer-events-none aria-disabled:opacity-50 data-[active=true]:bg-sidebar-accent data-[active=true]:font-medium data-[active=true]:text-sidebar-accent-foreground [aria-expanded=true]:data-hovered:bg-sidebar-accent [aria-expanded=true]:data-hovered:text-sidebar-accent-foreground group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0',
    variants: {
        variant: {
            default:
                'data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground',
            outline:
                'bg-background shadow-[0_0_0_1px_hsl(var(--sidebar-border))] data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground data-hovered:shadow-[0_0_0_1px_hsl(var(--sidebar-accent))]',
        },
        size: {
            default: 'h-8 text-sm',
            sm: 'h-7 text-xs',
            lg: 'h-12 text-sm group-data-[collapsible=icon]:p-0!',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'default',
    },
});

type SidebarMenuButtonVariants = VariantProps<typeof sidebarMenuButtonStyles>;

interface SidebarMenuButtonProps extends RACButtonProps {
    isActive?: boolean;
    variant?: SidebarMenuButtonVariants['variant'];
    size?: SidebarMenuButtonVariants['size'];
    tooltip?: string | { children: React.ReactNode };
}

function SidebarMenuButton({
    isActive = false,
    variant = 'default',
    size = 'default',
    tooltip,
    className,
    children,
    ...props
}: SidebarMenuButtonProps) {
    const { isMobile, state } = useSidebar();

    const buttonContent = (
        <Button
            data-slot="sidebar-menu-button"
            data-sidebar="menu-button"
            data-size={size}
            data-active={isActive}
            className={twMerge(
                sidebarMenuButtonStyles({ variant, size }),
                className as string,
            )}
            {...props}
        >
            {children}
        </Button>
    );

    if (!tooltip) {
        return buttonContent;
    }

    const tooltipContent =
        typeof tooltip === 'string' ? tooltip : tooltip.children;

    return (
        <TooltipTrigger delay={0}>
            {buttonContent}
            <Tooltip
                placement="right"
                style={{
                    display:
                        state !== 'collapsed' || isMobile ? 'none' : undefined,
                }}
            >
                {tooltipContent}
            </Tooltip>
        </TooltipTrigger>
    );
}

interface SidebarMenuLinkProps extends RACLinkProps {
    isActive?: boolean;
    variant?: SidebarMenuButtonVariants['variant'];
    size?: SidebarMenuButtonVariants['size'];
    tooltip?: string | { children: React.ReactNode };
}

function SidebarMenuLink({
    isActive = false,
    variant = 'default',
    size = 'default',
    tooltip,
    className,
    children,
    ...props
}: SidebarMenuLinkProps) {
    const { isMobile, state } = useSidebar();

    const linkContent = (
        <RACLink
            data-slot="sidebar-menu-button"
            data-sidebar="menu-button"
            data-size={size}
            data-active={isActive}
            className={twMerge(
                sidebarMenuButtonStyles({ variant, size }),
                className as string,
            )}
            {...props}
        >
            {children}
        </RACLink>
    );

    if (!tooltip) {
        return linkContent;
    }

    const tooltipContent =
        typeof tooltip === 'string' ? tooltip : tooltip.children;

    return (
        <TooltipTrigger delay={0}>
            {linkContent}
            <Tooltip
                placement="right"
                style={{
                    display:
                        state !== 'collapsed' || isMobile ? 'none' : undefined,
                }}
            >
                {tooltipContent}
            </Tooltip>
        </TooltipTrigger>
    );
}

function SidebarMenuAction({
    className,
    showOnHover = false,
    ...props
}: RACButtonProps & {
    showOnHover?: boolean;
}) {
    return (
        <Button
            data-slot="sidebar-menu-action"
            data-sidebar="menu-action"
            className={twMerge(
                'absolute top-1.5 right-1 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground ring-sidebar-ring outline-hidden transition-transform peer-hover/menu-button:text-sidebar-accent-foreground focus-visible:ring-2 data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground [&>svg]:size-4 [&>svg]:shrink-0',
                'after:absolute after:-inset-2 md:after:hidden',
                'peer-data-[size=sm]/menu-button:top-1',
                'peer-data-[size=default]/menu-button:top-1.5',
                'peer-data-[size=lg]/menu-button:top-2.5',
                'group-data-[collapsible=icon]:hidden',
                showOnHover &&
                    'group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 peer-data-[active=true]/menu-button:text-sidebar-accent-foreground md:opacity-0 [aria-expanded=true]:opacity-100',
                className as string,
            )}
            {...props}
        />
    );
}

function SidebarMenuBadge({
    className,
    ...props
}: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-menu-badge"
            data-sidebar="menu-badge"
            className={twMerge(
                'pointer-events-none absolute right-1 flex h-5 min-w-5 items-center justify-center rounded-md px-1 text-xs font-medium text-sidebar-foreground tabular-nums select-none',
                'peer-hover/menu-button:text-sidebar-accent-foreground peer-data-[active=true]/menu-button:text-sidebar-accent-foreground',
                'peer-data-[size=sm]/menu-button:top-1',
                'peer-data-[size=default]/menu-button:top-1.5',
                'peer-data-[size=lg]/menu-button:top-2.5',
                'group-data-[collapsible=icon]:hidden',
                className,
            )}
            {...props}
        />
    );
}

function SidebarMenuSub({ className, ...props }: React.ComponentProps<'ul'>) {
    return (
        <ul
            data-slot="sidebar-menu-sub"
            data-sidebar="menu-sub"
            className={twMerge(
                'mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l border-sidebar-border px-2.5 py-0.5',
                'group-data-[collapsible=icon]:hidden',
                className,
            )}
            {...props}
        />
    );
}

function SidebarMenuSubItem({
    className,
    ...props
}: React.ComponentProps<'li'>) {
    return (
        <li
            data-slot="sidebar-menu-sub-item"
            data-sidebar="menu-sub-item"
            className={twMerge('group/menu-sub-item relative', className)}
            {...props}
        />
    );
}

function SidebarMenuSubButton({
    size = 'md',
    isActive = false,
    className,
    ...props
}: RACLinkProps & {
    size?: 'sm' | 'md';
    isActive?: boolean;
}) {
    return (
        <RACLink
            data-slot="sidebar-menu-sub-button"
            data-sidebar="menu-sub-button"
            data-size={size}
            data-active={isActive}
            className={twMerge(
                'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground ring-sidebar-ring outline-hidden focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground pressed:bg-sidebar-accent pressed:text-sidebar-accent-foreground [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 [&>svg]:text-sidebar-accent-foreground',
                'data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground',
                size === 'sm' && 'text-xs',
                size === 'md' && 'text-sm',
                'group-data-[collapsible=icon]:hidden',
                className as string,
            )}
            {...props}
        />
    );
}

export {
    SidebarMenu,
    SidebarMenuAction,
    SidebarMenuBadge,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuLink,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
};
