import {
    DialogTrigger,
    Modal,
    ModalOverlay,
    Dialog as RACDialog,
    type ModalOverlayProps,
    type DialogProps as RACDialogProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv, type VariantProps } from 'tailwind-variants';

const sheetOverlayStyles = tv({
    base: 'fixed inset-0 z-50 bg-black/80',
    variants: {
        isEntering: {
            true: 'motion-safe:animate-in motion-safe:fade-in motion-safe:duration-300',
        },
        isExiting: {
            true: 'motion-safe:animate-out motion-safe:fade-out motion-safe:duration-300',
        },
    },
});

const sheetStyles = tv({
    base: 'fixed z-50 gap-4 bg-background shadow-lg motion-safe:transition motion-safe:ease-in-out',
    variants: {
        side: {
            top: 'inset-x-0 top-0 border-b',
            bottom: 'inset-x-0 bottom-0 border-t',
            left: 'inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm',
            right: 'inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm',
        },
        isEntering: {
            true: 'motion-safe:animate-in motion-safe:duration-300',
        },
        isExiting: {
            true: 'motion-safe:animate-out motion-safe:duration-300',
        },
    },
    compoundVariants: [
        {
            side: 'top',
            isEntering: true,
            className: 'motion-safe:slide-in-from-top',
        },
        {
            side: 'top',
            isExiting: true,
            className: 'motion-safe:slide-out-to-top',
        },
        {
            side: 'bottom',
            isEntering: true,
            className: 'motion-safe:slide-in-from-bottom',
        },
        {
            side: 'bottom',
            isExiting: true,
            className: 'motion-safe:slide-out-to-bottom',
        },
        {
            side: 'left',
            isEntering: true,
            className: 'motion-safe:slide-in-from-left',
        },
        {
            side: 'left',
            isExiting: true,
            className: 'motion-safe:slide-out-to-left',
        },
        {
            side: 'right',
            isEntering: true,
            className: 'motion-safe:slide-in-from-right',
        },
        {
            side: 'right',
            isExiting: true,
            className: 'motion-safe:slide-out-to-right',
        },
    ],
    defaultVariants: {
        side: 'right',
    },
});

type SheetSide = NonNullable<VariantProps<typeof sheetStyles>['side']>;

interface SheetContentProps extends ModalOverlayProps {
    side?: SheetSide;
    modalClassName?: string;
}

function SheetContent({
    side = 'right',
    className,
    modalClassName,
    children,
    isDismissable = true,
    ...props
}: SheetContentProps) {
    return (
        <ModalOverlay
            {...props}
            isDismissable={isDismissable}
            className={(renderProps) =>
                sheetOverlayStyles({
                    ...renderProps,
                    className:
                        typeof className === 'function'
                            ? className(renderProps)
                            : (className as string),
                })
            }
        >
            <Modal
                className={(renderProps) =>
                    sheetStyles({
                        side,
                        ...renderProps,
                        className: modalClassName,
                    })
                }
            >
                {children}
            </Modal>
        </ModalOverlay>
    );
}

function Sheet({ className, ...props }: RACDialogProps) {
    return (
        <RACDialog
            {...props}
            className={twMerge('grid gap-4 p-6 outline-none', className)}
        />
    );
}

function SheetHeader({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            className={twMerge(
                'flex flex-col gap-2 text-center sm:text-left',
                className,
            )}
            {...props}
        />
    );
}

function SheetFooter({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            className={twMerge(
                'flex flex-col-reverse gap-2 sm:flex-row sm:justify-end',
                className,
            )}
            {...props}
        />
    );
}

export {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetHeader,
    DialogTrigger as SheetTrigger,
    type SheetSide,
};
