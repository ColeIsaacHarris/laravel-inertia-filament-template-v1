import { Button } from '@/common/components/button';
import { Sheet, SheetContent } from '@/common/components/sheet';
import { useSidebar } from '@/modules/app-shell/contexts/sidebar-context';
import { PanelLeftCloseIcon, PanelLeftOpenIcon } from 'lucide-react';
import * as React from 'react';
import { Heading } from 'react-aria-components';
import { twMerge } from 'tailwind-merge';

const SIDEBAR_WIDTH_MOBILE = '18rem';

function Sidebar({
    side = 'left',
    variant = 'sidebar',
    collapsible = 'offcanvas',
    className,
    children,
    ...props
}: React.ComponentProps<'div'> & {
    side?: 'left' | 'right';
    variant?: 'sidebar' | 'floating' | 'inset';
    collapsible?: 'offcanvas' | 'icon' | 'none';
}) {
    const { isMobile, state, openMobile, setOpenMobile } = useSidebar();

    if (collapsible === 'none') {
        return (
            <div
                data-slot="sidebar"
                className={twMerge(
                    'flex h-full w-(--sidebar-width) flex-col bg-sidebar text-sidebar-foreground',
                    className,
                )}
                {...props}
            >
                {children}
            </div>
        );
    }

    if (isMobile) {
        return (
            <SheetContent
                isOpen={openMobile}
                onOpenChange={setOpenMobile}
                side={side}
                className="[&>div]:p-0"
                modalClassName="w-(--sidebar-width) bg-sidebar p-0 text-sidebar-foreground"
                style={
                    {
                        '--sidebar-width': SIDEBAR_WIDTH_MOBILE,
                    } as React.CSSProperties
                }
            >
                <Sheet
                    aria-label="Sidebar"
                    data-sidebar="sidebar"
                    data-slot="sidebar"
                    data-mobile="true"
                    className="flex h-full w-full flex-col p-0"
                >
                    <Heading slot="title" className="sr-only">
                        Sidebar
                    </Heading>
                    {children}
                </Sheet>
            </SheetContent>
        );
    }

    return (
        <div
            className="group peer hidden text-sidebar-foreground md:block"
            data-state={state}
            data-collapsible={state === 'collapsed' ? collapsible : ''}
            data-variant={variant}
            data-side={side}
            data-slot="sidebar"
        >
            <div
                className={twMerge(
                    'relative h-svh w-(--sidebar-width) bg-transparent motion-safe:transition-[width] motion-safe:duration-200 motion-safe:ease-linear',
                    'group-data-[collapsible=offcanvas]:w-0',
                    'group-data-[side=right]:rotate-180',
                    variant === 'floating' || variant === 'inset'
                        ? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4)))]'
                        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon)',
                )}
            />
            <div
                className={twMerge(
                    'fixed inset-y-0 z-10 hidden h-svh w-(--sidebar-width) motion-safe:transition-[left,right,width] motion-safe:duration-200 motion-safe:ease-linear md:flex',
                    side === 'left'
                        ? 'left-0 group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]'
                        : 'right-0 group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]',
                    variant === 'floating' || variant === 'inset'
                        ? 'p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4))+2px)]'
                        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon) group-data-[side=left]:border-r group-data-[side=right]:border-l',
                    className,
                )}
                {...props}
            >
                <div
                    data-sidebar="sidebar"
                    className="flex h-full w-full flex-col bg-sidebar group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:border group-data-[variant=floating]:border-sidebar-border group-data-[variant=floating]:shadow-sm"
                >
                    {children}
                </div>
            </div>
        </div>
    );
}

function SidebarTrigger({
    className,
    ...props
}: React.ComponentProps<typeof Button>) {
    const { toggleSidebar, isMobile, state } = useSidebar();

    return (
        <Button
            data-sidebar="trigger"
            data-slot="sidebar-trigger"
            variant="ghost"
            size="icon"
            className={twMerge('h-7 w-7', className as string)}
            onPress={toggleSidebar}
            {...props}
        >
            {isMobile || state === 'collapsed' ? (
                <PanelLeftOpenIcon />
            ) : (
                <PanelLeftCloseIcon />
            )}
            <span className="sr-only">Toggle Sidebar</span>
        </Button>
    );
}

export { Sidebar, SidebarTrigger };
