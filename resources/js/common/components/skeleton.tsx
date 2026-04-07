import { twMerge } from 'tailwind-merge';

function Skeleton({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div
            className={twMerge(
                'animate-pulse rounded-md bg-primary/10',
                className,
            )}
            {...props}
        />
    );
}

export { Skeleton };
