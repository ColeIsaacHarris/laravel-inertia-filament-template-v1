import { Link } from '@inertiajs/react';
import type { ComponentProps } from 'react';
import { twMerge } from 'tailwind-merge';

type Props = ComponentProps<typeof Link>;

export function TextLink({ className = '', children, ...props }: Props) {
    return (
        <Link
            className={twMerge(
                'text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500',
                className,
            )}
            {...props}
        >
            {children}
        </Link>
    );
}
