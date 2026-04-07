import { useState } from 'react';
import { twMerge } from 'tailwind-merge';

function Avatar({ className, ...props }: React.ComponentProps<'span'>) {
    return (
        <span
            className={twMerge(
                'relative flex size-8 shrink-0 overflow-hidden rounded-full',
                className,
            )}
            {...props}
        />
    );
}

function AvatarImage({
    className,
    src,
    alt,
    ...props
}: React.ComponentProps<'img'>) {
    const [hasError, setHasError] = useState(false);

    if (!src || hasError) {
        return null;
    }

    return (
        <img
            src={src}
            alt={alt}
            className={twMerge('aspect-square size-full', className)}
            onError={() => setHasError(true)}
            {...props}
        />
    );
}

function AvatarFallback({ className, ...props }: React.ComponentProps<'span'>) {
    return (
        <span
            className={twMerge(
                'flex size-full items-center justify-center rounded-full bg-muted',
                className,
            )}
            {...props}
        />
    );
}

export { Avatar, AvatarFallback, AvatarImage };
