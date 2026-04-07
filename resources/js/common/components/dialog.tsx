import {
    DialogTrigger,
    Heading,
    type HeadingProps,
    Modal,
    ModalOverlay,
    type ModalOverlayProps,
    Dialog as RACDialog,
    type DialogProps as RACDialogProps,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv, type VariantProps } from 'tailwind-variants';

const overlayStyles = tv({
    base: 'fixed inset-0 z-50 bg-black/80',
    variants: {
        isEntering: {
            true: 'animate-in fade-in duration-200',
        },
        isExiting: {
            true: 'animate-out fade-out duration-200',
        },
    },
});

const modalStyles = tv({
    base: 'fixed top-[50%] left-[50%] z-50 w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] rounded-lg border bg-background p-6 shadow-lg sm:max-w-lg',
    variants: {
        isEntering: {
            true: 'animate-in fade-in zoom-in-95 duration-200',
        },
        isExiting: {
            true: 'animate-out fade-out zoom-out-95 duration-200',
        },
    },
});

type DialogContentProps = ModalOverlayProps & {
    size?: VariantProps<typeof modalStyles>['isEntering'] extends unknown
        ? 'sm' | 'md' | 'lg'
        : never;
    modalClassName?: string;
};

function DialogContent({
    className,
    modalClassName,
    children,
    isDismissable = true,
    ...props
}: DialogContentProps) {
    return (
        <ModalOverlay
            {...props}
            isDismissable={isDismissable}
            className={(renderProps) =>
                overlayStyles({
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
                    modalStyles({
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

function Dialog({ className, ...props }: RACDialogProps) {
    return (
        <RACDialog {...props} className={twMerge('outline-none', className)} />
    );
}

function DialogHeader({ className, ...props }: React.ComponentProps<'div'>) {
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

function DialogFooter({ className, ...props }: React.ComponentProps<'div'>) {
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

function DialogTitle({ className, ...props }: HeadingProps) {
    return (
        <Heading
            slot="title"
            {...props}
            className={twMerge(
                'text-lg leading-none font-semibold',
                className as string,
            )}
        />
    );
}

function DialogDescription({ className, ...props }: React.ComponentProps<'p'>) {
    return (
        <p
            className={twMerge('text-sm text-muted-foreground', className)}
            {...props}
        />
    );
}

export {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
};
