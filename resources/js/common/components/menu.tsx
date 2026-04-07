import {
    Header,
    MenuSection,
    MenuTrigger,
    Popover,
    type PopoverProps,
    Menu as RACMenu,
    MenuItem as RACMenuItem,
    type MenuItemProps as RACMenuItemProps,
    type MenuProps as RACMenuProps,
    Separator,
    type SeparatorProps,
    composeRenderProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv } from 'tailwind-variants';

const menuStyles =
    'min-w-[8rem] overflow-auto rounded-md border bg-popover p-1 text-popover-foreground shadow-md outline-none';

const menuPopoverStyles = tv({
    base: 'z-50',
    variants: {
        isEntering: {
            true: 'animate-in fade-in zoom-in-95 duration-150',
        },
        isExiting: {
            true: 'animate-out fade-out zoom-out-95 duration-150',
        },
    },
});

const menuItemStyles = tv({
    base: "relative cursor-pointer flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none select-none [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 [&_svg:not([class*='text-'])]:text-muted-foreground",
    variants: {
        isFocused: {
            true: 'bg-accent text-accent-foreground',
        },
        isDisabled: {
            true: 'pointer-events-none opacity-50',
        },
        variant: {
            default: '',
            destructive:
                'text-destructive-foreground data-[focused]:bg-destructive/10 data-[focused]:text-destructive-foreground dark:data-[focused]:bg-destructive/40',
        },
    },
    defaultVariants: {
        variant: 'default',
    },
});

interface MenuPopoverProps extends Omit<PopoverProps, 'children'> {
    children: React.ReactNode;
}

function MenuPopover({ className, ...props }: MenuPopoverProps) {
    return (
        <Popover
            {...props}
            className={composeRenderProps(className, (className, renderProps) =>
                menuPopoverStyles({ ...renderProps, className }),
            )}
        />
    );
}

function Menu<T extends object>({ className, ...props }: RACMenuProps<T>) {
    return (
        <RACMenu
            {...props}
            className={twMerge(menuStyles, className as string)}
        />
    );
}

interface MenuItemProps extends RACMenuItemProps {
    variant?: 'default' | 'destructive';
}

function MenuItem({ className, variant, ...props }: MenuItemProps) {
    return (
        <RACMenuItem
            {...props}
            className={composeRenderProps(className, (className, renderProps) =>
                menuItemStyles({
                    ...renderProps,
                    variant,
                    className,
                }),
            )}
        />
    );
}

function MenuLabel({
    className,
    ...props
}: React.ComponentProps<typeof Header>) {
    return (
        <Header
            {...props}
            className={twMerge(
                'px-2 py-1.5 text-sm font-medium',
                className as string,
            )}
        />
    );
}

function MenuSeparator({ className, ...props }: SeparatorProps) {
    return (
        <Separator
            {...props}
            className={twMerge('-mx-1 my-1 h-px bg-border', className)}
        />
    );
}

export {
    Menu,
    MenuItem,
    MenuLabel,
    MenuPopover,
    MenuSection,
    MenuSeparator,
    MenuTrigger,
};
