import { Separator } from '@/common/components/separator';
import { Skeleton } from '@/common/components/skeleton';
import { Input } from '@/common/components/text-field';
import { useSidebar } from '@/modules/app-shell/contexts/sidebar-context';
import * as React from 'react';
import {
    Button,
    type ButtonProps as RACButtonProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';

function SidebarHeader({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-header"
            data-sidebar="header"
            className={twMerge('flex flex-col gap-2 p-2', className)}
            {...props}
        />
    );
}

function SidebarFooter({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-footer"
            data-sidebar="footer"
            className={twMerge('flex flex-col gap-2 p-2', className)}
            {...props}
        />
    );
}

function SidebarContent({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-content"
            data-sidebar="content"
            className={twMerge(
                'flex min-h-0 flex-1 flex-col gap-2 overflow-auto group-data-[collapsible=icon]:overflow-hidden',
                className,
            )}
            {...props}
        />
    );
}

function SidebarSeparator({
    className,
    ...props
}: React.ComponentProps<typeof Separator>) {
    return (
        <Separator
            data-slot="sidebar-separator"
            className={twMerge('mx-2 w-auto bg-sidebar-border', className)}
            {...props}
        />
    );
}

function SidebarInput({
    className,
    ...props
}: React.ComponentProps<typeof Input>) {
    return (
        <Input
            data-slot="sidebar-input"
            data-sidebar="input"
            className={twMerge(
                'h-8 w-full bg-background shadow-none',
                className as string,
            )}
            {...props}
        />
    );
}

function SidebarInset({ className, ...props }: React.ComponentProps<'main'>) {
    return (
        <main
            data-slot="sidebar-inset"
            className={twMerge(
                'relative flex min-h-svh max-w-full flex-1 flex-col bg-background',
                'peer-data-[variant=inset]:min-h-[calc(100svh-(--spacing(4)))] md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ml-0',
                className,
            )}
            {...props}
        />
    );
}

function SidebarRail({ className, ...props }: RACButtonProps) {
    const { toggleSidebar } = useSidebar();

    return (
        <Button
            data-sidebar="rail"
            data-slot="sidebar-rail"
            aria-label="Toggle Sidebar"
            excludeFromTabOrder
            onPress={toggleSidebar}
            className={twMerge(
                'absolute inset-y-0 z-20 hidden w-4 -translate-x-1/2 transition-all ease-linear group-data-[side=left]:-right-4 group-data-[side=right]:left-0 after:absolute after:inset-y-0 after:left-1/2 after:w-0.5 data-hovered:after:bg-sidebar-border sm:flex',
                'in-data-[side=left]:cursor-w-resize in-data-[side=right]:cursor-e-resize',
                '[[data-side=left][data-state=collapsed]_&]:cursor-e-resize [[data-side=right][data-state=collapsed]_&]:cursor-w-resize',
                'group-data-[collapsible=offcanvas]:translate-x-0 group-data-[collapsible=offcanvas]:after:left-full data-hovered:group-data-[collapsible=offcanvas]:bg-sidebar',
                '[[data-side=left][data-collapsible=offcanvas]_&]:-right-2',
                '[[data-side=right][data-collapsible=offcanvas]_&]:-left-2',
                className as string,
            )}
            {...props}
        />
    );
}

function SidebarMenuSkeleton({
    className,
    showIcon = false,
    ...props
}: React.ComponentProps<'div'> & {
    showIcon?: boolean;
}) {
    const [skeletonStyle] = React.useState(
        () =>
            ({
                '--skeleton-width': `${Math.floor(Math.random() * 40) + 50}%`,
            }) as React.CSSProperties,
    );

    return (
        <div
            data-slot="sidebar-menu-skeleton"
            data-sidebar="menu-skeleton"
            className={twMerge(
                'flex h-8 items-center gap-2 rounded-md px-2',
                className,
            )}
            {...props}
        >
            {showIcon && (
                <Skeleton
                    className="size-4 rounded-md"
                    data-sidebar="menu-skeleton-icon"
                />
            )}
            <Skeleton
                className="h-4 max-w-(--skeleton-width) flex-1"
                data-sidebar="menu-skeleton-text"
                style={skeletonStyle}
            />
        </div>
    );
}

export {
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarInput,
    SidebarInset,
    SidebarMenuSkeleton,
    SidebarRail,
    SidebarSeparator,
};
