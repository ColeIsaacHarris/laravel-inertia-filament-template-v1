import {
    composeRenderProps,
    Button as RACButton,
    type ButtonProps as RACButtonProps,
} from 'react-aria-components';
import { tv, type VariantProps } from 'tailwind-variants';

import { Spinner } from '@/common/components/spinner';
import { focusRing } from '@/common/helpers/compose';

const buttonStyles = tv({
    extend: focusRing,
    base: "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 cursor-default",
    variants: {
        variant: {
            default:
                'bg-primary text-primary-foreground shadow-xs data-hovered:bg-primary/90',
            destructive:
                'bg-destructive text-white shadow-xs data-hovered:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40',
            outline:
                'border border-input bg-background shadow-xs data-hovered:bg-accent data-hovered:text-accent-foreground',
            secondary:
                'bg-secondary text-secondary-foreground shadow-xs data-hovered:bg-secondary/80',
            ghost: 'data-hovered:bg-accent data-hovered:text-accent-foreground',
            link: 'text-primary underline-offset-4 data-hovered:underline',
        },
        size: {
            default: 'h-9 px-4 py-2 has-[>svg]:px-3',
            sm: 'h-8 rounded-md px-3 has-[>svg]:px-2.5',
            lg: 'h-10 rounded-md px-6 has-[>svg]:px-4',
            icon: 'size-9',
        },
        isPending: {
            true: 'text-transparent',
        },
    },
    defaultVariants: {
        variant: 'default',
        size: 'default',
    },
});

type ButtonVariants = VariantProps<typeof buttonStyles>;

interface ButtonProps extends RACButtonProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
}

function Button({ variant, size, ...props }: ButtonProps) {
    return (
        <RACButton
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    buttonStyles({
                        ...renderProps,
                        variant,
                        size,
                        className,
                    }),
            )}
        >
            {composeRenderProps(props.children, (children, { isPending }) => (
                <>
                    {children}
                    {isPending && (
                        <span
                            aria-hidden
                            className="absolute inset-0 flex items-center justify-center"
                        >
                            <Spinner />
                        </span>
                    )}
                </>
            ))}
        </RACButton>
    );
}

export { Button, buttonStyles, type ButtonProps };
