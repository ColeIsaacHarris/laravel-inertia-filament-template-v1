import * as React from 'react';
import {
    Button,
    type ButtonProps as RACButtonProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';

function SidebarGroup({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-group"
            data-sidebar="group"
            className={twMerge(
                'relative flex w-full min-w-0 flex-col p-2',
                className,
            )}
            {...props}
        />
    );
}

function SidebarGroupLabel({
    className,
    ...props
}: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-group-label"
            data-sidebar="group-label"
            className={twMerge(
                'flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium text-sidebar-foreground/70 ring-sidebar-ring outline-hidden ease-linear focus-visible:ring-2 motion-safe:transition-[margin,opacity] motion-safe:duration-200 [&>svg]:size-4 [&>svg]:shrink-0',
                'group-data-[collapsible=icon]:pointer-events-none group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0 group-data-[collapsible=icon]:select-none',
                className,
            )}
            {...props}
        />
    );
}

function SidebarGroupAction({ className, ...props }: RACButtonProps) {
    return (
        <Button
            data-slot="sidebar-group-action"
            data-sidebar="group-action"
            className={twMerge(
                'absolute top-3.5 right-3 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground ring-sidebar-ring outline-hidden transition-transform focus-visible:ring-2 data-hovered:bg-sidebar-accent data-hovered:text-sidebar-accent-foreground [&>svg]:size-4 [&>svg]:shrink-0',
                'after:absolute after:-inset-2 md:after:hidden',
                'group-data-[collapsible=icon]:hidden',
                className as string,
            )}
            {...props}
        />
    );
}

function SidebarGroupContent({
    className,
    ...props
}: React.ComponentProps<'div'>) {
    return (
        <div
            data-slot="sidebar-group-content"
            data-sidebar="group-content"
            className={twMerge('w-full text-sm', className)}
            {...props}
        />
    );
}

export {
    SidebarGroup,
    SidebarGroupAction,
    SidebarGroupContent,
    SidebarGroupLabel,
};
