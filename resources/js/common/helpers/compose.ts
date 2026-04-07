import { composeRenderProps } from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv } from 'tailwind-variants';

/**
 * Composes a className prop (which may be a string or a render prop function)
 * with additional Tailwind classes. Works with react-aria's ClassNameOrFunction type.
 */
export function composeTailwindRenderProps<T>(
    className:
        | string
        | ((v: T & { defaultClassName: string | undefined }) => string)
        | undefined,
    tw: string,
): string | ((v: T & { defaultClassName: string | undefined }) => string) {
    return composeRenderProps(className, (className) => twMerge(tw, className));
}

export const focusRing = tv({
    base: 'outline-none',
    variants: {
        isFocusVisible: {
            true: 'ring-ring/50 ring-[3px] ring-offset-0',
        },
    },
});
